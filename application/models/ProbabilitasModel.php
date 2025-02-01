<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ProbabilitasModel extends CI_Model
{
    public function get_penjualan_details()
    {
        $query = $this->db->get('tbl_penjualan_detail');
        return $query->result_array();
    }
}

/* End of file ProbabilitasModel.php */
