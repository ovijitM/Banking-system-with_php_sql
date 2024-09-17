<?php

@require '../connectserver.php';
session_start();
if (isset($_SESSION['account_number'])) {
    $account_number = $_SESSION['account_number']; //if available
} else {
    $account_number = $_GET['account_number']; 
}

$sql = "SELECT * FROM customer WHERE account_number = '$account_number'";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Details</title>
    <link rel="stylesheet" href="styleva.css">
</head>
<body>
    <h2>Account Details</h2>
    <?php
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<p>Account Number: {$row['account_number']}</p>";
        echo "<p>Account Holder Name: {$row['username']}</p>";
        echo "<p>Email: {$row['email']}</p>";
        echo "<p>Date of Birth: {$row['DOB']}</p>";
        echo "<p>Balance: {$row['balance']}</p>";
        echo "<p>Account Status: " . ($row['status'] == 1 ? 'Approved' : 'Pending') . "</p>";
    } else {
        echo "<p>No account found.</p>";
    }
    ?>
</body>
</html>
<?php
$conn->close();
?>

