<?php
// Replace with your actual database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bankloan";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loanAccountNumber = $_POST["loan_account_number"];

    // Prepare and execute query to get loan details
    $stmt = $conn->prepare("SELECT * FROM loan WHERE loan_account_number = ?");
    $stmt->bind_param("i", $loanAccountNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Output loan details
        while ($row = $result->fetch_assoc()) {
            echo "<h1>Account Information</h1>";
            echo "<p><strong>Account Number:</strong> " . htmlspecialchars($row['loan_account_number']) . "</p>";
            echo "<p><strong>Username:</strong> " . htmlspecialchars($row['username']) . "</p>";
            echo "<p><strong>Amount:</strong> " . htmlspecialchars($row['amount']) . "</p>";
            echo "<p><strong>Today:</strong> " . date("Y-m-d") . "</p>";
            echo "<p><strong>Day:</strong> " . date("l") . "</p>";
            echo "<p><strong>Due date:</strong> " . htmlspecialchars($row['timestamp']) . "</p>";
            echo "<p><strong>Status:</strong> <span class='status'>" . ($row['status'] == 1 ? 'Active' : 'Inactive') . "</span></p>";
        }
    } else {
        echo "No loan details found for the specified account number.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Loan Search</title>
    <style>
        /* Optional CSS styling for better presentation */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        p {
            margin-bottom: 10px;
        }
        .status {
            font-weight: bold;
            color: <?php echo ($row['status'] == 1) ? 'green' : 'red'; ?>;
        }
    </style>
</head>
<body>
    <h1>Loan Search</h1>
    <form method="post" action="">
        <label for="loan_account_number">Loan Account Number:</label>
        <input type="text" name="loan_account_number" required>
        <button type="submit">Search</button>
    </form>
</body>
</html>