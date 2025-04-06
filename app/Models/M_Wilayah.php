<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Wilayah extends Model
{
    protected $table = 'region';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'kecamatan_id', 'kelurahan_id', 'nrp', 'nama_daerah', 'latitude', 'longitude', 'deskripsi', 'gambar'
    ];
    protected $returnType = 'App\Entities\Wilayah';
    protected $useTimeStamp = false;

    // Ambil semua data kecamatan untuk dropdown, dll
    public function get_data_kecamatan()
    {
        return $this->db->table('kecamatan')
            ->select('*')
            ->orderBy('nama', 'asc')
            ->get();
    }

    // Ambil semua data kelurahan
    public function get_data_kelurahan()
    {
        return $this->db->table('kelurahan')
            ->select('*')
            ->orderBy('nama', 'asc')
            ->get();
    }

    // Mengambil data wilayah berdasarkan ID atau semua
    public function get_wilayah($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }

    // Fungsi pencarian berdasarkan nama daerah
    public function pencarian($keyword)
    {
        $builder = $this->builder();
        $builder->select('region.nama_daerah, kecamatan.nama as kecnama,
            kelurahan.nama as kelnama, region.deskripsi, region.latitude, region.longitude, 
            region.gambar, region.id');
        $builder->join('kecamatan', 'kecamatan.kecamatan_id = region.kecamatan_id');
        $builder->join('kelurahan', 'kelurahan.kelurahan_id = region.kelurahan_id');

        if (!empty($keyword)) {
            $builder->like('region.nama_daerah', $keyword);
        }

        return $builder->get()->getResult();
    }
}
