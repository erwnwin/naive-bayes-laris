<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_penjualan extends CI_Model
{
    public function get_items_by_date_range($start_date, $end_date)
    {
        $this->db->where('tanggal >=', $start_date);
        $this->db->where('tanggal <=', $end_date);
        return $this->db->get('tbl_penjualan_detail')->result_array();
    }

    public function save_prediction($data)
    {
        $this->db->insert('tbl_prediksi_popularitas', $data);
    }

    public function get_items_by_class($class)
    {
        // Tergantung dari parameter $class, kita memilih data qty yang sesuai
        if ($class == 'Laris') {
            // Ambil data produk dengan qty > 10 (Laris)
            $this->db->where('qty >', 10);
        } else {
            // Ambil data produk dengan qty <= 10 (Tidak Laris)
            $this->db->where('qty <=', 10);
        }

        // Ambil data produk dari tabel 'penjualan'
        $query = $this->db->get('tbl_penjualan_detail'); // Ganti 'penjualan' dengan nama tabel yang sesuai
        return $query->result_array(); // Mengembalikan hasil dalam bentuk array
    }
}

/* End of file M_penjualan.php */
