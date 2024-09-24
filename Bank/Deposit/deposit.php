<?php
require '../connectserver.php';

$deposit_status = "";
$balance_status = "";
$vault_status = "";

// Fetch the master account (vault) from the vault table
$vault_result = mysqli_query($conn, "SELECT master_account, balance_cash, balance_electric FROM vault LIMIT 1");
if ($vault_result && mysqli_num_rows($vault_result) > 0) {
    $vault_row = mysqli_fetch_assoc($vault_result);
    $vault_account = $vault_row['master_account'];
    $vault_balance_cash = $vault_row['balance_cash'];
    $vault_balance_electric = $vault_row['balance_electric']; // Fetch the electric balance as well
} else {
    $vault_status = "Error fetching vault account or vault does not exist.";
    exit();  // Stop further processing if the vault account is missing
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['account_number']) && isset($_POST['amount'])) {
        $account_number = $_POST['account_number'];
        $amount = $_POST['amount'];

        // Check if the account exists
        $account_result = mysqli_query($conn, "SELECT balance FROM account WHERE account_number = '$account_number'");
        if ($account_result && mysqli_num_rows($account_result) > 0) {
            $account_row = mysqli_fetch_assoc($account_result);
            $current_balance = $account_row['balance'];

            // Check if the deposit amount is valid (positive)
            if ($amount > 0) {
                // Check if the deposit amount is greater than the vault's electric balance
                if ($amount > $vault_balance_electric) {
                    $deposit_status = "Insufficient electric balance in the vault! Contact authority.";
                } else {
                    // Update user's account balance and vault balances
                    $add_to_account = mysqli_query($conn, "UPDATE account SET balance = balance + $amount WHERE account_number = '$account_number'");
                    $add_to_vault_cash = mysqli_query($conn, "UPDATE vault SET balance_cash = balance_cash + $amount WHERE master_account = '$vault_account'");
                    $vault_electric = mysqli_query($conn, "UPDATE vault SET balance_electric = balance_electric - $amount WHERE master_account = '$vault_account'");

                    // Record the transaction
                    $reference_id = strtoupper(substr(md5(uniqid(rand(), true)), 0, 10)); // Generate a random reference ID
                    $transaction_type = 'Deposit';
                    $record_transaction = mysqli_query($conn, 
                        "INSERT INTO transaction (transaction_type, amount, to_account, reference_id) 
                         VALUES ('$transaction_type', $amount, '$account_number', '$reference_id')");

                    // Check if all updates succeeded
                    if ($add_to_account && $add_to_vault_cash && $vault_electric && $record_transaction) {
                        $deposit_status = "Deposit successful!";
                    } else {
                        $deposit_status = "Error during deposit. Please try again.";
                    }
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
    <link rel="stylesheet" href="../../css/style8.css">
    <title>Deposit Page</title>
</head>
<body>
    <h2>Deposit Page</h2>

    <div class="status-messages">
        <p><?php echo $deposit_status; ?></p>
        <p><?php echo $balance_status; ?></p>
        <p><?php echo $vault_status; ?></p>
    </div>

    <form action="deposit.php" method="POST">
        <div>
            <label for="account_number">Account Number:</label>
            <input type="text" name="account_number" required><br><br>
        </div>

        <div>
            <label for="amount">Amount to Deposit:</label>
            <input type="number" name="amount" step="0.01" required><br><br>
        </div>

        <button type="submit" class="submit-button">Deposit</button>
    </form>

    <div class="button-group">
        <button onclick="window.history.back();" class="nav-button">Go Back</button>
        

        
    </div>
</body>
</html>
