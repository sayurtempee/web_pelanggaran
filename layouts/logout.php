<?php
session_start();
$_SESSION['success'] = 'Anda berhasil logout.';
session_write_close(); // Penting agar session tersimpan sebelum redirect

header("Location: ./index.php");
exit;
