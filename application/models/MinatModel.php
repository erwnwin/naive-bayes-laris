<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MinatModel extends CI_Model
{
    public function getUniqueBrands()
    {
        $this->db->select('DISTINCT(nama_brand) as nama_brand');
        $this->db->from('tbl_penjualan_detail');
        $this->db->order_by('nama_brand', 'ASC'); // Mengurutkan alfabetis
        return $this->db->get()->result_array();
    }


    public function getAverageTerjual()
    {
        $this->db->select_avg('qty', 'avg_qty');
        $result = $this->db->get('tbl_penjualan_detail')->row_array();
        return $result['avg_qty'];
    }

    public function calculateInterestLikelihood($start_date, $end_date)
    {
        // Contoh: Hitung rata-rata qty
        $avg_qty = $this->getAverageTerjual();

        $this->db->select("
        nama_brand,
        SUM(CASE WHEN qty > $avg_qty * 1.5 THEN 1 ELSE 0 END) as minat_tinggi,
        SUM(CASE WHEN qty BETWEEN $avg_qty * 0.5 AND $avg_qty * 1.5 THEN 1 ELSE 0 END) as minat_sedang,
        SUM(CASE WHEN qty < $avg_qty * 0.5 THEN 1 ELSE 0 END) as minat_rendah
    ");
        $this->db->where('tanggal >=', $start_date);
        $this->db->where('tanggal <=', $end_date);
        $this->db->group_by('nama_brand');
        $result = $this->db->get('tbl_penjualan_detail')->result_array();

        $likelihood = [];
        foreach ($result as $row) {
            $likelihood[$row['nama_brand']] = [
                'Minat Tinggi' => $row['minat_tinggi'],
                'Minat Sedang' => $row['minat_sedang'],
                'Minat Rendah' => $row['minat_rendah']
            ];
        }

        return $likelihood;
    }


    public function calculateInterestPrior($start_date, $end_date)
    {
        // Contoh: Hitung rata-rata qty
        $avg_qty = $this->getAverageTerjual();

        $this->db->select("
        SUM(CASE WHEN qty > $avg_qty * 1.5 THEN 1 ELSE 0 END) as minat_tinggi,
        SUM(CASE WHEN qty BETWEEN $avg_qty * 0.5 AND $avg_qty * 1.5 THEN 1 ELSE 0 END) as minat_sedang,
        SUM(CASE WHEN qty < $avg_qty * 0.5 THEN 1 ELSE 0 END) as minat_rendah
    ");
        $this->db->where('tanggal >=', $start_date);
        $this->db->where('tanggal <=', $end_date);
        $result = $this->db->get('tbl_penjualan_detail')->row_array();

        $total = $result['minat_tinggi'] + $result['minat_sedang'] + $result['minat_rendah'];

        return [
            'Minat Tinggi' => $result['minat_tinggi'] / $total,
            'Minat Sedang' => $result['minat_sedang'] / $total,
            'Minat Rendah' => $result['minat_rendah'] / $total
        ];
    }
}

/* End of file MinatModel.php */
