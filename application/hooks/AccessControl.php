<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AccessControl
{

    public function checkAccess()
    {
        $CI = &get_instance();

        // Cek kondisi tertentu, misalnya IP atau session
        if ($CI->input->ip_address() != '192.168.1.1') {
            show_404(); // Tampilkan 404 jika kondisi tidak terpenuhi
        }
    }
}
