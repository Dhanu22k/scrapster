<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="home.css">
</head>

<body>
    <nav>
        <ul>
            <li style="background-color:black"><a href="home.php">Home</a></li>
            <li><a href="stats.php">Stats</a></li>
            <li><a href="customers.php">Customers</a></li>
            <li><a href="message.php">Messages</a></li>
            <li><a href="settings.php">Settings</a></li>
        </ul>
    </nav>

    <!-- <h1 class="adminHeader">Admin Page</h1> -->
    <div class="container">
        <header>New Scrap Orders</header>
        <table>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Email</th>
                <th>ScrapName</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            session_start();

            if (!isset($_SESSION['admin_id'])) {
                // Redirect to sign-in page if not logged in
                header("Location: ../signin.php");
                exit();
            }
            require "../dbconnector.php";

            //newTable($conn);
            
            function newTable($conn)
            {
                $sql = "SELECT * FROM orders WHERE status='none'";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    $orderId = $row['orderid'];
                    $userId = $row['userid'];
                    $scrapName=$row['scrapname'];
                    $email = $row['email'];
                    $quantity = $row['quantity'];
                    $price = $row['price'];
                    $orderDate = $row['date'];
                    $status = $row['status'];

                    echo "<tr>";
                    echo "<td>$orderId</td>";
                    echo "<td>$userId</td>";
                    echo "<td>$email</td>";
                    echo "<td>$scrapName</td>";
                    echo "<td>$quantity</td>";
                    echo "<td>$price</td>";
                    echo "<td>$orderDate</td>";
                    echo "<td>$status</td>";
                    echo "<td>";
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='orderId' value='$orderId'/>";
                    echo "<button type='submit' name='accept' class='btnAccept'>Accept</button>";
                    echo "<button type='submit' id='rejectBtn' class='btnReject' value='$orderId' >Reject</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            }
            if (isset($_POST['accept'])) {
                $orderId = $_POST['orderId'];
                $updateQuery = "UPDATE orders SET status = 'accepted' WHERE orderid = '$orderId'";
                mysqli_query($conn, $updateQuery);
            }
            if (isset($_POST['reject'])) {
                $orderId = $_POST['orderId'];
                if(!isset($_POST['desc'])){
                $updateQuery = "UPDATE orders SET status = 'rejected' WHERE orderid = '$orderId'";
                }
                else{
                    $desc=$_POST['desc'];
                    $updateQuery = "UPDATE orders SET status = 'rejected',description='$desc' WHERE orderid = '$orderId'";
                }
                mysqli_query($conn, $updateQuery);
            }
            newTable($conn);

            ?>
        </table><br><br>
        <header>Accepted Orders</header>
        <table>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Email</th>
                <th>ScrapName</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Order Date</th>
                <th>Status</th>
            </tr>
            <?php
            $acceptedQuery = "SELECT * FROM orders WHERE status = 'accepted'";
            $acceptedResult = mysqli_query($conn, $acceptedQuery);

            while ($row = mysqli_fetch_assoc($acceptedResult)) {
                $orderId = $row['orderid'];
                $userId = $row['userid'];
                $email = $row['email'];
                $scrapName=$row['scrapname'];
                $quantity = $row['quantity'];
                $price = $row['price'];
                $orderDate = $row['date'];
                $status = $row['status'];

                echo "<tr>";
                echo "<td>$orderId</td>";
                echo "<td>$userId</td>";
                echo "<td>$email</td>";
                echo "<td>$scrapName</td>";
                echo "<td>$quantity</td>";
                echo "<td>$price</td>";
                echo "<td>$orderDate</td>";
                echo "<td>$status</td>";
                echo "</tr>";
            }
            ?>
        </table><br>
        <header>Rejected Orders</header>
        <table>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Email</th>
                <th>ScrapName</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            <?php
            $rejectedQuery = "SELECT * FROM orders WHERE status = 'rejected'";
            $rejectedResult = mysqli_query($conn, $rejectedQuery);

            while ($row = mysqli_fetch_assoc($rejectedResult)) {
                $orderId = $row['orderid'];
                $userId = $row['userid'];
                $email = $row['email'];
                $scrapName=$row['scrapname'];
                $quantity = $row['quantity'];
                $price = $row['price'];
                $orderDate = $row['date'];
                $status = $row['status'];
                $description=$row['description'];

                echo "<tr>";
                echo "<td>$orderId</td>";
                echo "<td>$userId</td>";
                echo "<td>$email</td>";
                echo "<td>$scrapName</td>";
                echo "<td>$quantity</td>";
                echo "<td>$price</td>";
                echo "<td>$orderDate</td>";
                echo "<td>$status</td>";
                echo"<td style='color:red'> $description</td>";
                echo "</tr>";
            }
            ?>

        </table>
        <form method="post">
            <div id="dialogBox" class="modal1">
                <div class="content">
                    <label for="desc">Are you sure</label>
                    <span class="close">&times;</span>
                    <input type="hidden" id="oid" name="orderId">
                    <input type="text" name="desc" id="desc" class="descText" placeholder="description(optional)"><br>
                    <button type="submit" name="reject" class="okBtn">OK</button>
                </div>
        </form>
    </div>
    <script src="home.js"></script>
</body>

</html>