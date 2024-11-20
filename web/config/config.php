<?php 

$server = "localhost";
$username = "root";
$password = "";
$db = "cekinout";
// urutan pemanggilan variabelnya sama
$koneksi = mysqli_connect($server, $username, $password, $db);

// cek koneksi, gagal atau tidak
if (mysqli_connect_errno()){
    echo "Koneksi gagal: " . mysqli_connect_error();
}