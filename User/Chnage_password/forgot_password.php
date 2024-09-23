<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
    <!-- <link rel="stylesheet" href="./styles/styles_forgot_password.css"> -->
</head>
<body>
    <form action="change_password.php" method="post">
        <label for="account">Account number:</label>
        <input type="number" id="number" name="account_number" placeholder="1002560002"><br>
        <label for="nid">NID number:</label>
        <input type="text" id="nid" name="nid" placeholder="1234567890"><br>
        <button>Submit</button>
    </form>
    <button onclick="window.history.back();">Go Back</button>

</body>
</html>