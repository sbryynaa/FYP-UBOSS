<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Clear session if logged in
if ($_SESSION['login'] != '') {
    $_SESSION['login'] = '';
}

// Handle login submission
if (isset($_POST['login'])) {
    $email = $_POST['emailid'];
    $password = md5($_POST['password']);
    $sql = "SELECT EmailId, Password, StudentId, Status FROM tblstudents WHERE EmailId=:email AND Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            $_SESSION['stdid'] = $result->StudentId;
            if ($result->Status == 1) {
                $_SESSION['login'] = $_POST['emailid'];
                echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
            } else {
                echo "<script>alert('Your Account Has been blocked. Please contact admin.');</script>";
            }
        }
    } else {
        echo "<script>alert('Invalid Details');</script>";
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
    <title>U-BOSS </title>
    <!-- BOOTSTRAP CORE STYLE -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Open Sans', sans-serif; }
        
        .contact-section {
            margin: 50px 0;
            padding: 40px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .contact-section h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-size: 28px;
        }

        .contact-info {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .contact-info h4 {
            color: #555;
            margin-bottom: 10px;
        }

        .contact-info p {
            margin: 0;
            color: #777;
        }

        .map-container {
            position: relative;
            width: 100%;
            height: 400px;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 20px;
        }

        iframe {
            border: 0;
            width: 100%;
            height: 100%;
        }
   .slideshow-container {
    position: relative;
    max-width: 1000px;
    margin: auto;
    overflow: hidden;
}

.mySlides {
    display: none; /* Hide slides initially */
}

.mySlides img {
    width: 100%;
    height: 400px; /* Set a fixed height for consistency */
    object-fit: cover; /* Ensure the image covers the area without stretching */
    border-radius: 10px; /* Optional: to give rounded corners */
}

     .staff-card-container {
        position: relative;
        display: flex;
        justify-content: space-between;
    }
    .staff-card {
        display: flex;
        flex-wrap: nowrap;
        overflow: hidden;
        width: 100%;
    }
    .staff-profile {
        flex: 1;
        padding: 10px;
        text-align: center;
        max-width: 33.33%;
    }
    .staff-profile img {
        width: 50%;
        height: auto;
        border-radius: 50%;
    }
   .nav-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.3); /* Lighter background */
    color: white;
    border: none;
    padding: 8px; /* Slightly bigger but still subtle */
    font-size: 18px;
    cursor: pointer;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* More subtle shadow */
    transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
}

.nav-arrow:hover {
    background-color: rgba(0, 0, 0, 0.5); /* Less contrast on hover */
    transform: translateY(-50%) scale(1.05); /* Subtle scaling effect */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3); /* Subtle shadow on hover */
}

.prev {
    left: 10px;
}

.next {
    right: 10px;
}

.text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 30px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

    </style>
</head>
<body>
    <!-- MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->
    &nbsp;
   
  <div class="content-wrapper">
        <div class="container">
            <!-- Slider -->
            <div class="slideshow-container">
               <div class="mySlides">
                    <img src="assets/img/lib2.jpg" alt="Library Image">
                    <div class="text">Welcome to Our Library</div>
                </div>
                <div class="mySlides">
                    <img src="assets/img/library.jpg" alt="Library Image">
                    <div class="text">Explore the World of Knowledge</div>
                </div>
                <div class="mySlides">
                    <img src="assets/img/uptm.jpg" alt="UPTM Image">
                    <div class="text">Your Journey Starts Here</div>
                </div>
                 <div class="mySlides">
                    <img src="assets/img/xox.png" alt="alkhwarizmi Image" >
                    <div class="text"></div>
                </div>
                
            </div>

            <!-- Contact and Location Section -->
            <div class="contact-section">
                <h2>Contact and Location</h2>
                &nbsp;
                <div class="row">
                    <div class="col-md-6">
                        <div class="contact-info">
                            <h4><i class="fa fa-map-marker" aria-hidden="true"></i> Office Address</h4>
                            <p>PERPUSTAKAAN AL-KAWARIZMI</p>
                            <p>Aras 1, Universiti Poly-Tech Malaysia Jalan 6/91, Taman Shamelin perkasa 56100, Cheras, Kuala Lumpur</p>
                        </div>
                        <div class="contact-info">
                            <h4><i class="fa fa-phone" aria-hidden="true"></i> Phone</h4>
                            <p>03-92069700</p>
                            
                        </div>
                        <div class="contact-info">
                            <h4><i class="fa fa-envelope" aria-hidden="true"></i> Email</h4>
                            <p>library@uptm.edu.my</p>
                          
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="map-container">
                           <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d254971.2492251374!2d101.48307818380992!3d3.114341390621827!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc374119aeec81%3A0xa023551a33256eb1!2sUniversiti%20Poly-Tech%20Malaysia!5e0!3m2!1sen!2smy!4v1731049621304!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
    
<!-- Staff Section -->
<div class="staff-section">
    <h2 style="text-align: center;">Our Dedicated Staff</h2>
    <div class="staff-card-container">
        <div class="staff-card">
            <?php
            // Array of staff data (only 3 items will be shown at a time)
            $staff = [
                [
                    'name' => 'SHARIFFAH SHUHAIZA BINTI SYED MOHD NOR',
                    'position' => 'Senior Assistant Registrar',
                    'department' => 'Information Management & Services Unit',
                    'email' => 'sshuhaiza@uptm.edu.my',
                    'phone' => '603-9206 9700 ext 663',
                    'photo' => 'sharifah-shuhaiza.png'
                ],
                [
                    'name' => 'PA’IZAH BINTI YUSOFF',
                    'position' => 'Senior Assistant Registrar',
                    'department' => 'Collection Development & Cataloging Unit',
                    'email' => 'paizah@uptm.edu.my',
                    'phone' => '603-9206 9700 ext 664',
                    'photo' => 'paizah.png'
                ],
                [
                    'name' => 'ROHANA BINTI A.AZIZ',
                    'position' => 'Senior Clerk',
                    'department' => '',
                    'email' => 'rohana@uptm.edu.my',
                    'phone' => '603-9206 9700 ext 666',
                    'photo' => 'rohana.png'
                ],
                [
                    'name' => 'SERIPAH NAZLIL BINTI SYED MOHAMED',
                    'position' => 'Senior Library Service Assistant',
                    'department' => '',
                    'email' => 'snazlil@uptm.edu.my',
                    'phone' => '603-9206 9700 ext 669',
                    'photo' => 'seripah.png'
                ],
                [
                    'name' => 'NOOR MAHANI BINTI HAJI MOHD NOORDIN',
                    'position' => 'Senior Library Service Assistant',
                    'department' => '',
                    'email' => 'nmahani@uptm.edu.my',
                    'phone' => '603-9206 9700 ext 668',
                    'photo' => 'mahani.png'
                ],
                [
                    'name' => 'RAFEAH BINTI MOHAMAD',
                    'position' => 'Senior Library Service Assistant',
                    'department' => '',
                    'email' => 'rafeah@uptm.edu.my',
                    'phone' => '603-9206 9700 ext 669',
                    'photo' => 'rafeah.png'
                ],
                [
                    'name' => 'NORMA BINTI NORDIN',
                    'position' => 'Library Service Assistant',
                    'department' => '',
                    'email' => 'norma@uptm.edu.my',
                    'phone' => '603-9206 9700 ext 668',
                    'photo' => 'norma.png'
                ]
            ];

            // Display first 3 staff members
            $displayedStaff = array_slice($staff, 0, 3); // Get the first 3 staff members
            foreach ($displayedStaff as $member) {
                echo '<div class="staff-profile">';
                echo '<img src="assets/img/' . $member['photo'] . '" alt="Staff Image">';
                echo '<h3>' . $member['name'] . '</h3>';
                echo '<p class="role">' . $member['position'] . '</p>';
                if ($member['department']) {
                    echo '<p>' . $member['department'] . '</p>';
                }
                echo '<p>Email: <a href="mailto:' . $member['email'] . '">' . $member['email'] . '</a></p>';
                echo '<p>Phone: ' . $member['phone'] . '</p>';
                echo '</div>';
            }
            ?>
        </div>

        <!-- Navigation Arrows -->
        <button class="nav-arrow prev" onclick="showStaff('prev')">&#8592;</button>
        <button class="nav-arrow next" onclick="showStaff('next')">&#8594;</button>
    </div>
</div>
</div></div>
    <!-- CONTENT-WRAPPER SECTION END-->


    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
<script>
    let currentIndex = 0; // Index to track the currently displayed staff

    const staff = <?php echo json_encode($staff); ?>; // Convert the PHP array to a JavaScript array

    function showStaff(direction) {
        const staffContainer = document.querySelector('.staff-card');
        
        if (direction === 'next') {
            currentIndex = (currentIndex + 3) % staff.length; // Go to next set of staff
        } else {
            currentIndex = (currentIndex - 3 + staff.length) % staff.length; // Go to previous set of staff
        }

        // Clear the container and display the new staff profiles
        staffContainer.innerHTML = '';
        
        // Display next 3 staff members based on the current index
        const displayedStaff = staff.slice(currentIndex, currentIndex + 3);
        displayedStaff.forEach(member => {
            const profileHTML = `
                <div class="staff-profile">
                    <img src="assets/img/${member.photo}" alt="Staff Image">
                    <h3>${member.name}</h3>
                    <p class="role">${member.position}</p>
                    ${member.department ? `<p>${member.department}</p>` : ''}
                    <p>Email: <a href="mailto:${member.email}">${member.email}</a></p>
                    <p>Phone: ${member.phone}</p>
                </div>
            `;
            staffContainer.innerHTML += profileHTML;
        });
    }
</script>
   <script>
        let slideIndex = 0;
    showSlides();

    function showSlides() {
        let slides = document.getElementsByClassName("mySlides");
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  // Hide all slides
        }
        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1;  // Reset to first slide
        }
        slides[slideIndex - 1].style.display = "block";  // Show the current slide
        setTimeout(showSlides, 3000);  // Change slide every 3 seconds
    }
    </script>
</body>
</html>
