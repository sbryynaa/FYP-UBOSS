<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start(); // Start output buffering
include('includes/config.php');

// Redirect if not logged in
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit; // Ensure script stops executing after redirection
} 

// Handle payment action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pay_now'])) {
    $issued_id = $_POST['issued_id'];
    $fine = $_POST['fine'];
    
    // Simulating successful payment for demo purposes
    $payment_status = 'Paid';

    // Update the payment status in the database
    $sql = "UPDATE tblissuedbookdetails SET payment_status = :payment_status WHERE id = :issued_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':payment_status', $payment_status, PDO::PARAM_STR); // Corrected parameter name
    $query->bindParam(':issued_id', $issued_id, PDO::PARAM_INT);
    $query->execute();

    // Show receipt after payment
    $payment_success = true; // Flag to show receipt
}

// Fetch the book details based on issued ID from the URL
if (isset($_GET['issued_id'])) {
    $issued_id = $_GET['issued_id'];
    
    // Fetch book details for the payment
    $sql = "SELECT fine FROM tblissuedbookdetails WHERE id = :issued_id"; // Corrected field to 'fine'
    $query = $dbh->prepare($sql);
    $query->bindParam(':issued_id', $issued_id, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    $fine = $result->fine;
}

// Bank selection mapping
$bank_names = [
    'bank1' => 'Maybank',
    'bank2' => 'Bank Islam',
    'bank3' => 'CIMB Bank',
    'bank4' => 'HSBC Bank'
];

// Retrieve the bank name based on user selection
$selected_bank = isset($_POST['bank']) ? $bank_names[$_POST['bank']] : 'Not Selected';
?>
<style>
/* Adjusting the form container */
.panel {
    border-radius: 10px;
    border: 1px solid #ddd;
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
}

/* Adjusting the receipt container */
.receipt {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 10px;
    margin-top: 30px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    margin: 20px auto;
}

.receipt h4 {
    text-align: center;
    font-size: 20px;
    font-weight: bold;
}

.receipt .details {
    font-size: 14px;
    margin-bottom: 10px;
}

.receipt .details strong {
    font-weight: bold;
}
</style>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Payment | U-BOSS</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body> 
    <div class="navbar navbar-inverse set-radius-zero">
        <a class="navbar-brand">
            <img src="assets/img/lib.jpg" />
        </a>
    </div>

    <section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a href="dashboard.php" class="menu-top-active">DASHBOARD</a></li>
                            <li><a href="staff.php">Library Staff</a></li>
                            <li><a href="forum.php">Forum</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="content-wrapper">
        <div class="container">
            <?php if (isset($payment_success) && $payment_success): ?>
                <div class="receipt">
                    <h4>Payment Receipt</h4>
                    <div class="details">
                        <strong>Issued ID:</strong> <?php echo htmlentities($issued_id); ?>
                    </div>
                    <div class="details">
                        <strong>Amount:</strong> RM <?php echo htmlentities($fine); ?>
                    </div>
                    <div class="details">
                        <strong>Status:</strong> Paid
                    </div>
                    <div class="details">
                        <strong>Payment Method:</strong> <?php echo htmlentities($selected_bank); ?>
                    </div>
                    <p class="text-center">Thank you for your payment!</p>
                </div>
                <script>
                    setTimeout(function() {
                        window.location.href = 'fines-book.php';
                    }, 5000);
                </script>
            <?php else: ?>
                <h4 class="header-line" style="text-align: center;">Complete Your Payment</h4>
                <div class="panel panel-default">
                    <div class="panel-heading">Payment Details</div>
                    <div class="panel-body">
                        <form method="POST" action="finespayment.php">
                            <input type="hidden" name="issued_id" value="<?php echo htmlentities($issued_id); ?>">
                            <input type="hidden" name="fine" value="<?php echo htmlentities($fine); ?>">
                            <div class="form-group">
                                <label for="bank">Select Bank:</label>
                                <select class="form-control" id="bank" name="bank">
                                    <option value="bank1">Maybank</option>
                                    <option value="bank2">Bank Islam</option>
                                    <option value="bank3">CIMB Bank</option>
                                    <option value="bank4">HSBC Bank</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount:</label>
                                <input type="text" class="form-control" name="amount_display" value="RM <?php echo htmlentities($fine); ?>" readonly>
                            </div>
                            <button type="submit" name="pay_now" class="btn btn-success">Pay Now</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <section class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <footer>
                        <p>&copy; 2024 U-BOSS | All Rights Reserved</p>
                    </footer>
                </div>
            </div>
        </div>
    </section>
    
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
