<?php

// Database credentials
$host = "localhost:3308"; // Replace with your database host
$dbUsername = "root"; // Replace with your database username
$dbPassword = ""; // Replace with your database password
$dbName = "scrapster"; // Replace with your database name

// Create a database connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$message;
// Function to sanitize input data
function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitize($_POST["email"]);
    $password = sanitize($_POST["password"]);

    if (isset($_POST['admin'])) {
        $sql = "SELECT * FROM admin WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $storedPassword = $row["password"];


            if ($password == $storedPassword) {
                // Password is correct, set up session
                session_start();
                $_SESSION['admin_id'] = $row["id"];
                $_SESSION['email'] = $row["email"];
                header("Location: admin/home.php");
                exit();
            } else {
                $message = "Inavlid email or password ";
            }
        } else {
            $message = "Inavlid email or password ";
        }

    } else {
        // Perform SQL query to retrieve user data
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);
        $storedPassword;
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $status = $row['status'];
            $storedPassword = $row["password"];

            // Verify the password

            if ($password == $storedPassword) {
                if ($status == 'active') {
                    // Password is correct, set up session
                    session_start();
                    $_SESSION['username'] = $row["name"];
                    $_SESSION['email'] = $row["email"];
                    $_SESSION['userid'] = $row["id"];

                    // Redirect to the dashboard
                    header("Location: user/home.php");
                    exit();
                } else {
                    $message = "user is blocked";
                }
            } else {
                $message = "Inavlid email or password ";
            }

        } else {
            $message = "user does not exist";
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Signin Page</title>
    <link rel="stylesheet" href="signin.css">
</head>

<body>

    <div class="container">
        <h2>Sign In</h2>
        <form action="signin.php" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" placeholder="Enter your email">

            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">
            </div>
            Admin:<input type="checkbox" name="admin">
            <input type="submit" value="Signin" class="button" />
            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
            <div id="error-message" class="error-message" style="display: none;"></div>
        </form>
        <?php
        if (!empty($message)) {
            echo ' <div class="alert" role="alert">
            ' . $message . '
        </div>';
        }
        ?>
    </div>

</body>

</html>