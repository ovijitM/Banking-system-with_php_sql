<?php
require '../connectserver.php';

$deposit_status = "";
$balance_status = "";
$vault_status = "";

// Fetch the master account 
$vault_result = mysqli_query($conn, "SELECT master_account, balance_cash, balance_electric FROM vault LIMIT 1");
if ($vault_result && mysqli_num_rows($vault_result) > 0) {
    $vault_row = mysqli_fetch_assoc($vault_result);
    $vault_account = $vault_row['master_account'];
    $vault_balance_cash = $vault_row['balance_cash'];
    $vault_balance_electric = $vault_row['balance_electric']; 
} else {
    $vault_status = "Error fetching vault account or vault does not exist.";
    exit();  
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['account_number']) && isset($_POST['amount'])) {
        $account_number = $_POST['account_number'];
        $amount = $_POST['amount'];

        // Check if the account exists
        $account_result = mysqli_query($conn, "SELECT balance FROM account WHERE account_number = '$account_number'");
        if ($account_result && mysqli_num_rows($account_result) > 0) {
            $account_row = mysqli_fetch_assoc($account_result);
            $current_balance = $account_row['balance'];

            // Show current balance
            $balance_status = "Current Balance: $" . number_format($current_balance, 2);

            // Check if the deposit amount is valid (positive)
            if ($amount > 0) {

                // Update user's account balance by adding the deposit amount
                $add_to_account = mysqli_query($conn, "UPDATE account SET balance = balance + $amount WHERE account_number = '$account_number'");

                // Update vault's cash balance
                $add_to_vault_cash = mysqli_query($conn, "UPDATE vault SET balance_cash = balance_cash + $amount WHERE master_account = '$vault_account'");

                // Update vault's electric balance (add the deposit amount to electric balance)
                $vault_electric = mysqli_query($conn, "UPDATE vault SET balance_electric = balance_electric - $amount WHERE master_account = '$vault_account'");

                // Record the transaction
                $reference_id = '';
                $characters = '0123456789KLMN';
                for ($i = 0; $i < 10; $i++) {
                    $reference_id .= $characters[rand(0, strlen($characters) - 1)];
                } 


                $transaction_type = 'Deposit';
                $record_transaction = mysqli_query($conn, 
                    "INSERT INTO transaction ( transaction_type, amount, to_account, reference_id) 
                     VALUES ( '$transaction_type', $amount, '$account_number', '$reference_id')");

                // Check if all updates succeeded
                if ($add_to_account && $add_to_vault_cash && $vault_electric && $record_transaction) {
                    $deposit_status = "Deposit successful!";
                    
                    // Fetch the updated balances
                    $account_result = mysqli_query($conn, "SELECT balance FROM account WHERE account_number = '$account_number'");
                    $vault_result = mysqli_query($conn, "SELECT balance_cash, balance_electric FROM vault WHERE master_account = '$vault_account'");
                    
                    if ($account_result && mysqli_num_rows($account_result) > 0) {
                        $account_row = mysqli_fetch_assoc($account_result);
                        $current_balance = $account_row['balance'];
                    }
                    
                    if ($vault_result && mysqli_num_rows($vault_result) > 0) {
                        $vault_row = mysqli_fetch_assoc($vault_result);
                        $vault_balance_cash = $vault_row['balance_cash'];
                        $vault_electric = $vault_row['balance_electric']; // Fetch updated electric balance
                    }

                    $balance_status = "Current Balance: $" . number_format($current_balance, 2);
                    $vault_status = "Current Vault Balance: Cash: $" . number_format($vault_balance_cash, 2); 
                    
                } else {
                    $deposit_status = "Error during deposit. Please try again.";
                }
            } else {
                $deposit_status = "Invalid deposit amount!";
            }
        } else {
            $deposit_status = "Account does not exist!";
        }
    } else {
        $deposit_status = "Please provide both account number and amount!";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Page</title>
</head>
<body>
    <h2>Deposit Page</h2>

    <div><p><?php echo $deposit_status; ?></p></div>
    <div><p><?php echo $balance_status; ?></p></div>
    <div><p><?php echo $vault_status; ?></p></div>

    <form action="deposit.php" method="POST">
        <div>
            <label for="account_number">Account Number:</label>
            <input type="text" name="account_number" required><br><br>
        </div>

        <div>
            <label for="amount">Amount to Deposit:</label>
            <input type="number" name="amount" step="0.01" required><br><br>
        </div>

        <button type="submit">Deposit</button>
    </form>

    <button onclick="window.history.back();">Go Back</button>
    <form action="../Bank_withdraw/withdraw.php" method="POST">
    <button type="submit">withdraw</button>

</form>
<form action="../Fund_transfer/fund_transfer.php" method="POST">
    <button type="submit">Transfer</button>
</form>
</body>
</html>
