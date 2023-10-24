
<?php

session_start();
// Check if the user is already signed in
if (isset($_SESSION['email'])) {
    // Redirect to the dashboard if already signed in
require "../dbconnector.php";

$email=$_SESSION['email'];
$sql = "SELECT count(*) as total FROM orders WHERE email = '$email'";
$result = mysqli_query($conn, $sql);
$count= mysqli_fetch_assoc($result);

$result = mysqli_query($conn, "SELECT SUM(price) AS value_sum FROM orders WHERE email = '$email' and status='accepted'"); 
$row = mysqli_fetch_assoc($result); 
$sum = $row['value_sum'];

if($sum=='')
{
  $sum=0;
}

$sql = "SELECT count(*) as total FROM orders WHERE email = '$email' and status='accepted'";
$result = mysqli_query($conn, $sql);
$countAccepted= mysqli_fetch_assoc($result);


$sql = "SELECT count(*) as total FROM orders WHERE email = '$email' and status='rejected'";
$result = mysqli_query($conn, $sql);
$countRejected= mysqli_fetch_assoc($result);


           
   echo' <!DOCTYPE html>
<html >
<head>
  <title>Home - Scrap Management App</title>
   <link rel="stylesheet" href="home.css"> 
</head>
<body>
  <header>
    <nav>
      <ul>
      <li class="point"><a href="home.php"><strong style="color:red">Home</strong></a></li>
        <li><a href="scraps.php">ManageScraps</a></li>
        <li><a href="orders.php">Orders</a></li>
        <li><a href="message.php">Message</a></li>
        <li><a href="profile.php">Profile</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <div class="container">
      <div class="dashboard-grid">
        <div class="dashboard-card">
          <h2>Total Orders</h2>
         <p id="totalOrders">'.$count["total"];echo'</p>
        </div>
        <div class="dashboard-card">
          <h2>Total Revenue</h2>
          <p id="totalRevenue">'.$sum;echo'</p>
        </div>

        <div class="dashboard-card">
        <h2>Accepted Orders</h2>
        <p id="accepted">'.$countAccepted["total"];echo'</p>
      </div>

      <div class="dashboard-card">
        <h2>Rejected Orders</h2>
        <p id="rejected">'.$countRejected["total"];echo'</p>
      </div>
      </div>
    </div>
  </main>

<div>
  <h2 class="olistHeader">ACCEPTED ORDERS</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Order Date</th>
            <th>Status</th>
        </tr>';
        
        $userid=$_SESSION['userid'];
        $acceptedQuery = "SELECT * FROM orders WHERE userid='$userid' and status='accepted' ORDER BY orderid DESC";
        $acceptedResult = mysqli_query($conn, $acceptedQuery);

        while ($row = mysqli_fetch_assoc($acceptedResult)) {
            $orderId = $row['orderid'];
            $userId = $row['userid'];
            $email = $row['email'];
            $quantity = $row['quantity'];
            $price = $row['price'];
            $orderDate = $row['date'];
            $status = $row['status'];

            echo "<tr>";
            echo "<td>$orderId</td>";
            echo "<td>$quantity</td>";
            echo "<td>$price</td>";
            echo "<td>$orderDate</td>";
            echo "<td>$status</td>";
            echo "</tr>";
        }
        
 echo"   </table><br>
  
 
</body>

</html>";

}

else{
  header('Location:../signin.php');
}
?>



