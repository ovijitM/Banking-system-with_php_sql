<?php
$conn = new mysqli('localhost', 'username', 'password', 'bank1_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// transaction history of bank
$sql = "SELECT * FROM transaction ORDER BY timestamp DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bank Transaction History</title>
    <link rel="stylesheet" href="stylebts.css">
</head>
<body>
    <h2>Bank-Wide Transaction History</h2>
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
