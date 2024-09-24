<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Bank Account</title>
    <link rel="stylesheet" href="../../css/style3.css">
</head>
<body>
    <h1>Create a New Bank Account</h1>
    <form method="POST" action="Create_user.php">
        <div class="form-group">
            <label for="name">Account Holder Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="nid">NID Number:</label>
            <input type="number" id="nid" name="nid" required>
        </div>
        <div class="form-group">
            <label for="birth">Date of Birth:</label>
            <input type="date" id="birth" name="birth" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
        </div>
        <div class="form-group">
            <label for="balance">Initial Deposit:</label>
            <input type="number" id="balance" name="balance" required>
        </div>
        <button type="submit">Create Account</button>
        <button type="button" onclick="window.history.back();">Go Back</button>
        <form action='../../bank.php' method='post'>
            <button type='submit'>Logout</button>
        </form>
    </form>
</body>
</html>
