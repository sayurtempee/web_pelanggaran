<?php
require 'vendor/autoload.php';
require_once 'connection.php';

use Dompdf\Dompdf;

$tahun = date('Y');
$html = '<h2 style="text-align:center;">Rekap Pelanggaran Siswa Tahun ' . $tahun . '</h2>';

$query = $conn->query("SELECT * FROM pelanggaran 
    WHERE YEAR(tanggal) = '$tahun'
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
  $html .= "<br><h4 style='margin-top:20px;'>Kelas: <b>" . strtoupper(str_replace("_", " ", $kelas)) . "</b> | Jurusan: <b>" . strtoupper($jurusan) . "</b></h4>";

  $html .= "<table border='1' cellspacing='0' cellpadding='6' width='100%'>
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

  $html .= "</table><br style='page-break-after:always;'>";
}

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("rekap-pelanggaran-tahun-{$tahun}.pdf", ["Attachment" => true]);
?>
