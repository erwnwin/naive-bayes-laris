<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat_prediksi_model  extends CI_Model
{
    public function save_riwayat_prediksi($data)
    {
        $this->db->insert('riwayat_prediksi', $data);
    }
}

/* End of file Riwayat_prediksi_model .php */
