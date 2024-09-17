<?php

@require "../connectserver.php";
session_start();
$account_number = $_POST['account_number'];
// Get history of login user
$sql = "SELECT * FROM transaction 
        WHERE from_account = '$account_number' OR to_account = '$account_number' 
        ORDER BY timestamp DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Transaction History</title>
    <link rel="stylesheet" href="styleuta.css">
</head>
<body>
    <h2>Transaction History for Account: <?php echo $account_number; ?></h2>
    <table>
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Reference ID</th>
                <th>From Account</th>
                <th>To Account</th>
                <th>Amount</th>
                <th>Type</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['transaction_id']}</td>
                            <td>{$row['reference_id']}</td>
                            <td>{$row['from_account']}</td>
                            <td>{$row['to_account']}</td>
                            <td>{$row['amount']}</td>
                            <td>{$row['transaction_type']}</td>
                            <td>{$row['timestamp']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No transactions found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
<?php
$conn->close();
?>
