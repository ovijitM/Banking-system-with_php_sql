<?php
@require "../connectserver.php";

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT complain_id, username, account_number, cause, status FROM complain_box";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="./styles/styles.css"> -->
    <link rel="stylesheet" href="../../css/style12.css">

    <title>Manage Complaints</title>
</head>
<body>
    <h2>Employee Complaint Management</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Account Number</th>
                <th>Cause</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are any complaints
            if (mysqli_num_rows($result) > 0) {
                // Fetch rows using mysqli_fetch_array (simpler method)
                while ($row = mysqli_fetch_array($result)) {
                    $complain_id = $row[0];
                    $username = $row[1];
                    $account_number = $row[2];
                    $cause = $row[3];
                    $status = $row[4] == 1 ? "Solved" : "Not Solved";
                    ?>
                    <tr>
                        <td><?php echo $complain_id; ?></td>
                        <td><?php echo $username; ?></td>
                        <td><?php echo $account_number; ?></td>
                        <td><?php echo $cause; ?></td>
                        <td><?php echo $status; ?></td>
                        <td>
                            <?php if ($row[4] == 0) { ?>
                            <form action="update_complaint.php" method="post">
                                <input type="hidden" name="complain_id" value="<?php echo $complain_id; ?>">
                                <button type="submit" class="action-button">Mark as Solved</button>
                            </form>
                            <?php } else { ?>
                                Solved
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='6'>No complaints found.</td></tr>";

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Account Number</th>
            <th>Cause</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php
     
        if (mysqli_num_rows($result) > 0) {
            
            while ($row = mysqli_fetch_array($result)) {
                $complain_id = $row[0];
                $username = $row[1];
                $account_number = $row[2];
                $cause = $row[3];
                $status = $row[4] == 1 ? "Solved" : "Not Solved";
                ?>
                <tr>
                    <td><?php echo $complain_id; ?></td>
                    <td><?php echo $username; ?></td>
                    <td><?php echo $account_number; ?></td>
                    <td><?php echo $cause; ?></td>
                    <td><?php echo $status; ?></td>
                    <td>
                        <?php if ($row[4] == 0) { ?>
                        <form action="update_complaint.php" method="post">
                            <input type="hidden" name="complain_id" value="<?php echo $complain_id; ?>">
                            <button type="submit">Mark as Solved</button>
                        </form>
                        <?php } else { ?>
                            Solved
                        <?php } ?>
                    </td>
                </tr>
                <?php

            }
            ?>
        </tbody>
    </table>

    <div class="nav-container">
        <a href='../bank_Dashboard/Bank_Dashboard.php' class='nav-button'>Home</a>
        <button onclick="window.history.back();" class="nav-button">Go Back</button>
    </div>
</body>
</html>


<?php
mysqli_close($conn);
?>
