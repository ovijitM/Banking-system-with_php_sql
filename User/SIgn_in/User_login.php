<!DOCTYPE html>
<html lang="en">
<head>
    <title>user</title>
    <!-- <link rel="stylesheet" href="./styles/styles_user.css"> -->
</head>
<body>
    <form action="../User_Dashboard/User_Dashboard.php" method="post">
        <label for="account">Account number:</label>
        <input type="number" id="number" name="account_number" placeholder="1002560002"><br>
        <label for="password">Account password:</label>
        <input type="text" id="password" name="password" placeholder="daasf"><br>
        <button> log in</button>
        <p><a href="../Chnage_password/forgot_password.php">Forgot Password?</a></p>
    </form>
</body>
</html>