<?php
include('includes/config.php');

// Get category id from the URL (if set) or show all books.
$categoryId = isset($_GET['category']) ? $_GET['category'] : null;
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
            height: 350px; /* Set a fixed height for all book cards */
            overflow: hidden; /* Hide anything that overflows the container */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 10px;
            margin-bottom: 20px;
            box-shadow: 0 0 0px rgba(0, 0, 0, 0.1); /* Optional: keeps the shadow effect */
            transition: transform 0.3s ease; /* Smooth transition for scaling */
        }

        .book-card:hover {
            transform: scale(1.05); /* Slightly enlarge the card on hover */
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
<div class="navbar navbar-inverse set-radius-zero" >
        
                <a class="navbar-brand" >

                 <img src="assets/img/lib.jpg" />

                </a>

            </div>
<body>
    <!-- MENU SECTION START-->
    <section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="allbook.php">All Books</a></li>
                            <li><a href="staff.php">Library Staff</a></li>
                            <li><a href="userlogin.php">Login</a></li>
                            <li><a href="signup.php">Signup</a></li>
                            <li><a href="adminlogin.php">Admin</a></li>
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
                    <h5>Categories</h5>
                    <ul class="list-group">
                        <?php
                        // Fetch categories from the database
                        $sql = "SELECT id, CategoryName FROM tblcategory";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $categories = $query->fetchAll(PDO::FETCH_OBJ);

                        foreach ($categories as $category) {
                            // Display each category as a link
                            echo "<li class='list-group-item'><a href='allbook.php?category=" . $category->id . "'>" . $category->CategoryName . "</a></li>";
                        }
                        ?>
                    </ul>
                </div>

                <div class="col-md-8">
                    <h5>Books</h5> Log in for more information.
                    <div class="row">
                        <?php
                        if ($categoryId) {
                            // Fetch books under the selected category
                            $sql = "SELECT tblbooks.BookName, tblcategory.CategoryName, tblauthors.AuthorName, tblbooks.ISBNNumber, tblbooks.id as bookid, tblbooks.bookImage
                                    FROM tblbooks
                                    JOIN tblcategory ON tblcategory.id = tblbooks.CatId
                                    JOIN tblauthors ON tblauthors.id = tblbooks.AuthorId
                                    WHERE tblbooks.CatId = :categoryId";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
                        } else {
                            // Fetch all books if no category is selected
                            $sql = "SELECT tblbooks.BookName, tblcategory.CategoryName, tblauthors.AuthorName, tblbooks.ISBNNumber, tblbooks.id as bookid, tblbooks.bookImage
                                    FROM tblbooks
                                    JOIN tblcategory ON tblcategory.id = tblbooks.CatId
                                    JOIN tblauthors ON tblauthors.id = tblbooks.AuthorId";
                            $query = $dbh->prepare($sql);
                        }
                        $query->execute();
                        $books = $query->fetchAll(PDO::FETCH_OBJ);

                        if ($query->rowCount() > 0) {
                            foreach ($books as $book) {
                        ?>
                                <div class="col-md-3">
                                    <div class="book-card">
                                        <img src="admin/bookimg/<?php echo htmlentities($book->bookImage); ?>" alt="Book Image" class="img-responsive">
                                        <h5><?php echo htmlentities($book->BookName); ?></h5>
                                        <p><strong>Category:</strong> <?php echo htmlentities($book->CategoryName); ?></p>
                                        <p><strong>Author:</strong> <?php echo htmlentities($book->AuthorName); ?></p>
                                        <p><strong>ISBN:</strong> <?php echo htmlentities($book->ISBNNumber); ?></p>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo "<p>No books available in this category.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->

    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME -->
    <!-- CORE JQUERY -->
  
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>

</html>
