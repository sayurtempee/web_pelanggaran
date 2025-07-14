<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama       = $_POST['nama'] ?? '';
    $kelas      = $_POST['kelas'] ?? '';
    $jurusan    = $_POST['jurusan'] ?? '';
    $tanggal    = $_POST['tanggal'] ?? '';
    $pelanggaranArray = $_POST['pelanggaran'] ?? [];
    $keterangan = empty($_POST['keterangan']) ? '-' : $_POST['keterangan'];

    // Validasi sederhana
    if (empty($nama) || empty($kelas) || empty($tanggal)) {
        die("Semua field wajib diisi.");
    }

    // Gabungkan pelanggaran jadi string: misalnya "merokok, bolos, telat"
    $pelanggaran = implode(', ', $pelanggaranArray);

    // Simpan ke DB
    $stmt = $conn->prepare("INSERT INTO pelanggaran (nama, kelas, jurusan, tanggal, pelanggaran, keterangan) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nama, $kelas, $jurusan, $tanggal, $pelanggaran, $keterangan);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Data berhasil disimpan.";
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal menyimpan data: " . $stmt->error;
    }
} else {
    echo "Invalid request method.";
}
