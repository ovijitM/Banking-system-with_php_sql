<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Loan Application</title>
</head>
<body>
  <form action="loan.php" method="post">
    <label for="amount">Amount</label>
    <input type="number" name="amount" id="amount" required>
    <br>
    <label for="time">Time</label>
    <input type="date" name="time" id="time" required>
    <br>
    <label for="reason">Reason</label>
    <input type="text" name="reason" id="reason" required>
    <br>
    <button type="submit">Submit</button>
  </form>
</body>
</html>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bankloan";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $amount = $_POST['amount'];
    $time = $_POST['time'];
    $reason = $_POST['reason'];
    $customer_username = 'john_doe'; 

    // First, retrieve the customer account number and username manually (no fetch_assoc())
    $customer_query = "SELECT account_number, username FROM customer WHERE username = '$customer_username'";
    $result = $conn->query($customer_query);

    // Custom manual data retrieval (without using fetch_assoc)
    $account_number = '';
    $customer_username_db = '';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()) {
            $account_number = $row[0]; // account_number is in the first column
            $customer_username_db = $row[1]; // username is in the second column
        }

        // Generate a random loan account number manually (15 digits long, without using random_int)
        $loan_account_number = generateRandomLoanAccountNumber(15);

        // Manually build the insert query
        $sql = "INSERT INTO loan (loan_account_number, account_number, username, cause, amount, timestamp, status)
                VALUES ('$loan_account_number', '$account_number', '$customer_username_db', '$reason', '$amount', '$time', 0)"; // 0 for 'pending' status

        // Run the insert query manually
        if ($conn->query($sql) === TRUE) {
            echo "Loan application submitted successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "No customer found with that username.";
    }
}

// Custom function to generate a random loan account number manually
function generateRandomLoanAccountNumber($length) {
    $number = '';
    for ($i = 0; $i < $length; $i++) {
        $number .= mt_rand(0, 9); // Use mt_rand() as a replacement for random_int
    }
    return $number;
}

$conn->close();
?>