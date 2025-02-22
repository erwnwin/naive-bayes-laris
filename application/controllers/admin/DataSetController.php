<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Autoload Spout library
require_once APPPATH . 'third_party/spout/src/Spout/Autoloader/autoload.php';
// require_once(APPPATH . 'third_party/PhpSpreadsheet/vendor/autoload.php');

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

class DataSetController extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('DataSetModel');
        $this->load->model('Barang_model');
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('login'));
        }
    }


    public function index()
    {
        $data['title'] = 'Data Set : Issue Shop';

        // Set default values for current month and year
        // $bulan = $this->input->get('bulan') ?: date('m');
        // $tahun = $this->input->get('tahun') ?: date('Y');

        // Query the database to get the filtered and aggregated data
        // $this->db->select('nama_barang, nama_brand, harga_brand, ukuran, SUM(qty) as total_qty, SUM(total_harga) as total_harga');
        $this->db->select('id, nama_barang, qty, value, gross, disc, subtotal, cons, netto, label');
        $this->db->from('barang');
        // $this->db->where('MONTH(tanggal)', $bulan);
        // $this->db->where('YEAR(tanggal)', $tahun);
        // $this->db->group_by('kode_produk, nama_brand, harga_brand, ukuran');
        $query = $this->db->get();

        $data['results'] = $query->result();
        // $data['bulan'] = $bulan;
        // $data['tahun'] = $tahun;


        $this->load->view('layouts/head', $data);
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/data_set', $data);
        $this->load->view('layouts/footer', $data);
    }




    // public function upload()
    // {
    //     // Konfigurasi upload file
    //     $config['upload_path'] = './uploads/data_set';  // Pastikan folder ini ada
    //     $config['allowed_types'] = 'csv|xls|xlsx';
    //     $config['max_size'] = 2048;  // Maksimal ukuran file 2 MB
    //     $config['encrypt_name'] = TRUE;

    //     $this->upload->initialize($config);

    //     if ($this->upload->do_upload('uploaded_file')) {
    //         $fileData = $this->upload->data();
    //         $filePath = $fileData['full_path'];

    //         // Proses file berdasarkan ekstensi
    //         $this->process_file($filePath);

    //         echo json_encode([
    //             'status' => 'success',
    //             'message' => 'File berhasil diunggah dan data diimport ke database.',
    //         ]);
    //     } else {
    //         echo json_encode([
    //             'status' => 'error',
    //             'message' => $this->upload->display_errors()
    //         ]);
    //     }
    // }





    public function upload()
    {
        // Set upload configuration
        $config['upload_path'] = './uploads/data_set';  // Ensure this directory exists
        $config['allowed_types'] = 'csv|xls|xlsx';
        $config['max_size'] = 2048;  // Maximum file size in KB (2 MB)
        $config['encrypt_name'] = TRUE;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('uploaded_file')) {
            $fileData = $this->upload->data();
            $filePath = $fileData['full_path'];

            // Process the file based on its extension
            $this->process_file($filePath, $fileData['file_ext']);

            echo json_encode([
                'status' => 'success',
                'message' => 'Nice!!<br>File uploaded and data imported successfully!',
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => $this->upload->display_errors()
            ]);
        }
    }



    private function process_file($filePath, $file_ext)
    {
        // Create the reader based on file type
        $reader = ReaderEntityFactory::createReaderFromFile($filePath);
        $reader->open($filePath);

        // Tentukan batasan untuk label otomatis berdasarkan gross dan qty
        $qty_min_laris = 300;  // Batasan qty untuk laris

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $rowIndex => $row) {
                if ($rowIndex == 1) continue;  // Skip header row

                $cells = $row->getCells();

                // Ambil nilai nama_barang, qty, dan gross dari kolom yang sesuai
                $nama_barang = $cells[1]->getValue();
                $qty = $cells[2]->getValue();
                $value = $cells[3]->getValue();
                $gross = $cells[4]->getValue();
                $disc = $cells[5]->getValue();
                $subtotal = $cells[6]->getValue();
                $cons = $cells[7]->getValue();
                $netto = $cells[8]->getValue();
                $periode = $cells[9]->getValue();

                // **Perbaikan Konversi DateTime**
                if ($periode instanceof \DateTime) {
                    $periode = $periode->format('Y-m-d'); // Format ke string
                }

                // Tentukan label otomatis berdasarkan aturan
                $label = 'Tidak Laris'; // Default value
                if ($qty >= 250) {
                    $label = 'Laris';
                }

                // Data untuk disimpan ke database
                $data = [
                    'nama_barang' => $nama_barang,
                    'qty' => $qty,
                    'value' => $value,
                    'gross' => $gross,
                    'disc' => $disc,
                    'subtotal' => $subtotal,
                    'cons' => $cons,
                    'netto' => $netto,
                    'periode' => $periode,  // Sudah dikonversi ke string
                    'label' => $label
                ];

                // Simpan data ke database
                $this->db->insert('barang', $data);
            }
        }

        $reader->close();
    }




    // private function process_file($filePath, $file_ext)
    // {
    //     // Create the reader based on file type
    //     $reader = ReaderEntityFactory::createReaderFromFile($filePath);
    //     $reader->open($filePath);

    //     foreach ($reader->getSheetIterator() as $sheet) {
    //         foreach ($sheet->getRowIterator() as $rowIndex => $row) {
    //             if ($rowIndex == 1) continue;  // Skip the header row

    //             $cells = $row->getCells();
    //             $data = [
    //                 'kode_produk' => $cells[0]->getValue(),
    //                 'nama_brand' => $cells[1]->getValue(),
    //                 'harga_brand' => $cells[2]->getValue(),
    //                 'ukuran' => $cells[3]->getValue(),
    //                 'qty' => $cells[4]->getValue(),
    //                 'total_harga' => $cells[5]->getValue(),
    //                 'tanggal' => date('Y-m-d', strtotime($cells[6]->getValue()))
    //             ];
    //             $this->db->insert('tbl_penjualan_detail', $data);
    //         }
    //     }

    //     $reader->close();
    // }


    public function download_sample()
    {
        $this->load->helper('download');
        $filePath = './uploads/rekap data payment.xlsx'; // Path to your sample file

        // Create a sample file if it does not exist
        if (!file_exists($filePath)) {
            $this->create_sample_file($filePath);
        }

        force_download($filePath, NULL);
    }

    private function create_sample_file($filePath)
    {
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToFile($filePath);

        // Add header row
        $header = WriterEntityFactory::createRowFromArray(['kode_produk', 'nama_brand', 'harga_brand', 'ukuran', 'qty', 'total_harga', 'tanggal']);
        $writer->addRow($header);

        // Add sample data
        $data = [
            ['P001', 'Brand A', '100000', 'L', '10', '100000', '2024-08-20'],
            ['P002', 'Brand B', '100000', 'M', '20', '200000', '2024-08-21'],
            ['P003', 'Brand C', '100000', 'S', '15', '150000', '2024-08-22'],
            ['P004', 'Brand D', '100000', 'XL', '25', '250000', '2024-08-23']
        ];

        foreach ($data as $rowData) {
            $row = WriterEntityFactory::createRowFromArray($rowData);
            $writer->addRow($row);
        }

        $writer->close();
    }


    public function delete_selected()
    {
        $ids = $this->input->post('ids');  // Mendapatkan ID yang dikirim dari AJAX

        if (!empty($ids)) {
            // Hapus data berdasarkan ID
            $this->Barang_model->delete_multiple($ids);

            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak ditemukan']);
        }
    }

    public function delete_data()
    {
        $id = $this->input->post('id');  // Mendapatkan ID yang dikirim dari AJAX

        if ($id) {
            // Hapus data berdasarkan ID
            $this->Barang_model->delete($id);

            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak ditemukan']);
        }
    }
}

/* End of file DataSetController.php */
