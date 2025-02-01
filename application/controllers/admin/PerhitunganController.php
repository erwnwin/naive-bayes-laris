<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PerhitunganController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_penjualan');
        $this->load->model('PredictModel');
        $this->load->model('PrediksiModel');
        $this->load->model('NaiveBayesModel');
        $this->load->model('Barang_model');
        $this->load->model('Aturan_model');
        $this->load->model('NaiveBayesDetailModel');
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('login'));
        }
    }


    public function index()
    {
        $data_barang = $this->Barang_model->get_all_barang();

        // Pengecekan apakah data_barang kosong
        if (empty($data_barang)) {
            // Mengarahkan ke halaman 'no_data' jika data barang kosong
            $data['title'] = 'Perhitungan : Issue Shop';

            $this->load->view('layouts/head', $data);
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar', $data);
            $this->load->view('admin/no_data', $data);
            $this->load->view('layouts/footer', $data);
        } else {
            # code...


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

            $TP = $FP = $TN = $FN = 0;

            // Menghitung prediksi untuk setiap barang
            foreach ($data_barang as $item) {
                $gross_input = $item['gross'];
                $qty_input = $item['qty'];


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
                $prediction = $prob_laris_given_x > $prob_tidak_laris_given_x ? 'Laris' : 'Tidak Laris';

                $actual = $item['label'];

                if ($prediction == 'Laris' && $actual == 'Laris') $TP++;
                if ($prediction == 'Laris' && $actual == 'Tidak Laris') $FP++;
                if ($prediction == 'Tidak Laris' && $actual == 'Tidak Laris') $TN++;
                if ($prediction == 'Tidak Laris' && $actual == 'Laris') $FN++;


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
            }

            $accuracy = ($TP + $TN) / ($TP + $FP + $TN + $FN);
            $precision = $TP / ($TP + $FP);
            $recall = $TP / ($TP + $FN);
            $f1_score = 2 * (($precision * $recall) / ($precision + $recall));

            // Kirim data hasil prediksi ke view
            $data['predictions'] = $predictions;
            $data['evaluation'] = [
                'TP' => $TP,
                'FP' => $FP,
                'TN' => $TN,
                'FN' => $FN,
                'accuracy' => $accuracy,
                'precision' => $precision,
                'recall' => $recall,
                'f1_score' => $f1_score
            ];
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



            $data['title'] = 'Perhitungan : Issue Shop';

            $this->load->view('layouts/head', $data);
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar', $data);
            $this->load->view('admin/perhitungan', $data);
            $this->load->view('layouts/footer', $data);
        }
    }

    public function prediksi()
    {
        $data['title'] = 'Tahapan Perhitungan : Issue Shop';

        $this->load->view('layouts/head', $data);
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/perhitungan', $data);
        $this->load->view('layouts/footer', $data);
    }

    // public function prediksi()
    // {
    //     $predictions = [];

    //     // Jika ada input tanggal yang dikirimkan
    //     if ($this->input->post()) {
    //         $start_date = $this->input->post('start_date'); // Tanggal mulai
    //         $end_date = $this->input->post('end_date');   // Tanggal akhir

    //         // Hitung probabilitas prior untuk setiap brand
    //         $prior = $this->PrediksiModel->calculatePrior($start_date, $end_date);

    //         // Hitung likelihood untuk setiap brand berdasarkan tanggal yang dipilih
    //         $likelihood = $this->PrediksiModel->calculateLikelihood($start_date, $end_date);

    //         // Gabungkan prior dan likelihood untuk ditampilkan pada view
    //         foreach ($prior as $brand => $prior_data) {
    //             $predictions[] = [
    //                 'nama_brand' => $brand,
    //                 'prior' => $prior_data,
    //                 'likelihood' => isset($likelihood[$brand]) ? $likelihood[$brand] : ['Laris' => 0, 'Tidak Laris' => 0]
    //             ];
    //         }
    //     }

    //     // Kembalikan data sebagai JSON
    //     echo json_encode([
    //         'status' => true,
    //         'predictions' => $predictions,
    //         'start_date' => $start_date ?? null,
    //         'end_date' => $end_date ?? null
    //     ]);
    // }


    public function predict_by_range()
    {
        // Ambil tanggal awal dan tanggal akhir dari form
        $tanggal_awal = $this->input->post('tanggal_awal');
        $tanggal_akhir = $this->input->post('tanggal_akhir');

        // Ambil data dari database berdasarkan range tanggal
        $this->db->where('tanggal >=', $tanggal_awal);
        $this->db->where('tanggal <=', $tanggal_akhir);
        $data_produk = $this->db->get('tbl_penjualan_detail')->result_array();

        $predictions = [];
        foreach ($data_produk as $produk) {
            // Lakukan prediksi untuk setiap produk
            $prediction = $this->NaiveBayesModel->predict(
                $produk['kode_produk'],
                $produk['nama_brand'],
                $produk['harga_brand'],
                $produk['qty'],
                $produk['total_harga'],
                $produk['tanggal']
            );

            // Simpan hasil prediksi
            $predictions[] = [
                'kode_produk' => $produk['kode_produk'],
                'nama_brand' => $produk['nama_brand'],
                'tanggal' => $produk['tanggal'],
                'prediction' => $prediction,
            ];
        }


        echo json_encode($predictions);
    }


    public function detail($nama_brand)
    {
        // Ambil parameter tanggal_awal dan tanggal_akhir dari query string
        $tanggal_awal = $this->input->get('tanggal_awal');
        $tanggal_akhir = $this->input->get('tanggal_akhir');

        // Ambil data transaksi berdasarkan nama_brand dan range tanggal
        $transactions = $this->NaiveBayesDetailModel->get_transactions_by_brand($nama_brand, $tanggal_awal, $tanggal_akhir);

        // Jika tidak ada transaksi, tampilkan pesan
        if (empty($transactions)) {
            $data = [
                'nama_brand' => $nama_brand,
                'message' => 'Tidak ada transaksi untuk brand ini dalam rentang tanggal yang dipilih.',
            ];
            $data['title'] = 'Perhitungan : Issue Shop';

            $this->load->view('layouts/head', $data);
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar', $data);
            $this->load->view('admin/perhitungan_detail_view', $data);
            $this->load->view('layouts/footer', $data);
            return;
        }

        // Lanjutkan dengan perhitungan jika data tersedia
        // Hitung jumlah transaksi laris dan tidak laris
        $count_laris_tidak_laris = $this->NaiveBayesDetailModel->count_laris_tidak_laris($transactions);

        // Hitung probabilitas prior
        $total_transactions = count($transactions);
        $prior = $this->NaiveBayesDetailModel->calculate_prior(
            $count_laris_tidak_laris['laris'],
            $count_laris_tidak_laris['tidak_laris'],
            $total_transactions
        );

        // Hitung probabilitas likelihood untuk setiap fitur
        $likelihood_laris = [];
        $likelihood_tidak_laris = [];
        $features = ['kode_produk', 'harga_brand', 'qty', 'total_harga', 'tanggal'];

        foreach ($features as $feature) {
            $likelihood_laris[$feature] = $this->NaiveBayesDetailModel->calculate_likelihood($transactions, $feature, $transactions[0][$feature], 1);
            $likelihood_tidak_laris[$feature] = $this->NaiveBayesDetailModel->calculate_likelihood($transactions, $feature, $transactions[0][$feature], 0);
        }

        // Kirim data ke view
        $data = [
            'nama_brand' => $nama_brand,
            'transactions' => $transactions,
            'count_laris_tidak_laris' => $count_laris_tidak_laris,
            'prior' => $prior,
            'likelihood_laris' => $likelihood_laris,
            'likelihood_tidak_laris' => $likelihood_tidak_laris,
        ];
        $data['title'] = 'Perhitungan : Issue Shop';

        // $this->load->view('detail_view', $data);
        $this->load->view('layouts/head', $data);
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/perhitungan_detail_view', $data);
        $this->load->view('layouts/footer', $data);
    }


    public function save_prediction($data)
    {
        $this->db->insert('prediksi_popularitas', $data);
    }
}

/* End of file PerhitunganController.php */
