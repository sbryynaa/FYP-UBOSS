<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="User Manual" />
    <meta name="author" content="" />
    <title>User Manual - U-BOSS</title>
    <!-- BOOTSTRAP CORE STYLE -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style>
        .manual-container {
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 900px;
        }
        .manual-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .manual-section {
            margin-bottom: 30px;
        }
        .manual-section h3 {
            color: #555;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }
        .manual-section p {
            color: #777;
            line-height: 1.8;
            text-align: justify;
        }
        .manual-section ul {
            list-style-type: disc;
            margin-left: 20px;
        }
        .manual-section ul li {
            margin-bottom: 10px;
            color: #555;
        }
    </style>
</head>
<body>
    <!-- MENU SECTION START -->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END -->
    <div class="content-wrapper">
        <div class="container">
            <div class="manual-container">
                <h2>User Manual</h2>
                
                <!-- Introduction Section -->
                <div class="manual-section">
                    <h3>Introduction</h3>
                    <p>Welcome to U-BOSS. This user manual is designed to guide you through the system and ensure that you can effectively navigate and utilize all the features provided.</p>
                </div>

                <!-- Login Section -->
                <div class="manual-section">
                    <h3>Logging In</h3>
                    <ul>
                        <li>Go to the login page by clicking on the "Login" option in the menu.</li>
                        <li>Make sure to register your account first at "Register" page in the menu.</li>
                        <li>Enter your email and password registered with the system.</li>
                        <li>If your account is active, you will be redirected to the dashboard. If you encounter issues, contact the administrator.</li>
                    </ul>
                </div>

                <!-- Dashboard Section -->
                <div class="manual-section">
                    <h3>Dashboard Overview</h3>
                    <p>After logging in, you will land on your dashboard, which provides access to key features:</p>
                    <ul>
                        <li><b>Profile:</b> View and edit your personal information.</li>
                        <li><b>Library Resources:</b> Explore available books and materials.</li>
                         <li><b>Forum:</b> Discussion among users.</li>
                          <li><b>Rating:</b>Explore high-rated books.</li>
                        <li><b>Issued Books:</b> Check books history.</li>
                      
                    </ul>
                </div>

                <!-- Borrowing Resources -->
                <div class="manual-section">
                    <h3>Borrowing Books</h3>
                    <p>To borrow books, follow these steps:</p>
                    <ul>
                        <li>Make sure to register and log into the system.</li>
                        <li>Go to the "All Books" section in the menu.</li>
                        <li>Search for the desired book or material using the search bar.</li>
                        <li>Click "Check Out Book" to initiate the borrowing process.</li>
                        <li>Check the book status at "Issued Books".</li>
                        <li>Make sure to make payment for delivery charges.</li>
                        <li>Receipt will be displayed once done payment.</li>
                        <li>Wait for confirmation from the librarian. You will be notified once your request is approved.</li>
                    </ul>
                </div>

                <!-- Troubleshooting -->
                <div class="manual-section">
                    <h3>Troubleshooting</h3>
                    <p>If you encounter any issues while using the system, consider the following:</p>
                    <ul>
                        <li><b>Forgot Password:</b> Use the "Forgot Password" link on the login page to reset your password.</li>
                        <li><b>Account Locked:</b> Contact the administrator at <a href="mailto:library@uptm.edu.my">library@uptm.edu.my</a>.</li>
                        <li><b>System Errors:</b> Refresh the page or try logging out and logging back in.</li>
                    </ul>
                </div>

                <!-- Contact Support -->
                <div class="manual-section">
                    <h3>Contact Support</h3>
                    <p>If you require further assistance, feel free to contact our support team:</p>
                    <ul>
                        <li><b>Email:</b> <a href="mailto:support@uptm.edu.my">support@uptm.edu.my</a></li>
                        <li><b>Phone:</b> 03-92069700</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT WRAPPER END -->

    <!-- FOOTER SECTION START -->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END -->

    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
