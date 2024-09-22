<?php 

require '../connectserver.php';

$withdrawal_status = "";
$balance_status = "";
$vault_status = "";

// Fetch the master account from the vault table
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

            // Check if the withdrawal amount is valid
            if ($amount > 0 && $amount <= $vault_balance_cash && $amount <= $current_balance) {

                // Update user's account balance
                $deduct_account = mysqli_query($conn, "UPDATE account SET balance = balance - $amount WHERE account_number = '$account_number'");

                // Update vault's cash balance
                $deduct_vault_cash = mysqli_query($conn, "UPDATE vault SET balance_cash = balance_cash - $amount WHERE master_account = '$vault_account'");

                // Update vault's electric balance
                $vault_electric = mysqli_query($conn, "UPDATE vault SET balance_electric = balance_electric + $amount WHERE master_account = '$vault_account'");

                // Record the transaction
                $reference_id = '';
                $characters = '0123456789OPQR';
                for ($i = 0; $i < 10; $i++) {
                    $reference_id .= $characters[rand(0, strlen($characters) - 1)];
                }

                $transaction_type = 'Withdrawal';
                $record_transaction = mysqli_query($conn, 
                    "INSERT INTO transaction (transaction_type, amount, to_account, reference_id) 
                     VALUES ('$transaction_type', $amount, '$account_number', '$reference_id')");

                // Check if all updates succeeded
                if ($deduct_account && $deduct_vault_cash && $vault_electric && $record_transaction) {
                    $withdrawal_status = "Withdrawal successful!";
                    
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
                        $vault_balance_electric = $vault_row['balance_electric']; // Fetch updated electric balance
                    }

                    $balance_status = "Current Account Balance: $" . number_format($current_balance, 2);
                     
                    
                } else {
                    $withdrawal_status = "Error during withdrawal. Please try again.";
                }
            } else {
                $withdrawal_status = "Invalid amount or insufficient funds in account or vault!";
            }
        } else {
            $withdrawal_status = "Account does not exist!";
        }
    } else {
        $withdrawal_status = "Please provide both account number and amount!";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdrawal Page</title>
</head>
<body>
    <h2>Withdrawal Page</h2>

    <div><p><?php echo $withdrawal_status; ?></p></div>
    <div><p><?php echo $balance_status; ?></p></div>
    <div><p><?php echo $vault_status; ?></p></div>

    <form action="withdraw.php" method="POST">
        <div>
            <label for="account_number">Account Number:</label>
            <input type="text" name="account_number" required><br><br>
        </div>

        <div>
            <label for="amount">Amount to Withdraw:</label>
            <input type="number" name="amount" step="0.01" required><br><br>
        </div>

        <button type="submit">Withdraw</button>
    </form>

    <button onclick="window.history.back();">Go Back</button>
    <form action="../Deposit/deposit.php" method="POST">
    <button type="submit">Deposit</button>
</form>
<form action="../Fund_transfer/fund_transfer.php" method="POST">
    <button type="submit">Transfer</button>
</form>
</body>
</html>
