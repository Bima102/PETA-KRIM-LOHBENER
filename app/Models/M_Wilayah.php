<?php

namespace App\Models;

// Mengimpor kelas Model dari CodeIgniter untuk fungsi dasar model
use CodeIgniter\Model;

// Kelas M_Wilayah mewarisi Model untuk mengelola data wilayah
class M_Wilayah extends Model
{
    // Menentukan nama tabel di database
    protected $table = 'maps';

    // Menentukan kolom primary key
    protected $primaryKey = 'id';

    // Daftar kolom yang diizinkan untuk mass assignment
    protected $allowedFields = [
        'id',
        'nama_daerah',
        'kelurahan',
        'latitude',
        'longitude',
        'jenis_kejahatan',
        'gambar',
        'status',
        'created_at'
    ];

    // Menentukan tipe kembalian sebagai entitas Wilayah
    protected $returnType = 'App\Entities\Wilayah';

    // Menonaktifkan penggunaan timestamp otomatis
    protected $useTimestamps = false;

    // Fungsi getKelurahanEnum: Mengambil daftar nilai enum dari kolom kelurahan
    public function getKelurahanEnum()
    {
        // Menjalankan query untuk mendapatkan metadata kolom kelurahan
        $query = $this->db->query("SHOW COLUMNS FROM maps LIKE 'kelurahan'");

        // Mengambil baris hasil query
        $row = $query->getRow();

        // Mengekstrak nilai enum dari tipe kolom menggunakan regex
        preg_match_all("/'([^']+)'/", $row->Type, $matches);

        // Mengembalikan array nilai enum
        return $matches[1];
    }

    // Fungsi getJenisKejahatanEnum: Mengambil daftar nilai enum dari kolom jenis_kejahatan
    public function getJenisKejahatanEnum()
    {
        // Menjalankan query untuk mendapatkan metadata kolom jenis_kejahatan
        $query = $this->db->query("SHOW COLUMNS FROM maps LIKE 'jenis_kejahatan'");

        // Mengambil baris hasil query
        $row = $query->getRow();

        // Mengekstrak nilai enum dari tipe kolom menggunakan regex
        preg_match_all("/'([^']+)'/", $row->Type, $matches);

        // Mengembalikan array nilai enum
        return $matches[1];
    }

    // Fungsi get_wilayah: Mengambil data wilayah berdasarkan ID atau semua data
    public function get_wilayah($id = false)
    {
        // Jika ID tidak diberikan, mengambil semua data wilayah
        if ($id === false) {
            return $this->findAll();
        }

        // Jika ID diberikan, mengambil data wilayah berdasarkan ID
        return $this->where('id', $id)->first();
    }

    // Fungsi getStatistikKejahatan: Mengambil statistik kejahatan berdasarkan filter
    public function getStatistikKejahatan($tahun = null, $bulan = null, $jenis = null)
    {
        // Membuat query builder untuk tabel maps
        $builder = $this->db->table('maps');

        // Memilih kolom jenis_kejahatan dan menghitung total kejadian
        $builder->select('jenis_kejahatan, COUNT(*) as total')
                ->where('status', 'diterima') // Hanya data dengan status 'diterima'
                ->groupBy('jenis_kejahatan') // Mengelompokkan berdasarkan jenis kejahatan
                ->orderBy('total', 'DESC');  // Mengurutkan berdasarkan total, terbanyak ke terkecil

        // Filter berdasarkan tahun jika diberikan
        if ($tahun) {
            $builder->where('YEAR(created_at)', $tahun);

            // Filter berdasarkan bulan jika diberikan
            if ($bulan) {
                $builder->where('MONTH(created_at)', $bulan);
            }
        // Filter berdasarkan bulan dan tahun saat ini jika hanya bulan diberikan
        } elseif ($bulan) {
            $builder->where('MONTH(created_at)', $bulan)
                    ->where('YEAR(created_at)', date('Y'));
        }

        // Filter berdasarkan jenis kejahatan jika diberikan
        if ($jenis) {
            $builder->where('jenis_kejahatan', $jenis);
        }

        // Mengembalikan hasil query sebagai array
        return $builder->get()->getResult();
    }

    // Fungsi getRankingWilayah: Mengambil ranking wilayah berdasarkan jumlah kejahatan
    public function getRankingWilayah($tahun = null, $bulan = null, $jenis = null)
    {
        // Membuat query builder untuk tabel maps
        $builder = $this->db->table('maps');

        // Memilih kolom nama_daerah, jenis_kejahatan, dan menghitung total kejadian
        $builder->select('nama_daerah as wilayah, jenis_kejahatan, COUNT(*) as total')
                ->where('status', 'diterima') // Hanya data dengan status 'diterima'
                ->groupBy('nama_daerah, jenis_kejahatan') // Mengelompokkan berdasarkan wilayah dan jenis kejahatan
                ->orderBy('total', 'DESC');  // Mengurutkan berdasarkan total, terbanyak ke terkecil

        // Filter berdasarkan tahun jika diberikan
        if ($tahun) {
            $builder->where('YEAR(created_at)', $tahun);

            // Filter berdasarkan bulan jika diberikan
            if ($bulan) {
                $builder->where('MONTH(created_at)', $bulan);
            }
        // Filter berdasarkan bulan dan tahun saat ini jika hanya bulan diberikan
        } elseif ($bulan) {
            $builder->where('MONTH(created_at)', $bulan)
                    ->where('YEAR(created_at)', date('Y'));
        }

        // Filter berdasarkan jenis kejahatan jika diberikan
        if ($jenis) {
            $builder->where('jenis_kejahatan', $jenis);
        }

        // Mengembalikan hasil query sebagai array
        return $builder->get()->getResult();
    }

    // Fungsi get_pending_laporan: Mengambil daftar laporan dengan status 'pending'
    public function get_pending_laporan()
    {
        // Membuat query builder untuk tabel maps
        return $this->db->table('maps')
                       ->select('maps.*') // Memilih semua kolom dari tabel maps
                       ->where('maps.status', 'pending') // Hanya data dengan status 'pending'
                       ->get(); // Mengembalikan hasil query
    }
}