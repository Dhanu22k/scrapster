<?php
  require "../dbconnector.php";
  $msgid=$_POST['messageid'] ;
      $sql = "select * from message where messageid='$msgid'";
     $result= mysqli_query($conn, $sql);
      while($row=mysqli_fetch_assoc($result))
      {
        echo $row['reply'];
      }
?>
