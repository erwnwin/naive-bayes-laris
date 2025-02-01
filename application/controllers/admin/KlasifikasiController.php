<?php

// Autoload Spout library
require_once APPPATH . 'third_party/spout/src/Spout/Autoloader/autoload.php';
// require_once(APPPATH . 'third_party/PhpSpreadsheet/vendor/autoload.php');

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

defined('BASEPATH') or exit('No direct script access allowed');

class KlasifikasiController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('KemungkinanModel');
        $this->load->model('Barang_model');
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('login'));
        }
    }
    public function index()
    {
        $data['title'] = 'Klasifikasi : Issue Shop';

        $results = $this->Barang_model->get_barang(); // Mengambil semua data barang

        // Kirim data ke view untuk ditampilkan
        $data['results'] = $results;
        // $bulan = $this->input->get('bulan');
        // $tahun = $this->input->get('tahun');

        // // Kirimkan parameter ke model
        // $data['penjualan'] = $this->KemungkinanModel->getPenjualanWithClassification($bulan, $tahun);
        // $data['penjualan'] = $this->KemungkinanModel->getPenjualanWithClassification();

        $this->load->view('layouts/head', $data);
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/klasifikasi', $data);
        $this->load->view('layouts/footer', $data);
    }



    public function filter_by_date_ajax()
    {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        // Ambil data berdasarkan bulan dan tahun
        $klasifikasi = $this->KemungkinanModel->getPenjualanWithClassification($bulan, $tahun);

        // Kirimkan data sebagai JSON
        echo json_encode(['status' => true, 'data' => $klasifikasi]);
    }



    // Function to export filtered data to Excel
    public function export_to_excel()
    {
        // Get the selected bulan and tahun from GET parameters
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');

        // Get the filtered data based on selected bulan and tahun
        $data['penjualan'] = $this->get_filtered_data($bulan, $tahun);

        // Create Spout writer
        $writer = WriterEntityFactory::createXLSXWriter();
        $filename = 'data_penjualan.xlsx'; // File name for the download

        // Set headers for Excel file download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Open writer to output Excel to the browser
        $writer->openToBrowser($filename); // Pass the filename as an argument here

        // Create and write header row
        $headerRow = [
            WriterEntityFactory::createCell('No'),
            WriterEntityFactory::createCell('Kategori Barang'),
            WriterEntityFactory::createCell('Brand'),
            WriterEntityFactory::createCell('Jumlah Terjual'),
            WriterEntityFactory::createCell('Nilai Penjualan'),
            WriterEntityFactory::createCell('Tanggal Penjualan'),
            WriterEntityFactory::createCell('Status Popularitas')
        ];

        // Wrap the header row in a Row entity
        $headerRowEntity = WriterEntityFactory::createRow($headerRow);
        $writer->addRow($headerRowEntity);

        // Write data rows
        $no = 1;
        foreach ($data['penjualan'] as $item) {
            $row = [
                WriterEntityFactory::createCell($no++),
                WriterEntityFactory::createCell($item['kode_produk']),
                WriterEntityFactory::createCell($item['nama_brand']),
                WriterEntityFactory::createCell($item['qty']),
                WriterEntityFactory::createCell('Rp ' . number_format($item['total_harga'], 0, ',', '.')),
                WriterEntityFactory::createCell(date('d-m-Y', strtotime($item['tanggal']))),
                WriterEntityFactory::createCell($item['status_popularitas'])
            ];

            // Wrap the row data in a Row entity
            $rowEntity = WriterEntityFactory::createRow($row);
            $writer->addRow($rowEntity);
        }

        // Close the writer and send the Excel file to the browser
        $writer->close();
    }

    // Function to retrieve filtered data based on bulan and tahun
    private function get_filtered_data($bulan, $tahun)
    {
        return $this->KemungkinanModel->getPenjualanWithClassification($bulan, $tahun);
    }
}

/* End of file KlasifikasiController.php */
