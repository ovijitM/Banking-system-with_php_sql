<?php
@require "../connectserver.php";

$sql = "SELECT * FROM customer WHERE status = 0";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Approve User</title>


    <link rel="stylesheet" href="../../css/style5.css"> 
</head>
<body>
    <div class="container">
        <h2>Pending User Applications</h2>
        <table>
            <tr>
                <th>Account number</th>
                <th>Holder Name</th>
                <th>email</th>
                <th>Date of Birth</th>
                <th>NID</th>
                <th>Address</th>
                <th>status</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['account_number']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['DOB']; ?></td>
                <td><?php echo $row['NID']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php if ($row['status'] == 0) {
                        echo "<span style='color: #ff9900;'>Pending</span>";
                    } else {
                        echo "<span style='color: #008000;'>Approved</span>";
                    } ?></td>
                <td>
                <form method="post" action="User_approval.php">
                    <input type="hidden" name="account_number" value="<?php echo $row['account_number']; ?>">
                    <button type="submit" name="approve">Approve</button>
                    <button type="submit" name="reject">Reject</button>
                </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <div class="button-container">
        <button onclick="window.history.back();">Go Back</button>
        <form action='../bank_Dashboard/Bank_Dashboard.php' method='post'>
            <button type='submit'>Home</button>
        </form>
    </div>
</body>
</html>


<?php
$conn->close();
?>