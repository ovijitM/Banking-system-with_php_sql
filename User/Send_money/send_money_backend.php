<?php
session_start();

// Ensure the user is logged in and account number is available
if (!isset($_SESSION['account_number'])) {
    header("Location: ../User_account/sign_in.php");
    exit();
}

require '../connectserver.php';

$account_number = $_SESSION['account_number'];
$transfer_status = "";
$fund_status = "";
$recipient_status = ""; 
$current_balance = 0;

// Fetch the current balance for the user
$result = mysqli_query($conn, "SELECT balance FROM account WHERE account_number = '$account_number'");
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $current_balance = $row['balance'];
} else {
    $fund_status = "Error fetching current balance or account does not exist.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form inputs are set to avoid warnings
    if (isset($_POST["recipient_account"]) && isset($_POST["amount"])) {
        $recipient_account = $_POST["recipient_account"];
        $amount = $_POST["amount"];

        // Check if the recipient account exists
        $recipient_result = mysqli_query($conn, "SELECT * FROM account WHERE account_number = '$recipient_account'");

        if (mysqli_num_rows($recipient_result) > 0) {
            if ($amount > 0 && $amount <= $current_balance) {
                // Generate a 10-character reference ID
                $reference_id = '';
                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVW';
                for ($i = 0; $i < 10; $i++) {
                    $reference_id .= $characters[rand(0, strlen($characters) - 1)];
                }

                // Deduct from sender's account
                $deduct_sender = mysqli_query($conn, "UPDATE account SET balance = balance - $amount WHERE account_number = '$account_number'");
                
                // Add to recipient's account
                $add_recipient = mysqli_query($conn, "UPDATE account SET balance = balance + $amount WHERE account_number = '$recipient_account'");

                // Record the transaction
                $record_transaction = mysqli_query($conn, "INSERT INTO transaction (reference_id, from_account, transaction_type, amount, to_account) VALUES ('$reference_id', '$account_number', 'send-money', $amount, '$recipient_account')");

                if ($deduct_sender && $add_recipient && $record_transaction) {
                    $transfer_status = "Transfer successful!";
                    $current_balance -= $amount;
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
