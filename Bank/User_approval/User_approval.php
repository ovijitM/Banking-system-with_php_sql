<?php
require "../connectserver.php";

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
        $sql = "SELECT * FROM customer WHERE account_number = '$account'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            $accountNumber = $row["account_number"];
            $username = $row["username"];
            $email = $row["email"];
            $balance = 0.00;
            $birth = $row["DOB"];
            $nid = $row['NID'];

            $sql = "INSERT INTO account (account_number, username, email, DOB, NID, balance) 
                    VALUES ('$accountNumber', '$username', '$email', '$birth', '$nid', '$balance')";

            if ($conn->query($sql) === TRUE) {
                header("Location: user_request.php");
                exit();
            } else {
                echo "Error inserting account: " . $conn->error;
            }
        } else {
            echo "No customer found with that account number.";
        }
    } else {
        echo "Error approving application: " . $conn->error;
    }
}

