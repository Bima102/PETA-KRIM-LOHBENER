<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Wilayah extends Model
{
    protected $table = 'maps';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'nama_daerah', 'kelurahan', // Hapus kecamatan_id dan kelurahan_id
        'latitude', 'longitude', 'jenis_kejahatan', 'gambar', 'status'
    ];
    protected $returnType = 'App\Entities\Wilayah';
    protected $useTimestamps = false;

    // Hapus fungsi get_data_kecamatan karena tabel kecamatan sudah dihapus
    // public function get_data_kecamatan() { ... }

    // Hapus fungsi get_data_kelurahan karena tabel kelurahan sudah dihapus
    // public function get_data_kelurahan() { ... }

    // Fungsi baru untuk mengambil daftar nilai enum dari kolom kelurahan
    public function getKelurahanEnum()
    {
        $query = $this->db->query("SHOW COLUMNS FROM maps LIKE 'kelurahan'");
        $row = $query->getRow();
        // Ambil daftar enum dari hasil query
        preg_match_all("/'([^']+)'/", $row->Type, $matches);
        return $matches[1]; // Daftar nilai enum: ['Bojongslawi', 'Kiajaran Kulon', ...]
    }

    // Ambil data wilayah, bisa all atau by ID
    public function get_wilayah($id = false)
    {
        if ($id === false) {
            return $this->findAll(); // Hapus filter kecamatan_id
        }

        return $this->where('id', $id)->first(); // Hapus filter kecamatan_id
    }

    // Statistik jumlah kejahatan berdasarkan jenis
    public function getStatistikKejahatan()
    {
        return $this->select('jenis_kejahatan, COUNT(*) as total')
            ->groupBy('jenis_kejahatan')
            ->orderBy('total', 'DESC')
            ->findAll(); // Hapus filter kecamatan_id
    }

    // Ranking wilayah rawan berdasarkan jumlah kejahatan per nama daerah
    public function getRankingWilayah()
    {
        return $this->select('nama_daerah as wilayah, jenis_kejahatan, COUNT(*) as total')
            ->groupBy('nama_daerah, jenis_kejahatan')
            ->orderBy('total', 'DESC')
            ->findAll(); // Hapus filter kecamatan_id
    }

    public function get_pending_laporan()
    {
        return $this->db->table('maps')
            ->select('maps.*') // Hapus join dengan kecamatan dan kelurahan
            ->where('maps.status', 'pending')
            ->get();
    }
}