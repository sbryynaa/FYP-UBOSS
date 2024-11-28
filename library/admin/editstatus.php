<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if user is logged in as admin
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit; // Ensure no further code is executed after redirect
}

// Check if the issued book ID is provided
if (isset($_GET['issued_id'])) {
    $issued_id = $_GET['issued_id'];

    // Fetch the current details of the issued book
    $sql = "SELECT tblissuedbookdetails.*, tblstudents.FirstName, tblstudents.LastName, tblbooks.BookName, tblissuedbookdetails.ExpectedReturnDate, tblissuedbookdetails.DeliveryOption 
            FROM tblissuedbookdetails 
            JOIN tblstudents ON tblstudents.StudentId = tblissuedbookdetails.StudentId 
            JOIN tblbooks ON tblbooks.id = tblissuedbookdetails.BookId 
            WHERE tblissuedbookdetails.id = :issued_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':issued_id', $issued_id, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    // Handle form submission to update book status
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $status = $_POST['status'];
        $return_date = isset($_POST['return_date']) ? $_POST['return_date'] : null;
        $expected_return_date = $_POST['expected_return_date'];
        $delivery_option = $_POST['delivery_option'];

        // Update the issued book details
        $update_sql = "UPDATE tblissuedbookdetails 
                       SET status = :status, DeliveryOption = :delivery_option, ExpectedReturnDate = :expected_return_date" . 
                       ($return_date ? ", ReturnDate = :return_date" : "") . " 
                       WHERE id = :issued_id";
        $update_query = $dbh->prepare($update_sql);
        $update_query->bindParam(':status', $status, PDO::PARAM_STR);
        $update_query->bindParam(':delivery_option', $delivery_option, PDO::PARAM_STR);
        $update_query->bindParam(':expected_return_date', $expected_return_date, PDO::PARAM_STR);
        if ($return_date) {
            $update_query->bindParam(':return_date', $return_date, PDO::PARAM_STR);
        }
        $update_query->bindParam(':issued_id', $issued_id, PDO::PARAM_INT);

        if ($update_query->execute()) {
            $_SESSION['msg'] = "Book status updated successfully!";
        } else {
            $_SESSION['error'] = "Error updating book status.";
        }

        // Redirect back to manage issued books page
        header('location: manage-issued-books.php');
        exit; // Ensure no further code is executed after redirect
    }
} else {
    $_SESSION['error'] = "Invalid issued book ID.";
    header('location: manage-issued-books.php');
    exit; // Ensure no further code is executed after redirect
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>U-BOSS | Edit Book Status</title>
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
                    <h4 class="header-line">Edit Book Status</h4>
                </div>
                <div class="row">
                    <?php if (!empty($_SESSION['error'])) { ?>
                        <div class="col-md-6">
                            <div class="alert alert-danger">
                                <strong>Error :</strong>
                                <?php 
                                echo htmlentities($_SESSION['error']); 
                                $_SESSION['error'] = ""; // Reset error message after displaying
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($_SESSION['msg'])) { ?>
                        <div class="col-md-6">
                            <div class="alert alert-success">
                                <strong>Success :</strong>
                                <?php 
                                echo htmlentities($_SESSION['msg']); 
                                $_SESSION['msg'] = ""; // Reset message after displaying
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Edit Issued Book Details
                        </div>
                        <div class="panel-body">
                            <form method="post" action="">
                                <div class="form-group">
                                    <label>Student Name</label>
                                    <input type="text" class="form-control" value="<?php echo htmlentities($result->FirstName . ' ' . $result->LastName); ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Book Name</label>
                                    <input type="text" class="form-control" value="<?php echo htmlentities($result->BookName); ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="Issued" <?php if ($result->status == 'Issued') echo 'selected'; ?>>Issued</option>
                                        <option value="Returned" <?php if ($result->status == 'Returned') echo 'selected'; ?>>Returned</option>
                                        <option value="Waiting to be Shipped" <?php if ($result->status == 'Waiting to be Shipped') echo 'selected'; ?>>Waiting to be Shipped</option>
                                        <option value="Waiting to be Pickup" <?php if ($result->status == 'Waiting to be Pickup') echo 'selected'; ?>>Waiting to be Pickup</option>
                                         <option value="Courier Take Over" <?php if ($result->status == 'Courier Take Over') echo 'selected'; ?>>Courier Take Over</option>
                                          <option value="Picked Up" <?php if ($result->status == 'Picked Up') echo 'selected'; ?>>Picked Up</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Delivery Option</label>
                                    <select name="delivery_option" class="form-control">
                                        <option value="Pickup" <?php if ($result->DeliveryOption == 'Pickup') echo 'selected'; ?>>Pickup</option>
                                        <option value="Delivery" <?php if ($result->DeliveryOption == 'Delivery') echo 'selected'; ?>>Delivery</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Expected Return Date</label>
                                    <input type="date" name="expected_return_date" class="form-control" value="<?php echo htmlentities($result->ExpectedReturnDate); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Return Date (Optional)</label>
                                    <input type="date" name="return_date" class="form-control" value="<?php echo htmlentities($result->ReturnDate); ?>">
                                </div>
                                <button type="submit" class="btn btn-primary">Update Status</button>
                                <a href="manage-issued-books.php" class="btn btn-default">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
</body>
</html>
