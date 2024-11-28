<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Handle the form submission (rating and review)
if (isset($_POST['submit'])) {
    // Get rating and review from the form
    $bookId = $_POST['bookId']; // BookId selected by the user
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    // Insert the rating and review into the database
    $sql = "INSERT INTO book_ratings (BookId, Rating, Review) VALUES (:bookId, :rating, :review)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':bookId', $bookId, PDO::PARAM_INT);
    $query->bindParam(':rating', $rating, PDO::PARAM_INT);
    $query->bindParam(':review', $review, PDO::PARAM_STR);
    $query->execute();

    // Show success message after review submission
    echo "<script>alert('Your rating and review have been submitted successfully.');</script>";
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>U-BOSS | Rate Book</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <style>
        /* New style for narrower content container */
        .content-container {
            max-width: 800px; /* Adjust the width as needed */
            margin: 0 auto;
        }

        .header-line {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <!-- MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container content-container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line" style=" font-family: 'Times New Roman', serif">Rate a Book</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <!-- Book Selection Form -->
                    <form method="get" action="ratingbook.php">
                        <div class="form-group">
                            <label for="bookId">Choose a Book:</label>
                            <select name="bookId" class="form-control" required>
                                <option value="">Select a book</option>
                                <?php
                                // Fetch the list of books to choose from
                                $sql = "SELECT id, BookName FROM tblbooks";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $books = $query->fetchAll(PDO::FETCH_OBJ);
                                
                                // Display books in the dropdown
                                foreach ($books as $book) {
                                    echo "<option value='{$book->id}'>{$book->BookName}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Select Book</button>
                    </form>
                </div>
            </div>

            <?php
            // If a book is selected, display the rating and review form
            if (isset($_GET['bookId']) && $_GET['bookId'] != '') {
                $selectedBookId = $_GET['bookId'];

                // Fetch book details to show the book being rated
                $sql = "SELECT * FROM tblbooks WHERE id = :bookId";
                $query = $dbh->prepare($sql);
                $query->bindParam(':bookId', $selectedBookId, PDO::PARAM_INT);
                $query->execute();
                $book = $query->fetch(PDO::FETCH_OBJ);
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <h4>Rate Book: <?php echo htmlentities($book->BookName); ?></h4>

                        <!-- Rating and Review Form -->
                        <form method="post" action="ratingbook.php">
                            <input type="hidden" name="bookId" value="<?php echo $selectedBookId; ?>">
                            
                            <div class="form-group">
                                <label for="rating">Rating (1 to 5):</label>
                                <select name="rating" class="form-control" required>
                                    <option value="1">1 - Poor</option>
                                    <option value="2">2 - Fair</option>
                                    <option value="3">3 - Good</option>
                                    <option value="4">4 - Very Good</option>
                                    <option value="5">5 - Excellent</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="review">Review:</label>
                                <textarea name="review" class="form-control" rows="5" required></textarea>
                            </div>

                            <button type="submit" name="submit" class="btn btn-primary">Submit Rating and Review</button>
                        </form>
                    </div>
                </div>

                <?php
            }
            ?>

        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>

</html>
