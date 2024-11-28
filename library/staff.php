<?php
session_start();
error_reporting(0);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>U-BOSS</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <style>
        .staff-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 20px;
        }

        .staff-member {
            width: 300px;
            text-align: center;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .staff-photo {
            width: 100%;
            height: 100%; /* Set the height equal to the width for a square */
            max-width: 200px; /* Limit the size */
            max-height: 200px; /* Limit the size */
            object-fit: cover; /* Ensure the image covers the area without distortion */
            border-radius: 8px; /* Optional: Keep the rounded corners */
            margin-bottom: 10px;
        }

        .staff-name {
            font-weight: bold;
            font-size: 18px;
            color: #333;
        }

        .staff-position,
        .staff-department,
        .staff-email,
        .staff-phone {
            font-size: 14px;
            color: #555;
        }

        .staff-member:hover {
            background-color: #f8f8f8;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: scale(1.05);
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>

    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h2 style="text-align: center;  font-family: 'Times New Roman', serif">Library Staff</h2><h2 style="border-top: 1px solid black; padding-bottom: 5px;">
                </div>

            </div>

  
     
        <div class="staff-container">
            <?php
            // Hardcoded staff data with correct commas between array items
            $staffMembers = [
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
                ]
                ,
                [
                    'name' => 'NORMA BINTI NORDIN',
                    'position' => 'Library Service Assistant',
                    'department' => '',
                    'email' => 'norma@uptm.edu.my',
                    'phone' => '603-9206 9700 ext 668',
                    'photo' => 'norma.png'
                ]
            ];

            // Loop through and display staff members
            foreach ($staffMembers as $staff) {
                ?>
                <div class="staff-member">
                    <!-- Staff photo -->
                    <img src="assets/img/<?php echo $staff['photo']; ?>" alt="<?php echo $staff['name']; ?>" class="staff-photo">
                    <div class="staff-name"><?php echo $staff['name']; ?></div>
                    <div class="staff-position"><?php echo $staff['position']; ?></div>
                    <div class="staff-department"><?php echo $staff['department']; ?></div>
                    <div class="staff-email"><?php echo $staff['email']; ?></div>
                    <div class="staff-phone"><?php echo $staff['phone']; ?></div>
                </div>
                <?php
            }
            ?>
        </div>
    </div></div>

    <?php include('includes/footer.php'); ?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
