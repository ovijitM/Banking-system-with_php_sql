<?php
require_once '../connectserver.php';

$accountNumber = $_POST['account_number'];
$password = $_POST['password'];


$sql = "SELECT * FROM customer WHERE account_number = '$accountNumber' AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if ($row['status'] == 1) {
        $sql = "SELECT * FROM account WHERE account_number = '$accountNumber'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc(); 
            $name = $row["username"];
            $email = $row["email"];
            $account = $row["account_number"];
            $balance = $row["balance"];
            $birth = $row["DOB"];

            echo "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Bank Account Info</title>
                <link rel='stylesheet' href='styles.css'>
            </head>
            <body>
                <div class='account-info'>
                    <h1>Hi $name, welcome to the bank</h1>
                    <h2>Account number: $account<br></h2>
                    <h2>Account holder name: $name<br></h2>
                    <h2>Account holder email: $email <br></h2>
                    <h2>Account holder birth date: $birth <br></h2>
                    <h2>Account Balance: $balance<br></h2>
                    <form action='./send_money/send.php' method='post'>
                        <input type='hidden' name='account_number' value='$accountNumber'>
                        <button type='submit'>Send Money</button>
                    </form>
                    <form action='../Transaction_history/user_transaction_history.php' method='post'>
                        <input type='hidden' name='account_number' value='$accountNumber'>
                        <button type='submit'>View Transaction History</button>
                    </form>
                    <a href='../loan_apply/login.php'>loan</a>
                    <form action='../../bank.php' method='post'>
                        <button type='submit'>LOGOUT</button>
                    </form>
                </div>
            </body>
            </html>";
        } else {
            echo "<p class='error'>Account not found.</p>";
        }
    } else {
        echo "<h1>Your request is under review. Please contact the bank for more information.</h1>";
    }
} else {
    echo "<p class='error'>Invalid account number or password.</p>";
}

