<?php
require '../connectserver.php';

$transfer_status = "";
$fund_status = "";
$sender_status = "";
$recipient_status = "";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["sender_account"]) && isset($_POST["recipient_account"]) && isset($_POST["amount"])) {
        $sender_account = $_POST["sender_account"];
        $recipient_account = $_POST["recipient_account"];
        $amount = $_POST["amount"];

        // Check if both accounts are provided and the amount is valid
        if ($amount > 0) {
            // Fetch sender's balance
            $sender_result = mysqli_query($conn, "SELECT balance FROM account WHERE account_number = '$sender_account'");
            if ($sender_result && mysqli_num_rows($sender_result) > 0) {
                $sender_row = mysqli_fetch_assoc($sender_result);
                $sender_balance = $sender_row['balance'];

                // Check if sender has enough funds
                if ($sender_balance >= $amount) {
                    // Fetch recipient's account
                    $recipient_result = mysqli_query($conn, "SELECT balance FROM account WHERE account_number = '$recipient_account'");
                    if ($recipient_result && mysqli_num_rows($recipient_result) > 0) {
                        // Deduct from sender's account
                        $deduct_from_sender = mysqli_query($conn, "UPDATE account SET balance = balance - $amount WHERE account_number = '$sender_account'");

                        // Add to recipient's account
                        $add_to_recipient = mysqli_query($conn, "UPDATE account SET balance = balance + $amount WHERE account_number = '$recipient_account'");

                        // Generate a random reference ID
                        $reference_id = '';
                        $characters = '0123456789FGHIJ';
                        for ($i = 0; $i < 10; $i++) {
                            $reference_id .= $characters[rand(0, strlen($characters) - 1)];
                        }

                        // Record the transaction
                        $transaction_type = 'Transfer';
                        $record_transaction = mysqli_query($conn, 
                        "INSERT INTO transaction (from_account, to_account, transaction_type, amount, reference_id) 
                         VALUES ('$sender_account', '$recipient_account', '$transaction_type', $amount, '$reference_id')");

                        // Check if the transaction succeeded
                        if ($deduct_from_sender && $add_to_recipient && $record_transaction) {
                            $transfer_status = "Transfer successful!";
                        } else {
                            $transfer_status = "Error during transfer. Please try again.";
                        }
                    } else {
                        $recipient_status = "Recipient account does not exist!";
                    }
                } else {
                    $sender_status = "Insufficient funds in the sender's account!";
                }
            } else {
                $sender_status = "Sender account does not exist!";
            }
        } else {
            $fund_status = "Invalid amount!";
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
    <title>Echo Bank - Fund Transfer</title>
</head>
<body>
    <h2>Welcome to the Fund Transfer Page</h2>

    <div><p><?php echo $fund_status; ?></p></div>
    <div><p><?php echo $sender_status; ?></p></div>
    <div><p><?php echo $recipient_status; ?></p></div>
    <div><p><?php echo $transfer_status; ?></p></div>

    <form action="fund_transfer.php" method="POST">
        <div>
            <label for="sender_account">Sender Account Number:</label>
            <input type="text" name="sender_account" required><br><br>
        </div>

        <div>
            <label for="recipient_account">Recipient Account Number:</label>
            <input type="text" name="recipient_account" required><br><br>
        </div>

        <div>
            <label for="amount">Amount:</label>
            <input type="number" name="amount" step="0.01" required><br><br>
        </div>

        <button type="submit">Transfer</button>
    </form>

    <button onclick="window.history.back();">Go Back</button>
    <form action="../Bank_withdraw/withdraw.php" method="POST">
        <button type="submit">Withdraw</button>
    </form>
    <form action="../Deposit/deposit.php" method="POST">
        <button type="submit">Deposit</button>
    </form>
</body>
</html>
