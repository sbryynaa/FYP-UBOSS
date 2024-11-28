<?php 
session_start();
include('includes/config.php');
error_reporting(0);

if(strlen($_SESSION['login']) == 0) {   
    header('location:index.php');
} else { 
    if(isset($_POST['update'])) {    
        $sid = $_SESSION['stdid'];  
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $mobileno = $_POST['mobileno'];
        $address = $_POST['address'];
        $poscode = $_POST['poscode'];
        $state = $_POST['state'];

        // Update FirstName, LastName, MobileNumber, Address, Poscode, and State
        $sql = "UPDATE tblstudents SET FirstName=:firstname, LastName=:lastname, MobileNumber=:mobileno, Address=:address, Poscode=:poscode, State=:state WHERE StudentId=:sid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':sid', $sid, PDO::PARAM_STR);
        $query->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':poscode', $poscode, PDO::PARAM_STR);
        $query->bindParam(':state', $state, PDO::PARAM_STR);
        $query->execute();

        echo '<script>alert("Your profile has been updated")</script>';
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>U-BOSS | Student Profile</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <style>
        .form-group label {
            font-size: 14px;
        }
        .form-control {
            font-size: 14px;
        }
        .panel-body {
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <?php include('includes/header.php');?>

     <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">My Profile</h4>
            </div>
        </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                   <div class="panel panel-danger">
                        <div class="panel-heading">My Profile</div>
                        <div class="panel-body">
                            <form name="signup" method="post">
                            <?php 
                            $sid = $_SESSION['stdid'];
                            // Fetch the profile details including Address, Poscode, State, and IdCardNumber
                            $sql = "SELECT StudentId, FirstName, LastName, EmailId, MobileNumber, Address, Poscode, State, IdCardNumber, RegDate, UpdationDate, Status FROM tblstudents WHERE StudentId=:sid";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':sid', $sid, PDO::PARAM_STR);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);

                            if($query->rowCount() > 0) {
                                foreach($results as $result) { ?>  

                                    <div class="form-group">
                                        <label>Student ID :</label>
                                        <?php echo htmlentities($result->StudentId);?>
                                    </div>

                                    <div class="form-group">
                                        <label>National ID :</label>
                                        <?php echo htmlentities($result->IdCardNumber);?>
                                    </div>

                                    <div class="form-group">
                                        <label>Reg Date :</label>
                                        <?php echo htmlentities($result->RegDate);?>
                                    </div>

                                    <?php if($result->UpdationDate != "") { ?>
                                    <div class="form-group">
                                        <label>Last Updation Date :</label>
                                        <?php echo htmlentities($result->UpdationDate);?>
                                    </div>
                                    <?php } ?>

                                    <div class="form-group">
                                        <label>Profile Status :</label>
                                        <?php if($result->Status == 1) { ?>
                                            <span style="color: green">Active</span>
                                        <?php } else { ?>
                                            <span style="color: red">Blocked</span>
                                        <?php }?>
                                    </div>

                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input class="form-control" type="text" name="firstname" value="<?php echo htmlentities($result->FirstName);?>" autocomplete="off" required />
                                    </div>

                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input class="form-control" type="text" name="lastname" value="<?php echo htmlentities($result->LastName);?>" autocomplete="off" required />
                                    </div>

                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input class="form-control" type="text" name="mobileno" maxlength="10" value="<?php echo htmlentities($result->MobileNumber);?>" autocomplete="off" required />
                                    </div>

                                    <div class="form-group">
                                        <label>Address</label>
                                        <input class="form-control" type="text" name="address" value="<?php echo htmlentities($result->Address);?>" autocomplete="off" required />
                                    </div>

                                    <div class="form-group">
                                        <label>Poscode</label>
                                        <input class="form-control" type="text" name="poscode" value="<?php echo htmlentities($result->Poscode);?>" autocomplete="off" required />
                                    </div>

                                    <div class="form-group">
                                        <label>State</label>
                                        <input class="form-control" type="text" name="state" value="<?php echo htmlentities($result->State);?>" autocomplete="off" required />
                                    </div>

                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input class="form-control" type="email" name="email" id="emailid" value="<?php echo htmlentities($result->EmailId);?>" autocomplete="off" required readonly />
                                    </div>

                            <?php }} ?>
                              
                                <button type="submit" name="update" class="btn btn-primary" id="submit">Update Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php');?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
