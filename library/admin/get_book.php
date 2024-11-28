<?php 
require_once("includes/config.php");

if (!empty($_POST["bookid"])) {
    $bookid = $_POST["bookid"];

    $sql = "SELECT DISTINCT tblbooks.BookName, tblbooks.id, tblauthors.AuthorName, tblbooks.bookImage
            FROM tblbooks
            JOIN tblauthors ON tblauthors.id = tblbooks.AuthorId
            LEFT JOIN tblissuedbookdetails ON tblbooks.id = tblissuedbookdetails.BookId
            WHERE (ISBNNumber = :bookid OR BookName LIKE :bookid)
            AND (tblissuedbookdetails.BookId IS NULL OR tblissuedbookdetails.ReturnDate IS NOT NULL)";  // Ensures book is not issued

    $query = $dbh->prepare($sql);
    $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
?>
        <table>
            <tr>
                <?php foreach ($results as $result) { ?>
                    <th style="padding-left:5%; width: 10%;">
                        <img src="bookimg/<?php echo htmlentities($result->bookImage); ?>" width="120"><br />
                        <?php echo htmlentities($result->BookName); ?><br />
                        <?php echo htmlentities($result->AuthorName); ?><br />
                        
                        <input type="radio" name="bookid" value="<?php echo htmlentities($result->id); ?>" required> <!-- Radio button for selection -->
                    </th>
                <?php 
                    echo "<script>$('#submit').prop('disabled', false);</script>"; 
                } 
                ?>
            </tr>
        </table>
    <?php  
    } else { ?>
        <p>Record not found. Please try again.</p>
        <script>$('#submit').prop('disabled', true);</script>
    <?php }
}
?>
