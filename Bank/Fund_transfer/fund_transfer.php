<?php 
require '../connectserver.php';

$transfer_status = "";
$fund_status = "";
$recipient_status = "";

// Fetch the master account and vault balance
$vault_result = mysqli_query($conn, "SELECT master_account, balance_cash FROM vault LIMIT 1");
if ($vault_result && mysqli_num_rows($vault_result) > 0) {
    $vault_row = mysqli_fetch_assoc($vault_result);
    $vault_account = $vault_row['master_account'];
    $vault_balance_cash = $vault_row['balance_cash'];
} else {
    $fund_status = "Error fetching vault details.";
    $vault_account = null; // Set to null to avoid undefined variable errors
    $vault_balance_cash = 0;
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["recipient_account"]) && isset($_POST["amount"]) && isset($_POST["account_number"])) {
        $recipient_account = $_POST["recipient_account"];
        $amount = $_POST["amount"];
        $account_number = $_POST["account_number"];

        // Check if the recipient account exists
        $recipient_result = mysqli_query($conn, "SELECT * FROM account WHERE account_number = '$recipient_account'");
        
        if (mysqli_num_rows($recipient_result) > 0) {
            if ($amount > 0 && $amount <= $vault_balance_cash) {
                // Generate a random reference ID
                $reference_id = '';
                $characters = '0123456789FGHIJ';
                for ($i = 0; $i < 10; $i++) {
                    $reference_id .= $characters[rand(0, strlen($characters) - 1)];
                }

                // Deduct from the vault's cash balance
                $deduct_from_vault = mysqli_query($conn, "UPDATE vault SET balance_cash = balance_cash - $amount WHERE master_account = '$vault_account'");
                // Add to recipient's account
                $add_recipient = mysqli_query($conn, "UPDATE account SET balance = balance + $amount WHERE account_number = '$recipient_account'");

                // Record the transaction
                $transaction_type = 'Transfer';
                $record_transaction = mysqli_query($conn, 
                "INSERT INTO transaction ( transaction_type, amount, to_account, reference_id) 
                 VALUES ( '$transaction_type', $amount, '$recipient_account', '$reference_id')");

                // Check if the transaction succeeded
                if ($deduct_from_vault && $add_recipient && $record_transaction) {
                    $transfer_status = "Transfer successful!";
                    
                    // Fetch the updated vault balance
                    $vault_result = mysqli_query($conn, "SELECT balance_cash FROM vault WHERE master_account = '$vault_account'");
                    if ($vault_result && mysqli_num_rows($vault_result) > 0) {
                        $vault_row = mysqli_fetch_assoc($vault_result);
                        $vault_balance_cash = $vault_row['balance_cash'];
                    } else {
                        $fund_status = "Error fetching updated vault balance.";
                    
                    }
                } else {
                    $transfer_status = "Error during transfer. Please try again.";
                }
            } else {
                $fund_status = "Invalid amount or insufficient vault funds!";
            }
        } else {
            $recipient_status = "Recipient account does not exist!";
        }
    } else {
        $fund_status = "Please fill in all required fields!";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Echo Bank</title>
</head>
<body>
    <h2>Welcome to the Fund transfer page</h2>
    <div><p><?php echo $fund_status; ?></p></div>
    <div><p><?php echo $recipient_status; ?></p></div>
    <div><p><?php echo $transfer_status; ?></p></div>

    <div><p><strong>Master Account (Vault):</strong> <?php echo htmlspecialchars($vault_account); ?></p></div> 
    <div><p>Updated Vault Cash Balance: $<?php echo number_format($vault_balance_cash, 2); ?></p></div>

    <form action="fund_transfer.php" method="POST">
        <div>
            <label for="recipient_account">Recipient Account Number:</label>
            <input type="text" name="recipient_account" required><br><br>
        </div>

        <div>
            <label for="amount">Amount:</label>
            <input type="number" name="amount" step="0.01" required><br><br>
        </div>

        <input type="hidden" name="account_number" value="<?php echo htmlspecialchars($account_number); ?>">

        <button type="button" onclick="window.history.back();">Go Back</button>
        <input type="submit" value="Transfer">
        <form action="../Bank_withdraw/withdraw.php" method="POST">
        <button type="submit">withdraw</button>
    </form>
    <form action="../Deposit/deposit.php" method="POST">
    <button type="submit">Deposit</button>
</form>
</body>
</html>
