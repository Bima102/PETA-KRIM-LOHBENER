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
        'created_at' // jika kamu ingin mengatur waktu saat data masuk
    ];

    protected $useTimestamps = true; // aktifkan jika kamu menggunakan kolom created_at
    protected $createdField  = 'created_at';
}
