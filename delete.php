<?php
session_start(); // WAJIB agar session bisa digunakan
include 'connection.php';

// Jalankan query hapus semua
if ($conn->query("DELETE FROM pelanggaran")) {
    $_SESSION['success'] = "Semua data berhasil dihapus.";
} else {
    $_SESSION['error'] = "Gagal menghapus data: " . $conn->error;
}

header("Location: index.php");
exit;
?>
