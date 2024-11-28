<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Fetch books with the average rating and reviews, sorted by most-rated
$sql = "SELECT tblbooks.id AS book_id, tblbooks.BookName, tblcategory.CategoryName, tblauthors.AuthorName, tblbooks.bookImage, 
                AVG(book_ratings.Rating) AS avg_rating
        FROM tblbooks
        LEFT JOIN book_ratings ON tblbooks.id = book_ratings.BookId
        LEFT JOIN tblcategory ON tblcategory.id = tblbooks.CatId
        LEFT JOIN tblauthors ON tblauthors.id = tblbooks.AuthorId
        GROUP BY tblbooks.id
        ORDER BY avg_rating DESC, tblbooks.BookName"; // Order by most-rated first

$query = $dbh->prepare($sql);
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
    <title>U-BOSS Book Ratings & Reviews</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <style>
        .rating-list-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* 3 columns per row */
            gap: 100px;
            margin-top: 20px;
        }

        .book-item {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .book-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 15px;
        }

        .book-photo {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .book-name {
            font-weight: bold;
            font-size: 18px;
            color: #333;
            text-align: center;
        }

        .book-category,
        .book-author {
            font-size: 14px;
            color: #555;
            text-align: center;
        }

        .rating-section {
            margin-top: 10px;
        }

        .rating-item {
            margin-bottom: 10px;
            padding: 10px;
            border-left: 3px solid #f0ad4e;
            background-color: #f1f1f1;
        }

        .rating-item p {
            margin: 5px 0;
        }

        .rating-item .stars {
            color: gold;
        }

        .rating-list-container .book-item:hover {
            background-color: #f8f8f8;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: scale(1.02);
            transition: all 0.3s ease-in-out;
        }

        .reviews-section {
            margin-top: 20px;
        }

        .review-item {
            background-color: #f9f9f9;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .review-item .stars {
            color: gold;
        }

        .review-item p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h2 style="text-align: center;font-family: 'Times New Roman', serif">Book Ratings and Reviews</h2>
                    <h2 style="border-top: 1px solid black; padding-bottom: 5px;">
                </div>
            </div>

            <!-- Filter Dropdown -->
            <div class="row">
                <div class="col-md-12">
                    <form method="GET" action="">
                        <label for="filter">Sort By:</label>
                        <select name="filter" id="filter" class="form-control" style="width: auto; display: inline;">
                            <option value="most-rated" <?php if ($_GET['filter'] == 'most-rated') echo 'selected'; ?>>Most Rated</option>
                            <option value="alphabetical" <?php if ($_GET['filter'] == 'alphabetical') echo 'selected'; ?>>Alphabetical</option>
                        </select>
                        <button type="submit" class="btn btn-primary" style="margin-left: 10px;">Apply</button>
                    </form>
                </div>
            </div>

            <div class="rating-list-container">
                <?php 
                // Get selected filter
                $filter = isset($_GET['filter']) ? $_GET['filter'] : 'most-rated';
                
                // Update SQL query based on filter
                if ($filter == 'alphabetical') {
                    $sql = "SELECT tblbooks.id AS book_id, tblbooks.BookName, tblcategory.CategoryName, tblauthors.AuthorName, tblbooks.bookImage, 
                            AVG(book_ratings.Rating) AS avg_rating
                            FROM tblbooks
                            LEFT JOIN book_ratings ON tblbooks.id = book_ratings.BookId
                            LEFT JOIN tblcategory ON tblcategory.id = tblbooks.CatId
                            LEFT JOIN tblauthors ON tblauthors.id = tblbooks.AuthorId
                            GROUP BY tblbooks.id
                            ORDER BY tblbooks.BookName"; // Order alphabetically
                } else {
                    $sql = "SELECT tblbooks.id AS book_id, tblbooks.BookName, tblcategory.CategoryName, tblauthors.AuthorName, tblbooks.bookImage, 
                            AVG(book_ratings.Rating) AS avg_rating
                            FROM tblbooks
                            LEFT JOIN book_ratings ON tblbooks.id = book_ratings.BookId
                            LEFT JOIN tblcategory ON tblcategory.id = tblbooks.CatId
                            LEFT JOIN tblauthors ON tblauthors.id = tblbooks.AuthorId
                            GROUP BY tblbooks.id
                            ORDER BY avg_rating DESC, tblbooks.BookName"; // Order by most rated
                }

                $query = $dbh->prepare($sql);
                $query->execute();
                $books = $query->fetchAll(PDO::FETCH_OBJ);

                // Loop through all books
                foreach ($books as $book) {
                ?>
                    <div class="book-item">
                        <div class="book-header">
                            <img src="admin/bookimg/<?php echo htmlentities($book->bookImage); ?>" alt="<?php echo htmlentities($book->BookName); ?>" class="book-photo">
                            <div class="book-name"><?php echo htmlentities($book->BookName); ?></div>
                            <div class="book-category">Category: <?php echo htmlentities($book->CategoryName); ?></div>
                            <div class="book-author">Author: <?php echo htmlentities($book->AuthorName); ?></div>
                        </div>
                        <div class="rating-section">
                            <p><strong>Average Rating:</strong> <?php 
                                $stars = str_repeat('★', round($book->avg_rating)) . str_repeat('☆', 5 - round($book->avg_rating));
                                echo '<span class="stars">' . $stars . "</span> (" . round($book->avg_rating, 1) . "/5)";
                            ?></p>
                        </div>

                        <!-- Display reviews for the book -->
                        <div class="reviews-section">
                            <?php
                            // Fetch reviews for the current book
                            $review_sql = "SELECT * FROM book_ratings WHERE BookId = :book_id";
                            $review_query = $dbh->prepare($review_sql);
                            $review_query->bindParam(':book_id', $book->book_id, PDO::PARAM_INT);
                            $review_query->execute();
                            $reviews = $review_query->fetchAll(PDO::FETCH_OBJ);

                            // Display reviews
                            foreach ($reviews as $review) {
                            ?>
                                <div class="review-item">
                                    
                                    <p><strong>Rating:</strong> <?php
                                        $stars = str_repeat('★', $review->Rating) . str_repeat('☆', 5 - $review->Rating);
                                        echo '<span class="stars">' . $stars . "</span>";
                                    ?></p>
                                    <p><strong>Review:</strong> <?php echo htmlentities($review->Review); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
      <?php include('includes/footer.php'); ?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
