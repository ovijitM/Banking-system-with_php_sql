<?php
@require "../connectserver.php";

$current_count = 0;
$result = $conn->query("SELECT COUNT(*) AS count FROM customer");
if ($result) {
    $row = $result->fetch_assoc();
    $current_count = $row['count'];
}

$accountNumber = 1002560000 + $current_count;
$username = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$DOB = $_POST['birth'];
$NID = $_POST['nid'];
$address = $_POST['address'];
$balance = $_POST['balance'];
$status = 1;

$birthDate = new DateTime($DOB);
$today = new DateTime();
$age = $today->diff($birthDate)->y;

if ($age < 18) {
    echo "Error: You must be at least 18 years old to create an account.";
    exit;
}

if (!ctype_digit($NID) || strlen($NID) !== 10) {
    echo "Error: NID must be exactly 10 digits long.";
    exit;
}

$nid_check = "SELECT username, account_number FROM account WHERE NID = '$NID'";
$nid_result = $conn->query($nid_check);

if ($nid_result->num_rows > 0) {
    $nid_check_row = $nid_result->fetch_assoc();
    echo "Error: This NID is already used by $nid_check_row[username] and account number is $nid_check_row[account_number]";
    exit;
}


$vault_query = "SELECT balance_electric, balance_cash FROM vault WHERE master_account = '1234567890'";
$vault_result = $conn->query($vault_query);
$vault_row = $vault_result->fetch_assoc();
$balance_electric = $vault_row['balance_electric'];
$balance_cash = $vault_row['balance_cash'];

if ($balance_electric < $balance) {
    echo "Error: Vault does not have enough balance.";
    exit;
}

$new_balance_electric = $balance_electric - $balance;
$new_balance_cash = $balance_cash + $balance;

$update_vault_query = " UPDATE vault SET balance_electric = $new_balance_electric, balance_cash = $new_balance_cash WHERE master_account = '1234567890'";
$conn->query($update_vault_query);

$sql = "INSERT INTO customer (account_number, username, email, password, DOB, NID, address, status) 
        VALUES ('$accountNumber', '$username', '$email', '$password', '$DOB', '$NID', '$address', '$status')";

global $conn;

if ($conn->query($sql) === TRUE) {
    $current_count++;
    echo "<h1>Welcome to our bank</h1>";
    echo "<h1>$username, your account creation successfully done.</h1>";
    echo "<h1>Your account number is: $accountNumber</h1>";
    echo "<h1>Please provide the account number and password to the user</h1>";
    $sql = "INSERT INTO account(account_number, username, email, DOB, NID, balance) 
        VALUES ('$accountNumber', '$username', '$email', '$DOB', '$NID', '$balance')";
    $conn->query($sql);
} else {
    echo "Something went wrong, please try again later.";
}
?>