<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Account Status</title>
    <link rel="stylesheet" href="../../css/style4.css"> <!-- Link to your CSS file -->
</head>
<body>
    <h1>Check Your Account Status</h1>
    <form method="POST" action="status.php" class="center-form">
        <div class="form-group">
            <label for="account_number">Account Number:</label>
            <input type="text" id="account_number" name="account_number" required>
        </div>
        <button type="submit">Check Status</button>
    </form>
    <div class="button-container">
        <button onclick="window.history.back();">Go Back</button>
        <form action='../../../bank.php' method='post'>
            <button type='submit'>Logout</button>
        </form>
    </div>
</body>
</html>
