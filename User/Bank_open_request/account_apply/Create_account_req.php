<!DOCTYPE html>
<html>
<head>
    <title>Create Bank Account</title>
</head>
<body>
    <h1>Create a New Bank Account</h1>
    <form method="POST" action="Create_user_req.php">
        <div class="form-group">
            <label for="name">Account Holder Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="nid">NID Number:</label>
            <input type="text" id="nid" name="nid" required pattern="\d{10}" title="NID must be exactly 10 digits">
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
        <button type="submit">Create Account Request</button>
    </form>
    <p>If you already applied, check your account status: <a href="../application_status/Check_status.php">Check Status</a></p>

<button onclick="window.history.back();">Go Back</button>
<form action='../../../bank.php' method='post'>
<button type='submit'>Logout</button></form>

</body>
</html>
