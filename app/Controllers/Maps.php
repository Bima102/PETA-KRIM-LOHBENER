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
        $this->builder->select('maps.nama_daerah, kecamatan.nama as kecnama,
            kelurahan.nama as kelnama, maps.jenis_kejahatan, maps.latitude, 
            maps.longitude, maps.gambar'); 

        $this->builder->join('kecamatan', 'kecamatan.kecamatan_id = maps.kecamatan_id');
        $this->builder->join('kelurahan', 'kelurahan.kelurahan_id = maps.kelurahan_id');

        $query = $this->builder->get();

        $data = [
            'title' => 'Peta Wilayah Rawan',
            'dataWilayah' => $query->getResult()
        ];

        return view('maps/maps', $data);
    }
}
