<?php  
session_start();  

// Redirect if not logged in  
if (!isset($_SESSION['login'])) {  
    header('location:index.php');  
    exit;  
}  

// Initialize variables  
$payment_successful = false;  
$payment_details = isset($_SESSION['payment_details']) ? $_SESSION['payment_details'] : null;  

// Check if payment details are available  
if ($payment_details) {  
    // Update the book status in the database to 'Waiting to be Shipped'  
    if (update_book_status($payment_details['issued_id'])) {  
        $payment_successful = true;  
        $_SESSION['message'] = 'Payment successful. Your book is now waiting to be shipped.';  
    } else {  
        $_SESSION['error'] = 'Failed to update book status in the database.';  
    }  
    // Clear payment details from session  
    unset($_SESSION['payment_details']);  
} else {  
    $_SESSION['error'] = 'No payment details found.';  
    header('location: payment.php');  
    exit;  
}  

// Update book status in the database  
function update_book_status($issued_id) {  
    include('includes/config.php');  

    try {
        // Update status to 'Waiting to be Shipped'  
        $sql = "UPDATE tblissuedbookdetails SET status = 'Waiting to be Shipped' WHERE id = :issued_id";  
        $query = $dbh->prepare($sql);  
        $query->bindParam(':issued_id', $issued_id, PDO::PARAM_STR);  
        return $query->execute(); // Return success status  
    } catch (PDOException $e) {
        // Log the error for debugging
        error_log("Database Error: " . $e->getMessage());
        return false;
    }
}  
?>  

<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Payment Confirmation</title>  
    <link rel="stylesheet" href="assets/css/bootstrap.css">  
</head>  
<body>  
    <div class="container">  
        <h2>Payment Confirmation</h2>  
        <?php if ($payment_successful): ?>  
            <div class="alert alert-success">
                <?php echo htmlentities($_SESSION['message']); unset($_SESSION['message']); ?>
            </div>
            <a href="issued-books.php" class="btn btn-primary">View Issued Books</a>
        <?php else: ?>  
            <div class="alert alert-danger">
                <?php echo htmlentities($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
            <a href="payment.php" class="btn btn-secondary">Try Again</a>
        <?php endif; ?>  
    </div>  
    <script src="assets/js/jquery-1.10.2.js"></script>  
    <script src="assets/js/bootstrap.js"></script>  
</body>  
</html>
