<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Redirect if not logged in
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
} else {
    // Handle return and delete actions
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Initialize feedback messages
        $message = '';
        $errorMessage = '';

        if (isset($_POST['return_book'])) {
            $issued_id = $_POST['issued_id'];
            // Update the status and return date when book is returned
            $sql = "UPDATE tblissuedbookdetails SET status = 'Returned', ReturnDate = NOW() WHERE id = :issued_id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':issued_id', $issued_id, PDO::PARAM_INT);
            if ($query->execute()) {
                // Clear ReturnDate if not returned
                $sql_clear = "UPDATE tblissuedbookdetails SET ReturnDate = NULL WHERE id = :issued_id AND status != 'Returned'";
                $clear_query = $dbh->prepare($sql_clear);
                $clear_query->bindParam(':issued_id', $issued_id, PDO::PARAM_INT);
                $clear_query->execute();
                
                $message = "Book returned successfully!";
            } else {
                $errorMessage = "Error while returning the book.";
            }
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
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>U-BOSS | Manage Issued Books</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.css" rel="stylesheet">
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h2 style="text-align: center;">Manage Issued Books</h2><h2 style="border-top: 1px solid black; padding-bottom: 5px;">
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
                                            <th>Student Name</th>
                                          
                                            <th>Book Name</th>
                                            <th>ISBN</th>
                                            <th>Issued Date</th>
                                            <th>Expected Return Date</th>
                                            <th>Update</th>
                                            <th>Delivery Option</th>
                                           
                                            <th>Status</th>
                                            <th>Payment Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT tblstudents.FirstName, tblstudents.LastName, tblbooks.BookName, tblbooks.ISBNNumber, 
                                                       tblissuedbookdetails.IssuesDate, tblissuedbookdetails.ExpectedReturnDate, 
                                                       tblissuedbookdetails.ReturnDate, tblissuedbookdetails.id as rid,
                                                       tblissuedbookdetails.DeliveryOption, 
                                                       tblissuedbookdetails.status, tblissuedbookdetails.pay_status
                                                FROM tblissuedbookdetails 
                                                JOIN tblstudents ON tblstudents.StudentId = tblissuedbookdetails.StudentId 
                                                JOIN tblbooks ON tblbooks.id = tblissuedbookdetails.BookId 
                                                ORDER BY tblissuedbookdetails.id DESC";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;

                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {
                                                ?>
                                                <tr class="odd gradeX">
                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                     <td><?php echo htmlentities($result->FirstName . ' ' . $result->LastName); ?></td>

                                                    <td><?php echo htmlentities($result->BookName); ?></td>
                                                    <td><?php echo htmlentities($result->ISBNNumber); ?></td>
                                                    <td><?php echo htmlentities($result->IssuesDate); ?></td>
                                                    <td><?php echo htmlentities($result->ExpectedReturnDate); ?></td>
                                                    <td><?php echo $result->ReturnDate ? htmlentities($result->ReturnDate) : "Not Returned Yet"; ?></td>
                                                    <td><?php echo htmlentities($result->DeliveryOption); ?></td>
                                                   
                                                    <td><?php echo htmlentities($result->status); ?></td>
                                                    <td><?php echo $result->pay_status == 'Paid' ? '<span class="label label-success">Paid</span>' : '<span class="label label-danger">Not Paid</span>'; ?></td>
                                                    <td>
                                                        <?php if ($result->status != 'Returned') { ?>
                                                            <form method="post" style="display:inline;">
                                                                <input type="hidden" name="issued_id" value="<?php echo htmlentities($result->rid); ?>">
                                                                <button type="submit" name="return_book" class="btn btn-danger btn-xs">Return</button>
                                                            </form>
                                                        <?php } ?>
                                                        <a href="editstatus.php?issued_id=<?php echo htmlentities($result->rid); ?>" class="btn btn-info btn-xs">Manage Status</a>
                                                        <form method="post" style="display:inline;">
                                                            <input type="hidden" name="issued_id" value="<?php echo htmlentities($result->rid); ?>">
                                                            <button type="submit" name="delete_book" class="btn btn-warning btn-xs" onclick="return confirm('Are you sure you want to delete this issued book record?');">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php 
                                                $cnt++; 
                                            }
                                        } else { ?>
                                            <tr>
                                                <td colspan="12" class="text-center">No books issued</td>
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
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTables-example').dataTable();
        });
    </script>
</body>
</html>
