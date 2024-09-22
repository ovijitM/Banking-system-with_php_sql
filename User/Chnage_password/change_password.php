<?php
@require "../connectserver.php";

if (isset($_POST['account_number']) && isset($_POST['nid'])) {
    $account_number = $_POST['account_number'];
    $nid = $_POST['nid'];

    $query = "SELECT * FROM customer WHERE account_number = '$account_number' AND NID = '$nid'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        ?>
        <form action="update_password.php" method="post">
            <label for="new_password">New password:</label>
            <input type="password" id="new_password" name="new_password" placeholder="Enter new password"><br>
            <button>Update password</button>
            <input type="hidden" name="account_number" value="<?php echo $account_number; ?>">
        </form>
        <?php
    } else {
        echo "Error: Account number and NID do not match.";
    }
}