<?php
require 'function.php';

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeat = $_POST['repeat_password'];

    if ($password == $repeat) {
        // Cek apakah email sudah terdaftar
        $cek = mysqli_query($conn, "SELECT * FROM login WHERE email='$email'");
        if (mysqli_num_rows($cek) > 0) {
            echo "<script>alert('Email sudah terdaftar!');</script>";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert = mysqli_query($conn, "INSERT INTO login (email, password) VALUES ('$email', '$hashed_password')");
            if ($insert) {
                header('Location: login.php');
                exit;
            } else {
                echo "<script>alert('Gagal mendaftar!');</script>";
            }
        }
    } else {
        echo "<script>alert('Password tidak cocok!');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register - Inventaris</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900"
        rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Buat Akun Baru</h1>
                            </div>
                            <form class="user" method="POST">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-user" required placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-user" required placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="repeat_password" class="form-control form-control-user" required placeholder="Ulangi Password">
                                </div>
                                <button type="submit" name="register" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="login.php">Sudah punya akun? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>
