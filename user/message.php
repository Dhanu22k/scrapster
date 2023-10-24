<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="message.css">
    <script src="http://code.jquery.com/jquery-latest.js"></script>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="scraps.php">ManageScraps</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="message.php"><strong style="color:red">Message</strong></a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <table>
            <tr>
                <th>Message id</th>
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
                $userid = $_SESSION['userid'];

                if (isset($_POST['send'])) {
                    $message = $_POST['message'];
                    $sql = "insert into message(userid,message) values('$userid','$message')";
                    mysqli_query($conn, $sql);
                }
                $sql = "select * from message where userid=$userid order by messageid desc";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $messageid=$row["messageid"];
                    echo '<form method="post"><tr>
                        <td>' .$messageid. '</td>
                        <td>' . $row["date"] . '</td>
                        <td class="msgTd" id="msg'.$messageid.'">' . $row["message"] . '</td>';
                        if(!empty($row['reply'])){
                       echo' <td> <input type="hidden" name="messageid" value="'.$messageid.'" id="messageid"><button type="button"  id="myBtn" value="'.$messageid.'"onclick="hanndleMessage(event);" class="btn btn-danger">Click to see</button></td>';
                        }
                        else{
                            echo'<td>.....</td>';
                        }
               echo' </tr> </form>';

                }

            } else {
                header('Location:../signin.php');
                exit();

            }

            ?>
        </table>
    </div>
    <center>
        <form method="post">
            <div class="text-box   input-group mb-3 ">
                <input type="text" name="message" class="form-control" placeholder="Enter the message"
                    aria-label="message" aria-describedby="button-addon2" required>
                <button class="btn btn-outline-secondary" type="submit" name="send" id="button-addon2">Send</button>
            </div>
        </form>

        <!-- dialogBox -->
            <div class="dbox">
                <div id="dialogBox" class="modal1">
                    <div class="content">
                        <span class="close">&times;</span>
                        <p class="textArea" id="textArea"></p>
                    </div>
                </div>
            </div>
        <script src="message.js"></script>
        <script>
           
        </script>
</body>

</html>