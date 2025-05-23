<?php

namespace App\Controllers;
use App\Models\M_Wilayah;

class Wilayah extends BaseController
{
    protected $builder, $db;

    public function __construct()
    {
        helper('form');
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('maps'); 
    }

    public function wilayah_data_read()
    {
        $this->builder->select('maps.nama_daerah, maps.kelurahan, maps.jenis_kejahatan, maps.latitude, maps.longitude, maps.gambar, maps.id'); 
        // Hapus alias 'as kelnama', gunakan 'kelurahan' langsung
    
        // Filter data utama hanya untuk status 'diterima'
        $this->builder->where('maps.status', 'diterima');
        $query = $this->builder->get();
    
        $dataModel = new M_Wilayah();
        $data = [
            'title'      => 'Data Wilayah',
            'content'    => $query->getResult(), // Hanya data dengan status 'diterima'
            'kelurahan'  => $dataModel->getKelurahanEnum(), // Gunakan daftar enum untuk dropdown
            'pengaduan'  => $dataModel->get_pending_laporan()->getResult(), // Data dengan status 'pending'
            'validation' => \Config\Services::validation()
        ];
    
        echo view('templates/header', $data);
        echo view('wilayah/wilayah');
    }
    
    public function wilayah_data_save()
    {
        if (!$this->validate([
            'gambar' => [
                'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileSampul = $this->request->getFile('gambar');
        $namaSampul = $fileSampul->getError() == 4 ? 'danger.png' : $fileSampul->getRandomName();

        if ($fileSampul->isValid() && !$fileSampul->hasMoved()) {
            $fileSampul->move('img', $namaSampul);
        }

        $dataMaster = [
            'kelurahan'         => $this->request->getPost('kelurahan'), // Ganti kelurahan_id dengan kelurahan
            'nama_daerah'       => $this->request->getPost('nama_daerah'),
            'latitude'          => $this->request->getPost('latitude'),
            'longitude'         => $this->request->getPost('longitude'),
            'jenis_kejahatan'   => $this->request->getPost('jenis_kejahatan'), 
            'gambar'            => $namaSampul,
            'status'            => 'pending' // Set status default sebagai 'pending'
        ];

        $modelMasterData = new M_Wilayah();
        $modelMasterData->save($dataMaster);

        session()->setFlashdata('msg', 'Data berhasil ditambahkan untuk validasi.');
        return redirect()->to('/wilayah');
    }

    public function wilayah_detail($id)
    {
        $dataModel = new M_Wilayah();
        $data = [
            'title' => 'Detail Wilayah',
            'dWilayah' => $dataModel->get_wilayah($id)
        ];

        if (empty($data['dWilayah'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Wilayah $id tidak ditemukan");
        }

        echo view('templates/header', $data);
        echo view('wilayah/wilayah_detail');
    }

    public function wilayah_edit($id)
    {
        $dataModel = new M_Wilayah();

        $this->builder->select('maps.nama_daerah, maps.kelurahan, maps.jenis_kejahatan, maps.latitude, maps.longitude, maps.gambar, maps.id'); 
        // Hapus alias 'as kelnama', gunakan 'kelurahan' langsung
        $query = $this->builder->get();

        $data = [
            'title'       => 'Edit Wilayah',
            'validation'  => \Config\Services::validation(),
            'wilayah'     => $dataModel->get_wilayah($id),
            'wilayahkec'  => $query->getResult(),
            'kelurahan'   => $dataModel->getKelurahanEnum(), // Gunakan daftar enum untuk dropdown
        ];        

        echo view('templates/header', $data);
        echo view('wilayah/wilayah_edit');
    }

    public function wilayahUpdate($id)
    {
        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $this->request->getVar('gambarLama');

        if ($fileGambar->isValid() && !$fileGambar->hasMoved()) {
            if ($namaGambar !== 'danger.png' && file_exists('img/' . $namaGambar)) {
                unlink('img/' . $namaGambar);
            }
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('img', $namaGambar);
        }

        $dataModel = new M_Wilayah();
        $dataModel->save([
            'id'              => $id,
            'kelurahan'       => $this->request->getVar('kelurahan'), // Ganti kelurahan_id dengan kelurahan
            'nama_daerah'     => $this->request->getVar('nama_daerah'),
            'latitude'        => $this->request->getVar('latitude'),
            'longitude'       => $this->request->getVar('longitude'),
            'jenis_kejahatan' => $this->request->getVar('jenis_kejahatan'),
            'gambar'          => $namaGambar,
        ]);

        session()->setFlashdata('msg', 'Data berhasil diubah.');
        return redirect()->to('/wilayah');
    }

    public function wilayahDelete($id)
    {
        $dataModel = new M_Wilayah();
        $mWilayah = $dataModel->find($id);
    
        if ($mWilayah && $mWilayah->gambar != 'danger.png' && file_exists('img/' . $mWilayah->gambar)) {
            unlink('img/' . $mWilayah->gambar);
        }
    
        $dataModel->delete($id);
        session()->setFlashdata('msg', 'Data berhasil dihapus.');
        return redirect()->to('/wilayah');
    }

    public function aduan()
    {
        $dataModel = new M_Wilayah();
        $data = [
            'title' => 'Form Pengaduan',
            'kelurahan' => $dataModel->getKelurahanEnum() // Gunakan daftar enum untuk dropdown
        ];
        echo view('templates/header', $data);
        echo view('wilayah/aduan');
    }

    public function aduanSave()
    {
        $file = $this->request->getFile('gambar');
        $namaGambar = $file->isValid() ? $file->getRandomName() : 'danger.png';

        if ($file->isValid() && !$file->hasMoved()) {
            $file->move('img', $namaGambar);
        }

        $this->db->table('maps')->insert([
            'kelurahan'       => $this->request->getPost('kelurahan'), // Ganti kelurahan_id dengan kelurahan
            'nama_daerah'     => $this->request->getPost('nama_daerah'),
            'latitude'        => $this->request->getPost('latitude'),
            'longitude'       => $this->request->getPost('longitude'),
            'jenis_kejahatan' => $this->request->getPost('jenis_kejahatan'),
            'gambar'          => $namaGambar,
            'status'          => 'pending' // Pastikan status default adalah 'pending'
        ]);

        return redirect()->to('/wilayah/aduan')->with('msg', 'Laporan berhasil dikirim untuk validasi.');
    }

    public function aduanTerima($id)
    {
        $this->db->table('maps')->where('id', $id)->update(['status' => 'diterima']);
        session()->setFlashdata('msg', 'Laporan diterima dan dipindahkan ke data wilayah.');
        return redirect()->to('/wilayah');
    }

    public function aduanTolak($id)
    {
        $this->db->table('maps')->delete(['id' => $id]);
        session()->setFlashdata('msg', 'Laporan ditolak dan dihapus.');
        return redirect()->to('/wilayah');
    }

    public function statistik()
    {
        $model = new M_Wilayah();
        $jenis = $this->request->getGet('jenis_kejahatan');

        if ($jenis) {
            $statistik = $model->where('jenis_kejahatan', $jenis)
                               ->where('status', 'diterima') // Hanya data yang diterima
                               ->select('jenis_kejahatan, COUNT(*) as total')
                               ->groupBy('jenis_kejahatan')
                               ->findAll();

            $rankingData = $model->where('jenis_kejahatan', $jenis)
                                 ->where('status', 'diterima') // Hanya data yang diterima
                                 ->select('nama_daerah as wilayah, jenis_kejahatan, COUNT(*) as total')
                                 ->groupBy('nama_daerah, jenis_kejahatan')
                                 ->orderBy('total', 'DESC')
                                 ->findAll();
        } else {
            $statistik = $model->getStatistikKejahatan();
            $rankingData = $model->getRankingWilayah();
        }

        // Ambil semua jenis kejahatan yang tersedia
        $jenisList = $model->select('jenis_kejahatan')
                           ->distinct()
                           ->where('status', 'diterima') // Hanya data yang diterima
                           ->orderBy('jenis_kejahatan', 'asc')
                           ->findAll();

        $data = [
            'title'         => 'Statistik Kriminalitas',
            'statistik'     => $statistik,
            'rankingData'   => $rankingData,
            'jenisList'     => $jenisList,
            'jenisDipilih'  => $jenis
        ];

        echo view('templates/header', $data);
        echo view('wilayah/statistik', $data);
    }
}