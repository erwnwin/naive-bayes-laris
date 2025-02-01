<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PredictModel extends CI_Model
{
    // Hitung rata-rata jumlah terjual
    public function getAverageTerjual()
    {
        $this->db->select_avg('qty', 'avg_qty');
        $result = $this->db->get('tbl_penjualan_detail')->row_array();
        return $result['avg_qty'];
    }

    // Hitung probabilitas prior
    public function calculatePrior($start_date, $end_date)
    {
        $avg_qty = $this->getAverageTerjual();

        // Hitung prior per brand
        $this->db->select("
            nama_brand,
            SUM(CASE WHEN qty > $avg_qty THEN 1 ELSE 0 END) as laris,
            SUM(CASE WHEN qty <= $avg_qty THEN 1 ELSE 0 END) as tidak_laris
        ");
        $this->db->where('tanggal >=', $start_date);
        $this->db->where('tanggal <=', $end_date);
        $this->db->group_by('nama_brand');
        $result = $this->db->get('tbl_penjualan_detail')->result_array();

        // Hitung prior untuk setiap brand
        $prior = [];
        foreach ($result as $row) {
            $total = $row['laris'] + $row['tidak_laris'];
            $prior[$row['nama_brand']] = [
                'Laris' => $total > 0 ? $row['laris'] / $total : 0,
                'Tidak Laris' => $total > 0 ? $row['tidak_laris'] / $total : 0
            ];
        }

        return $prior;
    }

    // Hitung likelihood
    public function calculateLikelihood($start_date, $end_date, $harga_brand, $qty)
    {
        $avg_qty = $this->getAverageTerjual();

        // Hitung likelihood untuk setiap fitur (qty dan harga_brand)
        $this->db->select("
            nama_brand,
            SUM(CASE WHEN qty > $avg_qty THEN 1 ELSE 0 END) as laris,
            SUM(CASE WHEN qty <= $avg_qty THEN 1 ELSE 0 END) as tidak_laris,
            AVG(harga_brand) as avg_harga,
            STDDEV(harga_brand) as std_harga,
            AVG(qty) as avg_qty,
            STDDEV(qty) as std_qty
        ");
        $this->db->where('tanggal >=', $start_date);
        $this->db->where('tanggal <=', $end_date);
        $this->db->group_by('nama_brand');
        $result = $this->db->get('tbl_penjualan_detail')->result_array();

        $likelihood = [];
        foreach ($result as $row) {
            $total_laris = $row['laris'];
            $total_tidak_laris = $row['tidak_laris'];

            // Hitung likelihood untuk qty dan harga_brand
            $likelihood[$row['nama_brand']] = [
                'Laris' => [
                    'qty' => $this->gaussianProbability($row['avg_qty'], $row['std_qty'], $qty),
                    'harga' => $this->gaussianProbability($row['avg_harga'], $row['std_harga'], $harga_brand)
                ],
                'Tidak Laris' => [
                    'qty' => $this->gaussianProbability($row['avg_qty'], $row['std_qty'], $qty),
                    'harga' => $this->gaussianProbability($row['avg_harga'], $row['std_harga'], $harga_brand)
                ]
            ];
        }

        return $likelihood;
    }

    // Fungsi untuk menghitung probabilitas Gaussian
    private function gaussianProbability($mean, $stddev, $x)
    {
        // Jika stddev = 0, kembalikan nilai default
        if ($stddev == 0) {
            return 0; // Atau kembalikan 1 jika Anda ingin mengabaikan fitur ini
        }
        $exponent = exp(-pow($x - $mean, 2) / (2 * pow($stddev, 2)));
        return (1 / (sqrt(2 * M_PI) * $stddev)) * $exponent;
    }

    // Prediksi menggunakan Naive Bayes
    // Prediksi menggunakan Naive Bayes
    public function predict($nama_brand, $qty, $harga_brand, $start_date, $end_date)
    {
        // Hitung prior probability
        $prior = $this->calculatePrior($start_date, $end_date);

        // Hitung likelihood (dengan meneruskan $harga_brand dan $qty sebagai parameter)
        $likelihood = $this->calculateLikelihood($start_date, $end_date, $harga_brand, $qty);

        // Pastikan brand ada dalam data
        if (!isset($prior[$nama_brand]) || !isset($likelihood[$nama_brand])) {
            return "Brand tidak ditemukan dalam data.";
        }

        // Ambil prior dan likelihood untuk brand yang dimaksud
        $prior_laris = $prior[$nama_brand]['Laris'];
        $prior_tidak_laris = $prior[$nama_brand]['Tidak Laris'];

        $likelihood_laris = $likelihood[$nama_brand]['Laris'];
        $likelihood_tidak_laris = $likelihood[$nama_brand]['Tidak Laris'];

        // Hitung posterior probability untuk "Laris"
        $posterior_laris = $prior_laris * $likelihood_laris['qty'] * $likelihood_laris['harga'];

        // Hitung posterior probability untuk "Tidak Laris"
        $posterior_tidak_laris = $prior_tidak_laris * $likelihood_tidak_laris['qty'] * $likelihood_tidak_laris['harga'];

        // Hitung total posterior
        $total_posterior = $posterior_laris + $posterior_tidak_laris;

        // Jika total_posterior = 0, berikan nilai default
        if ($total_posterior == 0) {
            $posterior_laris_normalized = 0.5; // Default: 50%
            $posterior_tidak_laris_normalized = 0.5; // Default: 50%
        } else {
            // Normalisasi posterior probability
            $posterior_laris_normalized = $posterior_laris / $total_posterior;
            $posterior_tidak_laris_normalized = $posterior_tidak_laris / $total_posterior;
        }

        // Prediksi kelas
        if ($posterior_laris_normalized > $posterior_tidak_laris_normalized) {
            return "Laris";
        } else {
            return "Tidak Laris";
        }
    }
}
