<?php
require 'vendor/autoload.php';
include 'koneksi.php';
// koneksi php dan mysql
#$koneksi = mysqli_connect("localhost","root","","db_arke");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// sheet pertama
$sheet->setTitle('Sheet 1');
$sheet->setCellValue('A1', 'Nama Peserta');
$sheet->setCellValue('B1', 'Alamat');
$sheet->setCellValue('C1', 'Jenis Kelamin');
$sheet->setCellValue('D1', 'Agama');
$sheet->setCellValue('E1', 'Sekolah Asal');


// membaca data dari mysql
$query="SELECT * FROM pendaftaran";
$anggota = mysqli_query($koneksi,$query);
$row = 2;
while($record = mysqli_fetch_array($anggota))
{
    $sheet->setCellValue('A'.$row, $record['nama_peserta']);
    $sheet->setCellValue('B'.$row, $record['alamat']);
    $sheet->setCellValue('C'.$row, $record['jenis_kelamin']);
    $sheet->setCellValue('D'.$row, $record['agama']);
    $sheet->setCellValue('E'.$row, $record['sekolah_asal']);
    $row++;
}

$writer = new Xlsx($spreadsheet);
$writer->save('list pendaftar.xlsx');
if ($writer)
    {
    echo "<script> alert('Data berhasil didownload'); window.location='index.php' </script>";
}
?>