<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="log.css ">
    </head>
<body>

    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <label for="account_number">Account Number</label>
            <input type="number" name="account_number" id="account_number" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <button type="submit" class="button-89">Login</button>
            <button class="button-89" onclick="window.history.back();">Go Back</button>
        </form>
    
    </div>
    

</body>
</html>


<?php
session_start();
include "conection.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $account_number = $_POST['account_number'];
    $password = $_POST['password']; 

    $login_query = "SELECT * FROM customer WHERE account_number = '$account_number' AND password = '$password'";
    $result = $conn->query($login_query);

    if ($result->num_rows > 0) {
        
        $row = $result->fetch_assoc();
        $_SESSION['account_number'] = $row['account_number'];
        $_SESSION['username'] = $row['username'];

        header("Location: loan.php");
        exit();
    } else {
        echo "Invalid account number or password!";
    }
}

$conn->close();
?>
