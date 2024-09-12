<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Account Status</title>
</head>
<body>
    <h1>Check Your Account Status</h1>
    <form method="POST" action="status.php">
        <div class="form-group">
            <label for="account_number">Account Number:</label>
            <input type="text" id="account_number" name="account_number" required>
        </div>
        <button type="submit">Check Status</button>
    </form>
</body>
</html>
