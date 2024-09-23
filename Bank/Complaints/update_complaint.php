<?php
// Database connection
@require "../connectserver.php";

//if (!$conn) {
  //  die("Connection failed: " . mysqli_connect_error());
//}

// Check if the form was submitted using POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the complaint ID from the form
    $complain_id = $_POST['complain_id'];

    // Update the complaint status in the database
    $sql = "UPDATE complain_box SET status = 1 WHERE complain_id = '$complain_id'";

    if (mysqli_query($conn, $sql)) {
        echo "Complaint marked as solved!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Redirect back to the complaints page
header("Location: employee_complaints.php");
exit;

mysqli_close($conn);
?>
