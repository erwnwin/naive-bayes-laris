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

        $data['periodes'] = $this->Barang_model->get_all_periodes();

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
            $qty_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'qty');
            $value_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'value');
            $gross_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'gross');
            $disc_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'disc');
            $subtotal_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'subtotal');
            $cons_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'cons');
            $netto_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'netto');
            $periode_laris = array_map(function ($item) {
                return strtotime($item);
            }, array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'periode'));

            $qty_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'qty');
            $value_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'value');
            $gross_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'gross');
            $disc_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'disc');
            $subtotal_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'subtotal');
            $cons_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'cons');
            $netto_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'netto');
            $periode_tidak_laris = array_map(function ($item) {
                return strtotime($item);
            }, array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'periode'));

            // Menghitung mean dan standar deviasi untuk setiap kolom
            $mean_qty_laris = mean($qty_laris);
            $stddev_qty_laris = std_dev($qty_laris, $mean_qty_laris);
            $mean_value_laris = mean($value_laris);
            $stddev_value_laris = std_dev($value_laris, $mean_value_laris);
            $mean_gross_laris = mean($gross_laris);
            $stddev_gross_laris = std_dev($gross_laris, $mean_gross_laris);
            $mean_disc_laris = mean($disc_laris);
            $stddev_disc_laris = std_dev($disc_laris, $mean_disc_laris);
            $mean_subtotal_laris = mean($subtotal_laris);
            $stddev_subtotal_laris = std_dev($subtotal_laris, $mean_subtotal_laris);
            $mean_cons_laris = mean($cons_laris);
            $stddev_cons_laris = std_dev($cons_laris, $mean_cons_laris);
            $mean_netto_laris = mean($netto_laris);
            $stddev_netto_laris = std_dev($netto_laris, $mean_netto_laris);
            $mean_periode_laris = mean($periode_laris);
            $stddev_periode_laris = std_dev($periode_laris, $mean_periode_laris);

            $mean_qty_tidak_laris = mean($qty_tidak_laris);
            $stddev_qty_tidak_laris = std_dev($qty_tidak_laris, $mean_qty_tidak_laris);
            $mean_value_tidak_laris = mean($value_tidak_laris);
            $stddev_value_tidak_laris = std_dev($value_tidak_laris, $mean_value_tidak_laris);
            $mean_gross_tidak_laris = mean($gross_tidak_laris);
            $stddev_gross_tidak_laris = std_dev($gross_tidak_laris, $mean_gross_tidak_laris);
            $mean_disc_tidak_laris = mean($disc_tidak_laris);
            $stddev_disc_tidak_laris = std_dev($disc_tidak_laris, $mean_disc_tidak_laris);
            $mean_subtotal_tidak_laris = mean($subtotal_tidak_laris);
            $stddev_subtotal_tidak_laris = std_dev($subtotal_tidak_laris, $mean_subtotal_tidak_laris);
            $mean_cons_tidak_laris = mean($cons_tidak_laris);
            $stddev_cons_tidak_laris = std_dev($cons_tidak_laris, $mean_cons_tidak_laris);
            $mean_netto_tidak_laris = mean($netto_tidak_laris);
            $stddev_netto_tidak_laris = std_dev($netto_tidak_laris, $mean_netto_tidak_laris);
            $mean_periode_tidak_laris = mean($periode_tidak_laris);
            $stddev_periode_tidak_laris = std_dev($periode_tidak_laris, $mean_periode_tidak_laris);

            // Fungsi untuk menghitung distribusi normal (normal PDF)
            function normal_pdf($x, $mean, $stddev)
            {
                return (1 / ($stddev * sqrt(2 * M_PI))) * exp(-0.5 * pow(($x - $mean) / $stddev, 2));
            }
            // function normal_pdf($x, $mean, $stddev)
            // {
            //     return (1 / ($stddev * sqrt(2 * M_PI))) * exp(-0.5 * pow(($x - $mean) / $stddev, 2));
            // }

            $TP = $FP = $TN = $FN = 0;

            // Menghitung prediksi untuk setiap barang
            foreach ($data_barang as $item) {
                $qty_input = $item['qty'];
                $value_input = $item['value'];
                $gross_input = $item['gross'];
                $disc_input = $item['disc'];
                $subtotal_input = $item['subtotal'];
                $cons_input = $item['cons'];
                $netto_input = $item['netto'];
                $periode_input = strtotime($item['periode']);

                // Menghitung P(Gross | Laris) dan P(Qty | Laris)
                $prob_qty_laris = normal_pdf($qty_input, $mean_qty_laris, $stddev_qty_laris);
                $prob_value_laris = normal_pdf($value_input, $mean_value_laris, $stddev_value_laris);
                $prob_gross_laris = normal_pdf($gross_input, $mean_gross_laris, $stddev_gross_laris);
                $prob_disc_laris = normal_pdf($disc_input, $mean_disc_laris, $stddev_disc_laris);
                $prob_subtotal_laris = normal_pdf($subtotal_input, $mean_subtotal_laris, $stddev_subtotal_laris);
                $prob_cons_laris = normal_pdf($cons_input, $mean_cons_laris, $stddev_cons_laris);
                $prob_netto_laris = normal_pdf($netto_input, $mean_netto_laris, $stddev_netto_laris);
                $prob_periode_laris = normal_pdf($periode_input, $mean_periode_laris, $stddev_periode_laris);

                // Menghitung P(Gross | Tidak Laris) dan P(Qty | Tidak Laris)
                $prob_qty_tidak_laris = normal_pdf($qty_input, $mean_qty_tidak_laris, $stddev_qty_tidak_laris);
                $prob_value_tidak_laris = normal_pdf($value_input, $mean_value_tidak_laris, $stddev_value_tidak_laris);
                $prob_gross_tidak_laris = normal_pdf($gross_input, $mean_gross_tidak_laris, $stddev_gross_tidak_laris);
                $prob_disc_tidak_laris = normal_pdf($disc_input, $mean_disc_tidak_laris, $stddev_disc_tidak_laris);
                $prob_subtotal_tidak_laris = normal_pdf($subtotal_input, $mean_subtotal_tidak_laris, $stddev_subtotal_tidak_laris);
                $prob_cons_tidak_laris = normal_pdf($cons_input, $mean_cons_tidak_laris, $stddev_cons_tidak_laris);
                $prob_netto_tidak_laris = normal_pdf($netto_input, $mean_netto_tidak_laris, $stddev_netto_tidak_laris);
                $prob_periode_tidak_laris = normal_pdf($periode_input, $mean_periode_tidak_laris, $stddev_periode_tidak_laris);

                // Menghitung P(Laris | X) dan P(Tidak Laris | X)
                $prob_laris_given_x = $prob_Laris * $prob_qty_laris * $prob_value_laris * $prob_gross_laris * $prob_disc_laris * $prob_subtotal_laris * $prob_cons_laris * $prob_netto_laris * $prob_periode_laris;
                $prob_tidak_laris_given_x = $prob_Tidak_Laris * $prob_qty_tidak_laris * $prob_value_tidak_laris * $prob_gross_tidak_laris * $prob_disc_tidak_laris * $prob_subtotal_tidak_laris * $prob_cons_tidak_laris * $prob_netto_tidak_laris * $prob_periode_tidak_laris;

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
                    'qty' => $qty_input,
                    'value' => $value_input,
                    'gross' => $gross_input,
                    'disc' => $disc_input,
                    'subtotal' => $subtotal_input,
                    'cons' => $cons_input,
                    'netto' => $netto_input,
                    'periode' => $periode_input,
                    'label' => $item['label'],
                    'prob_laris_given_x' => $prob_laris_given_x,
                    'prob_tidak_laris_given_x' => $prob_tidak_laris_given_x,
                    'prediksi' => $prediction,

                ];
            }

            // Rekomendasi kuantitas untuk barang yang diprediksi laris
            $recommended_qty = [];
            foreach ($predictions as $prediction) {
                if ($prediction['prediksi'] == 'Laris') {
                    // Ambil data historis penjualan untuk barang ini
                    $historis_qty = $this->Barang_model->get_historis_qty($prediction['nama']);

                    // Hitung rata-rata kuantitas dari data historis
                    $mean_qty_barang = mean($historis_qty);

                    // Tambahkan buffer 10% (opsional)
                    $recommended_qty_barang = $mean_qty_barang * 1.1;

                    $recommended_qty[] = [
                        'nama_barang' => $prediction['nama'],
                        'recommended_qty' => $recommended_qty_barang
                    ];
                }
            }

            $accuracy = ($TP + $TN) / ($TP + $FP + $TN + $FN);
            $precision = $TP / ($TP + $FP);
            $recall = $TP / ($TP + $FN);
            $f1_score = 2 * (($precision * $recall) / ($precision + $recall));

            // Kirim data hasil prediksi ke view
            $data['predictions'] = $predictions;
            $data['recommended_qty'] = $recommended_qty;
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
                'mean_qty_laris' => $mean_qty_laris,
                'stddev_qty_laris' => $stddev_qty_laris,
                'mean_value_laris' => $mean_value_laris,
                'stddev_value_laris' => $stddev_value_laris,
                'mean_gross_laris' => $mean_gross_laris,
                'stddev_gross_laris' => $stddev_gross_laris,
                'mean_disc_laris' => $mean_disc_laris,
                'stddev_disc_laris' => $stddev_disc_laris,
                'mean_subtotal_laris' => $mean_subtotal_laris,
                'stddev_subtotal_laris' => $stddev_subtotal_laris,
                'mean_cons_laris' => $mean_cons_laris,
                'stddev_cons_laris' => $stddev_cons_laris,
                'mean_netto_laris' => $mean_netto_laris,
                'stddev_netto_laris' => $stddev_netto_laris,
                'mean_periode_laris' => $mean_periode_laris,
                'stddev_periode_laris' => $stddev_periode_laris,

                'mean_qty_tidak_laris' => $mean_qty_tidak_laris,
                'stddev_qty_tidak_laris' => $stddev_qty_tidak_laris,
                'mean_value_tidak_laris' => $mean_value_tidak_laris,
                'stddev_value_tidak_laris' => $stddev_value_tidak_laris,
                'mean_gross_tidak_laris' => $mean_gross_tidak_laris,
                'stddev_gross_tidak_laris' => $stddev_gross_tidak_laris,
                'mean_disc_tidak_laris' => $mean_disc_tidak_laris,
                'stddev_disc_tidak_laris' => $stddev_disc_tidak_laris,
                'mean_subtotal_tidak_laris' => $mean_subtotal_tidak_laris,
                'stddev_subtotal_tidak_laris' => $stddev_subtotal_tidak_laris,
                'mean_cons_tidak_laris' => $mean_cons_tidak_laris,
                'stddev_cons_tidak_laris' => $stddev_cons_tidak_laris,
                'mean_netto_tidak_laris' => $mean_netto_tidak_laris,
                'stddev_netto_tidak_laris' => $stddev_netto_tidak_laris,
                'mean_periode_tidak_laris' => $mean_periode_tidak_laris,
                'stddev_periode_tidak_laris' => $stddev_periode_tidak_laris
            ];

            $data['title'] = 'Perhitungan : Issue Shop';

            $this->load->view('layouts/head', $data);
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar', $data);
            $this->load->view('admin/perhitungan', $data);
            $this->load->view('layouts/footer', $data);
        }
    }



    public function filterByPeriode()
    {
        // Ambil periode dari request POST
        $periode = $this->input->post('periode');

        // Filter data barang berdasarkan periode
        $data_barang = $this->Barang_model->get_barang_by_periode($periode);

        // Jika data barang kosong, kembalikan respons kosong
        if (empty($data_barang)) {
            echo json_encode([]);
            return;
        }

        // Lakukan perhitungan Naive Bayes seperti di method index()
        $aturan = $this->Aturan_model->get_all_aturan();
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
        $qty_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'qty');
        $value_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'value');
        $gross_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'gross');
        $disc_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'disc');
        $subtotal_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'subtotal');
        $cons_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'cons');
        $netto_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'netto');
        $periode_laris = array_map(function ($item) {
            return strtotime($item);
        }, array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'periode'));

        $qty_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'qty');
        $value_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'value');
        $gross_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'gross');
        $disc_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'disc');
        $subtotal_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'subtotal');
        $cons_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'cons');
        $netto_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'netto');
        $periode_tidak_laris = array_map(function ($item) {
            return strtotime($item);
        }, array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'periode'));

        // Menghitung mean dan standar deviasi untuk setiap kolom
        $mean_qty_laris = mean($qty_laris);
        $stddev_qty_laris = std_dev($qty_laris, $mean_qty_laris);
        $mean_value_laris = mean($value_laris);
        $stddev_value_laris = std_dev($value_laris, $mean_value_laris);
        $mean_gross_laris = mean($gross_laris);
        $stddev_gross_laris = std_dev($gross_laris, $mean_gross_laris);
        $mean_disc_laris = mean($disc_laris);
        $stddev_disc_laris = std_dev($disc_laris, $mean_disc_laris);
        $mean_subtotal_laris = mean($subtotal_laris);
        $stddev_subtotal_laris = std_dev($subtotal_laris, $mean_subtotal_laris);
        $mean_cons_laris = mean($cons_laris);
        $stddev_cons_laris = std_dev($cons_laris, $mean_cons_laris);
        $mean_netto_laris = mean($netto_laris);
        $stddev_netto_laris = std_dev($netto_laris, $mean_netto_laris);
        $mean_periode_laris = mean($periode_laris);
        $stddev_periode_laris = std_dev($periode_laris, $mean_periode_laris);

        $mean_qty_tidak_laris = mean($qty_tidak_laris);
        $stddev_qty_tidak_laris = std_dev($qty_tidak_laris, $mean_qty_tidak_laris);
        $mean_value_tidak_laris = mean($value_tidak_laris);
        $stddev_value_tidak_laris = std_dev($value_tidak_laris, $mean_value_tidak_laris);
        $mean_gross_tidak_laris = mean($gross_tidak_laris);
        $stddev_gross_tidak_laris = std_dev($gross_tidak_laris, $mean_gross_tidak_laris);
        $mean_disc_tidak_laris = mean($disc_tidak_laris);
        $stddev_disc_tidak_laris = std_dev($disc_tidak_laris, $mean_disc_tidak_laris);
        $mean_subtotal_tidak_laris = mean($subtotal_tidak_laris);
        $stddev_subtotal_tidak_laris = std_dev($subtotal_tidak_laris, $mean_subtotal_tidak_laris);
        $mean_cons_tidak_laris = mean($cons_tidak_laris);
        $stddev_cons_tidak_laris = std_dev($cons_tidak_laris, $mean_cons_tidak_laris);
        $mean_netto_tidak_laris = mean($netto_tidak_laris);
        $stddev_netto_tidak_laris = std_dev($netto_tidak_laris, $mean_netto_tidak_laris);
        $mean_periode_tidak_laris = mean($periode_tidak_laris);
        $stddev_periode_tidak_laris = std_dev($periode_tidak_laris, $mean_periode_tidak_laris);

        // Fungsi untuk menghitung distribusi normal (normal PDF)
        function normal_pdf($x, $mean, $stddev)
        {
            return (1 / ($stddev * sqrt(2 * M_PI))) * exp(-0.5 * pow(($x - $mean) / $stddev, 2));
        }

        $TP = $FP = $TN = $FN = 0;

        // Menghitung prediksi untuk setiap barang
        foreach ($data_barang as $item) {
            $qty_input = $item['qty'];
            $value_input = $item['value'];
            $gross_input = $item['gross'];
            $disc_input = $item['disc'];
            $subtotal_input = $item['subtotal'];
            $cons_input = $item['cons'];
            $netto_input = $item['netto'];
            $periode_input = strtotime($item['periode']);

            // Menghitung P(Gross | Laris) dan P(Qty | Laris)
            $prob_qty_laris = normal_pdf($qty_input, $mean_qty_laris, $stddev_qty_laris);
            $prob_value_laris = normal_pdf($value_input, $mean_value_laris, $stddev_value_laris);
            $prob_gross_laris = normal_pdf($gross_input, $mean_gross_laris, $stddev_gross_laris);
            $prob_disc_laris = normal_pdf($disc_input, $mean_disc_laris, $stddev_disc_laris);
            $prob_subtotal_laris = normal_pdf($subtotal_input, $mean_subtotal_laris, $stddev_subtotal_laris);
            $prob_cons_laris = normal_pdf($cons_input, $mean_cons_laris, $stddev_cons_laris);
            $prob_netto_laris = normal_pdf($netto_input, $mean_netto_laris, $stddev_netto_laris);
            $prob_periode_laris = normal_pdf($periode_input, $mean_periode_laris, $stddev_periode_laris);

            // Menghitung P(Gross | Tidak Laris) dan P(Qty | Tidak Laris)
            $prob_qty_tidak_laris = normal_pdf($qty_input, $mean_qty_tidak_laris, $stddev_qty_tidak_laris);
            $prob_value_tidak_laris = normal_pdf($value_input, $mean_value_tidak_laris, $stddev_value_tidak_laris);
            $prob_gross_tidak_laris = normal_pdf($gross_input, $mean_gross_tidak_laris, $stddev_gross_tidak_laris);
            $prob_disc_tidak_laris = normal_pdf($disc_input, $mean_disc_tidak_laris, $stddev_disc_tidak_laris);
            $prob_subtotal_tidak_laris = normal_pdf($subtotal_input, $mean_subtotal_tidak_laris, $stddev_subtotal_tidak_laris);
            $prob_cons_tidak_laris = normal_pdf($cons_input, $mean_cons_tidak_laris, $stddev_cons_tidak_laris);
            $prob_netto_tidak_laris = normal_pdf($netto_input, $mean_netto_tidak_laris, $stddev_netto_tidak_laris);
            $prob_periode_tidak_laris = normal_pdf($periode_input, $mean_periode_tidak_laris, $stddev_periode_tidak_laris);

            // Menghitung P(Laris | X) dan P(Tidak Laris | X)
            $prob_laris_given_x = $prob_Laris * $prob_qty_laris * $prob_value_laris * $prob_gross_laris * $prob_disc_laris * $prob_subtotal_laris * $prob_cons_laris * $prob_netto_laris * $prob_periode_laris;
            $prob_tidak_laris_given_x = $prob_Tidak_Laris * $prob_qty_tidak_laris * $prob_value_tidak_laris * $prob_gross_tidak_laris * $prob_disc_tidak_laris * $prob_subtotal_tidak_laris * $prob_cons_tidak_laris * $prob_netto_tidak_laris * $prob_periode_tidak_laris;

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
                'qty' => $qty_input,
                'value' => $value_input,
                'gross' => $gross_input,
                'disc' => $disc_input,
                'subtotal' => $subtotal_input,
                'cons' => $cons_input,
                'netto' => $netto_input,
                'periode' => $periode_input,
                'label' => $item['label'],
                'prob_laris_given_x' => $prob_laris_given_x,
                'prob_tidak_laris_given_x' => $prob_tidak_laris_given_x,
                'prediksi' => $prediction,
            ];
        }

        // Kirim data hasil prediksi dalam format JSON
        echo json_encode($predictions);
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

    public function export_pdf()
    {
        $this->load->library('dompdf_gen');

        // Ambil semua data barang dan aturan klasifikasi
        $data_barang = $this->Barang_model->get_all_barang();
        $aturan = $this->Aturan_model->get_all_aturan();

        // Inisialisasi hasil prediksi dan evaluasi
        $predictions = [];
        $TP = $FP = $TN = $FN = 0;

        // Hitung probabilitas prior P(Laris) dan P(Tidak Laris)
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
        $value_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'value');
        $disc_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'disc');
        $subtotal_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'subtotal');
        $cons_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'cons');
        $netto_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Laris'), 'netto');

        $gross_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'gross');
        $qty_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'qty');
        $value_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'value');
        $disc_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'disc');
        $subtotal_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'subtotal');
        $cons_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'cons');
        $netto_tidak_laris = array_column(array_filter($data_barang, fn($item) => $item['label'] == 'Tidak Laris'), 'netto');

        // Menghitung mean dan standar deviasi untuk setiap kolom
        $mean_gross_laris = mean($gross_laris);
        $stddev_gross_laris = std_dev($gross_laris, $mean_gross_laris);
        $mean_qty_laris = mean($qty_laris);
        $stddev_qty_laris = std_dev($qty_laris, $mean_qty_laris);
        $mean_value_laris = mean($value_laris);
        $stddev_value_laris = std_dev($value_laris, $mean_value_laris);
        $mean_disc_laris = mean($disc_laris);
        $stddev_disc_laris = std_dev($disc_laris, $mean_disc_laris);
        $mean_subtotal_laris = mean($subtotal_laris);
        $stddev_subtotal_laris = std_dev($subtotal_laris, $mean_subtotal_laris);
        $mean_cons_laris = mean($cons_laris);
        $stddev_cons_laris = std_dev($cons_laris, $mean_cons_laris);
        $mean_netto_laris = mean($netto_laris);
        $stddev_netto_laris = std_dev($netto_laris, $mean_netto_laris);

        $mean_gross_tidak_laris = mean($gross_tidak_laris);
        $stddev_gross_tidak_laris = std_dev($gross_tidak_laris, $mean_gross_tidak_laris);
        $mean_qty_tidak_laris = mean($qty_tidak_laris);
        $stddev_qty_tidak_laris = std_dev($qty_tidak_laris, $mean_qty_tidak_laris);
        $mean_value_tidak_laris = mean($value_tidak_laris);
        $stddev_value_tidak_laris = std_dev($value_tidak_laris, $mean_value_tidak_laris);
        $mean_disc_tidak_laris = mean($disc_tidak_laris);
        $stddev_disc_tidak_laris = std_dev($disc_tidak_laris, $mean_disc_tidak_laris);
        $mean_subtotal_tidak_laris = mean($subtotal_tidak_laris);
        $stddev_subtotal_tidak_laris = std_dev($subtotal_tidak_laris, $mean_subtotal_tidak_laris);
        $mean_cons_tidak_laris = mean($cons_tidak_laris);
        $stddev_cons_tidak_laris = std_dev($cons_tidak_laris, $mean_cons_tidak_laris);
        $mean_netto_tidak_laris = mean($netto_tidak_laris);
        $stddev_netto_tidak_laris = std_dev($netto_tidak_laris, $mean_netto_tidak_laris);

        // Fungsi untuk menghitung distribusi normal (normal PDF)
        function normal_pdf($x, $mean, $stddev)
        {
            return (1 / ($stddev * sqrt(2 * M_PI))) * exp(-0.5 * pow(($x - $mean) / $stddev, 2));
        }

        // Menghitung prediksi untuk setiap barang
        foreach ($data_barang as $item) {
            $gross_input = $item['gross'];
            $qty_input = $item['qty'];
            $value_input = $item['value'];
            $disc_input = $item['disc'];
            $subtotal_input = $item['subtotal'];
            $cons_input = $item['cons'];
            $netto_input = $item['netto'];

            // Menghitung P(Gross | Laris), P(Qty | Laris), P(Value | Laris), dll.
            $prob_gross_laris = normal_pdf($gross_input, $mean_gross_laris, $stddev_gross_laris);
            $prob_qty_laris = normal_pdf($qty_input, $mean_qty_laris, $stddev_qty_laris);
            $prob_value_laris = normal_pdf($value_input, $mean_value_laris, $stddev_value_laris);
            $prob_disc_laris = normal_pdf($disc_input, $mean_disc_laris, $stddev_disc_laris);
            $prob_subtotal_laris = normal_pdf($subtotal_input, $mean_subtotal_laris, $stddev_subtotal_laris);
            $prob_cons_laris = normal_pdf($cons_input, $mean_cons_laris, $stddev_cons_laris);
            $prob_netto_laris = normal_pdf($netto_input, $mean_netto_laris, $stddev_netto_laris);

            // Menghitung P(Gross | Tidak Laris), P(Qty | Tidak Laris), P(Value | Tidak Laris), dll.
            $prob_gross_tidak_laris = normal_pdf($gross_input, $mean_gross_tidak_laris, $stddev_gross_tidak_laris);
            $prob_qty_tidak_laris = normal_pdf($qty_input, $mean_qty_tidak_laris, $stddev_qty_tidak_laris);
            $prob_value_tidak_laris = normal_pdf($value_input, $mean_value_tidak_laris, $stddev_value_tidak_laris);
            $prob_disc_tidak_laris = normal_pdf($disc_input, $mean_disc_tidak_laris, $stddev_disc_tidak_laris);
            $prob_subtotal_tidak_laris = normal_pdf($subtotal_input, $mean_subtotal_tidak_laris, $stddev_subtotal_tidak_laris);
            $prob_cons_tidak_laris = normal_pdf($cons_input, $mean_cons_tidak_laris, $stddev_cons_tidak_laris);
            $prob_netto_tidak_laris = normal_pdf($netto_input, $mean_netto_tidak_laris, $stddev_netto_tidak_laris);

            // Menghitung P(Laris | X) dan P(Tidak Laris | X)
            $prob_laris_given_x = $prob_Laris * $prob_gross_laris * $prob_qty_laris * $prob_value_laris * $prob_disc_laris * $prob_subtotal_laris * $prob_cons_laris * $prob_netto_laris;
            $prob_tidak_laris_given_x = $prob_Tidak_Laris * $prob_gross_tidak_laris * $prob_qty_tidak_laris * $prob_value_tidak_laris * $prob_disc_tidak_laris * $prob_subtotal_tidak_laris * $prob_cons_tidak_laris * $prob_netto_tidak_laris;

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
                'value' => $value_input,
                'disc' => $disc_input,
                'subtotal' => $subtotal_input,
                'cons' => $cons_input,
                'netto' => $netto_input,
                'label' => $item['label'],
                'prob_laris_given_x' => $prob_laris_given_x,
                'prob_tidak_laris_given_x' => $prob_tidak_laris_given_x,
                'prediksi' => $prediction
            ];
        }

        // Filter untuk mendapatkan barang dengan prediksi 'Laris'
        $laris_predictions = array_filter($predictions, function ($prediction) {
            return $prediction['prediksi'] === 'Laris';
        });

        // Urutkan berdasarkan probabilitas P(Laris | X)
        usort($laris_predictions, function ($a, $b) {
            return $b['prob_laris_given_x'] - $a['prob_laris_given_x']; // Urutkan berdasarkan probabilitas
        });

        // Kirim data hasil prediksi dan evaluasi ke view
        $data['laris_predictions'] = $laris_predictions;

        // Evaluasi hasil prediksi
        $accuracy = ($TP + $TN) / ($TP + $FP + $TN + $FN);
        $precision = $TP / ($TP + $FP);
        $recall = $TP / ($TP + $FN);
        $f1_score = 2 * (($precision * $recall) / ($precision + $recall));

        // Kirim data hasil prediksi dan evaluasi ke view
        $data['predictions'] = $predictions;
        $data['accuracy'] = $accuracy;
        $data['precision'] = $precision;
        $data['recall'] = $recall;
        $data['f1_score'] = $f1_score;

        // Load view HTML untuk PDF
        $html = $this->load->view('export/prediksi_pdf', $data, true);

        // Load library Dompdf
        $this->dompdf_gen->load_html($html);
        $this->dompdf_gen->set_paper('A4', 'landscape');
        $this->dompdf_gen->render();

        // Output PDF ke browser
        $this->dompdf_gen->stream("prediksi_laris.pdf", array('Attachment' => 0));
    }



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
