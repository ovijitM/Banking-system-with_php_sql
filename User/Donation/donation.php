<?php
require "../connectserver.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['account_number']) && isset($_POST['amount'])) {
        $username = $_POST['username'];
        $account_number = $_POST['account_number'];
        $amount = $_POST['amount'];

        $donation_query = "INSERT INTO donation (username, account_number, amount) 
                           VALUES ('$username', '$account_number', $amount)";
        
        if (mysqli_query($conn, $donation_query)) {
            echo "<p>Donation successful!</p>";
        } else {
            echo "<p>Error: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p>Error: Please fill all the fields.</p>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation</title>
</head>
<body>
    <form action="donation.php" method="post">
        <h2>Make a Donation</h2>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="account_number">Account Number:</label>
        <input type="text" id="account_number" name="account_number" required><br>

        <label for="amount">Amount:</label>
        <input type="number" step="0.01" id="amount" name="amount" required><br>

        <button type="submit" name="donate">Donate</button>
    </form>
    <form action='../../bank.php' method='post'>
<button type='submit'>Logout</button></form>
<button onclick="window.history.back();">Go Back</button>

</body>
</html>



