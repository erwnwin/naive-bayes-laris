<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('get_initials')) {
    function get_initials($name)
    {
        $words = explode(' ', $name); // Pisahkan nama berdasarkan spasi
        $initials = strtoupper(substr($words[0], 0, 1)); // Ambil huruf pertama dari nama depan

        // Jika ada lebih dari satu kata, ambil huruf pertama dari kata kedua (untuk inisial)
        if (count($words) > 1) {
            $initials .= strtoupper(substr($words[1], 0, 1)); // Ambil huruf pertama dari nama belakang
        }

        // Jika hanya satu suku kata, gandakan inisial pertama
        if (count($words) == 1) {
            $initials .= $initials; // Gandakan inisial nama depan
        }

        return $initials; // Kembalikan inisial yang sudah diubah menjadi kapital
    }
}
