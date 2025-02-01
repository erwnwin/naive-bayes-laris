<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PenggunaController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('PenggunaModel');
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('login'));
        }
    }

    public function index()
    {
        $data['title'] = 'Role Pengguna : Issue Shop';

        $data['pengguna'] = $this->PenggunaModel->get_pengguna();
        $this->load->view('layouts/head', $data);
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/pengguna', $data);
        $this->load->view('layouts/footer', $data);
    }
}

/* End of file PenggunaController.php */
