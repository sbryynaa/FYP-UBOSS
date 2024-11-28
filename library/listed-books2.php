<?php
include('includes/config.php');
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>U-BOSS | Listed Books</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style>
        .book-list {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            width: 100%;
        }

        .book-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            background-color: #f9f9f9;
        }

        .book-card img {
            width: 150px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .book-card h5 {
            margin-bottom: 10px;
        }

        .book-card p {
            margin: 5px 0;
        }

        /* Adjust for responsiveness */
        @media (max-width: 1024px) {
            .book-list {
                grid-template-columns: repeat(3, 1fr); /* 3 books per row on medium screens */
            }
        }

        @media (max-width: 768px) {
            .book-list {
                grid-template-columns: repeat(2, 1fr); /* 2 books per row on small screens */
            }
        }

        @media (max-width: 480px) {
            .book-list {
                grid-template-columns: 1fr; /* 1 book per row on very small screens */
            }
        }
    </style>
</head>

<body>
    <!-- MENU SECTION START-->
    <section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="listed-books2.php">Listed Books</a></li>
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
                    <h4 class="header-line">Listed Books</h4>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Listed Books
                        </div>
                        <div class="panel-body">
                            <div class="book-list">
                                <?php
                                // Initialize search variable
                                $search = isset($_POST['search']) ? $_POST['search'] : '';

                                // Modify SQL query based on search input
                                $sql = "SELECT tblbooks.BookName, tblcategory.CategoryName, tblauthors.AuthorName, tblbooks.ISBNNumber, tblbooks.id as bookid, tblbooks.bookImage
                                        FROM tblbooks 
                                        JOIN tblcategory ON tblcategory.id = tblbooks.CatId 
                                        JOIN tblauthors ON tblauthors.id = tblbooks.AuthorId 
                                        WHERE tblbooks.BookName LIKE :search OR tblbooks.ISBNNumber LIKE :search";
                                $query = $dbh->prepare($sql);
                                $searchParam = '%' . $search . '%';
                                $query->bindParam(':search', $searchParam, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) {
                                ?>
                                        <div class="book-card">
                                            <img src="admin/bookimg/<?php echo htmlentities($result->bookImage); ?>" alt="Book Image">
                                            <h5><?php echo htmlentities($result->BookName); ?></h5>
                                            <p><strong>Category:</strong> <?php echo htmlentities($result->CategoryName); ?></p>
                                            <p><strong>Author:</strong> <?php echo htmlentities($result->AuthorName); ?></p>
                                            <p><strong>ISBN:</strong> <?php echo htmlentities($result->ISBNNumber); ?></p>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo "<p>No records found.</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- End Advanced Tables -->
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
