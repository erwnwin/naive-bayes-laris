<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aturan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Memuat database
    }

    // Fungsi untuk mengambil semua aturan yang ada
    public function get_all_aturan()
    {
        $this->db->select('*');
        $this->db->from('aturan');
        $query = $this->db->get();
        return $query->result_array(); // Mengembalikan hasil sebagai array
    }

    // Fungsi untuk menambahkan aturan baru
    public function insert_aturan($data)
    {
        return $this->db->insert('aturan', $data);
    }

    // Fungsi untuk mengupdate aturan berdasarkan ID
    public function update_aturan($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('aturan', $data);
    }

    // Fungsi untuk menghapus aturan berdasarkan ID
    public function delete_aturan($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('aturan');
    }
}
