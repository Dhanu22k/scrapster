<!DOCTYPE html>
<html>

<head>
    <title>user page</title>
    <link rel="stylesheet" href="orders.css">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="scraps.php">ManageScraps</a></li>
                <li><a href="orders.php"><strong style="color:red">Orders</strong></a></li>
                <li><a href="message.php">Message</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </nav>
    </header>

    <?php
    session_start();

    if (!isset($_SESSION['userid'])) {
        // Redirect to sign-in page if not logged in
        header("Location: ../signin.php");
        exit();
    }
    require "../dbconnector.php";?>


    <h2 class="tableHeader">ORDER LIST</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Order Date</th>
            <th>Status</th>
            <th>Description</th>
        </tr>
        <?php
        $userid = $_SESSION['userid'];
        $acceptedQuery = "SELECT * FROM orders WHERE userid='$userid' ORDER BY orderid desc";
        $acceptedResult = mysqli_query($conn, $acceptedQuery);

        while ($row = mysqli_fetch_assoc($acceptedResult)) {
            $orderId = $row['orderid'];
            $userId = $row['userid'];
            $email = $row['email'];
            $quantity = $row['quantity'];
            $price = $row['price'];
            $orderDate = $row['date'];
            $status = $row['status'];
            $description=$row['description'];

            echo "<tr>";
            echo "<td>$orderId</td>";
            echo "<td>$quantity</td>";
            echo "<td>$price</td>";
            echo "<td>$orderDate</td>";
            echo "<td>$status</td>";
            echo "<td style='color:red'>$description</td>";
            echo "</tr>";
        }
        ?>
    </table><br>


</body>

</html>