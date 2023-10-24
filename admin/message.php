<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer messages</title>
    <link rel="stylesheet" href="message.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="stats.php">Stats</a></li>
            <li><a href="customers.php">Customers</a></li>
            <li style="background-color:black"><a href="message.php">Messages</a></li>
            <li><a href="settings.php">Settings</a></li>
        </ul>
    </nav>
    <div class="container">
        <table>
            <tr>
                <th>Message id</th>
                <th>User id</th>
                <th>Time</th>
                <th>Message</th>
                <th>Reply</th>
            </tr>



            <?php

            session_start();
            // Check if the user is already signed in
            if (isset($_SESSION['email'])) {
                // Redirect to the dashboard if already signed in
            
                require "../dbconnector.php";
                $email = $_SESSION['email'];

                if (isset($_POST['send'])) {
                    $message = $_POST['message'];
                    $messageid=$_POST['messageid'];
                    $sql = "update message set reply='$message' where messageid=$messageid";
                    mysqli_query($conn, $sql);
                }
                $sql = "select * from message order by messageid desc";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $messageid = $row["messageid"];
                    $userid = $row["userid"];
                    $reply = $row["reply"];
                    echo '<form method="post"><tr>
                        <td>' . $messageid . '</td>
                        <td>' . $userid . '</td>
                        <td>' . $row["date"] . '</td>
                        <td class="msgTd" id="msg' . $messageid . '">' . $row["message"] . '</td>';
                    if (empty($reply)) {
                        echo '<td> <input type="hidden" name="messageid" value="' . $messageid . '" id="messageid"><button type="button"  id="myBtn" value="' . $messageid . '"onclick="hanndleMessage(event);" class="btn btn-danger">Click to reply</button></td>';
                    } else {
                        echo '<td>' . $reply . '</td>';
                    }
                    echo ' </tr> </form>';

                }

            } else {
                header('Location:../signin.php');
                exit();

            }

            ?>
        </table>
    </div>

    <!-- dialogBox -->
    <div class="dbox">
        <div id="dialogBox" class="modal1">
        <form method="post">
            <div class="content">
                <span class="close">&times;</span>
                <p class="textArea" id="textArea"></p><hr>
                <input type="hidden" name="messageid" id="msgid" />
               
                    <center>
                        <div class="text-box   input-group mb-3 ">
                            <input type="text" name="message" class="form-control" placeholder="Enter the message"
                                aria-label="message" aria-describedby="button-addon2" required>
                            <button class="btn btn-outline-secondary" type="submit" name="send"
                                id="button-addon2">Send</button>
                        </div>
                    </center>
            </div>
            </form>
        </div>
    </div>
    </center>
    <script src="message.js"></script>
</body>

</html>