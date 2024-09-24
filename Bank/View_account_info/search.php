<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Account</title>
    <link rel="stylesheet" href="../../css/style6.css">
</head>
<body>
    <h2>Search for an Account</h2>
    <form action="View_account_info.php" method="POST">
        <label for="account_number">Enter Account Number:</label>
        <input type="text" id="account_number" name="account_number" required>
        <button type="submit">Search</button>
    </form>
    
    <div class="button-container">
        <button onclick="window.history.back();">Go Back</button>
     
    </div>
</body>
</html>
