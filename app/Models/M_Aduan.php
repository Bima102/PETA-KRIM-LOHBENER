<?php

namespace App\Models;
use CodeIgniter\Model;

class M_Aduan extends Model
{
    protected $table = 'aduan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['jenis_kejahatan', 'kecamatan', 'kelurahan', 'daerah', 'pelapor'];
}
