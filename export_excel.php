<?php
require 'function.php';
require 'cek.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

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

// === Sheet 1: Stock Barang ===
$stockSheet = $spreadsheet->getActiveSheet();
$stockSheet->setTitle('Stock Barang');
$stockSheet->setCellValue('A1', 'Data Stock Barang');
$stockSheet->mergeCells('A1:I1');
$stockSheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
$stockSheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

$stockSheet->fromArray(['No.', 'Kode Barang', 'Nama Barang', 'Merk', 'Asal Usul', 'Jumlah', 'Harga', 'Keterangan', 'Ruangan'], NULL, 'A3');
applyHeaderStyle($stockSheet, 'A3:I3');
$stockSheet->freezePane('A4');

$stockData = mysqli_query($conn, "SELECT * FROM stock");
$row = 4; $no = 1;
while ($data = mysqli_fetch_array($stockData)) {
    $stockSheet->fromArray([
        $no++, $data['kodebarang'], $data['namabarang'], $data['merk'],
        $data['asal'], $data['stock'], $data['harga'], $data['keterangan'], $data['ruangan']
    ], NULL, 'A'.$row);

    $stockSheet->getStyle("A$row:I$row")->applyFromArray([
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    ]);

    // Format harga
    $stockSheet->getStyle("G$row")
        ->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

    // Zebra stripe (optional)
    if ($row % 2 == 0) {
        $stockSheet->getStyle("A$row:I$row")->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F2F2F2']
            ]
        ]);
    }
    $row++;
}
foreach (range('A', 'I') as $col) {
    $stockSheet->getColumnDimension($col)->setAutoSize(true);
}
$stockSheet->getHeaderFooter()->setOddFooter('&LStock Barang&RPage &P of &N');

// === Sheet 2: Log Masuk ===
$masukSheet = $spreadsheet->createSheet();
$masukSheet->setTitle('Log Masuk');
$masukSheet->setCellValue('A1', 'Log Barang Masuk');
$masukSheet->mergeCells('A1:E1');
$masukSheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
$masukSheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

$masukSheet->fromArray(['No.', 'Tanggal', 'Nama Barang', 'Jumlah', 'Keterangan'], NULL, 'A3');
applyHeaderStyle($masukSheet, 'A3:E3');
$masukSheet->freezePane('A4');

$masukData = mysqli_query($conn, "SELECT m.*, s.namabarang FROM masuk m JOIN stock s ON m.idbarang = s.idbarang");
$row = 4; $no = 1;
while ($data = mysqli_fetch_array($masukData)) {
    $masukSheet->fromArray([$no++, $data['tanggal'], $data['namabarang'], $data['qty'], $data['keterangan']], NULL, 'A'.$row);
    $masukSheet->getStyle("A$row:E$row")->applyFromArray([
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    ]);
    $row++;
}
foreach (range('A', 'E') as $col) {
    $masukSheet->getColumnDimension($col)->setAutoSize(true);
}
$masukSheet->getHeaderFooter()->setOddFooter('&LLog Masuk&RPage &P of &N');

// === Sheet 3: Log Keluar ===
$keluarSheet = $spreadsheet->createSheet();
$keluarSheet->setTitle('Log Keluar');
$keluarSheet->setCellValue('A1', 'Log Barang Keluar');
$keluarSheet->mergeCells('A1:E1');
$keluarSheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
$keluarSheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

$keluarSheet->fromArray(['No.', 'Tanggal', 'Nama Barang', 'Jumlah', 'Penerima'], NULL, 'A3');
applyHeaderStyle($keluarSheet, 'A3:E3');
$keluarSheet->freezePane('A4');

$keluarData = mysqli_query($conn, "SELECT k.*, s.namabarang FROM keluar k JOIN stock s ON k.idbarang = s.idbarang");
$row = 4; $no = 1;
while ($data = mysqli_fetch_array($keluarData)) {
    $keluarSheet->fromArray([$no++, $data['tanggal'], $data['namabarang'], $data['qty'], $data['penerima']], NULL, 'A'.$row);
    $keluarSheet->getStyle("A$row:E$row")->applyFromArray([
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    ]);
    $row++;
}
foreach (range('A', 'E') as $col) {
    $keluarSheet->getColumnDimension($col)->setAutoSize(true);
}
$keluarSheet->getHeaderFooter()->setOddFooter('&LLog Keluar&RPage &P of &N');

// === Output Excel ===
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Data_Inventory.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
