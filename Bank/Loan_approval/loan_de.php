<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Details</title>
    <link rel="stylesheet" href="loan_de.css">
</head>
<body>

    <h2>Check Loan Details by Account Number</h2>

    <form action="" method="post">
        <label for="account_number">Enter Account Number</label>
        <input type="number" name="account_number" id="account_number" required>
        <button type="submit" class="button-89">View Loans</button>
    </form>

    <?php
include "conection.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $account_number = $_POST['account_number'];

    $loan_query = "SELECT loan_account_number, username, cause, amount, timestamp, status FROM loan WHERE account_number = '$account_number'";
    $result = $conn->query($loan_query);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Loan Account Number</th><th>Username</th><th>Cause</th><th>Amount</th><th>Timestamp</th><th>Status</th></tr>";

        while ($row = $result->fetch_assoc()) {
            // Check if status is 0 or -1 for pending, else approved
            if ($row['status'] == 0 || $row['status'] == -1) {
                $status = "Pending";
            } else {
                $status = "Approved";
            }

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
        echo "<p class='no-data'>No loans found for this account number.</p>";
    }
}

$conn->close();
?>
