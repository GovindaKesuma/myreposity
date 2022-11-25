<?php
include('koneksi.php');
require_once("dompdf/autoload.inc.php");
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$query = mysqli_query($koneksi,"select * from pendaftaran");
$html = '<center><h3>Daftar Nama Peserta</h3></center><hr/><br/>';
$html .= '<table border="1" width="100%">
 <tr>
    <th>#</th>
	<th>Nama Peserta</th>
	<th>Alamat</th>
	<th>Jenis Kelamin</th>
    <th>Agama</th>
    <th>Sekolah Asal</th>
 </tr>';
$no = 1;
while($row = mysqli_fetch_array($query))
{
    $html .= "<tr>
        <td>".$no."</td>
        <td>".$row['nama_peserta']."</td>
        <td>".$row['alamat']."</td>
        <td>".$row['jenis_kelamin']."</td>
        <td>".$row['agama']."</td>
        <td>".$row['sekolah_asal']."</td>
    </tr>";
    $no++;
}
$html .= "</html>";
$dompdf->loadHtml($html);
// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'potrait');
// Rendering dari HTML Ke PDF
$dompdf->render();
// Melakukan output file Pdf
$dompdf->stream('pendaftar.pdf');
?>