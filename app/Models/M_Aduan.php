<?php

namespace App\Models;
use CodeIgniter\Model;

class M_Aduan extends Model
{
    protected $table = 'aduan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'jenis_kejahatan',
        'kelurahan',
        'daerah',
        'latitude',
        'longitude',
        'pelapor',
        'created_at' 
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
}
