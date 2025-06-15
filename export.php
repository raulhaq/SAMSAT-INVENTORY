<?php
require 'function.php';
require 'cek.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

function applyHeaderStyle($sheet, $range) {
    $style = [
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'D9E1F2']
        ]
    ];
    $sheet->getStyle($range)->applyFromArray($style);
}

$spreadsheet = new Spreadsheet();

// ===========================
// Sheet 1 - Stock Barang
// ===========================
$stockSheet = $spreadsheet->getActiveSheet();
$stockSheet->setTitle('Stock Barang');

$stockSheet->fromArray(['No.','Kode Barang', 'Nama Barang', 'Merk','Asal Usul', 'Jumlah', 'Harga', 'Keterangan', 'Ruangan'], NULL, 'A1');
applyHeaderStyle($stockSheet, 'A1:I1');

$stockData = mysqli_query($conn, "SELECT * FROM stock");
$row = 2; $no = 1;
while ($data = mysqli_fetch_array($stockData)) {
    $stockSheet->fromArray([$no++,$data['kodebarang'], $data['namabarang'], $data['merk'],$data['asal'], $data['stock'],$data['harga'], $data['keterangan'], $data['ruangan']], NULL, 'A'.$row);
    $stockSheet->getStyle("A$row:I$row")->applyFromArray([
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    ]);
    $row++;
}
foreach (range('A', 'I') as $col) {
    $stockSheet->getColumnDimension($col)->setAutoSize(true);
}

// ===========================
// Sheet 2 - Barang Masuk
// ===========================
$masukSheet = $spreadsheet->createSheet();
$masukSheet->setTitle('Log Masuk');
$masukSheet->fromArray(['No.', 'Tanggal', 'Nama Barang','Merk Barang', 'Jumlah', 'Penerima Barang'], NULL, 'A1');
applyHeaderStyle($masukSheet, 'A1:F1');

$masukData = mysqli_query($conn, "SELECT m.*, s.namabarang,s.merk FROM masuk m JOIN stock s ON m.idbarang = s.idbarang");
$row = 2; $no = 1;
while ($data = mysqli_fetch_array($masukData)) {
    $masukSheet->fromArray([$no++, $data['tanggal'], $data['namabarang'],$data['merk'], $data['qty'], $data['penerima']], NULL, 'A'.$row);
    $masukSheet->getStyle("A$row:F$row")->applyFromArray([
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    ]);
    $row++;
}
foreach (range('A', 'F') as $col) {
    $masukSheet->getColumnDimension($col)->setAutoSize(true);
}

// ===========================
// Sheet 3 - Barang Keluar
// ===========================
$keluarSheet = $spreadsheet->createSheet();
$keluarSheet->setTitle('Log Keluar');
$keluarSheet->fromArray(['No.', 'Tanggal', 'Nama Barang','Merk Barang', 'Jumlah', 'Pemakai'], NULL, 'A1');
applyHeaderStyle($keluarSheet, 'A1:F1');

$keluarData = mysqli_query($conn, "SELECT k.*, s.namabarang, s.merk FROM keluar k JOIN stock s ON k.idbarang = s.idbarang");
$row = 2; $no = 1;
while ($data = mysqli_fetch_array($keluarData)) {
    $keluarSheet->fromArray([$no++, $data['tanggal'], $data['namabarang'], $data['merk'], $data['qty'], $data['pemakai']], NULL, 'A'.$row);
    $keluarSheet->getStyle("A$row:F$row")->applyFromArray([
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    ]);
    $row++;
}
foreach (range('A', 'F') as $col) {
    $keluarSheet->getColumnDimension($col)->setAutoSize(true);
}

// ===========================
// Output Excel
// ===========================
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Data_Inventaris.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
