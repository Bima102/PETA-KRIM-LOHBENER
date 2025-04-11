<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Wilayah extends Model
{
    protected $table = 'region';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'kecamatan_id', 'kelurahan_id', 'nrp', 'nama_daerah', 'latitude', 'longitude', 'jenis_kejahatan', 'gambar'
    ];
    protected $returnType = 'App\Entities\Wilayah';
    protected $useTimeStamp = false;

    public function get_data_kecamatan()
    {
        return $this->db->table('kecamatan')
            ->select('*')
            ->orderBy('nama', 'asc')
            ->get();
    }

    public function get_data_kelurahan()
    {
        return $this->db->table('kelurahan')
            ->select('*')
            ->orderBy('nama', 'asc')
            ->get();
    }

    public function get_wilayah($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }
}
