<?php
@require '../connectserver.php';

if (isset($_POST['account_number'])) {
    $account_number = $_POST['account_number']; 
} else {
    echo "<p>No account number provided.</p>";
    exit();
}

// Query to get customer details
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

        // Query to get balance from the account table
        $sql_balance = "SELECT balance FROM account WHERE account_number = '$account_number'";
        $result_balance = $conn->query($sql_balance);

        if ($result_balance && $result_balance->num_rows > 0) {
            $row_balance = $result_balance->fetch_assoc();
            echo "<p>Balance: {$row_balance['balance']}</p>";
        } else {
            echo "<p>Balance information not found.</p>";
        }

        echo "<p>Account Status: ";
        if ($row['status'] == 1) {
            echo "Approved";
        } else {
            echo "Pending";
        }
        echo "</p>";

    } else {
        echo "<p>No account found for Account Number: $account_number</p>";
    }
    ?>
</body>
</html>
<?php
$conn->close();
?>
