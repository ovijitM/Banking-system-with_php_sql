<?php
@require "../connectserver.php";

$account = $_POST['account_number'];

if (isset($_POST['reject'])) {
    $sql = "DELETE FROM customer WHERE account_number = $account";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: user_request.php");
        exit();
    } else {
        echo "Error rejecting application: " . $conn->error;
    }
} else {
    $sql = "UPDATE customer SET status = 1 WHERE account_number = $account";
    if ($conn->query($sql) === TRUE) {
        header("Location: user_request.php");
        exit();
    } else {
        echo "Error rejecting application: " . $conn->error;
    }
    
}
$conn->close();
?>
