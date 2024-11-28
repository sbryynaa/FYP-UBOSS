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
    $sql = "SELECT tblbooks.BookName,tblissuedbookdetails.IssuesDate, 
                   tblissuedbookdetails.ExpectedReturnDate, 
                   tblissuedbookdetails.id AS rid, tblissuedbookdetails.fine, tblissuedbookdetails.payment_status
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
            $currentDate = new DateTime();
            $expectedReturnDate = new DateTime($result->ExpectedReturnDate);

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

            // Update the fine in the database if it has changed
            if ($result->fine != $fine) {
                $sql_update_fine = "UPDATE tblissuedbookdetails SET fine = :fine WHERE id = :issued_id";
                $query_update_fine = $dbh->prepare($sql_update_fine);
                $query_update_fine->bindParam(':fine', $fine, PDO::PARAM_INT);
                $query_update_fine->bindParam(':issued_id', $result->rid, PDO::PARAM_INT);
                $query_update_fine->execute();
            }

            // Update the payment status to "Not Paid" or "Paid" based on fine
            if ($fine > 0 && $result->payment_status != 'Paid') {
                $sql_update_status = "UPDATE tblissuedbookdetails SET payment_status = 'Not Paid' WHERE id = :issued_id";
                $query_update_status = $dbh->prepare($sql_update_status);
                $query_update_status->bindParam(':issued_id', $result->rid, PDO::PARAM_INT);
                $query_update_status->execute();
            } elseif ($fine == 0 && $result->payment_status != 'Paid') {
                $sql_update_status = "UPDATE tblissuedbookdetails SET payment_status = 'Paid' WHERE id = :issued_id";
                $query_update_status = $dbh->prepare($sql_update_status);
                $query_update_status->bindParam(':issued_id', $result->rid, PDO::PARAM_INT);
                $query_update_status->execute();
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
        }
    }

    // Handle payment actions for overdue books
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $message = '';
        $errorMessage = '';

        if (isset($_POST['pay_book'])) {
            $issued_id = $_POST['issued_id'];
            // Redirect to finespayment.php for fine payment
            header("Location: finespayment.php?issued_id=$issued_id");
            exit; // Ensure script stops executing after redirection
        }
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>U-BOSS | Overdue Books</title>
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
                    <h4 class="header-line">Overdue Books</h4>
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
                                           
                                            <th>Issued Date</th>
                                            <th>Expected Return Date</th>
                                            <th>Fine</th>
                                            <th>Payment Status</th>
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
                                                                                                      <td><?php echo htmlentities($result->IssuesDate); ?></td>
                                                    <td><?php echo htmlentities($result->ExpectedReturnDate); ?></td>
                                                    <td><?php echo htmlentities($result->fine); ?></td>
                                                    <td><?php echo htmlentities($result->payment_status); ?></td>
                                                    <td>
                                                        <?php if ($result->fine > 0 && $result->payment_status != 'Paid') { ?>
                                                            <form method="post">
                                                                <input type="hidden" name="issued_id" value="<?php echo htmlentities($result->rid); ?>" />
                                                                <button type="submit" name="pay_book" class="btn btn-success">Pay</button>
                                                            </form>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                        <?php $cnt++; } } ?>
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
