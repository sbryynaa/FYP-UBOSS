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

// SQL query to fetch delivery records based on search
$sql = "SELECT tblstudents.FirstName, tblstudents.LastName, tblstudents.Address, tblbooks.BookName, 
               tblissuedbookdetails.DeliveryOption, tblissuedbookdetails.status
        FROM tblissuedbookdetails
        JOIN tblstudents ON tblstudents.StudentId = tblissuedbookdetails.StudentId 
        JOIN tblbooks ON tblbooks.id = tblissuedbookdetails.BookId";

// If there is a search keyword, modify the query to filter by student name, address, or book title
if (!empty($searchKeyword)) {
    $sql .= " WHERE tblstudents.FirstName LIKE :search OR tblstudents.LastName LIKE :search 
              OR tblstudents.Address LIKE :search OR tblbooks.BookName LIKE :search";
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
$cnt = 1;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Manage Delivery | U-BOSS</title>
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
                     <h2 style="text-align: center;">Delivery Information</h2><h2 style="border-top: 1px solid black; padding-bottom: 5px;">
                </div>
            </div>

            <!-- Search Form -->
            <form method="POST" action="" class="form-inline mb-3">
                <input type="text" name="search" class="form-control" placeholder="Search by Student Name, Address, or Book Title" value="<?php echo htmlentities($searchKeyword); ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Delivery Details</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Student Address</th>
                                            <th>Issued Book</th>
                                            <th>Delivery Option</th>
                                            <th>Status</th>
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
                                                    <td><?php echo htmlentities($result->Address); ?></td>
                                                    <td><?php echo htmlentities($result->BookName); ?></td>
                                                    <td><?php echo htmlentities($result->DeliveryOption); ?></td>
                                                    <td><?php echo htmlentities($result->status); ?></td>
                                                </tr>
                                                <?php 
                                                $cnt++; 
                                            }
                                        } else { ?>
                                            <tr>
                                                <td colspan="6" class="text-center">No delivery records found</td>
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
</body>
</html>
