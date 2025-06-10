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
        $this->builder->select('maps.nama_daerah, maps.kelurahan AS kelnama, maps.jenis_kejahatan, maps.latitude, maps.longitude, maps.gambar, maps.status');
        $this->builder->where('maps.status', 'diterima'); // Filter hanya data diterima

        $query = $this->builder->get();

        $data = [
            'title'        => 'Peta Wilayah Rawan',
            'dataWilayah'  => $query->getResult()
        ];

        // Debugging: Log data yang dikirim ke view
        log_message('debug', 'Data Wilayah dikirim ke view: ' . print_r($data['dataWilayah'], true));

        return view('maps/maps', $data);
    }
}