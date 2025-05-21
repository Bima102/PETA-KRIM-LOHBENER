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
        $this->builder->select('maps.nama_daerah, maps.kelurahan AS kelnama, maps.jenis_kejahatan, maps.latitude, maps.longitude, maps.gambar');
        // Hapus join dengan kecamatan dan kelurahan, gunakan kolom kelurahan langsung
        // Hapus filter kecamatan_id

        $query = $this->builder->get();

        $data = [
            'title'        => 'Peta Wilayah Rawan',
            'dataWilayah'  => $query->getResult()
        ];

        return view('maps/maps', $data);
    }
}