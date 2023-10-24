<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Detail</title>
    <link rel="stylesheet" href="customerDetail.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <nav>
        <a href="customers.php" class="btn btn-info back-btn">Back</a>

    </nav>
    <?php
    session_start();

    if (!isset($_SESSION['admin_id'])) {
        // Redirect to sign-in page if not logged in
        header("Location: ../signin.php");
        exit();
    }
    require "../dbconnector.php";

    $userid = $_GET['userid'];
    $query = "SELECT * FROM users WHERE id=$userid";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $username = $row['name'];
        $userEmail = $row['email'];
        $profileImage = $row['profileImage'];
        $phone = $row['phone'];
        $address = $row['address'];
        $password = $row['password'];
        $status = $row['status'];
    }

    if (isset($_POST['active'])) {
        $q = "update users set status='blocked' where id=$userid";
        mysqli_query($conn, $q);
        $status = 'blocked';
    }
    if (isset($_POST['blocked'])) {
        $q = "update users set status='active' where id=$userid";
        mysqli_query($conn, $q);
        $status='active';
    }
    if ($status == 'active') {
        $color = "green";
        $btnText = 'Block';
    } else {
        $color = "red";
        $btnText = 'Unblock';
    }

    echo ' <div class="container">
        <div class="main-body">
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                ';
    if (!empty($profileImage)) {
        echo ' <img
                                    src="data:image/jpg;charset=utf8;base64,';
        echo base64_encode($profileImage);
        echo '"
                                    alt="Admin" class="rounded-circle" width="150">';
    } else {
        echo ' <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                                    class="rounded-circle" width="150">';
    }
    echo ' <div class="mt-3">
                                    <h4>' . $username . '</h4>
                                    <h6 class="text-muted font-size-sm">USERID: ' . $userid . '</h6>
                                   <span class="status-text" style="color:' . $color . '">Status: ' . $status . '</span>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="post">
                        <div class="card mt-3">
                            <button type="submit" id="myBtn" class="btn btn-danger " name="' . $status . '">' . $btnText . '</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        ' . $userEmail . '
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Full Name</h6>
                                    </div>
                                        <div class="col-sm-9 text-secondary">
                                        ' . $username . '
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Phone</h6>
                                    </div>
                                        <div class="col-sm-9 text-secondary">
                                        ' . $phone . '
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Address</h6>
                                    </div>
                                        <div class="col-sm-9 text-secondary">
                                        ' . $address . '
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Password</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <div class="password-field">
                                            <input type="password" value="' . $password . '" class="password" id="Password" readonly/>
                                            <span><i id="toggler"class="far fa-eye"></i></span>
                                        </div>
                                    </div>
                            </div>
                            
                        </div>
                    </div>



                </div>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>';
    ?>
    <script>
        var password = document.getElementById('Password');
        var toggler = document.getElementById('toggler');
        showHidePassword = () => {
            if (password.type == 'password') {
                password.setAttribute('type', 'text');
                toggler.classList.add('fa-eye-slash');
            } else {
                toggler.classList.remove('fa-eye-slash');
                password.setAttribute('type', 'password');
            }
        };
        toggler.addEventListener('click', showHidePassword);
    </script>
</body>

</html>