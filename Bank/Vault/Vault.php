<?php
    require_once('../connectserver.php');

    $sql = "SELECT balance_cash, balance_electric FROM vault WHERE master_account = '1234567890'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $electric_balance = $row['balance_electric'];
            $cash_balance = $row['balance_cash'];
        }
    } else {
        echo "No data found.";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Vault</title>
</head>
<body>
    <h1>Vault</h1>
    <div class="balance-container">
        <div class="balance-item">
            <h2>Electric Balance</h2>
            <p>$<?= number_format($electric_balance, 2) ?></p>
        </div>
        <div class="balance-item">
            <h2>Cash Balance</h2>
            <p>$<?= number_format($cash_balance, 2) ?></p>
        </div>
    </div>
    <form action='../../bank.php' method='post'>
<button type='submit'>Logout</button> </form>
</body>
</html>

