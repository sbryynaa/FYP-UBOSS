<?php 
session_start();
error_reporting(0);
include('includes/config.php');

// Handle deletion request only for ratings that exist in the database
if (isset($_POST['delete_rating'])) {
    $rating_id = $_POST['rating_id'];
    // Check if the rating exists before attempting to delete
    $check_sql = "SELECT id FROM book_ratings WHERE id = :rating_id";
    $check_query = $dbh->prepare($check_sql);
    $check_query->bindParam(':rating_id', $rating_id, PDO::PARAM_INT);
    $check_query->execute();
    
    if ($check_query->rowCount() > 0) {
        // Rating exists, proceed to delete
        $delete_sql = "DELETE FROM book_ratings WHERE id = :rating_id";
        $delete_query = $dbh->prepare($delete_sql);
        $delete_query->bindParam(':rating_id', $rating_id, PDO::PARAM_INT);
        $delete_query->execute();
        header("Location: adminrating.php"); // Refresh the page after deletion
    }
}

// Fetch books with their ratings and reviews
$sql = "SELECT tblbooks.id AS book_id, tblbooks.BookName, tblcategory.CategoryName, tblauthors.AuthorName, 
               book_ratings.id AS rating_id, book_ratings.Rating, book_ratings.Review
        FROM tblbooks
        LEFT JOIN book_ratings ON tblbooks.id = book_ratings.BookId
        LEFT JOIN tblcategory ON tblcategory.id = tblbooks.CatId
        LEFT JOIN tblauthors ON tblauthors.id = tblbooks.AuthorId
        ORDER BY tblbooks.BookName";
$query = $dbh->prepare($sql);
$query->execute();
$ratings = $query->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Book Ratings & Reviews</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h2 style="text-align: center;">Book Ratings and Reviews</h2><h2 style="border-top: 1px solid black; padding-bottom: 5px;">
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                       
                        <th>Book Name</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($ratings as $rating) { 
                        if ($rating->rating_id) { // Only display rows with an actual rating
                    ?>
                        <tr>
                           
                            <td><?php echo htmlentities($rating->BookName); ?></td>
                            <td><?php echo htmlentities($rating->CategoryName); ?></td>
                            <td><?php echo htmlentities($rating->AuthorName); ?></td>
                            <td><?php echo str_repeat('★', $rating->Rating) . str_repeat('☆', 5 - $rating->Rating); ?> (<?php echo htmlentities($rating->Rating); ?>/5)</td>
                            <td><?php echo htmlentities($rating->Review) ?: 'No review available'; ?></td>
                            <td>
                                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this rating?');">
                                    <input type="hidden" name="rating_id" value="<?php echo $rating->rating_id; ?>">
                                    <button type="submit" name="delete_rating" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php 
                        }
                    } 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
