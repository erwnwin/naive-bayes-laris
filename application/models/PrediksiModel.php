<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PrediksiModel extends CI_Model
{
    // Cache untuk menyimpan hasil perhitungan
    private $prior_cache = [];
    private $likelihood_cache = [];

    // Hitung rata-rata jumlah terjual
    public function getAverageTerjual()
    {
        $this->db->select_avg('qty', 'avg_qty');
        $result = $this->db->get('tbl_penjualan_detail')->row_array();
        return $result['avg_qty'];
    }

    // Hitung probabilitas prior berdasarkan rentang tanggal
    public function calculatePrior($start_date, $end_date)
    {
        $cache_key = $start_date . '_' . $end_date;
        if (isset($this->prior_cache[$cache_key])) {
            return $this->prior_cache[$cache_key];
        }

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

        // Simpan hasil ke cache
        $this->prior_cache[$cache_key] = $prior;
        return $prior;
    }

    // Hitung likelihood per nama_brand berdasarkan data penjualan di rentang tanggal
    public function calculateLikelihood($start_date, $end_date)
    {
        $cache_key = $start_date . '_' . $end_date;
        if (isset($this->likelihood_cache[$cache_key])) {
            return $this->likelihood_cache[$cache_key];
        }

        $avg_qty = $this->getAverageTerjual();

        // Hitung likelihood per brand untuk qty dan harga
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
            $likelihood[$row['nama_brand']] = [
                'Laris' => [
                    'qty' => $this->gaussianProbability($row['avg_qty'], $row['std_qty']),
                    'harga' => $this->gaussianProbability($row['avg_harga'], $row['std_harga']),
                ],
                'Tidak Laris' => [
                    'qty' => $this->gaussianProbability($row['avg_qty'], $row['std_qty']),
                    'harga' => $this->gaussianProbability($row['avg_harga'], $row['std_harga']),
                ]
            ];
        }

        // Simpan hasil ke cache
        $this->likelihood_cache[$cache_key] = $likelihood;
        return $likelihood;
    }

    // Fungsi untuk menghitung probabilitas Gaussian
    private function gaussianProbability($mean, $stddev)
    {
        if ($stddev == 0) {
            return 0; // Kembalikan 0 jika standar deviasi nol
        }
        $exponent = exp(-pow($mean, 2) / (2 * pow($stddev, 2)));
        return (1 / (sqrt(2 * M_PI) * $stddev)) * $exponent;
    }

    // Prediksi menggunakan Naive Bayes
    public function predict($nama_brand, $qty, $harga_brand, $start_date, $end_date)
    {
        // Normalisasi qty dan harga_brand
        $normalized_qty = $this->normalize($qty, 'qty', $start_date, $end_date);
        $normalized_harga = $this->normalize($harga_brand, 'harga_brand', $start_date, $end_date);

        // Hitung prior dan likelihood
        $prior = $this->calculatePrior($start_date, $end_date);
        $likelihood = $this->calculateLikelihood($start_date, $end_date);

        if (!isset($prior[$nama_brand]) || !isset($likelihood[$nama_brand])) {
            return 'Data tidak ditemukan untuk brand ini.';
        }

        // Hitung posterior untuk Laris
        $laris_posterior = $prior[$nama_brand]['Laris'] *
            ($likelihood[$nama_brand]['Laris']['qty'] * $this->gaussianProbability($normalized_qty, $likelihood[$nama_brand]['Laris']['qty'])) *
            ($likelihood[$nama_brand]['Laris']['harga'] * $this->gaussianProbability($normalized_harga, $likelihood[$nama_brand]['Laris']['harga']));

        // Hitung posterior untuk Tidak Laris
        $tidak_laris_posterior = $prior[$nama_brand]['Tidak Laris'] *
            ($likelihood[$nama_brand]['Tidak Laris']['qty'] * $this->gaussianProbability($normalized_qty, $likelihood[$nama_brand]['Tidak Laris']['qty'])) *
            ($likelihood[$nama_brand]['Tidak Laris']['harga'] * $this->gaussianProbability($normalized_harga, $likelihood[$nama_brand]['Tidak Laris']['harga']));

        // Bandingkan probabilitas posterior
        if ($laris_posterior > $tidak_laris_posterior) {
            return 'Laris';
        } else {
            return 'Tidak Laris';
        }
    }

    // Normalisasi data
    private function normalize($value, $column, $start_date, $end_date)
    {
        $this->db->select("AVG($column) as avg, STDDEV($column) as std");
        $this->db->where('tanggal >=', $start_date);
        $this->db->where('tanggal <=', $end_date);
        $result = $this->db->get('tbl_penjualan_detail')->row_array();

        if ($result['std'] == 0) {
            return 0; // Kembalikan 0 jika standar deviasi nol
        }

        return ($value - $result['avg']) / $result['std'];
    }
}
