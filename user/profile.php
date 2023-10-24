<?php
session_start();
if (isset($_SESSION['email'])) {

  require "../dbconnector.php";
  $userid = $_SESSION['userid'];
  $query = "SELECT * FROM users WHERE id='$userid'";
  $result = mysqli_query($conn, $query);

  while ($row = mysqli_fetch_assoc($result)) {
    $email = $row['email'];
    $name = $row['name'];
    $phone = $row['phone'];
    $address = $row['address'];
    $profileImage=$row['profileImage'];
  }
  if (empty($address)) {
    $address = "";
  }
  if(empty($phone))
  {
    $phone="";
  }

  //if the form is submited then this code is executed
  
  if (isset($_POST['submit'])) {
    $name=$_POST['name'];
    $phone=$_POST['phone'];
    $address=$_POST['address'];
    $q="update users set name='$name',phone='$phone',address='$address' where id=$userid";
    mysqli_query($conn, $q);
  }

// Profile picture uploading
  if (isset($_POST['imageUpload'])){
    $Fname = $_FILES['image']['name'];
      $type = $_FILES['image']['type'];
      $data = file_get_contents($_FILES['image']['tmp_name']);
      $pdo = new PDO('mysql:host=localhost:3308;dbname='.$dbName,$dbUsername,$dbPassword);
      // insert the image data into the database
      $stmt = $pdo->prepare("update users set profileImage=? where id=$userid");
      $stmt->bindParam(1, $data);
      $stmt->execute();
      header("Refresh:0");

  }

  // Logout code
  if(isset($_POST['logout']))
  {
    session_destroy();
    header("Location: ../signin.php");
    exit();
  }

echo '

    <!DOCTYPE html>
<html >
<head>
  <title>Home - Scrap Management App</title>
   <link rel="stylesheet" href="profile.css"> 
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
  <header>
    <nav>
      <ul>
      <li class="point"><a href="home.php">Home</a></li>
        <li><a href="scraps.php">ManageScraps</a></li>
        <li><a href="orders.php">Orders</a></li>
        <li><a href="message.php">Message</a></li>
        <li><a href="profile.php"><strong style="color:red">Profile</strong></a></li>
      </ul>
    </nav>
  </header>
  <div class="container">
  <div class="main-body">
        <div class="row gutters-sm">
          <div class="col-md-4 mb-3">
            <div class="card">
              <div class="card-body">
                <div class="d-flex flex-column align-items-center text-center">
               ';
               if(!empty($profileImage)){
                 echo' <img src="data:image/jpg;charset=utf8;base64,';echo base64_encode($profileImage);echo'" alt="Admin" class="rounded-circle" width="150">';
               }
               else{
                echo' <img src="https://bootdey.com/img/Content/avatar/avatar7.png"  alt="Admin" class="rounded-circle" width="150">';
               }
                echo'  <div class="mt-3">
                    <h4>' . $name . '</h4>
                    <p class="text-muted font-size-sm">USERID: ' . $userid . '</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="card mt-3">           
                <button id="myBtn" class="btn btn-info " >Update profile picture</button>
            </div>
            <form method="post">
            <div class="card mt-3">           
                <button type="submit" id="myBtn" class="btn btn-danger " name="logout" >Logout</button>
            </div>
            </form>
          </div>
          <div class="col-md-8">
            <div class="card mb-3">
              <div class="card-body">
              <form method="post">
                <div class="row">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Email</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    ' . $email . '
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3" >
                    <h6 class="mb-0" >Full Name</h6>
                  </div>
                  
                  <input type="text" name="name" class="col-sm-9 text-secondary" value="'.$name.'" id="dataField" readonly="readonly" />
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Phone</h6>
                  </div>
                  <input type="number" name="phone" class="col-sm-9 text-secondary"  id="dataField" readonly="readonly"   placeholder="no phone number" value="'.$phone.'"  />
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Address</h6>
                  </div>
                  <input type="text" name="address" class="col-sm-9 text-secondary" value="'.$address.'" id="dataField" readonly="readonly"  placeholder="........"/>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-12">
                    <a class="btn btn-info "  href="#" id="editBtn" >Edit</a>
                    <button type="submit" class="btn btn-info " name="submit"  id="submitBtn" hidden>Submit</button>
                  </div>
                </div>
                </form>
              </div>
            </div>



          </div>
        </div>

      </div>
  </div>
  <!-- dialogBox -->
    <form method="post" enctype="multipart/form-data">
      <div id="dialogBox" class="modal1">
        <div class="content">
          <span class="close">&times;</span>
          <input type="file" id="file" name="image" accept="image/*"/>
          <button type="submit" id="imgUpBtn" name="imageUpload" class="btn btn-primary " hidden>Upload</button>
      </div>
    </form>
</div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="profileScript.js"></script>
    </body>
    </html>
    ';
} else {
  header('Location:../signin.php');
}

?>