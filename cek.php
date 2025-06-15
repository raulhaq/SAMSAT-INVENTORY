<?php
//tempat cek apakah sudah pernah login apa blom

//jika blum login
if(isset($_SESSION['log'])){
    
} else {
    header('location:login.php');
}
?>