<?php

session_start();

if (!isset($_SESSION['admin_id'])) {
    // Redirect to sign-in page if not logged in
    header("Location: ../signin.php");
    exit();
}

// Get the admin ID from the session
$adminId = $_SESSION['admin_id'];

// Get admin details from the database
require "../dbconnector.php";

// Fetch admin details from the database
$query = "SELECT name, email FROM admin WHERE id = '$adminId'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $adminName = $row['name'];
    $adminEmail = $row['email'];
} else {
    // Handle case if admin details are not found
    $adminName = "Admin";
    $adminEmail = "admin@example.com";
}

// Handle form submission for changing password
if (isset($_POST['change_password'])) {
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];

    // Validate old password
    $validateQuery = "SELECT * FROM admin WHERE id = '$adminId' AND password = '$oldPassword'";
    $validateResult = mysqli_query($conn, $validateQuery);

    if (mysqli_num_rows($validateResult) > 0) {
        // Update password
        $updateQuery = "UPDATE admin SET password = '$newPassword' WHERE id = '$adminId'";
        mysqli_query($conn, $updateQuery);

        // Redirect to settings page
        // header("Location: settings.php");
        $displayMsg = "Password successfully changed";
        $color = "green";
    } else {
        $displayMsg = "Invalid old password";
        $color = "red";
    }
}

// Handle logout
if (isset($_POST['logout'])) {
    // Destroy session and redirect to sign-in page
    session_destroy();
    header("Location: ../signin.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Settings</title>
    <link rel="stylesheet" href="settings.css">
    <style>
       .msg {
    color:
        <?php echo $color; ?>
    ;
    margin-bottom: 10px;
}
    </style>
</head>

<body>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="stats.php">Stats</a></li>
            <li><a href="customers.php">Customers</a></li>
            <li><a href="message.php">Messages</a></li>
            <li style="background-color:black"><a href="settings.php">Settings</a></li>
        </ul>
    </nav>
    <div class="container">
        <div class=content>
            <h1>Settings</h1>

            <p>Welcome,
                <?php echo $adminName; ?>!
            </p>
            <p>Email:
                <?php echo $adminEmail; ?>
            </p>

            <h2>Change Password</h2>
            <?php
            if (isset($displayMsg)) {
                echo "<p style='color: $color;' id='displayMsg'>$displayMsg</p>";
            }
            ?>
            <script>
                setTimeout(()=>{
                    document.getElementById('displayMsg').hidden='true';
                },2000)
                
            </script>
            <form method="post">
                <label for="old_password">Old Password:</label>
                <input type="password" id="old_password" name="old_password" required>
                <br>
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>
                <br>
                <button type="submit" name="change_password">Change Password</button>
            </form>

            <h2>Logout</h2>
            <form method="post">
                <button type="submit" name="logout">Logout</button>
            </form>
        </div>
    </div>
</body>

</html>

<?php
// Close the database connection
mysqli_close($conn);
?>