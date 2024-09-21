<?php
require '../Send_money/send_money_backend.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Echo Bank</title>
</head>
<body>
  <h2>Welcome to transfer page</h2>
  <form action="send_money.php" method="POST">
    <div><p><?php echo $fund_status; ?></p></div>
    <div><p><?php echo $recipient_status; ?></p></div>
    <div><p><?php echo $transfer_status; ?></p></div>

    <div><p><strong>Account Number Is:</strong> <?php echo htmlspecialchars($account_number); ?></p></div> 
    <div><p>Current Balance: $<?php echo number_format($current_balance, 2); ?></p></div>

    <div>
      <label for="to_account">Recipient Account Number:</label>
      <input type="text" name="recipient_account" required><br><br>
    </div>

    <div>
      <label for="amount">Amount:</label>
      <input type="number" name="amount" step="0.01" required><br><br>
    </div>

    <button class="btn btn--form back--1" type="button" onclick="window.history.back();">Go Back</button>
    <input class="btn btn--form" type="submit" value="Transfer">
 

  </form>
</body>
</html>
