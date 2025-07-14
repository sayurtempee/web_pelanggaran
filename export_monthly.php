<?php
require 'vendor/autoload.php';
require_once 'connection.php';

use Dompdf\Dompdf;

// Array nama bulan dalam Bahasa Indonesia
$namaBulan = [
  1 => 'Januari',
  2 => 'Februari',
  3 => 'Maret',
  4 => 'April',
  5 => 'Mei',
  6 => 'Juni',
  7 => 'Juli',
  8 => 'Agustus',
  9 => 'September',
  10 => 'Oktober',
  11 => 'November',
  12 => 'Desember'
];

// Ambil bulan & tahun saat ini
$bulan = date('n'); // Tanpa leading zero
$tahun = date('Y');

$judul = "Rekap Bulan " . $namaBulan[$bulan] . " $tahun";

$html = "<h2 style='text-align:center;'>$judul</h2>
<table border='1' cellspacing='0' cellpadding='6' width='100%'>
<tr style='background:#eee;'>
  <th>No</th>
  <th>Nama</th>
  <th>Kelas</th>
  <th>Jurusan</th>
  <th>Tanggal</th>
  <th>Keterangan</th>
</tr>";

$data = $conn->query("SELECT * FROM pelanggaran WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' ORDER BY tanggal DESC");
$no = 1;
while ($row = $data->fetch_assoc()) {
  $html .= "<tr>
    <td>{$no}</td>
    <td>{$row['nama']}</td>
    <td>" . strtoupper($row['kelas']) . "</td>
    <td>" . strtoupper($row['jurusan']) . "</td>
    <td>" . date('d-m-Y', strtotime($row['tanggal'])) . "</td>
    <td>{$row['keterangan']}</td>
  </tr>";
  $no++;
}

$html .= '</table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("rekap-bulanan-{$bulan}-{$tahun}.pdf", ["Attachment" => true]);
?>
