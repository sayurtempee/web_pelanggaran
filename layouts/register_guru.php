<?php
session_start();
include '../connection.php';

$username = trim($_POST['username']);
$password = $_POST['password'];
$confirm  = $_POST['password_confirmation'];

if (empty($username) || empty($password) || empty($confirm)) {
  $_SESSION['error'] = "Semua field wajib diisi!";
  header("Location: ../index.php");
  exit;
}

if ($password !== $confirm) {
  $_SESSION['error'] = "Konfirmasi password tidak cocok!";
  header("Location: ../index.php");
  exit;
}

$stmt = $conn->prepare("SELECT id FROM guru WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
  $_SESSION['error'] = "Username sudah digunakan.";
  header("Location: ../index.php");
  exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
$insert = $conn->prepare("INSERT INTO guru (username, password) VALUES (?, ?)");
$insert->bind_param("ss", $username, $hashed);

if ($insert->execute()) {
  $_SESSION['success'] = "Berhasil mendaftar! Silakan login.";
} else {
  $_SESSION['error'] = "Gagal menyimpan data!";
}

header("Location: ../index.php");
exit;
?>
