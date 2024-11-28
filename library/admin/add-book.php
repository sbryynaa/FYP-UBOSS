<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Redirect to login if not logged in
if(strlen($_SESSION['alogin']) == 0) {   
    header('location:index.php');
} else { 

    // Add book to the database
    if(isset($_POST['add'])) {
        $bookname = $_POST['bookname'];
        $category = $_POST['category'];
        $author = $_POST['author'];
        $isbn = $_POST['isbn'];
        $quantity = $_POST['quantity']; // New Quantity Field
        $bookimg = $_FILES["bookpic"]["name"];
        
        // Get the image extension
        $extension = strtolower(pathinfo($bookimg, PATHINFO_EXTENSION));
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        
        // Validate the image extension
        if(!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg / png / gif formats are allowed');</script>";
        } else {
            // Rename the image file
            $imgnewname = md5($bookimg.time()) . '.' . $extension;
            
            // Move the image to the designated directory
            move_uploaded_file($_FILES["bookpic"]["tmp_name"], "bookimg/" . $imgnewname);
            
            // Insert data into the database
            $sql = "INSERT INTO tblbooks (BookName, CatId, AuthorId, ISBNNumber, bookImage, Quantity) 
                    VALUES (:bookname, :category, :author, :isbn, :imgnewname, :quantity)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':bookname', $bookname, PDO::PARAM_STR);
            $query->bindParam(':category', $category, PDO::PARAM_STR);
            $query->bindParam(':author', $author, PDO::PARAM_STR);
            $query->bindParam(':isbn', $isbn, PDO::PARAM_STR);
            $query->bindParam(':imgnewname', $imgnewname, PDO::PARAM_STR);
            $query->bindParam(':quantity', $quantity, PDO::PARAM_INT); // Bind Quantity
            
            // Execute query and check if insertion was successful
            if($query->execute()) {
                echo "<script>alert('Book listed successfully');</script>";
                echo "<script>window.location.href='manage-books.php'</script>";
            } else {
                echo "<script>alert('Something went wrong. Please try again');</script>";
                echo "<script>window.location.href='manage-books.php'</script>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>U-BOSS | Add Book</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script type="text/javascript">
        function checkisbnAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_availability.php",
                data: 'isbn=' + $("#isbn").val(),
                type: "POST",
                success: function(data) {
                    $("#isbn-availability-status").html(data);
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
                    <h4 class="header-line">Add Book</h4>
                </div>
            </div>
            <div class="row">
               <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                    <div class="panel panel-info">
                        <div class="panel-heading">Book Info</div>
                        <div class="panel-body">
                            <form role="form" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Book Name <span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="bookname" autocomplete="off" required />
                                </div>
                                <div class="form-group">
                                    <label>Category <span style="color:red;">*</span></label>
                                    <select class="form-control" name="category" required="required">
                                        <option value="">Select Category</option>
                                        <?php 
                                        $status = 1;
                                        $sql = "SELECT * FROM tblcategory WHERE Status=:status";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':status', $status, PDO::PARAM_STR);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) { ?>
                                                <option value="<?php echo htmlentities($result->id); ?>">
                                                    <?php echo htmlentities($result->CategoryName); ?>
                                                </option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Author <span style="color:red;">*</span></label>
                                    <select class="form-control" name="author" required="required">
                                        <option value="">Select Author</option>
                                        <?php 
                                        $sql = "SELECT * FROM tblauthors";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) { ?>
                                                <option value="<?php echo htmlentities($result->id); ?>">
                                                    <?php echo htmlentities($result->AuthorName); ?>
                                                </option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>ISBN Number <span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="isbn" id="isbn" required="required" autocomplete="off" onBlur="checkisbnAvailability()" />
                                    <p class="help-block">An ISBN is an International Standard Book Number. ISBN Must be unique.</p>
                                    <span id="isbn-availability-status" style="font-size:12px;"></span>
                                </div>
                                <div class="form-group">
                                    <label>Quantity <span style="color:red;">*</span></label>
                                    <input class="form-control" type="number" name="quantity" required="required" min="1" />
                                </div>
                                <div class="form-group">
                                    <label>Book Picture <span style="color:red;">*</span></label>
                                    <input class="form-control" type="file" name="bookpic" autocomplete="off" required="required" />
                                </div>
                                <button type="submit" name="add" id="add" class="btn btn-info">Submit</button>
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
