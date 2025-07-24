<?php

namespace App\Controllers;

class Maps extends BaseController
{
    protected $builder, $db;

    public function __construct()
    {
        helper('form');
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('maps');
    }

    public function index()
    {
        // Memilih kolom yang akan diambil dari tabel 'maps'
        $this->builder->select('maps.nama_daerah, maps.kelurahan AS kelnama, maps.jenis_kejahatan, maps.latitude, maps.longitude, maps.gambar, maps.status');
        
        // Mengambil data dengan status 'Selesai' (atau bisa ditambahkan 'Diproses' jika diinginkan)
        $this->builder->whereIn('maps.status', ['Selesai']); // Ubah dari 'diterima' ke 'Selesai'
        
        // Menjalankan query untuk mendapatkan hasil
        $query = $this->builder->get();
        $dataWilayah = $query->getResult();

        // Menyusun data yang akan dikirim ke view
        $data = [
            'title'       => 'Peta Wilayah Rawan',
            'dataWilayah' => $dataWilayah
        ];
        
        // Mencatat data yang dikirim ke view untuk debugging
        log_message('debug', 'Data Wilayah dikirim ke view: ' . print_r($data['dataWilayah'], true));
        
        // Mengembalikan view 'maps/maps'
        return view('maps/maps', $data);
    }
}