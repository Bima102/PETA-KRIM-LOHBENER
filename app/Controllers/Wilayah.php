<?php

namespace App\Controllers;

use App\Models\M_Wilayah;

class Wilayah extends BaseController
{
    protected $builder, $db;

    /**
     * Konstruktor untuk inisialisasi koneksi database dan helper form.
     */
    public function __construct()
    {
        helper('form'); // Memuat helper form untuk keperluan validasi dan pengolahan form
        $this->db = \Config\Database::connect(); // Menginisialisasi koneksi ke database
        $this->builder = $this->db->table('maps'); // Menyiapkan query builder untuk tabel 'maps'
    }

    /**
     * Fungsi untuk menampilkan data wilayah yang sudah diterima, dengan filter tahun dan bulan.
     * Hanya dapat diakses oleh admin.
     */
    public function wilayah_data_read()
    {
        // Memeriksa apakah pengguna sudah login dan memiliki role admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Anda harus login sebagai admin untuk mengakses halaman ini.');
            return redirect()->to('/login');
        }

        // Mengambil data wilayah dari tabel maps dengan status 'diterima'
        $this->builder->select('maps.kelurahan, maps.nama_daerah, maps.latitude, maps.longitude, maps.jenis_kejahatan, maps.gambar, maps.id');
        $this->builder->where('maps.status', 'diterima');

        // Mengambil parameter tahun dan bulan dari query string untuk filter
        $tahun = $this->request->getGet('tahun');
        $bulan = $this->request->getGet('bulan');

        // Filter data berdasarkan tahun dan/atau bulan
        if ($tahun) {
            $this->builder->where('YEAR(created_at)', $tahun);
            if ($bulan) {
                $this->builder->where('MONTH(created_at)', $bulan);
            }
        } elseif ($bulan) {
            $this->builder->where('MONTH(created_at)', $bulan);
            $this->builder->where('YEAR(created_at)', date('Y'));
        }

        // Menjalankan query dan menyimpan hasilnya
        $query = $this->builder->get();
        $content = $query->getResult();

        // Mengambil data agregat untuk laporan cetak berdasarkan kelurahan
        $laporanBuilder = $this->db->table('maps');
        $laporanBuilder->select("kelurahan,
            SUM(CASE WHEN jenis_kejahatan = 'curanmor' THEN 1 ELSE 0 END) as curanmor,
            SUM(CASE WHEN jenis_kejahatan = 'perampokan' THEN 1 ELSE 0 END) as perampokan,
            SUM(CASE WHEN jenis_kejahatan = 'begal' THEN 1 ELSE 0 END) as begal,
            SUM(CASE WHEN jenis_kejahatan = 'tawuran' THEN 1 ELSE 0 END) as tawuran,
            (SUM(CASE WHEN jenis_kejahatan = 'curanmor' THEN 1 ELSE 0 END) +
             SUM(CASE WHEN jenis_kejahatan = 'perampokan' THEN 1 ELSE 0 END) +
             SUM(CASE WHEN jenis_kejahatan = 'begal' THEN 1 ELSE 0 END) +
             SUM(CASE WHEN jenis_kejahatan = 'tawuran' THEN 1 ELSE 0 END)) as total_kejahatan");
        $laporanBuilder->where('status', 'diterima');

        // Menerapkan filter tahun dan bulan untuk laporan
        if ($tahun) {
            $laporanBuilder->where('YEAR(created_at)', $tahun);
            if ($bulan) {
                $laporanBuilder->where('MONTH(created_at)', $bulan);
            }
        } elseif ($bulan) {
            $laporanBuilder->where('MONTH(created_at)', $bulan);
            $laporanBuilder->where('YEAR(created_at)', date('Y'));
        }
        $laporanBuilder->groupBy('kelurahan');
        $laporanData = $laporanBuilder->get()->getResult();

        // Inisialisasi model untuk mengambil data tambahan
        $dataModel = new M_Wilayah();
        $data = [
            'title'       => 'Data Wilayah', // Judul halaman
            'content'     => $content, // Data wilayah yang diterima
            'laporanData' => $laporanData, // Data agregat untuk laporan
            'kelurahan'   => $dataModel->getKelurahanEnum(), // Daftar kelurahan dari enum
            'pengaduan'   => $dataModel->get_pending_laporan()->getResult(), // Data pengaduan yang masih pending
            'validation'  => \Config\Services::validation(), // Objek validasi untuk form
            'tahun'       => $tahun, // Tahun filter
            'bulan'       => $bulan // Bulan filter
        ];

        // Menampilkan view dengan data yang disiapkan
        echo view('templates/header', $data);
        echo view('wilayah/wilayah', $data);
    }

    /**
     * Fungsi untuk menyimpan data wilayah baru ke database.
     * Hanya dapat diakses oleh admin.
     */
    public function wilayah_data_save()
    {
        // Memeriksa apakah pengguna sudah login dan memiliki role admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Anda harus login sebagai admin untuk menambah data.');
            return redirect()->to('/login');
        }

        // Validasi file gambar yang diunggah
        if (!$this->validate([
            'gambar' => [
                'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in'  => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Mengelola file gambar yang diunggah
        $fileSampul = $this->request->getFile('gambar');
        $namaSampul = $fileSampul->getError() == 4 ? 'danger.png' : $fileSampul->getRandomName();

        if ($fileSampul->isValid() && !$fileSampul->hasMoved()) {
            $fileSampul->move('img', $namaSampul); // Memindahkan file ke folder img
        }

        // Mengambil jenis kejahatan, menggunakan custom jika memilih "lainnya"
        $jenisKejahatan = $this->request->getPost('jenis_kejahatan');
        if ($jenisKejahatan === 'lainnya') {
            $customKejahatan = $this->request->getPost('custom_kejahatan');
            $jenisKejahatan = $customKejahatan ? $customKejahatan : $jenisKejahatan;
        }

        // Menyiapkan data untuk disimpan ke database
        $dataMaster = [
            'kelurahan'         => $this->request->getPost('kelurahan'),
            'nama_daerah'       => $this->request->getPost('nama_daerah'),
            'latitude'          => $this->request->getPost('latitude'),
            'longitude'         => $this->request->getPost('longitude'),
            'jenis_kejahatan'   => $jenisKejahatan,
            'gambar'            => $namaSampul,
            'status'            => 'diterima', // Status langsung diterima untuk input admin
            'created_at'        => date('Y-m-d H:i:s')
        ];

        // Menyimpan data menggunakan model
        $modelMasterData = new M_Wilayah();
        $modelMasterData->save($dataMaster);

        // Menampilkan pesan sukses dan redirect
        session()->setFlashdata('msg', 'Data berhasil ditambahkan.');
        return redirect()->to('/wilayah');
    }

    /**
     * Fungsi untuk menampilkan form edit data wilayah.
     * Hanya dapat diakses oleh admin.
     */
    public function wilayah_edit($id)
    {
        // Memeriksa apakah pengguna sudah login dan memiliki role admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Anda harus login sebagai admin untuk mengedit data.');
            return redirect()->to('/login');
        }

        // Mengambil data wilayah untuk ditampilkan di form edit
        $dataModel = new M_Wilayah();
        $this->builder->select('maps.nama_daerah, maps.kelurahan, maps.jenis_kejahatan, maps.latitude, maps.longitude, maps.gambar, maps.id');
        $query = $this->builder->get();

        $data = [
            'title'       => 'Edit Wilayah',
            'validation'  => \Config\Services::validation(),
            'wilayah'     => $dataModel->get_wilayah($id),
            'wilayahkec'  => $query->getResult(),
            'kelurahan'   => $dataModel->getKelurahanEnum(),
        ];

        // Menampilkan view form edit
        echo view('templates/header', $data);
        echo view('wilayah/wilayah_edit');
    }

    /**
     * Fungsi untuk memperbarui data wilayah berdasarkan ID.
     * Hanya dapat diakses oleh admin.
     */
    public function wilayahUpdate($id)
    {
        // Memeriksa apakah pengguna sudah login dan memiliki role admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Anda harus login sebagai admin untuk memperbarui data.');
            return redirect()->to('/login');
        }

        // Mengelola file gambar baru (jika ada)
        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $this->request->getVar('gambarLama');

        if ($fileGambar->isValid() && !$fileGambar->hasMoved()) {
            if ($namaGambar !== 'danger.png' && file_exists('img/' . $namaGambar)) {
                unlink('img/' . $namaGambar); // Menghapus gambar lama
            }
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('img', $namaGambar); // Menyimpan gambar baru
        }

        // Mengambil jenis kejahatan, menggunakan custom jika memilih "lainnya"
        $jenisKejahatan = $this->request->getVar('jenis_kejahatan');
        if ($jenisKejahatan === 'lainnya') {
            $customKejahatan = trim($this->request->getVar('custom_kejahatan'));
            $jenisKejahatan = !empty($customKejahatan) ? $customKejahatan : $jenisKejahatan;
        }

        // Memperbarui data menggunakan model
        $dataModel = new M_Wilayah();
        $dataModel->save([
            'id'              => $id,
            'kelurahan'       => $this->request->getVar('kelurahan'),
            'nama_daerah'     => $this->request->getVar('nama_daerah'),
            'latitude'        => $this->request->getVar('latitude'),
            'longitude'       => $this->request->getVar('longitude'),
            'jenis_kejahatan' => $jenisKejahatan,
            'gambar'          => $namaGambar,
        ]);

        // Menampilkan pesan sukses dan redirect
        session()->setFlashdata('msg', 'Data berhasil diubah.');
        return redirect()->to('/wilayah');
    }

    /**
     * Fungsi untuk menghapus data wilayah berdasarkan ID.
     * Hanya dapat diakses oleh admin.
     */
    public function wilayahDelete($id)
    {
        // Memeriksa apakah pengguna sudah login dan memiliki role admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Anda harus login sebagai admin untuk menghapus data.');
            return redirect()->to('/login');
        }

        // Mengambil data wilayah untuk menghapus gambar terkait
        $dataModel = new M_Wilayah();
        $mWilayah = $dataModel->find($id);

        if ($mWilayah && $mWilayah->gambar != 'danger.png' && file_exists('img/' . $mWilayah->gambar)) {
            unlink('img/' . $mWilayah->gambar); // Menghapus file gambar
        }

        // Menghapus data dari database
        $dataModel->delete($id);

        // Menampilkan pesan sukses dan redirect
        session()->setFlashdata('msg', 'Data berhasil dihapus.');
        return redirect()->to('/wilayah');
    }

    /**
     * Fungsi untuk menampilkan form pengaduan.
     * Hanya dapat diakses oleh user biasa.
     */
    public function aduan()
    {
        // Memeriksa apakah pengguna sudah login dan memiliki role user
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'user') {
            session()->setFlashdata('error', 'Anda harus login sebagai user untuk mengakses halaman ini.');
            return redirect()->to('/login');
        }

        // Menyiapkan data untuk form pengaduan
        $dataModel = new M_Wilayah();
        $data = [
            'title'     => 'Form Pengaduan',
            'kelurahan' => $dataModel->getKelurahanEnum()
        ];

        // Menampilkan view form pengaduan
        echo view('templates/header', $data);
        echo view('wilayah/aduan');
    }

    /**
     * Fungsi untuk menyimpan data pengaduan yang dikirim oleh user.
     * Hanya dapat diakses oleh user biasa.
     */
    public function aduanSave()
    {
        // Memeriksa apakah pengguna sudah login dan memiliki role user
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'user') {
            session()->setFlashdata('error', 'Anda harus login sebagai user untuk mengirim pengaduan.');
            return redirect()->to('/login');
        }

        // Debug: Mencatat data POST yang diterima
        log_message('debug', 'Data POST: ' . print_r($this->request->getPost(), true));

        // Mengelola file gambar yang diunggah
        $file = $this->request->getFile('gambar');
        $namaGambar = $file->isValid() ? $file->getRandomName() : 'danger.png';

        if ($file->isValid() && !$file->hasMoved()) {
            $file->move('img', $namaGambar); // Menyimpan gambar ke folder img
        }

        // Mengambil jenis kejahatan, menggunakan custom jika memilih "lainnya"
        $jenisKejahatan = $this->request->getPost('jenis_kejahatan');
        if ($jenisKejahatan === 'lainnya') {
            $customKejahatan = trim($this->request->getPost('custom_kejahatan'));
            $jenisKejahatan = !empty($customKejahatan) ? $customKejahatan : 'Lainnya Tidak Ditentukan';
        }

        // Validasi jenis kejahatan tidak boleh kosong
        if (empty($jenisKejahatan)) {
            session()->setFlashdata('error', 'Jenis kejahatan tidak boleh kosong.');
            return redirect()->back()->withInput();
        }

        // Menyimpan data pengaduan ke database dengan status 'pending'
        $this->db->table('maps')->insert([
            'kelurahan'       => $this->request->getPost('kelurahan'),
            'nama_daerah'     => $this->request->getPost('nama_daerahatan'),
            'latitude'        => $this->request->getPost('latitude'),
            'longitude'       => $this->request->getPost('longitude'),
            'jenis_kejahatan' => $jenisKejahatan,
            'gambar'          => $namaGambar,
            'status'          => 'pending',
            'created_at'      => date('Y-m-d H:i:s')
        ]);

        // Debug: Mencatat query terakhir yang dijalankan
        log_message('debug', 'Last Query: ' . $this->db->getLastQuery());

        // Menampilkan pesan sukses dan redirect
        return redirect()->to('/wilayah/aduan')->with('msg', 'Laporan berhasil dikirim untuk validasi.');
    }

    /**
     * Fungsi untuk menerima pengaduan dan mengubah status menjadi 'diterima'.
     * Hanya dapat diakses oleh admin.
     */
    public function aduanTerima($id)
    {
        // Memeriksa apakah pengguna sudah login dan memiliki role admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Anda harus login sebagai admin untuk menerima laporan.');
            return redirect()->to('/login');
        }

        // Mengubah status pengaduan menjadi 'diterima'
        $this->db->table('maps')->where('id', $id)->update(['status' => 'diterima']);

        // Menampilkan pesan sukses dan redirect
        session()->setFlashdata('msg', 'Laporan diterima dan dipindahkan ke data wilayah.');
        return redirect()->to('/wilayah');
    }

    /**
     * Fungsi untuk menolak pengaduan dan menghapusnya dari database.
     * Hanya dapat diakses oleh admin.
     */
    public function aduanTolak($id)
    {
        // Memeriksa apakah pengguna sudah login dan memiliki role admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Anda harus login sebagai admin untuk menolak laporan.');
            return redirect()->to('/login');
        }

        // Menghapus pengaduan dari database
        $this->db->table('maps')->delete(['id' => $id]);

        // Menampilkan pesan sukses dan redirect
        session()->setFlashdata('msg', 'Laporan ditolak dan dihapus.');
        return redirect()->to('/wilayah');
    }

    /**
     * Fungsi untuk menampilkan statistik kriminalitas berdasarkan jenis kejahatan, tahun, dan bulan.
     */
    public function statistik()
    {
        // Inisialisasi model
        $model = new M_Wilayah();
        $jenis = $this->request->getGet('jenis_kejahatan');
        $tahun = $this->request->getGet('tahun');
        $bulan = $this->request->getGet('bulan');

        // Query untuk statistik jumlah kejahatan per jenis
        $statistikBuilder = $this->db->table('maps');
        $statistikBuilder->select('jenis_kejahatan, COUNT(*) as total')
            ->where('status', 'diterima')
            ->groupBy('jenis_kejahatan')
            ->orderBy('total', 'DESC');

        // Query untuk ranking wilayah berdasarkan jumlah kejahatan
        $rankingBuilder = $this->db->table('maps');
        $rankingBuilder->select('nama_daerah as wilayah, jenis_kejahatan, COUNT(*) as total')
            ->where('status', 'diterima')
            ->groupBy('nama_daerah, jenis_kejahatan')
            ->orderBy('total', 'DESC');

        // Menerapkan filter tahun dan bulan untuk kedua query
        if ($tahun) {
            $statistikBuilder->where('YEAR(created_at)', $tahun);
            $rankingBuilder->where('YEAR(created_at)', $tahun);
            if ($bulan) {
                $statistikBuilder->where('MONTH(created_at)', $bulan);
                $rankingBuilder->where('MONTH(created_at)', $bulan);
            }
        } elseif ($bulan) {
            $statistikBuilder->where('MONTH(created_at)', $bulan)
                ->where('YEAR(created_at)', date('Y'));
            $rankingBuilder->where('MONTH(created_at)', $bulan)
                ->where('YEAR(created_at)', date('Y'));
        }

        // Menerapkan filter jenis kejahatan jika ada
        if ($jenis) {
            $statistikBuilder->where('jenis_kejahatan', $jenis);
            $rankingBuilder->where('jenis_kejahatan', $jenis);
        }

        // Menjalankan query dan menyimpan hasil
        $statistik = $statistikBuilder->get()->getResult();
        $rankingData = $rankingBuilder->get()->getResult();

        // Mengambil daftar jenis kejahatan yang unik
        $jenisList = $model->select('jenis_kejahatan')
            ->distinct()
            ->where('status', 'diterima')
            ->orderBy('jenis_kejahatan', 'asc')
            ->findAll();

        // Menyiapkan data untuk view
        $data = [
            'title'         => 'Statistik Kriminalitas',
            'statistik'     => $statistik,
            'rankingData'   => $rankingData,
            'jenisList'     => $jenisList,
            'jenisDipilih'  => $jenis,
            'tahun'         => $tahun,
            'bulan'         => $bulan
        ];

        // Menampilkan view statistik
        echo view('templates/header', $data);
        echo view('wilayah/statistik', $data);
    }
}