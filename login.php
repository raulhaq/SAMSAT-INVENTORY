<?php
require 'function.php';
// session_start();

if (isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cocokin dgn database, cari apakah ada atau tidak
    $cekdatabase = mysqli_query($conn, "SELECT * FROM login where email='$email' and password='$password'");
    
    // Hitung jumlah data
    $hitung = mysqli_num_rows($cekdatabase);

    if ($hitung > 0){
        $_SESSION['log'] = 'True';
        header('location: index.php');
    } else {
        header('location: login.php');
    };
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login - Inventaris</title>

    <!-- Fonts dan CSS -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-flex align-items-center justify-content-center flex-column bg-light p-4">
                            <img src="logo2.png" alt="Logo Pemerintah Aceh" style="max-width: 300px; height: auto; margin-bottom: 20px;">
                            <h4 class="text-primary text-center font-weight-bold">UPTD-PPA Wil. I<br>Banda Aceh BPKA</h4>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Admin Login</h1>
                                </div>
                                <form class="user" method="post">
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" name="email" placeholder="Enter Email Address..." required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="password" placeholder="Password" required>
                                    </div>
                                    <button class="btn btn-primary btn-user btn-block" name="login">
                                        Login
                                    </button>
                                </form>

                                <!-- Tombol User Baru -->
                                <div class="text-center mt-4">
                                    <a href="register.php" class="btn btn-outline-secondary btn-user btn-block">
                                        User Baru
                                    </a>
                                </div>

                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script JS -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>

</body>
</html>
