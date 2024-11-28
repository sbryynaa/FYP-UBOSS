<?php 
require_once("includes/config.php");
if(!empty($_POST["studentid"])) {
  $studentid = strtoupper($_POST["studentid"]);

  // Adjusted query to fetch first and last name, and use them correctly
  $sql = "SELECT FirstName, LastName, Status, EmailId, MobileNumber FROM tblstudents WHERE StudentId = :studentid";
  $query = $dbh->prepare($sql);
  $query->bindParam(':studentid', $studentid, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);

  if($query->rowCount() > 0) {
    foreach ($results as $result) {
      if($result->Status == 0) {
        echo "<span style='color:red'> Student ID Blocked </span><br />";
        echo "<b>Student Name - </b>" . htmlentities($result->FirstName . " " . $result->LastName) . "<br />";
        echo "<script>$('#submit').prop('disabled', true);</script>";
      } else {
        echo htmlentities($result->FirstName . " " . $result->LastName) . "<br />";
        echo htmlentities($result->EmailId) . "<br />";
        echo htmlentities($result->MobileNumber);
        echo "<script>$('#submit').prop('disabled', false);</script>";
      }
    }
  } else {
    echo "<span style='color:red'> Invalid Student Id. Please Enter Valid Student Id. </span>";
    echo "<script>$('#submit').prop('disabled', true);</script>";
  }
}
?>
