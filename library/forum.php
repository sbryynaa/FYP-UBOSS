<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Handle thread submission
if (isset($_POST['submit_thread'])) {
    $username = $_POST['username'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Insert new thread into database
    $sql = "INSERT INTO forum_threads (user_name, thread_title, thread_content) 
            VALUES (:username, :title, :content)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':title', $title, PDO::PARAM_STR);
    $query->bindParam(':content', $content, PDO::PARAM_STR);
    $query->execute();
}

// Fetch all threads from database
$sql = "SELECT * FROM forum_threads ORDER BY created_at DESC";
$query = $dbh->prepare($sql);
$query->execute();
$threads = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Forum</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <style>
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

        .forum-thread-info {
            font-size: 12px;
            color: #777;
        }

        .forum-reply-link {
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
        }

        .forum-reply-link:hover {
            text-decoration: underline;
        }

        .thread-form {
            margin-top: 30px;
        }

        /* New Layout Styles */
        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .forum-threads {
            flex: 0 0 60%; /* Left side takes 70% of the width */
            margin-right: 30px;
        }

        .thread-form {
            flex: 0 0 30%; /* Right side form takes 30% of the width */
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 15px;
        }

        /* Adjust form to be more compact */
        .form-control {
            font-size: 14px;
            padding: 8px;
        }

        h5 {
            font-size: 18px;
            margin-bottom: 15px;
        }

        /* Adjust spacing for responsiveness */
        @media (max-width: 768px) {
            .forum-threads, .thread-form {
                flex: 0 0 100%; /* Stack the form and threads on smaller screens */
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>

    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h2 style="text-align: center; font-family: 'Times New Roman', serif";>Forum</h2><h2 style="border-top: 1px solid black; padding-bottom: 5px;">
                </div>
            </div>

            <!-- Thread Submission Form -->
            <div class="row">
                <div class="forum-threads">
                    <h5>Threads</h5>
                    <?php
                    // Loop through each thread and display them
                    foreach ($threads as $thread) {
                        // Get number of replies for each thread
                        $reply_sql = "SELECT COUNT(*) AS reply_count FROM forum_replies WHERE thread_id = :thread_id";
                        $reply_query = $dbh->prepare($reply_sql);
                        $reply_query->bindParam(':thread_id', $thread->thread_id, PDO::PARAM_INT);
                        $reply_query->execute();
                        $reply_count = $reply_query->fetch(PDO::FETCH_OBJ)->reply_count;
                    ?>
                        <div class="forum-thread">
                            <div class="forum-thread-title"><?php echo htmlentities($thread->thread_title); ?></div>
                            <div class="forum-thread-content"><?php echo nl2br(htmlentities($thread->thread_content)); ?></div>
                            <div class="forum-thread-info">
                                <small>Posted by: <?php echo htmlentities($thread->user_name); ?> on <?php echo htmlentities($thread->created_at); ?></small>
                            </div>
                            <a href="viewforum.php?thread_id=<?php echo $thread->thread_id; ?>" class="forum-reply-link">
                                <?php echo $reply_count . " repl" . ($reply_count != 1 ? "ies" : ""); ?>
                            </a>
                        </div>
                    <?php } ?>
                </div>

                <div class="thread-form">
                    <h5>Create a New Thread</h5>
                    <form method="POST">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea name="content" class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" name="submit_thread" class="btn btn-primary">Post Thread</button>
                    </form>
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
