<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DashboardController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_model');
        $this->load->model('Aturan_model');

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('login'));
        }
    }


    public function index()
    {
        // Ambil semua data barang dari database
        $data_barang = $this->Barang_model->get_all_barang();

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
        $TP = $FP = $TN = $FN = 0;
        $total_prediksi_laris = 0;
        $total_prediksi_tidak_laris = 0;

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

            // Hitung TP, FP, TN, FN
            if ($prediction == 'Laris' && $actual == 'Laris') $TP++;
            if ($prediction == 'Laris' && $actual == 'Tidak Laris') $FP++;
            if ($prediction == 'Tidak Laris' && $actual == 'Tidak Laris') $TN++;
            if ($prediction == 'Tidak Laris' && $actual == 'Laris') $FN++;

            // Menambahkan jumlah prediksi
            if ($prediction == 'Laris') $total_prediksi_laris++;
            else $total_prediksi_tidak_laris++;

            // Simpan hasil prediksi ke dalam array
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

        // Menghitung metrik evaluasi
        $accuracy = ($TP + $TN) / ($TP + $FP + $TN + $FN);
        $precision = $TP / ($TP + $FP);
        $recall = $TP / ($TP + $FN);
        $f1_score = 2 * (($precision * $recall) / ($precision + $recall));

        // Kirim data hasil prediksi dan statistik ke view dashboard
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
        $data['total_prediksi_laris'] = $total_prediksi_laris;
        $data['total_prediksi_tidak_laris'] = $total_prediksi_tidak_laris;
        $data['total_data'] = $total_prediksi_laris + $total_prediksi_tidak_laris;

        $data['title'] = 'Dashboard : Issue Shop';

        $this->load->view('layouts/head', $data);
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('layouts/footer', $data);
    }
}

/* End of file DashboardController.php */
