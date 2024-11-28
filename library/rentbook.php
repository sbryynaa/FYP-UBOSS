<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['login'])==0) {   
    header('location:index.php');
} else {
    if(isset($_POST['rent_books'])) {
        if(isset($_POST['book_ids']) && !empty($_POST['book_ids'])) {
            $student_id = $_SESSION['stdid'];
            $rental_date = $_POST['rental_date'];
            $delivery_option = $_POST['delivery_option'];
            $delivery_fee = ($delivery_option == 'delivery') ? 8 : 0;

            foreach($_POST['book_ids'] as $book_id) {
                $expected_return_date = date('Y-m-d', strtotime($rental_date . ' + 7 days'));
                $sql = "INSERT INTO tblissuedbookdetails (BookId, StudentId, IssuesDate, DeliveryOption, ExpectedReturnDate, status) VALUES (:book_id, :student_id, :rental_date, :delivery_option, :expected_return_date, 'Issued')";
                $query = $dbh->prepare($sql);
                $query->bindParam(':book_id', $book_id, PDO::PARAM_STR);
                $query->bindParam(':student_id', $student_id, PDO::PARAM_STR);
                $query->bindParam(':rental_date', $rental_date, PDO::PARAM_STR);
                $query->bindParam(':delivery_option', $delivery_option, PDO::PARAM_STR);
                $query->bindParam(':expected_return_date', $expected_return_date, PDO::PARAM_STR);

                if($query->execute()) {
                    $update_sql = "UPDATE tblbooks SET quantity = quantity - 1 WHERE id = :book_id";
                    $update_query = $dbh->prepare($update_sql);
                    $update_query->bindParam(':book_id', $book_id, PDO::PARAM_STR);
                    $update_query->execute();
                }
            }
            $_SESSION['delivery_fee'] = $delivery_fee;
            echo "<script>alert('Books rented successfully. Delivery option: $delivery_option. Rental date: $rental_date');</script>";
        } else {
            echo "<script>alert('Please select at least one book to rent.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>U-BOSS | Rent Books</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <style>
        .content-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header-line {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="content-wrapper">
        <div class="container content-container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line" style="font-family: 'Times New Roman', serif">Check Out Book</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Check Out Book</div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <div class="form-group">
                                 <label>Select Books</label><br>
<?php
// Check if 'bookid' parameter is passed in the URL
$selectedBookId = isset($_GET['bookid']) ? $_GET['bookid'] : null;

// SQL query to fetch books that are available for rent
$sql = "SELECT id, BookName FROM tblbooks WHERE quantity > 0";
$query = $dbh->prepare($sql);
$query->execute();
$books = $query->fetchAll(PDO::FETCH_OBJ);

// Create the dropdown list
echo '<select name="book_ids[]" class="form-control" required>';
echo '<option value="">Select a book</option>'; // Default option

// Loop through the books and create options in the dropdown
foreach ($books as $book) {
    // Check if the current book is selected based on the passed bookid
    $isSelected = ($selectedBookId == $book->id) ? 'selected' : '';
    echo "<option value='".htmlentities($book->id)."' $isSelected>".htmlentities($book->BookName)."</option>";
}

echo '</select>';
?>

                                </div>
                                <div class="form-group">
                                    <label>Delivery Option</label><br>
                                    <label class="radio-inline">
                                        <input type="radio" name="delivery_option" value="pickup" required> Pickup at Library
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="delivery_option" value="delivery" required> Delivery to Home
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="rental_date">Rental Date</label>
                                    <input type="date" name="rental_date" class="form-control" required value="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <button type="submit" name="rent_books" class="btn btn-primary">Rent Books</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>
    <script>
  // This will show the alert as soon as the page loads
  alert("If a book is unavailable, it will not appear in the selection list in the form.");
</script>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
