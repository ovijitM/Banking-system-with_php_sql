<?php
//session_start();

@require "../connectserver.php";

//if (!isset($_SESSION['username']) || !isset($_SESSION['account_number'])) {
//die("Please log in to submit a complaint.");
//

$username = $_POST['username'];
$account_number = $_POST['account_number'];
$cause = $_POST['cause'];

$complaint_query = "INSERT INTO complain_box (username, account_number, cause, status) 
                        VALUES ('$username', '$account_number', '$cause', 0)";

if (mysqli_query($conn, $complaint_query)) {
    echo "<p>Complaint submitted successfully!</p>";
} else {
    echo "<p>Error: " . mysqli_error($conn) . "</p>";
}


//mysqli_close($conn);
