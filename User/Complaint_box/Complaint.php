<?php
// Start the session
//session_start();

// Database connection
@require "../connectserver.php";

// Ensure the user is logged in and their details are available
//if (!isset($_SESSION['username']) || !isset($_SESSION['account_number'])) {
//die("Please log in to submit a complaint.");
//

// Fetch username and account number from the session
$username = $_POST['username'];
$account_number = $_POST['account_number'];
$cause = $_POST['cause'];




// Insert complaint into the database
$complaint_query = "INSERT INTO complain_box (username, account_number, cause, status) 
                        VALUES ('$username', '$account_number', '$cause', 0)";

if (mysqli_query($conn, $complaint_query)) {
    echo "<p>Complaint submitted successfully!</p>";
} else {
    echo "<p>Error: " . mysqli_error($conn) . "</p>";
}


//mysqli_close($conn);
