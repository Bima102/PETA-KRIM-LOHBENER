<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Wilayah extends Model
{
    protected $table = 'maps';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'kecamatan_id', 'kelurahan_id', 'nrp', 'nama_daerah',
        'latitude', 'longitude', 'jenis_kejahatan', 'gambar'
    ];
    protected $returnType = 'App\Entities\Wilayah';
    protected $useTimestamps = false;

    // Ambil semua data kecamatan, bisa dibatasi langsung Lohbener jika ingin hardcoded
    public function get_data_kecamatan()
    {
        return $this->db->table('kecamatan')
            ->select('*')
            ->where('kecamatan_id', 101) // khusus Lohbener
            ->orderBy('nama', 'asc')
            ->get();
    }

    // Ambil kelurahan yang hanya berada di Kecamatan Lohbener (jika relasinya tersedia)
    public function get_data_kelurahan()
    {
        return $this->db->table('kelurahan')
            ->select('*')
            ->where('kecamatan_id', 101) // hanya kelurahan di Lohbener
            ->orderBy('nama', 'asc')
            ->get();
    }

    // Ambil data wilayah, bisa all atau by ID
    public function get_wilayah($id = false)
    {
        if ($id === false) {
            return $this->where('kecamatan_id', 101)->findAll();
        }

        return $this->where([
            'id' => $id,
            'kecamatan_id' => 101 // pastikan hanya data Lohbener
        ])->first();
    }

    // Statistik jumlah kejahatan berdasarkan jenis
    public function getStatistikKejahatan()
    {
        return $this->select('jenis_kejahatan, COUNT(*) as total')
            ->where('kecamatan_id', 101)
            ->groupBy('jenis_kejahatan')
            ->orderBy('total', 'DESC')
            ->findAll();
    }

    // Ranking wilayah rawan berdasarkan jumlah kejahatan per nama daerah
    public function getRankingWilayah()
    {
        return $this->select('nama_daerah as wilayah, jenis_kejahatan, COUNT(*) as total')
            ->where('kecamatan_id', 101)
            ->groupBy('nama_daerah, jenis_kejahatan')
            ->orderBy('total', 'DESC')
            ->findAll();
    }

    public function get_pending_laporan()
    {
        return $this->db->table('maps')
            ->select('maps.*, kecamatan.nama as kecnama, kelurahan.nama as kelnama')
            ->join('kecamatan', 'kecamatan.kecamatan_id = maps.kecamatan_id')
            ->join('kelurahan', 'kelurahan.kelurahan_id = maps.kelurahan_id')
            ->where('maps.status', 'pending')
            ->get();
    }

}
