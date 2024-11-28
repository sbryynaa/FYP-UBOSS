<?php
include('includes/config.php');

// Get category id from the URL (if set) or show all books.
$categoryId = isset($_GET['category']) ? $_GET['category'] : null;
$authorId = isset($_GET['author']) ? $_GET['author'] : null;
$searchText = isset($_GET['search']) ? $_GET['search'] : '';

// Building the SQL query dynamically based on filter values
$sql = "SELECT tblbooks.BookName, tblcategory.CategoryName, tblauthors.AuthorName, tblbooks.ISBNNumber, tblbooks.quantity, tblbooks.id as bookid, tblbooks.bookImage
        FROM tblbooks
        JOIN tblcategory ON tblcategory.id = tblbooks.CatId
        JOIN tblauthors ON tblauthors.id = tblbooks.AuthorId
        WHERE 1";  // '1' is a placeholder for the always true condition

// Append conditions to the query if filters are set
if ($categoryId) {
    $sql .= " AND tblbooks.CatId = :categoryId";
}
if ($authorId) {
    $sql .= " AND tblbooks.AuthorId = :authorId";
}
if ($searchText) {
    $sql .= " AND tblbooks.BookName LIKE :searchText";
}

// Prepare and execute the query
$query = $dbh->prepare($sql);

if ($categoryId) {
    $query->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
}
if ($authorId) {
    $query->bindParam(':authorId', $authorId, PDO::PARAM_INT);
}
if ($searchText) {
    $searchText = '%' . $searchText . '%';  // Adding wildcards for LIKE query
    $query->bindParam(':searchText', $searchText, PDO::PARAM_STR);
}

$query->execute();
$books = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>U-BOSS | All Books</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

     <style>
        .book-card {
            height: 450px; /* Set a fixed height for all book cards */
            overflow: hidden; /* Hide anything that overflows the container */
            display: flex;
            flex-direction: column;
          
            padding: 10px;
            margin-bottom: 20px;
            box-shadow: 0 0 0px rgba(0, 0, 0, 0.1); /* Optional: keeps the shadow effect */
        }

        .book-card img {
            max-height: 200px; /* Adjust image size */
            object-fit: cover;
            width: 100%;
        }

        .book-card h5, .book-card p {
            margin: 0 0 5px 0; /* Adjust margins to make text spacing consistent */
        }
    </style>
</head>

<body>
    <div class="navbar navbar-inverse set-radius-zero">
        <a class="navbar-brand">
            <img src="assets/img/lib.jpg" />
        </a>
    </div>

    <!-- MENU SECTION START-->
  <section class="menu-section">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a href="dashboard.php" class="menu-top-active">DASHBOARD</a></li>
                             <li><a href="staff.php">Library Staff</a></li>
                            <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Rating <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="ratingbook.php">Rate Books</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="viewratebook.php">View Rating</a></li>
                                </ul>
                            </li>
                               <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Books <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="listed-books.php">All Books</a></li>
                                      <li role="presentation"><a role="menuitem" tabindex="-1" href="issued-books.php">Issued Books</a></li>
                                      <li role="presentation"><a role="menuitem" tabindex="-1" href="rentbook.php">Rent Books</a></li>
                                </ul>
                            </li>  <li><a href="forum.php">Forum</a></li>
                             <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Account <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="my-profile.php">My Profile</a></li>
                                     <li role="presentation"><a role="menuitem" tabindex="-1" href="change-password.php">Change Password</a></li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- MENU SECTION END-->

    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">All Books</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <h5>Search Filters</h5>
                    <!-- Search Form -->
                    <form action="listed-books.php" method="get">
                        <div class="form-group">
                            <label for="search">Search by Title</label>
                            <input type="text" name="search" id="search" class="form-control" value="<?php echo htmlspecialchars($searchText); ?>" placeholder="Search books by title" />
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category" id="category" class="form-control">
                                <option value="">Select Category</option>
                                <?php
                                // Fetch categories from the database
                                $sql = "SELECT id, CategoryName FROM tblcategory";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $categories = $query->fetchAll(PDO::FETCH_OBJ);

                                foreach ($categories as $category) {
                                    echo "<option value='" . $category->id . "'" . ($category->id == $categoryId ? ' selected' : '') . ">" . $category->CategoryName . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="author">Author</label>
                            <select name="author" id="author" class="form-control">
                                <option value="">Select Author</option>
                                <?php
                                // Fetch authors from the database
                                $sql = "SELECT id, AuthorName FROM tblauthors";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $authors = $query->fetchAll(PDO::FETCH_OBJ);

                                foreach ($authors as $author) {
                                    echo "<option value='" . $author->id . "'" . ($author->id == $authorId ? ' selected' : '') . ">" . $author->AuthorName . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>  <a href="listed-books.php" class="btn btn-primary">Back</a>
                    </form>
                  
                </div>

                <div class="col-md-8">
                    <h5>Books</h5>
                    <div class="row">
                        <?php
                        if (count($books) > 0) {
                            foreach ($books as $book) {
                        ?>
                                <div class="col-md-3" style="margin-bottom: 50px;">
                                    <div class="book-card">
                                        <img src="admin/bookimg/<?php echo htmlentities($book->bookImage); ?>" alt="Book Image" class="img-responsive">
                                        &nbsp;
                                        <h5><?php echo htmlentities($book->BookName); ?></h5>
                                        <p><strong>Category:</strong> <?php echo htmlentities($book->CategoryName); ?></p>
                                        <p><strong>Author:</strong> <?php echo htmlentities($book->AuthorName); ?></p>
                                        <p><strong>ISBN:</strong> <?php echo htmlentities($book->ISBNNumber); ?></p>
                                         <p><strong>Quantity:</strong> <?php echo htmlentities($book->quantity); ?></p>
                                         <p>Status: 
                <?php 
                if ($book->quantity > 0) {
                    echo "<span style='color: green;'>Available</span>";
                } else {
                    echo "<span style='color: red;'>Not available</span>";
                }
                ?>
            </p>
                                        
                                    </div>
                                    
                                    <a href="rentbook.php?bookid=<?php echo htmlentities($book->bookid); ?>" class="btn btn-primary">Check Out Book</a>
                                </div>
                        <?php
                            }
                        } else {
                            echo "<p>No books found matching your criteria.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>

</html>
