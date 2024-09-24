<?php
require "../connectserver.php";

$accountNumber = $_POST['id_number'];
$password = $_POST['password'];

$sql = "SELECT * FROM stuff WHERE stuff_id = '$accountNumber' AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $accountNumber = $row['stuff_id'];
    $password = $row['password'];

    // Login successful, display the banking functions
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>My Bank</title>
        <link rel="stylesheet" href="../style.css">
        <link rel="stylesheet" href="../../css/style.css">
    </head>
    <body>
        <h1>Hi, Welcome to the Bank</h1>
        <h2>Choose Your Functions</h2>
        <div class='button-container'>
            <form action='../Create_account/Create_account.php'>
                <button type='submit'>Create Account</button>
            </form>
            <form action='../User_approval/User_request.php' target="_blank">
                <button type='submit'>User request</button>
            </form>
            <form action='../View_account_info/search.php'>
                <button type='submit'>View Info</button>
            </form>
            <form action='../Fund_transfer/fund_transfer.php'>
                <button type='submit'>Transfer Funds</button>
            </form>
            <form action='../Deposit/deposit.php'>
                <button type='submit'>Deposit</button>
            </form>
            <form action='../Bank_withdraw/withdraw.php'>
                <button type='submit'>Withdraw</button>
            </form>
            <form action='../Transaction_history/bank_transaction_history.php' target="_blank">
                <button type='submit'>View Transactions</button>
            </form>
            <form action='../Complaints/employee_complaints.php'>
                <button type='submit'>Complaint list</button>
            </form>
            <form action='../Vault/Vault.php'>
                <button type='submit'>View vault</button>
            </form>
            <form action='../Loan_approval/staff_see_request.php'>
                <button type='submit'>loan requests</button>
            </form>
            <form action='../Loan_approval/loan_de.php'>
                <button type='submit'>User loan Details</button>
            </form>
            <form action='../../bank.php' method='post'>
                <button type='submit'>Logout</button>
            </form>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "Invalid account number or password!";
}
?>