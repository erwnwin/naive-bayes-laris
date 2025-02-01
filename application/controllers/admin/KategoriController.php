<?php

defined('BASEPATH') or exit('No direct script access allowed');

class KategoriController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('login'));
        }
    }


    public function index() {}
}

/* End of file KategoriController.php */
