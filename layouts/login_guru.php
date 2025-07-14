<?php
session_start();
include '../connection.php';

$username = trim($_POST['username']);
$password = $_POST['password'];

if (empty($username) || empty($password)) {
  $_SESSION['error'] = "Username dan password wajib diisi!";
  header("Location: index.php");
  exit;
}

$stmt = $conn->prepare("SELECT id, password FROM guru WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();
  if (password_verify($password, $user['password'])) {
    $_SESSION['guru'] = $username;
    $_SESSION['username'] = $username;
    $_SESSION['success'] = "Login berhasil.";
    header("Location: ../index.php");
    exit;
  }
}

$_SESSION['error'] = "Username atau password salah.";
header("Location: ../index.php");
exit;
