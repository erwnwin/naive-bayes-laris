<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DataSetModel extends CI_Model
{
    private $data = [
        ['Nama' => 'Produk1', 'Harga' => 'Tinggi', 'Musim' => 'Musim Dingin', 'Ukuran' => 'Besar', 'Warna' => 'Merah', 'Merek' => 'MerekA', 'Kategori' => 'Laris'],
        ['Nama' => 'Produk2', 'Harga' => 'Tinggi', 'Musim' => 'Musim Panas', 'Ukuran' => 'Sedang', 'Warna' => 'Hijau', 'Merek' => 'MerekB', 'Kategori' => 'Tidak Laris'],
        ['Nama' => 'Produk3', 'Harga' => 'Sedang', 'Musim' => 'Musim Dingin', 'Ukuran' => 'Sedang', 'Warna' => 'Biru', 'Merek' => 'MerekC', 'Kategori' => 'Kurang Laris'],
        ['Nama' => 'Produk4', 'Harga' => 'Sedang', 'Musim' => 'Musim Panas', 'Ukuran' => 'Besar', 'Warna' => 'Merah', 'Merek' => 'MerekA', 'Kategori' => 'Laris'],
        ['Nama' => 'Produk5', 'Harga' => 'Rendah', 'Musim' => 'Musim Dingin', 'Ukuran' => 'Kecil', 'Warna' => 'Putih', 'Merek' => 'MerekB', 'Kategori' => 'Tidak Laris'],
        ['Nama' => 'Produk6', 'Harga' => 'Rendah', 'Musim' => 'Musim Panas', 'Ukuran' => 'Sedang', 'Warna' => 'Biru', 'Merek' => 'MerekC', 'Kategori' => 'Kurang Laris'],
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function calculate_probabilities($features)
    {
        $categories = ['Laris', 'Kurang Laris', 'Tidak Laris'];
        $result = [];

        foreach ($categories as $category) {
            $prior_prob = $this->calculate_prior($category);
            $likelihood = 1;

            foreach ($features as $feature => $value) {
                $likelihood *= $this->calculate_likelihood($feature, $value, $category);
            }

            $posterior_prob = $prior_prob * $likelihood;

            $result[$category] = $posterior_prob;
        }

        return $result;
    }

    public function calculate_prior($category)
    {
        $total = count($this->data);
        $count = 0;

        foreach ($this->data as $row) {
            if ($row['Kategori'] == $category) {
                $count++;
            }
        }

        return $count / $total;
    }

    public function calculate_likelihood($feature, $value, $category)
    {
        $count_feature_category = 0;
        $count_value_feature_category = 0;

        foreach ($this->data as $row) {
            if ($row['Kategori'] == $category) {
                $count_feature_category++;
                if ($row[$feature] == $value) {
                    $count_value_feature_category++;
                }
            }
        }

        return ($count_value_feature_category + 1) / ($count_feature_category + 4); // Laplace smoothing
    }
}

/* End of file DataSetModel.php */
