<?php

namespace App\Controllers;

// Deklarasi kelas Maps yang merupakan turunan dari BaseController
class Maps extends BaseController
{
    // Properti untuk menyimpan objek builder dan koneksi database
    protected $builder, $db;

    // Konstruktor untuk inisialisasi kelas
    public function __construct()
    {
        // Memuat helper 'form' untuk keperluan form handling
        helper('form');
        
        // Membuat koneksi ke database menggunakan konfigurasi default
        $this->db = \Config\Database::connect();
        
        // Menginisialisasi builder untuk tabel 'maps'
        $this->builder = $this->db->table('maps');
    }

    // Fungsi untuk menampilkan data peta wilayah rawan
    public function index()
    {
        // Memilih kolom yang akan diambil dari tabel 'maps'
        $this->builder->select('maps.nama_daerah, maps.kelurahan AS kelnama, maps.jenis_kejahatan, maps.latitude, maps.longitude, maps.gambar, maps.status');
        
        // Menambahkan kondisi untuk hanya mengambil data dengan status 'diterima'
        $this->builder->where('maps.status', 'diterima');
        
        // Menjalankan query untuk mendapatkan hasil
        $query = $this->builder->get();
        
        // Menyusun data yang akan dikirim ke view
        $data = [
            'title'        => 'Peta Wilayah Rawan', // Judul halaman
            'dataWilayah'  => $query->getResult()   // Hasil query dalam bentuk array objek
        ];
        
        // Mencatat data yang dikirim ke view untuk keperluan debugging
        log_message('debug', 'Data Wilayah dikirim ke view: ' . print_r($data['dataWilayah'], true));
        
        // Mengembalikan view 'maps/maps' dengan data yang telah disiapkan
        return view('maps/maps', $data);
    }
}