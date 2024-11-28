<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Handle thread deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Delete the selected thread from the database
    $sql = "DELETE FROM forum_threads WHERE thread_id = :delete_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
    $query->execute();

    // Redirect back to the forum main page after deletion
    header("Location: adminforum.php");
    exit;
}

// Fetch all threads from the database
$sql = "SELECT * FROM forum_threads ORDER BY created_at DESC";
$query = $dbh->prepare($sql);
$query->execute();
$threads = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Forum</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
    <?php include('includes/header.php'); ?>

    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h2 style="text-align: center;">Manage Forum Threads</h2><h2 style="border-top: 1px solid black; padding-bottom: 5px;">
                </div>
            </div>

            <!-- Display Threads in a Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Posted By</th>
                            <th>Date Posted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        foreach ($threads as $thread) { ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo htmlentities($thread->thread_title); ?></td>
                                <td><?php echo nl2br(htmlentities($thread->thread_content)); ?></td>
                                <td><?php echo htmlentities($thread->user_name); ?></td>
                                <td><?php echo htmlentities($thread->created_at); ?></td>
                                <td>
                                    <a href="adminforum.php?delete_id=<?php echo $thread->thread_id; ?>" 
                                       onclick="return confirm('Are you sure you want to delete this thread?');" 
                                       class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
