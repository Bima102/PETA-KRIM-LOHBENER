<?php

namespace App\Controllers;

use App\Models\M_Wilayah;

class Statistik extends BaseController
{
    protected $wilayahModel;

    public function __construct()
    {
        $this->wilayahModel = new M_Wilayah();
    }

    public function index() 
    {
        $data = [
            'title' => 'Statistik Kejahatan',
            'statistik' => $this->wilayahModel->getStatistikKejahatan(),
            'rankingData' => $this->wilayahModel->getRankingWilayah()
        ];
    
        echo view('templates/header', $data); 
        echo view('wilayah/statistik'); 
    }    
}