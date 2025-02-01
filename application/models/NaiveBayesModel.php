<?php

defined('BASEPATH') or exit('No direct script access allowed');

class NaiveBayesModel extends CI_Model
{

    // Ambil data training dari database
    public function get_training_data()
    {
        $query = $this->db->get('tbl_penjualan_detail');
        return $query->result_array();
    }

    // Encoding data kategorikal
    private function encode_data($data)
    {
        $encoded_data = [];
        foreach ($data as $row) {
            $encoded_data[] = [
                'kode_produk' => $row['kode_produk'],
                'nama_brand' => $row['nama_brand'],
                'harga_brand' => $row['harga_brand'],
                'qty' => $row['qty'],
                'total_harga' => $row['total_harga'],
                'tanggal' => $this->encode_tanggal($row['tanggal']),
                'laris' => $this->is_laris($row['qty']), // Kriteria laris
            ];
        }
        return $encoded_data;
    }

    // Encoding tanggal (misalnya, hari dalam seminggu)
    private function encode_tanggal($tanggal)
    {
        return date('N', strtotime($tanggal)); // 1 (Senin) sampai 7 (Minggu)
    }

    // Kriteria laris: jika qty >= 10, maka laris
    private function is_laris($qty)
    {
        return $qty >= 10 ? 1 : 0; // 1 = Laris, 0 = Tidak Laris
    }

    // Hitung probabilitas prior
    private function calculate_prior($data_training)
    {
        $total_data = count($data_training);
        $total_laris = array_sum(array_column($data_training, 'laris'));
        $total_tidak_laris = $total_data - $total_laris;

        return [
            'laris' => $total_laris / $total_data,
            'tidak_laris' => $total_tidak_laris / $total_data,
        ];
    }

    // Hitung probabilitas likelihood
    private function calculate_likelihood($data_training, $feature, $value, $class)
    {
        $filtered_data = array_filter($data_training, function ($item) use ($feature, $value, $class) {
            return $item[$feature] == $value && $item['laris'] == $class;
        });

        $total_class = array_sum(array_column($data_training, 'laris')) == $class ?
            array_sum(array_column($data_training, 'laris')) :
            count($data_training) - array_sum(array_column($data_training, 'laris'));

        return count($filtered_data) / $total_class;
    }

    // Prediksi
    public function predict($kode_produk, $nama_brand, $harga_brand, $qty, $total_harga, $tanggal)
    {
        // Ambil data training dari database
        $data_training = $this->get_training_data();

        // Encode data training
        $encoded_data = $this->encode_data($data_training);

        // Hitung probabilitas prior
        $prior = $this->calculate_prior($encoded_data);

        // Encode input
        $tanggal_encoded = $this->encode_tanggal($tanggal);

        // Hitung probabilitas likelihood untuk "Laris"
        $likelihood_laris = [
            'kode_produk' => $this->calculate_likelihood($encoded_data, 'kode_produk', $kode_produk, 1),
            'nama_brand' => $this->calculate_likelihood($encoded_data, 'nama_brand', $nama_brand, 1),
            'harga_brand' => $this->calculate_likelihood($encoded_data, 'harga_brand', $harga_brand, 1),
            'qty' => $this->calculate_likelihood($encoded_data, 'qty', $qty, 1),
            'total_harga' => $this->calculate_likelihood($encoded_data, 'total_harga', $total_harga, 1),
            'tanggal' => $this->calculate_likelihood($encoded_data, 'tanggal', $tanggal_encoded, 1),
        ];

        // Hitung probabilitas likelihood untuk "Tidak Laris"
        $likelihood_tidak_laris = [
            'kode_produk' => $this->calculate_likelihood($encoded_data, 'kode_produk', $kode_produk, 0),
            'nama_brand' => $this->calculate_likelihood($encoded_data, 'nama_brand', $nama_brand, 0),
            'harga_brand' => $this->calculate_likelihood($encoded_data, 'harga_brand', $harga_brand, 0),
            'qty' => $this->calculate_likelihood($encoded_data, 'qty', $qty, 0),
            'total_harga' => $this->calculate_likelihood($encoded_data, 'total_harga', $total_harga, 0),
            'tanggal' => $this->calculate_likelihood($encoded_data, 'tanggal', $tanggal_encoded, 0),
        ];

        // Hitung probabilitas posterior untuk "Laris"
        $posterior_laris = $prior['laris'] *
            $likelihood_laris['kode_produk'] *
            $likelihood_laris['nama_brand'] *
            $likelihood_laris['harga_brand'] *
            $likelihood_laris['qty'] *
            $likelihood_laris['total_harga'] *
            $likelihood_laris['tanggal'];

        // Hitung probabilitas posterior untuk "Tidak Laris"
        $posterior_tidak_laris = $prior['tidak_laris'] *
            $likelihood_tidak_laris['kode_produk'] *
            $likelihood_tidak_laris['nama_brand'] *
            $likelihood_tidak_laris['harga_brand'] *
            $likelihood_tidak_laris['qty'] *
            $likelihood_tidak_laris['total_harga'] *
            $likelihood_tidak_laris['tanggal'];

        // Bandingkan probabilitas posterior
        if ($posterior_laris > $posterior_tidak_laris) {
            return "Laris";
        } else {
            return "Tidak Laris";
        }
    }
}

/* End of file NaiveBayesModel.php */
