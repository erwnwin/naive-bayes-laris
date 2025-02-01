<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ProbabilitasController extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('ProbabilitasModel');
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('login'));
        }
    }


    public function index()
    {



        $data = $this->ProbabilitasModel->get_penjualan_details();

        // Inisialisasi array untuk menyimpan tabel probabilitas
        $probabilitas = [
            'nama_brand' => ['laris' => [], 'tidak_laris' => []],
            'harga_brand' => ['laris' => [], 'tidak_laris' => []],
            'qty' => ['laris' => [], 'tidak_laris' => []],
            'ukuran' => ['laris' => [], 'tidak_laris' => []]
        ];

        $threshold_qty = 10; // Definisikan ambang batas untuk laris

        $total_records = count($data);
        $total_laris = $total_tidak_laris = 0;
        $count_laris = $count_tidak_laris = 0;

        foreach ($data as $row) {
            $is_laris = $row['qty'] >= $threshold_qty;

            // Update total counts
            if ($is_laris) {
                $total_laris++;
            } else {
                $total_tidak_laris++;
            }

            // Probabilitas nama_brand
            $nama_brand = $row['nama_brand'];
            $status = $is_laris ? 'laris' : 'tidak_laris';
            if (!isset($probabilitas['nama_brand'][$status][$nama_brand])) {
                $probabilitas['nama_brand'][$status][$nama_brand] = 0;
            }
            $probabilitas['nama_brand'][$status][$nama_brand]++;

            // Probabilitas harga_brand
            $harga_brand = $row['harga_brand'];
            if (!isset($probabilitas['harga_brand'][$status][$harga_brand])) {
                $probabilitas['harga_brand'][$status][$harga_brand] = 0;
            }
            $probabilitas['harga_brand'][$status][$harga_brand]++;

            // Probabilitas qty
            $qty = $row['qty'];
            if (!isset($probabilitas['qty'][$status][$qty])) {
                $probabilitas['qty'][$status][$qty] = 0;
            }
            $probabilitas['qty'][$status][$qty]++;

            // Probabilitas ukuran
            $ukuran = $row['ukuran'];
            if (!isset($probabilitas['ukuran'][$status][$ukuran])) {
                $probabilitas['ukuran'][$status][$ukuran] = 0;
            }
            $probabilitas['ukuran'][$status][$ukuran]++;
        }

        // Hitung probabilitas
        foreach (['nama_brand', 'harga_brand', 'qty', 'ukuran'] as $feature) {
            foreach (['laris', 'tidak_laris'] as $status) {
                foreach ($probabilitas[$feature][$status] as $key => $count) {
                    if ($status == 'laris') {
                        $probabilitas[$feature][$status][$key] = $count / $total_laris;
                    } else {
                        $probabilitas[$feature][$status][$key] = $count / $total_tidak_laris;
                    }
                }
            }
        }

        $data['probabilitas'] = $probabilitas;
        $data['total_laris'] = $total_laris;
        $data['total_tidak_laris'] = $total_tidak_laris;
        $data['title'] = 'Tabel Probabilitas : Issue Shop';


        $this->load->view('layouts/head', $data);
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/table_probabilitas', $data);
        $this->load->view('layouts/footer', $data);
    }
}

/* End of file ProbabilitasController.php */
