<?php
@require '../connectserver.php';

$searchQuery = "";
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search']; 
}
$sql = "SELECT * FROM transaction WHERE 
            transaction_id LIKE '%$searchQuery%' 
            OR reference_id LIKE '%$searchQuery%' 
            OR from_account LIKE '%$searchQuery%' 
            OR to_account LIKE '%$searchQuery%'
        ORDER BY timestamp DESC";

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
    <form method="GET" action="">
        <label for="search">Search by Transaction ID, Reference ID, or Account Number:</label>
        <input type="text" id="search" name="search" placeholder="Enter search term" value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit">Search</button>
    </form>

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
                    $from_account = $row['from_account'];
                    if ($from_account == "" || $from_account == NULL) {
                        $from_account = 'Vault Account'; 
                    }

                    echo "<tr>
                            <td>" . $row['transaction_id'] . "</td>
                            <td>" . $row['reference_id'] . "</td>
                            <td>" . $from_account . "</td>
                            <td>" . $row['to_account'] . "</td>
                            <td>" . $row['amount'] . "</td>
                            <td>" . $row['transaction_type'] . "</td>
                            <td>" . $row['timestamp'] . "</td>
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


