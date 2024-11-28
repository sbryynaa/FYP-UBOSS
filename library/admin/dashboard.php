<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{ 
    header('location:index.php');
}
else{
    // Check for recently issued books (issued in the last 24 hours)
    $sql_recent_checkout = "SELECT id FROM tblissuedbookdetails WHERE IssuesDate > DATE_SUB(NOW(), INTERVAL 1 DAY)";
    $query_recent_checkout = $dbh->prepare($sql_recent_checkout);
    $query_recent_checkout->execute();
    $recent_checkouts = $query_recent_checkout->rowCount(); // Count the number of books issued recently
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>U-BOSS | Admin Dash Board</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
      <!-- MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">ADMIN DASHBOARD</h4>  
            </div>
        </div>

        <!-- Notification Box for Recent Checkouts -->
        <?php if($recent_checkouts > 0): ?>
            <div class="alert alert-info text-center">
                <i class="fa fa-bell"></i> You have <?php echo $recent_checkouts; ?> new book checkout(s) in the last 24 hours.  
                 <a href="manage-issued-books.php" class="btn btn-info">Click Here!</a>
            </div>
        <?php endif; ?>

        <div class="row">
            <a href="manage-books.php">
                <div class="col-md-2 col-sm-2 col-xs-6">
                    <div class="alert alert-success back-widget-set text-center">
                        <i class="fa fa-book fa-5x"></i>
                        <?php 
                        $sql ="SELECT id from tblbooks ";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $listdbooks=$query->rowCount();
                        ?>
                        <h3><?php echo htmlentities($listdbooks);?></h3>
                        Books Listed
                    </div>
                </div>
            </a>

            <a href="manage-issued-books.php">
                <div class="col-md-3 col-sm-2 col-xs-6">
                    <div class="alert alert-warning back-widget-set text-center">
                        <i class="fa fa-exclamation-triangle fa-5x"></i>
                        <?php 
                        $sql2 ="SELECT id from tblissuedbookdetails where (status='Issued' || status is null)";
                        $query2 = $dbh -> prepare($sql2);
                        $query2->execute();
                        $results2=$query2->fetchAll(PDO::FETCH_OBJ);
                        $returnedbooks=$query2->rowCount();
                        ?>
                        <h3><?php echo htmlentities($returnedbooks);?></h3>
                        Books Not Returned Yet
                    </div>
                </div>
            </a>

            <a href="reg-students.php">
                <div class="col-md-2 col-sm-2 col-xs-6">
                    <div class="alert alert-danger back-widget-set text-center">
                        <i class="fa fa-users fa-5x"></i>
                        <?php 
                        $sql3 ="SELECT id from tblstudents ";
                        $query3 = $dbh -> prepare($sql3);
                        $query3->execute();
                        $results3=$query3->fetchAll(PDO::FETCH_OBJ);
                        $regstds=$query3->rowCount();
                        ?>
                        <h3><?php echo htmlentities($regstds);?></h3>
                        Registered Users
                    </div>
                </div>
            </a>

            <a href="manage-authors.php">
                <div class="col-md-2 col-sm-2 col-xs-6">
                    <div class="alert alert-success back-widget-set text-center">
                        <i class="fa fa-user fa-5x"></i>
                        <?php 
                        $sq4 ="SELECT id from tblauthors ";
                        $query4 = $dbh -> prepare($sq4);
                        $query4->execute();
                        $results4=$query4->fetchAll(PDO::FETCH_OBJ);
                        $listdathrs=$query4->rowCount();
                        ?>
                        <h3><?php echo htmlentities($listdathrs);?></h3>
                        Authors Listed
                    </div>
                </div>
            </a>

            <a href="manage-categories.php">            
                <div class="col-md-2 col-sm-2 col-xs-6">
                    <div class="alert alert-info back-widget-set text-center">
                        <i class="fa fa-file-archive-o fa-5x"></i>
                        <?php 
                        $sql5 ="SELECT id from tblcategory ";
                        $query5 = $dbh -> prepare($sql5);
                        $query5->execute();
                        $results5=$query5->fetchAll(PDO::FETCH_OBJ);
                        $listdcats=$query5->rowCount();
                        ?>
                        <h3><?php echo htmlentities($listdcats);?></h3>
                        Listed Categories
                    </div>
                </div>
            </a>
        </div>
    </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
<?php include('includes/footer.php');?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
