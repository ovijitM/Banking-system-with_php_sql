<?php
@require "../connectserver.php";

if (isset($_POST['new_password']) && isset($_POST['account_number'])) {
    $new_password = $_POST['new_password'];
    $account_number = $_POST['account_number'];

    $query = "UPDATE customer SET password = '$new_password' WHERE account_number = '$account_number'";
    $result = $conn->query($query);

    if ($result) {
        echo "Password updated successfully.";
    } else {
        echo "Error: Unable to update password.";
    }
}