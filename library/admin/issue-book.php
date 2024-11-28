<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0)
{   
    header('location:index.php');
}
else { 

    if(isset($_POST['issue'])) {
        $studentid = strtoupper($_POST['studentid']);
        $bookid = $_POST['bookid'];
        $isissued = 1;
        $delivery_option = $_POST['delivery_option'];
        $expected_return_date = $_POST['expected_return_date'];

        // Insert data into tblissuedbookdetails and update tblbooks with delivery option and return date
        $sql = "INSERT INTO tblissuedbookdetails(StudentID, BookId, DeliveryOption, ExpectedReturnDate) 
                VALUES(:studentid, :bookid, :delivery_option, :expected_return_date);
                UPDATE tblbooks SET isIssued = :isissued WHERE id = :bookid;";
        $query = $dbh->prepare($sql);
        $query->bindParam(':studentid', $studentid, PDO::PARAM_STR);
        $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
        $query->bindParam(':isissued', $isissued, PDO::PARAM_STR);
        $query->bindParam(':delivery_option', $delivery_option, PDO::PARAM_STR);
        $query->bindParam(':expected_return_date', $expected_return_date, PDO::PARAM_STR);
        $query->execute();

        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId) {
            $_SESSION['msg'] = "Book issued successfully";
            header('location: manage-issued-books.php');
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again";
            header('location: manage-issued-books.php');
        }
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>U-BOSS | Issue a new Book</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <script>
    // function for get student name
    function getstudent() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "get_student.php",
            data:'studentid='+$("#studentid").val(),
            type: "POST",
            success:function(data){
                $("#get_student_name").html(data);
                $("#loaderIcon").hide();
            },
            error:function (){}
        });
    }

    //function for book details
    function getbook() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "get_book.php",
            data:'bookid='+$("#bookid").val(),
            type: "POST",
            success:function(data){
                $("#get_book_name").html(data);
                $("#loaderIcon").hide();
            },
            error:function (){}
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
                    <h2 style="text-align: center;">Issue a New Book</h2><h2 style="border-top: 1px solid black; padding-bottom: 5px;">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Issue a New Book
                        </div>
                        <div class="panel-body">
                            <form method="post" action="" name="issuebook">
                                <div class="form-group">
                                    <label>Student ID<span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="studentid" id="studentid" onBlur="getstudent()" required="required" />
                                </div>
                                <div class="form-group">
                                    <label>Student Name</label>
                                    <span id="get_student_name"></span>
                                </div>
                                <div class="form-group">
                                    <label>ISBN Number or Book Title<span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="bookid" id="bookid" onBlur="getbook()" required="required" />
                                </div>
                                <div class="form-group">
                                    <label>Book Title</label>
                                    <span id="get_book_name"></span>
                                </div>

                                <!-- Delivery Option -->
                                <div class="form-group">
                                    <label>Delivery Option<span style="color:red;">*</span></label>
                                    <select class="form-control" name="delivery_option" required="required">
                                        <option value="">Select Delivery Option</option>
                                        <option value="delivery">delivery</option>
                                        <option value="pickup">pickup</option>
                                    </select>
                                </div>

                                <!-- Expected Return Date -->
                                <div class="form-group">
                                    <label>Expected Return Date<span style="color:red;">*</span></label>
                                    <input class="form-control" type="date" name="expected_return_date" required="required" />
                                </div>

                                <button type="submit" name="issue" class="btn btn-primary">Issue Book</button>
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
</body>
</html>
