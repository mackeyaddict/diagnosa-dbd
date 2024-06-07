<?php
// Menentukan nama server, nama user, password, dan nama database
$server = "localhost";
$user = "root";
$password = "";
$database = "dbd";

// Membuat koneksi dengan database MySQL
$koneksi = mysqli_connect($server, $user, $password, $database);

// Memeriksa apakah koneksi berhasil atau gagal
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
