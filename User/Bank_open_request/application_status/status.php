<?php
require "../connectserver.php";


$account_number = $_POST['account_number'];


$sql = "SELECT account_number, status FROM customer WHERE account_number = '$account_number'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $status = $row['status'] == 1 ? 'Active' : 'Pending';

    echo "<h1>Account Status</h1>";
    echo "<p>Account Number: " . $row['account_number'] . "</p>";
    echo "<p>Status: " . $status . "</p>";
} else {
    echo "<h1>Error</h1>";
    echo "<p>No account found with the provided account number.</p>";
}
