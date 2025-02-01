<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Prediction extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load model
        $this->load->model('Barang_model');
        $this->load->model('Aturan_model');
        $this->load->model('Riwayat_prediksi_model');
    }

    // public function index()
    // {
    //     // Ambil semua data barang dari database
    //     $data_barang = $this->Barang_model->get_all_barang();

    //     // Ambil aturan klasifikasi dari database
    //     $aturan = $this->Aturan_model->get_all_aturan();

    //     // Inisialisasi hasil prediksi
    //     $predictions = [];

    //     // Menghitung probabilitas prior P(Laris) dan P(Tidak Laris)
    //     $total_data = count($data_barang);
    //     $total_laris = count(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'));
    //     $total_tidak_laris = $total_data - $total_laris;

    //     $prob_Laris = $total_laris / $total_data;
    //     $prob_Tidak_Laris = $total_tidak_laris / $total_data;

    //     // Fungsi untuk menghitung mean dan standar deviasi
    //     function mean($values)
    //     {
    //         return array_sum($values) / count($values);
    //     }

    //     function std_dev($values, $mean)
    //     {
    //         $sum = 0;
    //         foreach ($values as $value) {
    //             $sum += pow($value - $mean, 2);
    //         }
    //         return sqrt($sum / count($values));
    //     }

    //     // Tentukan batasan untuk label otomatis berdasarkan gross dan qty
    //     $gross_min_laris = 100000; // Misalnya batasan gross untuk laris
    //     $qty_min_laris = 50; // Misalnya batasan qty untuk laris

    //     // Menghitung mean dan standar deviasi untuk data Laris dan Tidak Laris
    //     $gross_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'gross');
    //     $qty_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'qty');
    //     $gross_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'gross');
    //     $qty_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'qty');

    //     $mean_gross_laris = mean($gross_laris);
    //     $stddev_gross_laris = std_dev($gross_laris, $mean_gross_laris);
    //     $mean_qty_laris = mean($qty_laris);
    //     $stddev_qty_laris = std_dev($qty_laris, $mean_qty_laris);

    //     $mean_gross_tidak_laris = mean($gross_tidak_laris);
    //     $stddev_gross_tidak_laris = std_dev($gross_tidak_laris, $mean_gross_tidak_laris);
    //     $mean_qty_tidak_laris = mean($qty_tidak_laris);
    //     $stddev_qty_tidak_laris = std_dev($qty_tidak_laris, $mean_qty_tidak_laris);

    //     // Fungsi untuk menghitung distribusi normal (normal PDF)
    //     function normal_pdf($x, $mean, $stddev)
    //     {
    //         return (1 / ($stddev * sqrt(2 * M_PI))) * exp(-0.5 * pow(($x - $mean) / $stddev, 2));
    //     }

    //     // Menghitung prediksi untuk setiap barang
    //     foreach ($data_barang as $item) {
    //         $gross_input = $item['gross'];
    //         $qty_input = $item['qty'];

    //         // Tentukan label otomatis berdasarkan aturan
    //         if ($gross_input >= $gross_min_laris && $qty_input >= $qty_min_laris) {
    //             $item['label'] = 'Laris';
    //         } else {
    //             $item['label'] = 'Tidak Laris';
    //         }

    //         // Menghitung P(Gross | Laris) dan P(Qty | Laris)
    //         $prob_gross_laris = normal_pdf($gross_input, $mean_gross_laris, $stddev_gross_laris);
    //         $prob_qty_laris = normal_pdf($qty_input, $mean_qty_laris, $stddev_qty_laris);

    //         // Menghitung P(Gross | Tidak Laris) dan P(Qty | Tidak Laris)
    //         $prob_gross_tidak_laris = normal_pdf($gross_input, $mean_gross_tidak_laris, $stddev_gross_tidak_laris);
    //         $prob_qty_tidak_laris = normal_pdf($qty_input, $mean_qty_tidak_laris, $stddev_qty_tidak_laris);

    //         // Menghitung P(Laris | X) dan P(Tidak Laris | X)
    //         $prob_laris_given_x = $prob_Laris * $prob_gross_laris * $prob_qty_laris;
    //         $prob_tidak_laris_given_x = $prob_Tidak_Laris * $prob_gross_tidak_laris * $prob_qty_tidak_laris;

    //         // Prediksi berdasarkan perbandingan probabilitas
    //         $prediction = $prob_laris_given_x > $prob_tidak_laris_given_x ? 'Laris' : 'Tidak Laris';

    //         // Simpan hasil prediksi beserta nilai probabilitas
    //         $predictions[] = [
    //             'nama' => $item['nama_barang'],
    //             'gross' => $gross_input,
    //             'qty' => $qty_input,
    //             'label' => $item['label'], // Menambahkan label otomatis
    //             'prob_laris_given_x' => $prob_laris_given_x,
    //             'prob_tidak_laris_given_x' => $prob_tidak_laris_given_x,
    //             'prediksi' => $prediction
    //         ];
    //     }

    //     // Kirim data statistik dan prediksi ke view untuk ditampilkan
    //     $data['predictions'] = $predictions;
    //     $data['stats'] = [
    //         'mean_gross_laris' => $mean_gross_laris,
    //         'stddev_gross_laris' => $stddev_gross_laris,
    //         'mean_qty_laris' => $mean_qty_laris,
    //         'stddev_qty_laris' => $stddev_qty_laris,
    //         'mean_gross_tidak_laris' => $mean_gross_tidak_laris,
    //         'stddev_gross_tidak_laris' => $stddev_gross_tidak_laris,
    //         'mean_qty_tidak_laris' => $mean_qty_tidak_laris,
    //         'stddev_qty_tidak_laris' => $stddev_qty_tidak_laris
    //     ];

    //     $this->load->view('prediction_view', $data);
    // }


    public function proses_prediksi()
    {
        // Ambil tanggal prediksi dari form
        // $tanggal_prediksi = $this->input->post('tanggal_prediksi');

        // Ambil semua data barang dari database
        $data_barang = $this->Barang_model->get_all_barang();

        // Ambil aturan klasifikasi dari database
        $aturan = $this->Aturan_model->get_all_aturan();

        // Inisialisasi hasil prediksi
        $predictions = [];

        // Menghitung probabilitas prior P(Laris) dan P(Tidak Laris)
        $total_data = count($data_barang);
        $total_laris = count(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'));
        $total_tidak_laris = $total_data - $total_laris;

        $prob_Laris = $total_laris / $total_data;
        $prob_Tidak_Laris = $total_tidak_laris / $total_data;

        // Fungsi untuk menghitung mean dan standar deviasi
        function mean($values)
        {
            return array_sum($values) / count($values);
        }

        function std_dev($values, $mean)
        {
            $sum = 0;
            foreach ($values as $value) {
                $sum += pow($value - $mean, 2);
            }
            return sqrt($sum / count($values));
        }

        // Tentukan batasan untuk label otomatis berdasarkan gross dan qty
        // $gross_min_laris = 100000; // Misalnya batasan gross untuk laris
        // $qty_min_laris = 50; // Misalnya batasan qty untuk laris

        // Menghitung mean dan standar deviasi untuk data Laris dan Tidak Laris
        $gross_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'gross');
        $qty_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'qty');
        $gross_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'gross');
        $qty_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'qty');

        $mean_gross_laris = mean($gross_laris);
        $stddev_gross_laris = std_dev($gross_laris, $mean_gross_laris);
        $mean_qty_laris = mean($qty_laris);
        $stddev_qty_laris = std_dev($qty_laris, $mean_qty_laris);

        $mean_gross_tidak_laris = mean($gross_tidak_laris);
        $stddev_gross_tidak_laris = std_dev($gross_tidak_laris, $mean_gross_tidak_laris);
        $mean_qty_tidak_laris = mean($qty_tidak_laris);
        $stddev_qty_tidak_laris = std_dev($qty_tidak_laris, $mean_qty_tidak_laris);

        // Fungsi untuk menghitung distribusi normal (normal PDF)
        function normal_pdf($x, $mean, $stddev)
        {
            return (1 / ($stddev * sqrt(2 * M_PI))) * exp(-0.5 * pow(($x - $mean) / $stddev, 2));
        }

        // Menghitung prediksi untuk setiap barang
        foreach ($data_barang as $item) {
            $gross_input = $item['gross'];
            $qty_input = $item['qty'];

            // Tentukan label otomatis berdasarkan aturan
            // if ($gross_input >= $gross_min_laris && $qty_input >= $qty_min_laris) {
            //     $item['label'] = 'Laris';
            // } else {
            //     $item['label'] = 'Tidak Laris';
            // }

            // Menghitung P(Gross | Laris) dan P(Qty | Laris)
            $prob_gross_laris = normal_pdf($gross_input, $mean_gross_laris, $stddev_gross_laris);
            $prob_qty_laris = normal_pdf($qty_input, $mean_qty_laris, $stddev_qty_laris);

            // Menghitung P(Gross | Tidak Laris) dan P(Qty | Tidak Laris)
            $prob_gross_tidak_laris = normal_pdf($gross_input, $mean_gross_tidak_laris, $stddev_gross_tidak_laris);
            $prob_qty_tidak_laris = normal_pdf($qty_input, $mean_qty_tidak_laris, $stddev_qty_tidak_laris);

            // Menghitung P(Laris | X) dan P(Tidak Laris | X)
            $prob_laris_given_x = $prob_Laris * $prob_gross_laris * $prob_qty_laris;
            $prob_tidak_laris_given_x = $prob_Tidak_Laris * $prob_gross_tidak_laris * $prob_qty_tidak_laris;

            // Prediksi berdasarkan perbandingan probabilitas
            // $prediction = $prob_laris_given_x > $prob_tidak_laris_given_x ? 'Laris' : 'Tidak Laris';
            // Prediksi berdasarkan perbandingan probabilitas
            $prediction = $prob_laris_given_x > $prob_tidak_laris_given_x ? 'Laris' : 'Tidak Laris';


            // Simpan hasil prediksi beserta nilai probabilitas ke dalam array
            $predictions[] = [
                'nama' => $item['nama_barang'],
                'gross' => $gross_input,
                'qty' => $qty_input,
                'label' => $item['label'],
                'prob_laris_given_x' => $prob_laris_given_x,
                'prob_tidak_laris_given_x' => $prob_tidak_laris_given_x,
                'prediksi' => $prediction
            ];

            // Simpan hasil prediksi ke dalam tabel riwayat_prediksi
            // $this->Riwayat_prediksi_model->save_riwayat_prediksi([
            //     'nama_barang' => $item['nama_barang'],
            //     'gross' => $gross_input,
            //     'qty' => $qty_input,
            //     'prediksi' => $prediction,
            //     'tanggal_prediksi' => $tanggal_prediksi
            // ]);
        }

        // Kirim data hasil prediksi ke view
        $data['predictions'] = $predictions;
        $data['stats'] = [
            'prob_Laris' => $prob_Laris,
            'prob_Tidak_Laris' => $prob_Tidak_Laris,
            'mean_gross_laris' => $mean_gross_laris,
            'stddev_gross_laris' => $stddev_gross_laris,
            'mean_qty_laris' => $mean_qty_laris,
            'stddev_qty_laris' => $stddev_qty_laris,
            'mean_gross_tidak_laris' => $mean_gross_tidak_laris,
            'stddev_gross_tidak_laris' => $stddev_gross_tidak_laris,
            'mean_qty_tidak_laris' => $mean_qty_tidak_laris,
            'stddev_qty_tidak_laris' => $stddev_qty_tidak_laris
        ];

        // Load the views
        $this->load->view('layouts/head', $data);
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/prediction_view', $data);
        $this->load->view('layouts/footer', $data);
    }
}
