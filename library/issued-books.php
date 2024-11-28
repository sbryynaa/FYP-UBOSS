<?php 
session_start();
error_reporting(0);
include('includes/config.php');

// Redirect if not logged in
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit; // Ensure script stops executing after redirection
} else {
    // Fetch issued books for the logged-in student
    $sid = $_SESSION['stdid'];
    $sql = "SELECT tblbooks.BookName, tblbooks.ISBNNumber, tblissuedbookdetails.IssuesDate, 
                   tblissuedbookdetails.ExpectedReturnDate, tblissuedbookdetails.ReturnDate, 
                   tblissuedbookdetails.id AS rid, tblissuedbookdetails.DeliveryOption, 
                   tblissuedbookdetails.status, tblissuedbookdetails.pay_status, 
                   tblissuedbookdetails.amount
            FROM tblissuedbookdetails 
            JOIN tblstudents ON tblstudents.StudentId = tblissuedbookdetails.StudentId 
            JOIN tblbooks ON tblbooks.id = tblissuedbookdetails.BookId 
            WHERE tblstudents.StudentId = :sid 
            ORDER BY tblissuedbookdetails.id DESC";

    $query = $dbh->prepare($sql);
    $query->bindParam(':sid', $sid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    // Handle late fees and payment updates
    foreach ($results as $result) {
        try {
            $amount = 0;
            $currentDate = new DateTime();
            $expectedReturnDate = new DateTime($result->ExpectedReturnDate);

            if ($result->DeliveryOption === 'delivery') {
                $amount += 5; // Delivery charge
            }
// Check if the book status is 'Returned'
if ($result->status != 'Returned') {
    // Only update fine if overdue
    if ($currentDate > $expectedReturnDate) {
        $daysLate = $currentDate->diff($expectedReturnDate)->days;
        $fine = $daysLate * 1; // Assuming RM1 per day late fine
    } else {
        $fine = 0; // No fine if not overdue
    }
} else {
    $fine = 0; // No fine if book is returned
}

// Update the fine in the database
$sql_update_fine = "UPDATE tblissuedbookdetails SET fine = :fine WHERE id = :issued_id";
$query_update_fine = $dbh->prepare($sql_update_fine);
$query_update_fine->bindParam(':fine', $fine, PDO::PARAM_INT);
$query_update_fine->bindParam(':issued_id', $result->rid, PDO::PARAM_INT);
$query_update_fine->execute();

            // Update amount if it differs or pay status is not paid
            if ($amount != $result->amount || $result->pay_status != 'Paid') {
                $status_sql = "UPDATE tblissuedbookdetails 
                               SET amount = :amount 
                               WHERE id = :rid";
                $status_query = $dbh->prepare($status_sql);
                $status_query->bindParam(':amount', $amount, PDO::PARAM_STR);
                $status_query->bindParam(':rid', $result->rid, PDO::PARAM_INT);
                $status_query->execute();
            }

            // Automatically mark as paid for "pickup" delivery option
            if ($result->DeliveryOption === 'pickup' && $result->pay_status != 'Paid') {
                $payStatusSql = "UPDATE tblissuedbookdetails SET pay_status = 'Paid' WHERE id = :rid";
                $payStatusQuery = $dbh->prepare($payStatusSql);
                $payStatusQuery->bindParam(':rid', $result->rid, PDO::PARAM_INT);
                $payStatusQuery->execute();
                $result->pay_status = 'Paid'; // Update the local object as well
            }

            // Ensure ReturnDate is only set by admin action, not automatically
            if ($result->status === 'Issued' && $result->DeliveryOption === 'delivery' && is_null($result->ReturnDate)) {
                // Keep ReturnDate empty for delivered books until admin updates it
                $update_sql = "UPDATE tblissuedbookdetails 
                               SET ReturnDate = NULL 
                               WHERE id = :rid";
                $update_query = $dbh->prepare($update_sql);
                $update_query->bindParam(':rid', $result->rid, PDO::PARAM_INT);
                $update_query->execute();
            }

        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
        }
    }

    // Handle return and delete actions for admin
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $message = '';
        $errorMessage = '';

        if (isset($_POST['return_book'])) {
            $issued_id = $_POST['issued_id'];
            $sql = "UPDATE tblissuedbookdetails SET status = 'Returned', ReturnDate = NOW() WHERE id = :issued_id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':issued_id', $issued_id, PDO::PARAM_INT);
            $message = $query->execute() ? "Book returned successfully!" : "Error while returning the book.";
        }

        if (isset($_POST['delete_book'])) {
            $issued_id = $_POST['issued_id'];
            $sql = "DELETE FROM tblissuedbookdetails WHERE id = :issued_id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':issued_id', $issued_id, PDO::PARAM_INT);
            $message = $query->execute() ? "Book issued record deleted successfully!" : "Error while deleting the book issued record.";
        }

        $_SESSION['msg'] = $message;
        $_SESSION['error'] = $errorMessage;
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>U-BOSS | Manage Issued Books</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Manage Issued Books</h4>
                </div>
                <div class="row">
                    <?php if (!empty($_SESSION['error'])) { ?>
                        <div class="col-md-6">
                            <div class="alert alert-danger">
                                <strong>Error :</strong> <?php echo htmlentities($_SESSION['error']); ?>
                            </div>
                        </div>
                        <?php $_SESSION['error'] = ""; ?>
                    <?php } ?>
                    <?php if (!empty($_SESSION['msg'])) { ?>
                        <div class="col-md-6">
                            <div class="alert alert-success">
                                <strong>Success :</strong> <?php echo htmlentities($_SESSION['msg']); ?>
                            </div>
                        </div>
                        <?php $_SESSION['msg'] = ""; ?>
                    <?php } ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Issued Books</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Book Name</th>
                                            <th>ISBN</th>
                                            <th>Issued Date</th>
                                            <th>Expected Return Date</th>
                                            <th>Update</th>
                                            <th>Delivery Option</th>
                                            <th>Status</th>
                                            <th>Pay Status</th>
                                            <th>Amount</th>
                                          
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $cnt = 1;
                                        if (!empty($results)) {
                                            foreach ($results as $result) { 
                                                ?>
                                                <tr>
                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                    <td><?php echo htmlentities($result->BookName); ?></td>
                                                    <td><?php echo htmlentities($result->ISBNNumber); ?></td>
                                                    <td><?php echo htmlentities($result->IssuesDate); ?></td>
                                                    <td><?php echo htmlentities($result->ExpectedReturnDate); ?></td>
                                                    <td><?php echo htmlentities($result->ReturnDate); ?></td>
                                                    <td><?php echo htmlentities($result->DeliveryOption); ?></td>
                                                    <td><?php echo htmlentities($result->status); ?></td>
                                                    <td>
                                                        <?php 
                                                        if ($result->pay_status == 'Paid') {
                                                            echo '<span class="label label-success">Paid</span>';
                                                        } elseif ($result->pay_status == 'Pending') {
                                                            echo '<span class="label label-warning">Pending</span>';
                                                        } else {
                                                            echo '<span class="label label-danger">Not Paid</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo htmlentities($result->amount); ?></td>
                                                  
                                                    <td>
                                                        <?php if ($result->pay_status != 'Paid' && $result->DeliveryOption === 'delivery' ) { ?>
                                                            <form method="get" action="payment.php" style="display:inline;">
                                                                <input type="hidden" name="issued_id" value="<?php echo htmlentities($result->rid); ?>">
                                                                <button type="submit" class="btn btn-primary">Pay</button>
                                                            </form>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php 
                                                $cnt++;
                                            } 
                                        } else { 
                                            ?>
                                            <tr>
                                                <td colspan="11" class="text-center">No books issued yet.</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>
      <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- DATATABLE SCRIPTS  -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable();
        });
    </script>
</body>
</html>
