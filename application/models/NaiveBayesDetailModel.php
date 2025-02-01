<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NaiveBayesDetailModel extends CI_Model
{
    // Ambil data transaksi berdasarkan nama_brand dan range tanggal
    public function get_transactions_by_brand($nama_brand, $tanggal_awal, $tanggal_akhir)
    {
        $this->db->where('nama_brand', $nama_brand);
        $this->db->where('tanggal >=', $tanggal_awal);
        $this->db->where('tanggal <=', $tanggal_akhir);
        return $this->db->get('tbl_penjualan_detail')->result_array();
    }

    // Hitung jumlah transaksi laris dan tidak laris
    public function count_laris_tidak_laris($transactions)
    {
        $laris = 0;
        $tidak_laris = 0;

        foreach ($transactions as $transaction) {
            if ($transaction['qty'] >= 10) {
                $laris++;
            } else {
                $tidak_laris++;
            }
        }

        return [
            'laris' => $laris,
            'tidak_laris' => $tidak_laris,
        ];
    }

    // Hitung probabilitas prior
    public function calculate_prior($laris, $tidak_laris, $total_transactions)
    {
        // Pastikan total_transactions tidak nol
        if ($total_transactions == 0) {
            return [
                'prior_laris' => 0,
                'prior_tidak_laris' => 0,
            ];
        }

        return [
            'prior_laris' => $laris / $total_transactions,
            'prior_tidak_laris' => $tidak_laris / $total_transactions,
        ];
    }

    // Hitung probabilitas likelihood
    public function calculate_likelihood($transactions, $feature, $value, $class)
    {
        // Hitung total transaksi untuk kelas tertentu (laris atau tidak laris)
        $total_class = array_sum(array_map(function ($item) use ($class) {
            return ($item['qty'] >= 10 ? 1 : 0) == $class ? 1 : 0;
        }, $transactions));

        // Jika tidak ada transaksi untuk kelas tertentu, kembalikan 0
        if ($total_class == 0) {
            return 0;
        }

        // Hitung jumlah transaksi dengan fitur tertentu dan kelas tertentu
        $filtered_data = array_filter($transactions, function ($item) use ($feature, $value, $class) {
            return $item[$feature] == $value && ($item['qty'] >= 10 ? 1 : 0) == $class;
        });

        return count($filtered_data) / $total_class;
    }
}
