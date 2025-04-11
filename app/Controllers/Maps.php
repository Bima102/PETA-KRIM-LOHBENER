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
        $this->builder->select('region.nama_daerah, kecamatan.nama as kecnama,
            kelurahan.nama as kelnama, region.jenis_kejahatan, region.latitude, 
            region.longitude, region.gambar'); 

        $this->builder->join('kecamatan', 'kecamatan.kecamatan_id = region.kecamatan_id');
        $this->builder->join('kelurahan', 'kelurahan.kelurahan_id = region.kelurahan_id');

        $query = $this->builder->get();

        $data = [
            'title' => 'Peta Wilayah Rawan',
            'dataWilayah' => $query->getResult()
        ];

        return view('maps/maps', $data);
    }
}
