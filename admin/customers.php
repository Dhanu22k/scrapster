<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="customers.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="stats.php">Stats</a></li>
            <li style="background-color:black"><a href="customers.php">Customers</a></li>
            <li><a href="message.php">Messages</a></li>
            <li><a href="settings.php">Settings</a></li>
        </ul>
    </nav>
    <div class="contain">
        <?php
        session_start();

        if (!isset($_SESSION['admin_id'])) {
            // Redirect to sign-in page if not logged in
            header("Location: ../signin.php");
            exit();
        }
        require "../dbconnector.php";
        $acceptedQuery = "SELECT * FROM users";
        $acceptedResult = mysqli_query($conn, $acceptedQuery);
        echo '<div class="profile-grid">';


        while ($row = mysqli_fetch_assoc($acceptedResult)) {
            $userid = $row['id'];
            $username = $row['name'];
            $userEmail=$row['email'];
            $status=$row['status'];
            $profileImage = $row['profileImage'];
            echo '<div class="card profile-item" style="width: 18rem;">
        <div class="d-flex flex-column align-items-center text-center">
        ';
            if (!empty($profileImage)) {
                echo ' <img src="data:image/jpg;charset=utf8;base64,';
                echo base64_encode($profileImage);
                echo '" alt="Admin" class="rounded-circle" width="200px" height="150px">';
            } else {
                echo ' <img src="https://bootdey.com/img/Content/avatar/avatar7.png"  alt="Admin" class="rounded-circle" width="200px" height="150px">';
            }
            echo '
         </div>
        <div class="card-body">
            <h5 class="card-title">User Id: ' . $userid . '</h5>
            <h5 class="card-title">Name: ' . $username . '</h5>
            <h5 class="card-title">Email: '.$userEmail.'</h5>
            <form method="get" action="customerDetail.php">
            <input type="hidden" name="userid" value="'.$userid.'"/>
            <button type="submit" class="btn btn-primary">More</button><span id="status" class="status-flag">'.$status.'</span>
            </form>
        </div>
      </div>';
        }
        echo ' </div>'
            ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
<script src="customers.js">

</script>
</body>

</html>