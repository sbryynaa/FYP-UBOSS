<?php 
session_start();
include('includes/config.php');
error_reporting(0);

if(isset($_POST['signup'])) {
    // Code for student ID
    $count_my_page = ("studentid.txt");
    $hits = file($count_my_page);
    $hits[0]++;
    $fp = fopen($count_my_page, "w");
    fputs($fp, "$hits[0]");
    fclose($fp); 
    $StudentId = $hits[0];

    // Capture form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $mobileno = $_POST['mobileno'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $address = $_POST['address'];
    $poscode = $_POST['poscode'];
    $state = $_POST['state'];
    $id_card_number = $_POST['id_card_number'];
    $status = 1;

    // Insert data into the database
    $sql = "INSERT INTO tblstudents(StudentId, FirstName, LastName, MobileNumber, EmailId, Password, Address, Poscode, State, IdCardNumber, Status) 
            VALUES(:StudentId, :firstname, :lastname, :mobileno, :email, :password, :address, :poscode, :state, :id_card_number, :status)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':StudentId', $StudentId, PDO::PARAM_STR);
    $query->bindParam(':firstname', $firstname, PDO::PARAM_STR);
    $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
    $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->bindParam(':address', $address, PDO::PARAM_STR);
    $query->bindParam(':poscode', $poscode, PDO::PARAM_STR);
    $query->bindParam(':state', $state, PDO::PARAM_STR);
    $query->bindParam(':id_card_number', $id_card_number, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);

    $query->execute();
    $lastInsertId = $dbh->lastInsertId();

    if($lastInsertId) {
        echo '<script>alert("Your Registration is successful and your student id is ' . $StudentId . '")</script>';
    } else {
        echo "<script>alert('Something went wrong. Please try again');</script>";
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>U-BOSS | Student Sign Up</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script type="text/javascript">
        function valid() {
            if(document.signup.password.value != document.signup.confirmpassword.value) {
                alert("Password and Confirm Password Field do not match!");
                document.signup.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
    <script>
        function checkAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_availability.php",
                data: 'emailid=' + $("#emailid").val(),
                type: "POST",
                success: function(data) {
                    $("#user-availability-status").html(data);
                    $("#loaderIcon").hide();
                },
                error: function() {}
            });
        }
    </script>    
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Register New Member</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 col-md-offset-1">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            SIGN UP FORM
                        </div>
                        <div class="panel-body">
                            <form name="signup" method="post" onSubmit="return valid();">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input class="form-control" type="text" name="firstname" autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input class="form-control" type="text" name="lastname" autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label>Identification Card Number</label>
                                    <input class="form-control" type="text" name="id_card_number" maxlength="12" autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label>Home Address</label>
                                    <input class="form-control" type="text" name="address" autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label>Poscode</label>
                                    <input class="form-control" type="text" name="poscode" maxlength="5" autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label>State</label>
                                    <input class="form-control" type="text" name="state" autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <input class="form-control" type="text" name="mobileno" maxlength="10" autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="form-control" type="email" name="email" id="emailid" onBlur="checkAvailability()" autocomplete="off" required />
                                    <span id="user-availability-status" style="font-size:12px;"></span> 
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" type="password" name="password" autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label>Confirm Password </label>
                                    <input class="form-control" type="password" name="confirmpassword" autocomplete="off" required />
                                </div>

                                <button type="submit" name="signup" class="btn btn-danger" id="submit">Register Now </button>
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
    <script src="assets/js/custom.js"></script>
</body>
</html>
