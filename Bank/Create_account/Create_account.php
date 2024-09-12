<!DOCTYPE html>
<html>
<head>
    <title>Create Bank Account</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Create a New Bank Account</h1>
    <form method="POST" action="create_account.php">
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
            <label for="balance">Initial Deposit:</label>
            <input type="number" id="balance" name="balance" required>
        </div>
        <button type="submit">Create Account</button>
    </form>
</body>
</html>
