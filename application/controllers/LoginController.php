<?php

defined('BASEPATH') or exit('No direct script access allowed');

class LoginController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('PenggunaModel');
    }


    public function index()
    {
        $data['title'] = 'Login : Issue Shop';

        $this->load->view('auth/login', $data);
    }

    public function login()
    {
        // Ambil data dari AJAX
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // Validasi input
        if (empty($username) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Sorry!!<br>Username dan Password wajib diisi.']);
            return;
        }

        // Periksa pengguna di database
        $pengguna = $this->PenggunaModel->getPenggunaByUsername($username);

        if ($pengguna) {
            // Verifikasi password
            // if (password_verify($password, $pengguna['password'])) {
            if ($password == $pengguna['password']) {
                // Simpan data pengguna ke session
                $role = $pengguna['role'];
                $akses = ''; // Hak akses default

                // Tentukan akses berdasarkan role
                if ($role == 'Staf Admin') {
                    $akses = 'admin';  // Hak akses untuk admin
                } elseif ($role == 'Pimpinan Toko') {
                    $akses = 'kepala_toko';  // Hak akses untuk kepala toko
                }

                // Simpan data pengguna dan hak akses ke session
                $this->session->set_userdata([
                    'id' => $pengguna['id'],
                    'nama_pengguna' => $pengguna['nama_pengguna'],
                    'username' => $pengguna['username'],
                    'role' => $role,
                    'akses' => $akses,  // Menyimpan hak akses
                    'logged_in' => true
                ]);

                echo json_encode(['status' => 'success', 'message' => 'Nice!!<br>Login berhasil.', 'redirect' => base_url('dashboard')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Opps!!<br>Password salah.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Sorry!!<br>Username tidak ditemukan.']);
        }
    }


    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }
}

/* End of file LoginController.php */
