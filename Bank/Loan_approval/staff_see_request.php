<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "echo_bank";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Function to manually escape HTML
function escapeHtml($string) {
    $search = ['&', '<', '>', '"', "'"];
    $replace = ['&amp;', '&lt;', '&gt;', '&quot;', '&#39;'];
    return str_replace($search, $replace, $string);
}

// Handle loan status update
if (isset($_POST['action']) && isset($_POST['loan_id'])) {
    $loan_id = $_POST['loan_id'];
    $action = $_POST['action'];
    $status = $action === 'approve' ? 1 : 0;

    $conn->begin_transaction();
    try {
        // Fetch loan details
        $stmt = $conn->prepare("SELECT account_number, amount FROM loan WHERE loan_id = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $loan_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $loan_row = $result->fetch_assoc();
            $account_number = $loan_row['account_number'];
            $amount = $loan_row['amount'];

            // Update loan status
            $stmt = $conn->prepare("UPDATE loan SET status = ? WHERE loan_id = ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("ii", $status, $loan_id);
            $stmt->execute();

            // If approved, deduct from vault and add to customer balance
            if ($status === 1) {
                $stmt = $conn->prepare("UPDATE vault SET balance_electric = balance_electric - ? WHERE master_account = ?");
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }
                $muster_account = 1234567890 ; // Vault account number
                $stmt->bind_param("di", $amount, $muster_account);
                $stmt->execute();

                if ($stmt->affected_rows === 0) {
                    throw new Exception("No rows updated in vault table.");
                }

                // Update customer's balance
                $stmt = $conn->prepare("UPDATE account SET balance = balance + ? WHERE account_number = ?");
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }
                $stmt->bind_param("ds", $amount, $account_number);
                $stmt->execute();

                if ($stmt->affected_rows === 0) {
                    throw new Exception("No rows updated in customer table.");
                }
            }

            $conn->commit();
            echo $status === 1 ? "Loan approved and customer balance updated successfully." : "Loan status updated successfully.";
        } else {
            echo "Loan not found.";
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Information</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Loan Information</h1>
    <table>
        <thead>
            <tr>
                <th>Loan ID</th>
                <th>Loan Account Number</th>
                <th>Name</th>
                <th>Reason</th>
                <th>Amount</th>
                <th>Time</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT loan_id, account_number, username, cause, amount, timestamp, status FROM loan";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . escapeHtml($row["loan_id"]) . "</td>";
                    echo "<td>" . escapeHtml($row["account_number"]) . "</td>";
                    echo "<td>" . escapeHtml($row["username"]) . "</td>";
                    echo "<td>" . escapeHtml($row["cause"]) . "</td>";
                    echo "<td>" . escapeHtml($row["amount"]) . "</td>";
                    echo "<td>" . escapeHtml($row["timestamp"]) . "</td>";
                    echo "<td>" . ($row["status"] == 1 ? "Approved" : "Pending") . "</td>";
                    echo "<td>";
                    echo "<form method='post' style='display:inline;'>";
                    echo "<input type='hidden' name='loan_id' value='" . escapeHtml($row["loan_id"]) . "'>";
                    echo "<button type='submit' name='action' value='approve'>Approve</button>";
                    echo "</form>";
                    echo "<form method='post' style='display:inline;'>";
                    echo "<input type='hidden' name='loan_id' value='" . escapeHtml($row["loan_id"]) . "'>";
                    echo "<button type='submit' name='action' value='cancel'>Cancel</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
