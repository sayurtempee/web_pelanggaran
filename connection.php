<?php
$host = "127.0.0.1";
$user = "root";
$pass = "mii123";
$db = "data_pelanggaran";

$conn = new mysqli($host, $user, $pass, $db);

if($conn->connect_error) {
  die("Koneksi Gagal: " . $conn->connect_errno);
}

?>