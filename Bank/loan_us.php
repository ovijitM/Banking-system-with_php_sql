<?php
session_start(); // Start session to access logged-in user data
if (!isset($_SESSION['account_number'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

include "conection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Details</title>
    <link rel="stylesheet" href="loan_de.css">
</head>
<body>

    <h2>Your Loan Details</h2>

    <?php
    // Get the logged-in user's account number from session
    $account_number = $_SESSION['account_number'];

    // Query to fetch loans for the logged-in user
    $loan_query = "SELECT loan_account_number, username, cause, amount, timestamp, status 
                   FROM loan 
                   WHERE account_number = '$account_number'";
    $result = $conn->query($loan_query);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Loan Account Number</th><th>Username</th><th>Cause</th><th>Amount</th><th>Timestamp</th><th>Status</th></tr>";

        while ($row = $result->fetch_assoc()) {
            $status = $row['status'] == 0 ? "Pending" : "Approved";
            echo "<tr>";
            echo "<td>{$row['loan_account_number']}</td>";
            echo "<td>{$row['username']}</td>";
            echo "<td>{$row['cause']}</td>";
            echo "<td>{$row['amount']}</td>";
            echo "<td>{$row['timestamp']}</td>";
            echo "<td>$status</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='no-data'>No loans found for your account.</p>";
    }

    $conn->close();
    ?>

</body>
</html>
