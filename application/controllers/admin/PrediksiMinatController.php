<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PrediksiMinatController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MinatModel');
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('login'));
        }
    }


    public function index()
    {
        $data['title'] = 'Prediksi Minat : Issue Shop';

        $data['brands'] = $this->MinatModel->getUniqueBrands();

        $this->load->view('layouts/head', $data);
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/prediksi_minat', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function predict_interest()
    {
        $brand = $this->input->post('brand'); // Nama brand
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        // Hitung prior dan likelihood
        $prior = $this->MinatModel->calculateInterestPrior($start_date, $end_date);
        $likelihood = $this->MinatModel->calculateInterestLikelihood($start_date, $end_date);

        // Filter hanya untuk nama_brand yang dipilih
        if (isset($prior) && isset($likelihood[$brand])) {
            $posterior = [];
            foreach ($prior as $interest_level => $prob_prior) {
                $prob_likelihood = $likelihood[$brand][$interest_level] ?? 0;
                $posterior[$interest_level] = $prob_prior * $prob_likelihood;
            }

            // Tentukan minat berdasarkan probabilitas posterior tertinggi
            $prediksi = array_keys($posterior, max($posterior))[0];

            // Hasil prediksi
            $result = [
                'nama_brand' => $brand,
                'prior' => $prior,
                'likelihood' => $likelihood[$brand],
                'posterior' => $posterior,
                'prediksi' => $prediksi
            ];

            echo json_encode(['status' => true, 'result' => $result]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Data tidak ditemukan untuk nama brand yang dipilih.']);
        }
    }
}

/* End of file PrediksiMinatController.php */
