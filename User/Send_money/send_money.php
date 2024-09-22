<?php
require '../connectserver.php';

$transfer_status = "";
$fund_status = "";
$recipient_status = ""; 

// Ensure the account number is available
if (!isset($_POST['account_number'])) {
    header("Location: ../SIgn_in/User_login.php");
    exit();
}

$account_number = $_POST['account_number'];

// Fetch the current balance for the user
$result = mysqli_query($conn, "SELECT balance FROM account WHERE account_number = '$account_number'");
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $current_balance = $row['balance'];
} else {
    $fund_status = "Error fetching current balance or account does not exist.";
    $current_balance = 0; // Set to 0 to avoid undefined variable error
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["recipient_account"]) && isset($_POST["amount"])) {
        $recipient_account = $_POST["recipient_account"];
        $amount = $_POST["amount"];

        // Check if the recipient account exists
        $recipient_result = mysqli_query($conn, "SELECT * FROM account WHERE account_number = '$recipient_account'");

        if (mysqli_num_rows($recipient_result) > 0) {
            if ($amount > 0 && $amount <= $current_balance) {
                // Generate a random reference ID
                $reference_id = '';
                $characters = '0123456789ABCDE';
                for ($i = 0; $i < 10; $i++) {
                    $reference_id .= $characters[rand(0, strlen($characters) - 1)];
                }

                // Deduct from sender's account
                $deduct_sender = mysqli_query($conn, "UPDATE account SET balance = balance - $amount WHERE account_number = '$account_number'");
                // Add to recipient's account
                $add_recipient = mysqli_query($conn, "UPDATE account SET balance = balance + $amount WHERE account_number = '$recipient_account'");

                // Record the transaction
                $transaction_type = 'Send_money';
                $record_transaction = mysqli_query($conn, 
                    "INSERT INTO transaction (from_account, transaction_type, amount, to_account, reference_id) 
                     VALUES ('$account_number', '$transaction_type', $amount, '$recipient_account', '$reference_id')");

                // Check if the transaction succeeded
                if ($deduct_sender && $add_recipient && $record_transaction) {
                    $transfer_status = "Transfer successful!";
                    
                    // Fetch the updated current balance
                    $result = mysqli_query($conn, "SELECT balance FROM account WHERE account_number = '$account_number'");
                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $current_balance = $row['balance'];
                    } else {
                        $fund_status = "Error fetching updated balance.";
                        $current_balance = 0; // Handle the case where balance fetching fails
                    }
                } else {
                    $transfer_status = "Error during transfer. Please try again.";
                }
            } else {
                $fund_status = "Invalid amount or insufficient funds!";
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
    <h2>Welcome to the transfer page</h2>
    <div><p><?php echo $fund_status; ?></p></div>
    <div><p><?php echo $recipient_status; ?></p></div>
    <div><p><?php echo $transfer_status; ?></p></div>

    <div><p><strong>Account Number Is:</strong> <?php echo htmlspecialchars($account_number); ?></p></div> 
    <div><p>Updated Balance: $<?php echo number_format($current_balance, 2); ?></p></div>

    <form action="send_money.php" method="POST">
        <div>
            <label for="recipient_account">Recipient Account Number:</label>
            <input type="text" name="recipient_account" required><br><br>
        </div>

        <div>
            <label for="amount">Amount:</label>
            <input type="number" name="amount" step="0.01" required><br><br>
        </div>

        <input type="hidden" name="account_number" value="<?php echo htmlspecialchars($account_number); ?>">
        <input type="hidden" name="current_balance" value="<?php echo htmlspecialchars($current_balance); ?>">

        <button type="button" onclick="window.history.back();">Go Back</button>
        <input type="submit" value="Transfer">
    </form>
</body>
</html>
