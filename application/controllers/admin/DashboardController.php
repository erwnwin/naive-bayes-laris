<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DashboardController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('login'));
        }
    }


    public function index()
    {
        $data['title'] = 'Dashboard : Issue Shop';

        $this->load->view('layouts/head', $data);
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('layouts/footer', $data);
    }
}

/* End of file DashboardController.php */
