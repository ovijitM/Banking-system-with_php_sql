<?php
include "conection.php";

function escapeHtml($string) {
    $search = ['&', '<', '>', '"', "'"];
    $replace = ['&amp;', '&lt;', '&gt;', '&quot;', '&#39;'];
    return str_replace($search, $replace, $string);
}

if (isset($_POST['action']) && isset($_POST['loan_id'])) {
    $loan_id = $_POST['loan_id'];
    $action = $_POST['action'];
    $status = ($action === 'approve') ? 1 : ($action === 'cancel' ? -1 : 0);

    $conn->begin_transaction();
    try {
        
        $stmt = $conn->prepare("SELECT account_number, amount, status FROM loan WHERE loan_id = ?");
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
            $current_status = $loan_row['status'];

            
            if ($current_status == 1 && $action === 'approve') {
                throw new Exception("Loan has already been approved.");
            }
            if ($current_status == -1 && $action === 'cancel') {
                throw new Exception("Loan has already been canceled.");
            }

            
            $stmt = $conn->prepare("UPDATE loan SET status = ? WHERE loan_id = ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("ii", $status, $loan_id);
            $stmt->execute();

            
            if ($status === 1) {
                
                $stmt = $conn->prepare("UPDATE vault SET balance_electric = balance_electric - ? WHERE master_account = ?");
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }
                $master_account = 1234567890; 
                $stmt->bind_param("di", $amount, $master_account);
                $stmt->execute();

                if ($stmt->affected_rows === 0) {
                    throw new Exception("No rows updated in vault table.");
                }

                $stmt = $conn->prepare("UPDATE account SET balance = balance + ? WHERE account_number = ?");
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }
                $stmt->bind_param("ds", $amount, $account_number);
                $stmt->execute();

                if ($stmt->affected_rows === 0) {
                    throw new Exception("No rows updated in account table.");
                }
            }

            
            if ($status === -1) {
               
                $stmt = $conn->prepare("SELECT balance FROM account WHERE account_number = ?");
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }
                $stmt->bind_param("s", $account_number);
                $stmt->execute();
                $balance_result = $stmt->get_result();
                $account_data = $balance_result->fetch_assoc();
                $customer_balance = $account_data['balance'];

                if ($customer_balance < $amount) {
                    throw new Exception("Customer does not have enough balance to cancel the loan.");
                }

               
                $stmt = $conn->prepare("UPDATE account SET balance = balance - ? WHERE account_number = ?");
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }
                $stmt->bind_param("ds", $amount, $account_number);
                $stmt->execute();

                if ($stmt->affected_rows === 0) {
                    throw new Exception("No rows updated in account table.");
                }

                

                $stmt = $conn->prepare("UPDATE vault SET balance_electric = balance_electric - ? WHERE master_account = ?");
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }
                $master_account = 1234567890; 
                $stmt->bind_param("di", $amount, $master_account);
                $stmt->execute();

                if ($stmt->affected_rows === 0) {
                    throw new Exception("No rows updated in vault table.");
                }

            }

            $conn->commit();
            echo ($status === 1) ? "Loan approved and customer balance updated successfully." : (($status === -1) ? "Loan canceled and funds returned to vault." : "Loan status updated successfully.");
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
