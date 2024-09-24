<?php

@require "../connectserver.php";

//if (!$conn) {
  //  die("Connection failed: " . mysqli_connect_error());
//}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $complain_id = $_POST['complain_id'];
  
    $sql = "UPDATE complain_box SET status = 1 WHERE complain_id = '$complain_id'";

    if (mysqli_query($conn, $sql)) {
        echo "Complaint marked as solved!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

header("Location: employee_complaints.php");
exit;

mysqli_close($conn);
?>
