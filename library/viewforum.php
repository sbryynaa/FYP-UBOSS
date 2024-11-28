<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if a thread_id is provided in the URL
if (isset($_GET['thread_id'])) {
    $thread_id = $_GET['thread_id'];

    // Fetch the selected thread details from the database
    $sql = "SELECT * FROM forum_threads WHERE thread_id = :thread_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':thread_id', $thread_id, PDO::PARAM_INT);
    $query->execute();
    $thread = $query->fetch(PDO::FETCH_OBJ);

    // Fetch all replies for the thread
    $reply_sql = "SELECT * FROM forum_replies WHERE thread_id = :thread_id ORDER BY created_at ASC";
    $reply_query = $dbh->prepare($reply_sql);
    $reply_query->bindParam(':thread_id', $thread_id, PDO::PARAM_INT);
    $reply_query->execute();
    $replies = $reply_query->fetchAll(PDO::FETCH_OBJ);

    // Handle reply submission
    if (isset($_POST['submit_reply'])) {
        $username = $_POST['username'];
        $content = $_POST['content'];

        // Insert new reply into the database
        $insert_reply_sql = "INSERT INTO forum_replies (thread_id, user_name, reply_content) 
                             VALUES (:thread_id, :username, :content)";
        $insert_reply_query = $dbh->prepare($insert_reply_sql);
        $insert_reply_query->bindParam(':thread_id', $thread_id, PDO::PARAM_INT);
        $insert_reply_query->bindParam(':username', $username, PDO::PARAM_STR);
        $insert_reply_query->bindParam(':content', $content, PDO::PARAM_STR);
        $insert_reply_query->execute();
    }
}
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>View Thread</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <style>
        /* New style for a smaller content container */
        .content-container {
            max-width: 800px; /* Adjust width as needed */
            margin: 0 auto;
        }

        .forum-thread {
            border: 1px solid #ddd;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .forum-thread-title {
            font-size: 18px;
            font-weight: bold;
        }

        .forum-thread-content {
            font-size: 16px;
            color: #555;
        }

        .forum-reply {
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }

        .forum-reply-content {
            font-size: 14px;
            color: #555;
        }

        .forum-reply-info {
            font-size: 12px;
            color: #777;
        }

        .forum-reply-form {
            margin-top: 30px;
        }

        .form-control {
            font-size: 14px;
            padding: 8px;
        }
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>

    <div class="content-wrapper">
        <div class="container content-container">
            <div class="row pad-botm">
                <div class="col-md-12 text-center">
                    <h2><?php echo htmlentities($thread->thread_title); ?></h2>
                    <p>Posted by: <?php echo htmlentities($thread->user_name); ?> on <?php echo htmlentities($thread->created_at); ?></p>
                </div>
            </div>

            <!-- Thread Details -->
            <div class="forum-thread">
                <div class="forum-thread-title"><?php echo htmlentities($thread->thread_title); ?></div>
                <div class="forum-thread-content"><?php echo nl2br(htmlentities($thread->thread_content)); ?></div>
            </div>

            <!-- Replies Section -->
            <div class="forum-replies">
                <?php foreach ($replies as $reply) { ?>
                    <div class="forum-reply">
                        <div class="forum-reply-content"><?php echo nl2br(htmlentities($reply->reply_content)); ?></div>
                        <div class="forum-reply-info">
                            <small>Replied by: <?php echo htmlentities($reply->user_name); ?> on <?php echo htmlentities($reply->created_at); ?></small>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Reply Form -->
            <div class="forum-reply-form">
                <h5>Reply to this Thread</h5>
                <form method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label for="content">Reply</label>
                        <textarea name="content" class="form-control" rows="5" required></textarea>
                    </div>
                    <button type="submit" name="submit_reply" class="btn btn-primary">Post Reply</button>
                    <a href="forum.php" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
