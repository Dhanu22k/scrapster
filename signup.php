<?php
// Database credentials
$host = "localhost:3308";  // Replace with your database host
$dbUsername = "root";  // Replace with your database username
$dbPassword = "";  // Replace with your database password
$dbName = "scrapster";  // Replace with your database name

// Create a database connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize($_POST["name"]);
    $email = sanitize($_POST["email"]);
    $password = sanitize($_POST["password"]);

    // Perform SQL query to insert user data
    $sql = "INSERT INTO users (name, email, password,status) VALUES ('$username', '$email', '$password','active')";
    
    if ($conn->query($sql) === TRUE) {
         // Signup successful, redirect to sign-in page with success message
         $successMessage = "Signup successful! Please sign in.";
         header("Location: signin.php?message=" . urlencode($successMessage));
         exit();
    }
     else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    // Close the database connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Signup Page</title>
  <link rel="stylesheet" href="signup.css">
</head>
<body>
  <div class="container">
    <h2>Signup</h2>
    <form id="signupForm" action="signup.php" method="post">
    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" placeholder="Enter your name" required>
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" required>
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="text" id="password" name="password" placeholder="Enter your password" required>
    </div>
    <div class="form-group">
      <label for="confirm-password">Confirm Password:</label>
      <input type="password" id="confirm-password" placeholder="Confirm your password" required>
      <span id="passwordError" class="error"></span><br>
    </div>
 <input type="submit" class="button" value="Signup" >
    <p>Already have an account? <a href="signin.php">Sign In</a></p>
    <div id="error-message" class="error-message" style="display: none;"></div>
  </form>
  </div>
  <script>
    document.getElementById("signupForm").addEventListener("submit", function(event) {
            var passwordInput = document.getElementById("password");
            var confirmPasswordInput=document.getElementById("confirm-password");
            var passwordError = document.getElementById("passwordError");

            var password = passwordInput.value;

            // Validate password
            var isValid = true;
            var errorMessage = "";

            // Minimum character length of 8
            if (password.length < 8) {
                isValid = false;
                errorMessage += "Password must be at least 8 characters long.<br>";
                event.preventDefault();
            }
// Special character
if (!/[!@#$%^&*]/.test(password)) {
                isValid = false;
                errorMessage += "Password must contain at least one special character (!, @, #, $, %, ^, &, *).<br>";
            }

            // Uppercase letter
            if (!/[A-Z]/.test(password)) {
                isValid = false;
                errorMessage += "Password must contain at least one uppercase letter.<br>";
                event.preventDefault();
            }
 // Lowercase letter
 if (!/[a-z]/.test(password)) {
                isValid = false;
                errorMessage += "Password must contain at least one lowercase letter.<br>";
                event.preventDefault();
            }

            // Digit
            if (!/[0-9]/.test(password)) {
                isValid = false;
                errorMessage += "Password must contain at least one digit (0-9).<br>";
                event.preventDefault();
            }

            if (!isValid) {
                passwordError.innerHTML = errorMessage;
                event.preventDefault(); // Prevent form submission
            } else {
                passwordError.innerHTML = ""; // Clear error message
            }



            var password = passwordInput.value;
            var confirmPassword = confirmPasswordInput.value;
            var isValid = true;
            var errorMessage = "";

            // Password match
            if (password !== confirmPassword) {
                isValid = false;
                errorMessage += "Passwords do not match.<br>";
                event.preventDefault();
            }

            // Additional password validation rules...
            // Minimum character length, special character, uppercase, lowercase, digit, etc.

            if (!isValid) {
                passwordError.innerHTML = errorMessage;
                confirmPasswordError.innerHTML = errorMessage;
                event.preventDefault(); // Prevent form submission
            } else {
                confirmPasswordError.innerHTML = ""; // Clear error message
            }
            
        });



    </script>

</body>
</html>

