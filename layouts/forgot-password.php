<?php
session_start();
include '../connection.php'; // pastikan file ini menghubungkan ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirmation = $_POST['password_confirmation'] ?? '';

    // Validasi
    if (empty($username) || empty($password) || empty($password_confirmation)) {
        $_SESSION['error'] = 'Semua field wajib diisi.';
        header('Location: ../reset_password.php');
        exit;
    }

    if ($password !== $password_confirmation) {
        $_SESSION['error'] = 'Password tidak cocok.';
        header('Location: ../reset_password.php');
        exit;
    }

    // Hash password baru
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah username ada
    $stmt = $conn->prepare("SELECT * FROM guru WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error'] = 'Username tidak ditemukan.';
        header('Location: ../index.php');
        exit;
    }

    // Update password
    $update = $conn->prepare("UPDATE guru SET password = ? WHERE username = ?");
    $update->bind_param("ss", $hashedPassword, $username);

    if ($update->execute()) {
        $_SESSION['success'] = 'Password berhasil diperbarui.';
    } else {
        $_SESSION['error'] = 'Gagal memperbarui password.';
    }

    header('Location: ../index.php');
    exit;
}
?>
