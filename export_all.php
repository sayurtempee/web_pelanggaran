<?php
require 'vendor/autoload.php';
require_once 'connection.php';

use Dompdf\Dompdf;

$tahun = date('Y');
$html = '<h2 style="text-align:center;">Data Pelanggaran Siswa ' . $tahun . '</h2> <table border="1" cellspacing="0" cellpadding="6" width="100%">
<tr>
  <th>No</th>
  <th>Nama</th>
  <th>Kelas</th>
  <th>Jurusan</th>
  <th>Tanggal</th>
  <th>Keterangan</th>
</tr>';

$data = $conn->query("SELECT * FROM pelanggaran ORDER BY tanggal DESC");
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
$dompdf->stream("data-siswa-pelanggaran.pdf", ["Attachment" => true]);
?>
