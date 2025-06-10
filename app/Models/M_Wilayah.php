<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Wilayah extends Model
{
    protected $table = 'maps';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'nama_daerah', 'kelurahan',
        'latitude', 'longitude', 'jenis_kejahatan', 'gambar', 'status', 'created_at'
    ];
    protected $returnType = 'App\Entities\Wilayah';
    protected $useTimestamps = false;

    public function getKelurahanEnum()
    {
        $query = $this->db->query("SHOW COLUMNS FROM maps LIKE 'kelurahan'");
        $row = $query->getRow();
        preg_match_all("/'([^']+)'/", $row->Type, $matches);
        return $matches[1];
    }

    // Tambahkan metode untuk mendapatkan enum jenis_kejahatan (opsional)
    public function getJenisKejahatanEnum()
    {
        $query = $this->db->query("SHOW COLUMNS FROM maps LIKE 'jenis_kejahatan'");
        $row = $query->getRow();
        preg_match_all("/'([^']+)'/", $row->Type, $matches);
        return $matches[1];
    }
    
    public function get_wilayah($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }
        return $this->where('id', $id)->first();
    }

    public function getStatistikKejahatan($tahun = null, $bulan = null, $jenis = null)
    {
        $builder = $this->db->table('maps');
        $builder->select('jenis_kejahatan, COUNT(*) as total')
            ->where('status', 'diterima')
            ->groupBy('jenis_kejahatan')
            ->orderBy('total', 'DESC');

        if ($tahun) {
            $builder->where('YEAR(created_at)', $tahun);
            if ($bulan) {
                $builder->where('MONTH(created_at)', $bulan);
            }
        } elseif ($bulan) {
            $builder->where('MONTH(created_at)', $bulan)
                ->where('YEAR(created_at)', date('Y'));
        }

        if ($jenis) {
            $builder->where('jenis_kejahatan', $jenis);
        }

        return $builder->get()->getResult();
    }

    public function getRankingWilayah($tahun = null, $bulan = null, $jenis = null)
    {
        $builder = $this->db->table('maps');
        $builder->select('nama_daerah as wilayah, jenis_kejahatan, COUNT(*) as total')
            ->where('status', 'diterima')
            ->groupBy('nama_daerah, jenis_kejahatan')
            ->orderBy('total', 'DESC');

        if ($tahun) {
            $builder->where('YEAR(created_at)', $tahun);
            if ($bulan) {
                $builder->where('MONTH(created_at)', $bulan);
            }
        } elseif ($bulan) {
            $builder->where('MONTH(created_at)', $bulan)
                ->where('YEAR(created_at)', date('Y'));
        }

        if ($jenis) {
            $builder->where('jenis_kejahatan', $jenis);
        }

        return $builder->get()->getResult();
    }

    public function get_pending_laporan()
    {
        return $this->db->table('maps')
            ->select('maps.*')
            ->where('maps.status', 'pending')
            ->get();
    }
}