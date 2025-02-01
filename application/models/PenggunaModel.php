<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PenggunaModel extends CI_Model
{
    public function get_pengguna()
    {
        $this->db->select('*');
        $this->db->from('tbl_pengguna');
        $query = $this->db->get();
        return $query->result();
    }


    public function getPenggunaByUsername($username)
    {
        $this->db->where('username', $username);
        return $this->db->get('tbl_pengguna')->row_array();
    }
}

/* End of file PenggunaModel.php */
