<?php
require 'vendor/autoload.php';
require_once 'connection.php';

use Dompdf\Dompdf;

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

$bulan = date('n');
$tahun = date('Y');

$judul = "Rekap Bulan " . $namaBulan[$bulan] . " $tahun";
$html = "<h2 style='text-align:center;'>$judul</h2>";

$query = $conn->query("SELECT * FROM pelanggaran 
  WHERE MONTH(tanggal) = '$bulan' 
    AND YEAR(tanggal) = '$tahun' 
  ORDER BY kelas, jurusan, tanggal DESC");

// Kelompokkan data berdasarkan kelas + jurusan
$kelompok = [];
while ($row = $query->fetch_assoc()) {
  $key = "{$row['kelas']}|{$row['jurusan']}";
  $kelompok[$key][] = $row;
}

// Buat tabel per kelompok
foreach ($kelompok as $key => $rows) {
  [$kelas, $jurusan] = explode('|', $key);
  $html .= "<br><h4>Kelas: " . strtoupper(str_replace("_", " ", $kelas)) . " | Jurusan: " . strtoupper($jurusan) . "</h4>";
  $html .= "<table border='1' cellspacing='0' cellpadding='5' width='100%'>
    <tr style='background:#eee;'>
      <th>No</th>
      <th>Nama</th>
      <th>Tanggal</th>
      <th>Pelanggaran</th>
      <th>Keterangan</th>
    </tr>";

  $no = 1;
  foreach ($rows as $row) {
    $html .= "<tr>
          <td>{$no}</td>
          <td>{$row['nama']}</td>
          <td>" . date('d-m-Y', strtotime($row['tanggal'])) . "</td>
          <td>" . strtoupper($row['pelanggaran']) . "</td>
          <td>{$row['keterangan']}</td>
        </tr>";
    $no++;
  }
  $html .= "</table><br>";
}

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("rekap-struktur-bulanan-{$bulan}-{$tahun}.pdf", ["Attachment" => true]);
?>