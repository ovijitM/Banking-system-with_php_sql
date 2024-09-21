<?php
@require "../../connectserver.php"; 

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
$status = 0; 



$birthDate = new DateTime($DOB);
$today = new DateTime();
$age = $today->diff($birthDate)->y;

if ($age < 18) {
    echo "Error: You must be at least 18 years old to create an account.";
    exit;
}

if (!ctype_digit($NID) || strlen($NID) !== 10) {
    echo "Error: NID must be exactly 10 digits long.";
}

$nid_check = "SELECT username , account_number FROM account WHERE NID = '$NID'";
$nid_result = $conn->query($nid_check);

if ($nid_result->num_rows > 0) {
    $nid_check_row = $nid_result->fetch_assoc();
    echo "Error: This NID is already used";
}

$sql = "INSERT INTO customer (account_number, username, email, password, DOB, NID, address,status) 
        VALUES ('$accountNumber', '$username', '$email', '$password', '$DOB', '$NID', '$address', '$status')";

global $conn;

if ($conn->query($sql) === TRUE) {
    $current_count++;
    echo "<h1>Welcome to our bank</h1>";
    echo "<h1>$username, your account creation request was successfully sent.</h1>";
    echo "<h1>Your account number is: $accountNumber</h1>";
    echo "<h1>You can check your account status with your account number.</h1>";
} else {
    echo "Something went wrong, please try again later.";
}

?>

