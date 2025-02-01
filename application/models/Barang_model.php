<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Memuat database
    }

    // Fungsi untuk mengambil semua barang
    public function get_all_barang()
    {
        $this->db->select('*');
        $this->db->from('barang');
        $query = $this->db->get();
        return $query->result_array(); // Mengembalikan hasil sebagai array
    }


public function get_barang()
    {
        // Ambil semua data barang tanpa filter
        $this->db->select('*');
        $query = $this->db->get('barang');  // Pastikan tabelnya sesuai
        return $query->result();  // Mengembalikan data hasil query
    }

    // Fungsi untuk mengambil barang berdasarkan ID
    public function get_barang_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('barang');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array(); // Mengembalikan hasil sebagai array tunggal
    }

    // Fungsi untuk menambahkan barang baru
    public function insert_barang($data)
    {
        return $this->db->insert('barang', $data);
    }

    // Fungsi untuk mengupdate barang berdasarkan ID
    public function update_barang($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('barang', $data);
    }

    // Fungsi untuk menghapus barang berdasarkan ID
    public function delete_barang($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('barang');
    }

    // Fungsi untuk mendapatkan barang dengan label laris atau tidak laris
    public function get_barang_by_label($label)
    {
        $this->db->select('*');
        $this->db->from('barang');
        $this->db->where('label', $label);
        $query = $this->db->get();
        return $query->result_array(); // Mengembalikan hasil sebagai array
    }


    public function delete_multiple($ids)
    {
        $this->db->where_in('id', $ids);  // Memilih data berdasarkan ID
        $this->db->delete('barang');  // Hapus data dari tabel barang
    }


    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('barang');  // Hapus data berdasarkan ID
    }
}
