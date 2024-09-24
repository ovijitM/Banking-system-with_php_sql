<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../css/style5.css"> 
</head>
<body>
    <form action="change_password.php" method="post" class="center-form">
        <label for="account">Account number:</label>
        <input type="number" id="number" name="account_number" placeholder="1002560002" required><br>
        
        <label for="nid">NID number:</label>
        <input type="text" id="nid" name="nid" placeholder="1234567890" required><br>
        
        <button type="submit">Submit</button>
    </form>
    <button onclick="window.history.back();">Go Back</button>
</body>
</html>
