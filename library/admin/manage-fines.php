<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Redirect if not logged in
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
}

// Initialize search keyword
$searchKeyword = isset($_POST['search']) ? $_POST['search'] : '';

// SQL query to fetch fines based on search
$sql = "SELECT tblstudents.FirstName, tblstudents.LastName, tblbooks.BookName, 
               tblissuedbookdetails.fine, tblissuedbookdetails.status, tblissuedbookdetails.id AS fine_id
        FROM tblissuedbookdetails
        JOIN tblstudents ON tblstudents.StudentId = tblissuedbookdetails.StudentId 
        JOIN tblbooks ON tblbooks.id = tblissuedbookdetails.BookId";

// If there is a search keyword, modify the query to filter by student name or book title
if (!empty($searchKeyword)) {
    $sql .= " WHERE tblstudents.FirstName LIKE :search OR tblstudents.LastName LIKE :search 
              OR tblbooks.BookName LIKE :search";
}

$sql .= " ORDER BY tblissuedbookdetails.id DESC";

$query = $dbh->prepare($sql);

// Bind the search parameter if it exists
if (!empty($searchKeyword)) {
    $searchTerm = "%$searchKeyword%";
    $query->bindParam(':search', $searchTerm, PDO::PARAM_STR);
}

$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

// Handle Delete action
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    // Delete the fine record from the database
    $deleteQuery = $dbh->prepare("DELETE FROM tblissuedbookdetails WHERE id = :id");
    $deleteQuery->bindParam(':id', $delete_id, PDO::PARAM_INT);
    if ($deleteQuery->execute()) {
        echo "<script>alert('Fine record deleted successfully');</script>";
        echo "<script>window.location.href='manage-fines.php';</script>";
    } else {
        echo "<script>alert('Failed to delete the record');</script>";
    }
}

$cnt = 1;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Manage Fines | U-BOSS</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                     <h2 style="text-align: center;">Fines Information</h2><h2 style="border-top: 1px solid black; padding-bottom: 5px;">
                </div>
            </div>

            <!-- Search Form -->
            <form method="POST" action="" class="form-inline mb-3">
                <input type="text" name="search" class="form-control" placeholder="Search by Student Name or Book Title" value="<?php echo htmlentities($searchKeyword); ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Fine Details</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Issued Book</th>
                                            <th>Fine (RM)</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {
                                                ?>
                                                <tr class="odd gradeX">
                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                    <td><?php echo htmlentities($result->FirstName . ' ' . $result->LastName); ?></td>
                                                    <td><?php echo htmlentities($result->BookName); ?></td>
                                                    <td><?php echo htmlentities($result->fine); ?></td>
                                                    <td><?php echo htmlentities($result->status); ?></td>
                                                    <td>
                                                        <a href="manage-fines.php?delete_id=<?php echo htmlentities($result->fine_id); ?>" 
                                                           onclick="return confirm('Are you sure you want to delete this fine record?')" 
                                                           class="btn btn-danger">Delete</a>
                                                    </td>
                                                </tr>
                                                <?php 
                                                $cnt++; 
                                            }
                                        } else { ?>
                                            <tr>
                                                <td colspan="6" class="text-center">No fine records found</td>
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
