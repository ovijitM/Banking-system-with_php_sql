
<?php 
    
    $username = $_POST['username'];
    $account_number = $_POST['account_number'];
    $password=$_POST['password'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Box</title>
    <link rel="stylesheet" href="../css/style6.css"> <!-- Link to your CSS file -->
</head>
<body>
    <form action="Complaint.php" method="post">
        <h2>Submit Complaint</h2>
        <label for="cause">Complaint:</label>
        <textarea id="cause" name="cause" required></textarea><br>
        <input type='hidden' name='account_number' value='<?php echo"$account_number";?>'>
        <input type='hidden' name='username' value='<?php echo"$username"?>'>
        <button type="submit" name="submit_complaint">Submit Complaint</button>
    </form>
    <button class="go--btn" onclick="window.history.back();">Go Back</button>
    <a href='../../bank.php' class='logout-link'>Logout</a> <!-- Logout as a link -->
</body>
</html>







