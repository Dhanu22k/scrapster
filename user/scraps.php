<?php

session_start();

// Check if the user is already signed in
if (!isset($_SESSION['email'])) {
  header("Location:../signin.php");
}



echo '<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Scraps - Scrap Management App</title>
  <link rel="stylesheet" href="scraps.css">
  
</head>

<body>
  <header>
    <nav>
      <ul>
      <li><a href="home.php">Home</a></li>
      <li><a href="scraps.php"><strong style="color:red">ManageScraps</strong></a></li>
      <li><a href="orders.php">Orders</a></li>
      <li><a href="message.php">Message</a></li>
      <li><a href="profile.php">Profile</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <div class="container">
      <h1>Manage Scraps</h1>

      <form id="scrapForm" method="post">
        <div class="form-group">
          <label for="name">Scrap Name</label>
          <input type="text" id="name" name="scrapname" placeholder="Enter scrap name" required>
        </div>

        <div class="form-group">
          <label for="quantity">Quantity</label>
          <input type="number" id="quantity" name="quantity" placeholder="Enter quantity" required>
        </div>

        <div class="form-group">
          <label for="price">Price</label>
          <input type="number" id="price" name="price" placeholder="Enter price" required>
        </div>
        
        <button type="submit" name="submit">Add Scrap</button>
      </form>
    </div>
  </main>



</body>

</html>';

require "../dbconnector.php";

// Function to sanitize input data
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $scrapname = sanitize($_POST["scrapname"]);
    $quantity = sanitize($_POST["quantity"]);
    $price = sanitize($_POST["price"]);
    $date=date("Y/m/d");
    $userid=$_SESSION['userid'];
    $email= $_SESSION['email'];
    $status="none";
  

    // Perform SQL query to insert user data
    $sql = "INSERT INTO orders (scrapname, date,userid,email,quantity,price,status) VALUES ('$scrapname','$date','$userid','$email','$quantity','$price','$status')";
    
    if ($conn->query($sql) === TRUE) {
         // Signup successful, redirect to sign-in page with success message
         $successMessage = "Added Successfuly";
    }
     else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    // Close the database connection
    $conn->close();
}
 
 ?>