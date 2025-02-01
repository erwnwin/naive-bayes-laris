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
        $this->db->select('id, nama_barang, gross, qty, label');
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


    private function process_fileku($filePath, $file_ext)
    {
        // Create the reader based on file type
        $reader = ReaderEntityFactory::createReaderFromFile($filePath);
        $reader->open($filePath);

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $rowIndex => $row) {
                if ($rowIndex == 1) continue;  // Skip header row

                $cells = $row->getCells();

                // Ambil nilai tanggal (kolom ke-7)
                $date_value = $cells[6]->getValue();

                $tanggal = null; // Default value for date

                // Cek jika $date_value adalah objek DateTime
                if ($date_value instanceof DateTime) {
                    // Jika objek DateTime, format menjadi Y-m-d
                    $tanggal = $date_value->format('Y-m-d');
                } else {
                    // Jika bukan objek DateTime, anggap sebagai string
                    // Pastikan tanggal dalam format d/m/Y
                    $date_value = (string)$date_value;

                    // Tangani format tanggal
                    if (is_numeric($date_value)) {
                        // Jika tanggal berupa serial number (Excel format)
                        $unix_date = ($date_value - 25569) * 86400; // Convert Excel serial date to Unix timestamp
                        $tanggal = date('Y-m-d', $unix_date);
                    } else {
                        // Jika tanggal dalam format d/m/Y (string)
                        $tanggal_obj = DateTime::createFromFormat('d/m/Y', $date_value);
                        $tanggal = $tanggal_obj ? $tanggal_obj->format('Y-m-d') : null;
                    }
                }

                // Jika format tanggal tidak valid, log error dan skip row ini
                if (!$tanggal) {
                    log_message('error', "Invalid date format at row $rowIndex: " . json_encode($date_value));
                    continue;
                }

                // Data untuk disimpan ke database
                $data = [
                    'kode_produk' => $cells[0]->getValue(),
                    'nama_brand' => $cells[1]->getValue(),
                    'harga_brand' => $cells[2]->getValue(),
                    'ukuran' => $cells[3]->getValue(),
                    'qty' => $cells[4]->getValue(),
                    'total_harga' => $cells[5]->getValue(),
                    'tanggal' => $tanggal
                ];

                // Simpan data ke database
                $this->db->insert('tbl_penjualan_detail', $data);
            }
        }

        $reader->close();
    }



    private function process_file($filePath, $file_ext)
    {
        // Create the reader based on file type
        $reader = ReaderEntityFactory::createReaderFromFile($filePath);
        $reader->open($filePath);

        // Tentukan batasan untuk label otomatis berdasarkan gross dan qty
        $gross_min_laris = 15000000; // Batasan gross untuk laris
        $qty_min_laris = 70;  // Batasan qty untuk laris

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $rowIndex => $row) {
                if ($rowIndex == 1) continue;  // Skip header row

                $cells = $row->getCells();

                // Ambil nilai nama_barang, qty, dan gross dari kolom yang sesuai
                $nama_barang = $cells[1]->getValue();  // Nama Barang ada di CELL B2 (kolom 1)
                $qty = $cells[2]->getValue();  // Qty ada di CELL C2 (kolom 2)
                $gross = $cells[3]->getValue();  // Gross ada di CELL D2 (kolom 3)

                // Tentukan label otomatis berdasarkan aturan
                $label = 'Tidak Laris'; // Default value
                if ($gross >= $gross_min_laris && $qty >= $qty_min_laris) {
                    $label = 'Laris';
                }

                // Data untuk disimpan ke database
                $data = [
                    'nama_barang' => $nama_barang,  // Nama Barang
                    'gross' => $gross,              // Gross
                    'qty' => $qty,                  // Qty
                    'label' => $label               // Label yang sudah ditentukan
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
