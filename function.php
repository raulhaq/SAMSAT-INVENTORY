<?php
session_start();
$conn = mysqli_connect("localhost","root","","tes1");


// tambahkan fungsi untuk daftar user
function registerUser($email, $password) {
    global $conn;

    // Cek apakah user sudah ada
    $check = mysqli_query($conn, "SELECT * FROM login WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        return false; // User sudah terdaftar
    }

    // Insert user baru
    $insert = mysqli_query($conn, "INSERT INTO login (email, password) VALUES ('$email', '$password')");
    return $insert ? true : false;
}

//tambah barang di tables
if (isset ($_POST['addnewbarang'])){
    $kodebarang = $_POST['kodebarang'];
    $namabarang = $_POST['namabarang'];
    $merk = $_POST['merk'];
    $tahun = $_POST['tahun'];
    $asal = $_POST['asal'];
    $kondisi = $_POST['kondisi'];
    $stock = $_POST['stock'];
    $harga = preg_replace('/[^0-9]/', '', $_POST['harga']); // hanya ambil angka
    $keterangan = $_POST['keterangan'];
    $ruangan = $_POST['ruangan'];


    $addtable = mysqli_query($conn, "insert  into stock (kodebarang, namabarang, merk, tahun, asal, kondisi, stock, harga, keterangan, ruangan) 
    values ('$kodebarang','$namabarang','$merk','$tahun','$asal','$kondisi', '$stock', '$harga', '$keterangan', '$ruangan')");
    if ($addtable){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');  
    }
}

//menambah barang masuk
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];
    $tanggal = !empty($_POST['tanggal']) ? $_POST['tanggal'] : date("Y-m-d H:i:s");


    $cek_stock_sekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambil_data_stock = mysqli_fetch_array($cek_stock_sekarang);

    $stock_sekarang = $ambil_data_stock['stock'];
    $tambah_stock_qty = $stock_sekarang+$qty;


    $addmasuk = mysqli_query($conn,"insert into masuk (idbarang, penerima, qty, tanggal) values ('$barangnya','$penerima','$qty', '$tanggal')");
    $update_stock_masuk = mysqli_query($conn, "update stock set stock ='$tambah_stock_qty' where idbarang ='$barangnya'");

    if ($addmasuk&&$update_stock_masuk){
        header('location:barang_masuk.php');
    } else {
        echo 'Gagal';
        header('location:barang_masuk.php');  
    }
}


//menambah barang keluar
if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $pemakai = $_POST['pemakai'];
    $qty = $_POST['qty'];
    $tanggal = !empty($_POST['tanggal']) ? $_POST['tanggal'] : date("Y-m-d H:i:s");

    $cek_stock_sekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambil_data_stock = mysqli_fetch_array($cek_stock_sekarang);

    $stock_sekarang = $ambil_data_stock['stock'];
    $tambah_stock_qty = $stock_sekarang-$qty;


    $addkeluar = mysqli_query($conn,"insert into keluar (idbarang, pemakai, qty, tanggal) values ('$barangnya','$pemakai','$qty', '$tanggal')");
    $update_stock_masuk = mysqli_query($conn, "update stock set stock ='$tambah_stock_qty' where idbarang ='$barangnya'");

    if ($addkeluar&&$update_stock_masuk){
        header('location:barang_keluar.php');
    } else {
        echo 'Gagal';
        header('location:barang_keluar.php');  
    }
}



// update info barang
if(isset($_POST['updatebarang'])){
    $idb = $_POST['idb'];
    $kodebarang = $_POST['kodebarang'];
    $namabarang = $_POST['namabarang'];
    $merk = $_POST['merk'];
    $tahun = $_POST['tahun'];
    $asal = $_POST['asal'];
    $kondisi = $_POST['kondisi'];
    $stock = $_POST['stock'];
    $harga = $_POST['harga']; // hanya ambil angka
    $keterangan = $_POST['keterangan'];
    $ruangan = $_POST['ruangan'];


    $update = mysqli_query($conn,"update stock set kodebarang='$kodebarang', namabarang='$namabarang', merk='$merk', tahun='$tahun',
     asal='$asal', kondisi='$kondisi', keterangan='$keterangan', ruangan='$ruangan' where idbarang='$idb'");
    if($update){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}


// menghapus barang dari stok
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn,"delete from stock where idbarang='$idb'");
    if($hapus){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
};


//edit barang masuk
if(isset($_POST['updatebarang_masuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    // Ambil stok saat ini
    $lihat_stock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihat_stock);
    $stock_skrg = $stocknya['stock'];

    // Ambil qty saat ini
    $qty_sekarang = mysqli_query($conn,"select * from masuk where idmasuk ='$idm'");
    $qtynya = mysqli_fetch_array($qty_sekarang);
    $qty_sekarang = $qtynya['qty'];

    // Kembalikan stok ke kondisi semula
    $stok_awal = $stock_skrg - $qty_sekarang;

    // Hitung stok baru berdasarkan qty baru
    $stok_baru = $stok_awal + $qty;

    // Validasi agar stok tidak negatif
    if ($stok_baru < 0) {
        echo "Error: Stok tidak bisa menjadi negatif.";
        header('location:barang_masuk.php');
        exit;
    }

    // Update stok
    $kurangi_stock = mysqli_query($conn, "update stock set stock='$stok_baru' where idbarang='$idb'");
    $updatenya = mysqli_query($conn, "update masuk set qty='$qty', penerima='$penerima' where idmasuk='$idm'");

    // Redirect jika berhasil
    if($kurangi_stock && $updatenya){
        header('location:barang_masuk.php');
    } else {
        echo 'Gagal';
        header('location:barang_masuk.php');
    }
}
// delete barang masuk

if(isset($_POST['hapusbarang_masuk'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $get_data_stock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($get_data_stock);
    $stok = $data['stock'];

    $selisih = $stok-$qty;

    $update = mysqli_query($conn, "update stock set stock='$selisih' where idbarang ='$idb'");
    $hapus_data = mysqli_query($conn,"delete from masuk where idmasuk='$idm'");

    if($update&&$hapus_data){
        header('location: barang_masuk.php');
    } else {
        header('location: blank.html');
    }

}


// edit data barang keluar

// if(isset($_POST['updatebarang_keluar'])){
//     $idb = $_POST['idb'];
//     $idk = $_POST['idk'];
//     $pemakai = $_POST['pemakai'];
//     $qty = $_POST['qty'];

//     $lihat_stock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
//     $stocknya = mysqli_fetch_array($lihat_stock);
//     $stock_skrg = $stocknya['stock'];

//     $qty_sekarang = mysqli_query($conn,"select * from keluar where idkeluar ='$idk'");
//     $qtynya = mysqli_fetch_array($qty_sekarang);
//     $qty_sekarang = $qtynya['qty'];


//     if($qty > $qty_sekarang){
//         $selisih = $qty - $qty_sekarang;
//         $kurangin = $stock_skrg - $selisih;

//         $kurangi_stock = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
//         $updatenya = mysqli_query($conn, "update keluar set qty='$qty', pemakai='$pemakai' where idkeluar='$idk'");
//             if($kurangi_stock && $updatenya){
//                 header('location:barang_keluar.php');
//                 } else {
//                     echo 'Gagal';
//                     header('location:barang_keluar.php');
//                 }

//     } else{
//         $selisih = $qty_sekarang - $qty ;
//         $kurangin = $stock_skrg + $selisih;

//         $kurangi_stock = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
//         $updatenya = mysqli_query($conn, "update keluar set qty='$qty', pemakai='$pemakai' where idkeluar='$idk'");
//             if($kurangi_stock&&$updatenya){
//                 header('location:barang_keluar.php');
//                 } else {
//                     echo 'Gagal';
//                     header('location:barang_keluar.php');
//                 }
//     }
// }

//edit barang keluar
if(isset($_POST['updatebarang_keluar'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idk'];
    $pemakai = $_POST['pemakai'];
    $qty = $_POST['qty'];

    // Ambil stok saat ini
    $lihat_stock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihat_stock);
    $stock_skrg = $stocknya['stock'];

    // Ambil qty saat ini
    $qty_sekarang = mysqli_query($conn,"select * from keluar where idkeluar ='$idk'");
    $qtynya = mysqli_fetch_array($qty_sekarang);
    $qty_sekarang = $qtynya['qty'];

    // Kembalikan stok ke kondisi semula
    $stok_awal = $stock_skrg + $qty_sekarang;

    // Hitung stok baru berdasarkan qty baru
    $stok_baru = $stok_awal - $qty;

    // Validasi agar stok tidak negatif
    if ($stok_baru < 0) {
        echo "Error: Stok tidak bisa menjadi negatif.";
        header('location:barang_keluar.php');
        exit;
    }

    // Update stok
    $kurangi_stock = mysqli_query($conn, "update stock set stock='$stok_baru' where idbarang='$idb'");
    $updatenya = mysqli_query($conn, "update keluar set qty='$qty', pemakai='$pemakai' where idkeluar='$idk'");

    // Redirect jika berhasil
    if($kurangi_stock && $updatenya){
        header('location:barang_keluar.php');
    } else {
        echo 'Gagal';
        header('location:barang_keluar.php');
    }
}

// delete data barang keluar
if(isset($_POST['hapusbarang_keluar'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $get_data_stock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($get_data_stock);
    $stok = $data['stock'];

    $selisih = $stok+$qty;

    $update = mysqli_query($conn, "update stock set stock='$selisih' where idbarang ='$idb'");
    $hapus_data = mysqli_query($conn,"delete from keluar where idkeluar='$idk'");

    if($update&&$hapus_data){
        header('location: barang_keluar.php');
    } else {
        header('location: barang_keluar.php');
    }

}

?>
