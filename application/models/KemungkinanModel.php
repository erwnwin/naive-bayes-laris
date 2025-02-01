<?php

defined('BASEPATH') or exit('No direct script access allowed');

class KemungkinanModel extends CI_Model
{
    public function getAverageTerjual()
    {
        $this->db->select_avg('qty', 'avg_terjual');
        $result = $this->db->get('tbl_penjualan_detail')->row_array();
        return $result['avg_terjual'];
    }


    public function getPenjualanWithClassification($bulan = null, $tahun = null)
    {
        // Hitung rata-rata jumlah terjual
        $avg_terjual = $this->getAverageTerjual();

        // Base query
        $this->db->select("
        id, 
        kode_produk, 
        nama_brand, 
        qty, 
        total_harga, 
        tanggal,
        CASE 
            WHEN qty > $avg_terjual THEN 'Laris'
            ELSE 'Tidak Laris'
        END as status_popularitas
    ");
        $this->db->from('tbl_penjualan_detail');

        // Filter berdasarkan bulan dan tahun jika ada
        if ($bulan) {
            $this->db->where('MONTH(tanggal)', $bulan);
        }
        if ($tahun) {
            $this->db->where('YEAR(tanggal)', $tahun);
        }

        // Jalankan query
        return $this->db->get()->result_array();
    }

    // Ambil data dengan status klasifikasi
    // public function getPenjualanWithClassification()
    // {
    //     // Hitung rata-rata jumlah terjual
    //     $avg_terjual = $this->getAverageTerjual();

    //     // Query untuk data penjualan dengan CASE WHEN
    //     $query = $this->db->query("
    //     SELECT 
    //         id, 
    //         kode_produk, 
    //         nama_brand, 
    //         qty, 
    //         total_harga, 
    //         tanggal,
    //         CASE 
    //             WHEN qty > $avg_terjual THEN 'Laris'
    //             ELSE 'Tidak Laris'
    //         END as status_popularitas
    //     FROM tbl_penjualan_detail
    // ");

    //     return $query->result_array();
    // }
}

/* End of file KemungkinanModel.php */
