<?php

namespace App\Controllers;

class Maps extends BaseController
{
    protected $builder, $db;

    public function __construct()
    {
        helper('form');
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('region');
    }

    public function index()
    {
        // Ambil data dari tabel yang masih relevan
        $this->builder->select('region.nama_daerah, kecamatan.nama as kecnama,
            kelurahan.nama as kelnama, region.deskripsi, region.latitude, 
            region.longitude, region.gambar');

        $this->builder->join('kecamatan', 'kecamatan.kecamatan_id = region.kecamatan_id');
        $this->builder->join('kelurahan', 'kelurahan.kelurahan_id = region.kelurahan_id');

        $query = $this->builder->get();

        $data = [
            'title' => 'Maps',
            'dataWilayah' => $query->getResult(),
        ];

        // Tampilkan hanya header dan halaman maps, tanpa footer
        echo view('users/templates/header', $data);
        echo view('maps/v_maps', $data);
    }
}
