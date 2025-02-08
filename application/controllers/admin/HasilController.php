<?php

defined('BASEPATH') or exit('No direct script access allowed');

class HasilController extends CI_Controller
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
            $this->load->view('admin/table_hasil', $data);
            $this->load->view('layouts/footer', $data);
        }
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
        $this->dompdf_gen->set_paper('A4', 'portrait');
        $this->dompdf_gen->render();

        // Output PDF ke browser
        $this->dompdf_gen->stream("prediksi_laris.pdf", array('Attachment' => 0));
    }
}

/* End of file HasilController.php */
