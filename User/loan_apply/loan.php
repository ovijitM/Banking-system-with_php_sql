<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Application</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2></h2>
    <form action="" method="post">
        <label for="amount">Amount</label>
        <input type="number" name="amount" id="amount" required>
        <br>
        <label for="time">Time</label>
        <input type="date" name="time" id="time" required>
        <br>
        <label for="reason">Reason</label>
        <input type="text" name="reason" id="reason" required>
        <br>
        <button type="submit" class="button-89">Submit Loan</button>
        <button class="button-89" onclick="window.location.href='../../bank.php'">Exit</button>
    </form>
    
</body>
</html>



<?php
session_start();

if (!isset($_SESSION['account_number'])) {
    header("Location: User/SIgn_in/User_login.php"); 
    exit();
}

include "conection.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $amount = $_POST['amount'];
    $time = $_POST['time'];
    $reason = $_POST['reason'];
    $account_number = $_SESSION['account_number'];
    $customer_username = $_SESSION['username'];  


    $loan_account_number = generateRandomLoanAccountNumber(15);


    $sql = "INSERT INTO loan (loan_account_number, account_number, username, cause, amount, timestamp, status)
            VALUES ('$loan_account_number', '$account_number', '$customer_username', '$reason', '$amount', '$time', 0)";

    if ($conn->query($sql) === TRUE) {
        echo "You ar money will added soon. Have a good day.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function generateRandomLoanAccountNumber($length) {
    $number = '';
    for ($i = 0; $i < $length; $i++) {
        $number .= mt_rand(0, 9); 
    }
    return $number;
}


$conn->close();
?>

