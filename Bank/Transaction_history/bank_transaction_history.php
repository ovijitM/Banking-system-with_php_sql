<?php
@require '../connectserver.php';

$masterAccountSql = "SELECT master_account FROM vault LIMIT 1";
$masterAccountResult = $conn->query($masterAccountSql);
$masterAccount = '';

if ($masterAccountResult && $masterAccountResult->num_rows > 0) {
    $masterAccountRow = $masterAccountResult->fetch_assoc();
    $masterAccount = $masterAccountRow['master_account'];
}
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
    <link rel="stylesheet" href="../../css/style11.css">
</head>
<body>
    <h2>Bank-Wide Transaction History</h2>
    <form method="GET" action="">
        <label for="search">Search by Transaction ID, Reference ID, or Account Number:</label>
        <input type="text" id="search" name="search" placeholder="Enter search term" value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit" class="search-button">Search</button>
    </form>

    <table>
        <thead>
            <tr>
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
                    if (empty($from_account)) {
                        $from_account = $masterAccount; 
                    }

                    echo "<tr>
                            <td>" . $row['reference_id'] . "</td>
                            <td>" . $from_account . "</td>
                            <td>" . $row['to_account'] . "</td>
                            <td>" . $row['amount'] . "</td>
                            <td>" . $row['transaction_type'] . "</td>
                            <td>" . $row['timestamp'] . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No transactions found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="nav-container">
        
        <button onclick="window.history.back();" class="nav-button">Go Back</button>
    </div>
</body>
</html>


<?php
$conn->close();
?>
