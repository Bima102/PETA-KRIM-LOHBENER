<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['title'] = 'Wilayah';
        return view('login', $data);
    }

    public function halaman_utama()
    {
        $data = [
            'title' => 'Halaman Utama'
        ];
        echo view('templates/header', $data);
        echo view('index');
        echo view('templates/footer');
    }

    public function informasi()
    {
        $data = [
            'title' => 'Informasi Jenis Kejahatan'
        ];
        echo view('templates/header', $data);
        echo view('informasi');
    }
}
