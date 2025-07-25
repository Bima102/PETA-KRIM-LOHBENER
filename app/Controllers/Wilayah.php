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

    private function sendWhatsAppMessage($no_hp, $message)
    {
        $token = 'utLc1fdSmBVG2weieKt6'; // Ganti dengan token API Fonnte Anda
        $url = 'https://api.fonnte.com/send';

        $data = [
            'target' => $no_hp,
            'message' => $message,
            'countryCode' => '+62', // Kode negara Indonesia
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => [
                "Authorization: $token"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            log_message('error', 'Fonnte API Error: ' . $err);
            return false;
        } else {
            $result = json_decode($response, true);
            return isset($result['status']) && $result['status'] === true;
        }
    }

    public function wilayah_data_read()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Anda harus login sebagai admin untuk mengakses halaman ini.');
            return redirect()->to('/login');
        }

        $this->builder->select('maps.kelurahan, maps.nama_daerah, maps.latitude, maps.longitude, maps.jenis_kejahatan, maps.nama_pelapor, maps.no_hp, maps.deskripsi, maps.gambar, maps.id, maps.status');
        $this->builder->whereIn('maps.status', ['pending', 'Diproses', 'Selesai']);
        $tahun = $this->request->getGet('tahun');
        $bulan = $this->request->getGet('bulan');

        if ($tahun) {
            $this->builder->where('YEAR(created_at)', $tahun);
            if ($bulan) {
                $this->builder->where('MONTH(created_at)', $bulan);
            }
        } elseif ($bulan) {
            $this->builder->where('MONTH(created_at)', $bulan);
            $this->builder->where('YEAR(created_at)', date('Y'));
        }

        $query = $this->builder->get();
        $content = $query->getResult();

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
        $laporanBuilder->whereIn('status', ['pending', 'Diproses', 'Selesai']);
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

        $dataModel = new M_Wilayah();
        $data = [
            'title'       => 'Data Wilayah',
            'content'     => $content,
            'laporanData' => $laporanData,
            'kelurahan'   => $dataModel->getKelurahanEnum(),
            'pengaduan'   => $dataModel->get_pending_laporan()->getResult(),
            'selesai'     => $dataModel->get_selesai_laporan()->getResult(),
            'validation'  => \Config\Services::validation(),
            'tahun'       => $tahun,
            'bulan'       => $bulan
        ];

        echo view('templates/header', $data);
        echo view('wilayah/wilayah', $data);
    }

    public function updateStatus($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Anda harus login sebagai admin untuk mengubah status laporan.');
            return redirect()->to('/login');
        }

        $status = $this->request->getPost('status');
        $dataModel = new M_Wilayah();
        $laporan = $dataModel->find($id);

        if (!$laporan) {
            session()->setFlashdata('error', 'Laporan tidak ditemukan.');
            return redirect()->to('/wilayah');
        }

        $no_hp = $laporan->no_hp;
        $nama_pelapor = $laporan->nama_pelapor;
        $message = '';

        if ($status === 'Diproses') {
            $message = "Halo $nama_pelapor, laporan Anda sedang diproses oleh Polsek Lohbener.";
            $this->db->table('maps')->update(['status' => 'Diproses'], ['id' => $id]);
        } elseif ($status === 'Selesai') {
            $message = "Halo $nama_pelapor, laporan Anda telah selesai ditangani oleh Polsek Lohbener. Terima kasih atas laporan Anda.";
            $this->db->table('maps')->update(['status' => 'Selesai'], ['id' => $id]);
        } elseif ($status === 'Ditolak') {
            $message = "Halo $nama_pelapor, maaf laporan Anda ditolak oleh Polsek Lohbener karena tidak memenuhi syarat.";
            if ($laporan->gambar != 'danger.png' && file_exists('img/' . $laporan->gambar)) {
                unlink('img/' . $laporan->gambar);
            }
            $dataModel->delete($id);
        } else {
            session()->setFlashdata('error', 'Status tidak valid.');
            return redirect()->to('/wilayah');
        }

        if (!empty($message)) {
            $this->sendWhatsAppMessage($no_hp, $message);
        }

        session()->setFlashdata('msg', 'Status laporan berhasil diperbarui.');
        return redirect()->to('/wilayah');
    }

    public function wilayah_data_save()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Anda harus login sebagai admin untuk menambah data.');
            return redirect()->to('/login');
        }

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

        $fileSampul = $this->request->getFile('gambar');
        $namaSampul = $fileSampul->getError() == 4 ? 'danger.png' : $fileSampul->getRandomName();

        if ($fileSampul->isValid() && !$fileSampul->hasMoved()) {
            $fileSampul->move('img', $namaSampul);
        }

        $jenisKejahatan = $this->request->getPost('jenis_kejahatan');
        if ($jenisKejahatan === 'lainnya') {
            $customKejahatan = $this->request->getPost('custom_kejahatan');
            $jenisKejahatan = $customKejahatan ? $customKejahatan : $jenisKejahatan;
        }

        $dataMaster = [
            'kelurahan'         => $this->request->getPost('kelurahan'),
            'nama_daerah'       => $this->request->getPost('nama_daerah'),
            'latitude'          => $this->request->getPost('latitude'),
            'longitude'         => $this->request->getPost('longitude'),
            'jenis_kejahatan'   => $jenisKejahatan,
            'nama_pelapor'      => $this->request->getPost('nama_pelapor'),
            'no_hp'             => $this->request->getPost('no_hp'),
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'gambar'            => $namaSampul,
            'status'            => 'pending',
            'created_at'        => date('Y-m-d H:i:s')
        ];

        $modelMasterData = new M_Wilayah();
        $modelMasterData->save($dataMaster);

        $this->sendWhatsAppMessage(
            $this->request->getPost('no_hp'),
            "Halo {$this->request->getPost('nama_pelapor')}, laporan Anda telah diterima dan sedang menunggu validasi oleh Polsek Lohbener."
        );

        session()->setFlashdata('msg', 'Data berhasil ditambahkan.');
        return redirect()->to('/wilayah');
    }

    public function wilayah_edit($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Anda harus login sebagai admin untuk mengedit data.');
            return redirect()->to('/login');
        }

        $dataModel = new M_Wilayah();
        $this->builder->select('maps.nama_daerah, maps.kelurahan, maps.jenis_kejahatan, maps.nama_pelapor, maps.no_hp, maps.deskripsi, maps.latitude, maps.longitude, maps.gambar, maps.id');
        $query = $this->builder->get();

        $data = [
            'title'       => 'Edit Wilayah',
            'validation'  => \Config\Services::validation(),
            'wilayah'     => $dataModel->get_wilayah($id),
            'wilayahkec'  => $query->getResult(),
            'kelurahan'   => $dataModel->getKelurahanEnum(),
        ];

        echo view('templates/header', $data);
        echo view('wilayah/wilayah_edit');
    }

    public function wilayahUpdate($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Anda harus login sebagai admin untuk memperbarui data.');
            return redirect()->to('/login');
        }

        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $this->request->getVar('gambarLama');

        if ($fileGambar->isValid() && !$fileGambar->hasMoved()) {
            if ($namaGambar !== 'danger.png' && file_exists('img/' . $namaGambar)) {
                unlink('img/' . $namaGambar);
            }
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('img', $namaGambar);
        }

        $jenisKejahatan = $this->request->getVar('jenis_kejahatan');
        if ($jenisKejahatan === 'lainnya') {
            $customKejahatan = trim($this->request->getVar('custom_kejahatan'));
            $jenisKejahatan = !empty($customKejahatan) ? $customKejahatan : $jenisKejahatan;
        }

        $dataModel = new M_Wilayah();
        $dataModel->save([
            'id'              => $id,
            'kelurahan'       => $this->request->getVar('kelurahan'),
            'nama_daerah'     => $this->request->getVar('nama_daerah'),
            'latitude'        => $this->request->getVar('latitude'),
            'longitude'       => $this->request->getVar('longitude'),
            'jenis_kejahatan' => $jenisKejahatan,
            'nama_pelapor'    => $this->request->getVar('nama_pelapor'),
            'no_hp'           => $this->request->getVar('no_hp'),
            'deskripsi'       => $this->request->getVar('deskripsi'),
            'gambar'          => $namaGambar,
        ]);

        $this->sendWhatsAppMessage(
            $this->request->getVar('no_hp'),
            "Halo {$this->request->getVar('nama_pelapor')}, data laporan Anda telah diperbarui oleh Polsek Lohbener."
        );

        session()->setFlashdata('msg', 'Data berhasil diubah.');
        return redirect()->to('/wilayah');
    }

    public function wilayahDelete($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Anda harus login sebagai admin untuk menghapus data.');
            return redirect()->to('/login');
        }

        $dataModel = new M_Wilayah();
        $laporan = $dataModel->find($id);

        if ($laporan) {
            if ($laporan->gambar != 'danger.png' && file_exists('img/' . $laporan->gambar)) {
                unlink('img/' . $laporan->gambar);
            }
            $this->sendWhatsAppMessage(
                $laporan->no_hp,
                "Halo {$laporan->nama_pelapor}, laporan Anda telah dihapus oleh Polsek Lohbener."
            );
            $dataModel->delete($id);
            session()->setFlashdata('msg', 'Data berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Laporan tidak ditemukan.');
        }

        return redirect()->to('/wilayah');
    }

    public function aduan()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'user') {
            session()->setFlashdata('error', 'Anda harus login sebagai user untuk mengakses halaman ini.');
            return redirect()->to('/login');
        }

        $dataModel = new M_Wilayah();
        $data = [
            'title'     => 'Form Pengaduan',
            'kelurahan' => $dataModel->getKelurahanEnum()
        ];

        echo view('templates/header', $data);
        echo view('wilayah/aduan');
    }

    public function aduanSave()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'user') {
            session()->setFlashdata('error', 'Anda harus login sebagai user untuk mengirim pengaduan.');
            return redirect()->to('/login');
        }

        if (!$this->validate([
            'kelurahan' => [
                'rules' => 'required',
                'errors' => ['required' => 'Kelurahan wajib dipilih.']
            ],
            'nama_daerah' => [
                'rules' => 'required',
                'errors' => ['required' => 'Detail patokan tempat wajib diisi.']
            ],
            'latitude' => [
                'rules' => 'required|decimal',
                'errors' => [
                    'required' => 'Latitude wajib diisi.',
                    'decimal' => 'Latitude harus berupa angka desimal.'
                ]
            ],
            'longitude' => [
                'rules' => 'required|decimal',
                'errors' => [
                    'required' => 'Longitude wajib diisi.',
                    'decimal' => 'Longitude harus berupa angka desimal.'
                ]
            ],
            'jenis_kejahatan' => [
                'rules' => 'required',
                'errors' => ['required' => 'Jenis kejahatan wajib dipilih.']
            ],
            'nama_pelapor' => [
                'rules' => 'required',
                'errors' => ['required' => 'Nama pelapor wajib diisi.']
            ],
            'no_hp' => [
                'rules' => 'required|numeric|min_length[10]|max_length[15]',
                'errors' => [
                    'required' => 'Nomor telepon wajib diisi.',
                    'numeric' => 'Nomor telepon harus berupa angka.',
                    'min_length' => 'Nomor telepon minimal 10 digit.',
                    'max_length' => 'Nomor telepon maksimal 15 digit.'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => ['required' => 'Kronologi kejadian wajib diisi.']
            ],
            'gambar' => [
                'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar.',
                    'is_image' => 'File yang diunggah bukan gambar.',
                    'mime_in' => 'File yang diunggah bukan gambar.'
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('gambar');
        $namaGambar = $file->isValid() ? $file->getRandomName() : 'danger.png';

        if ($file->isValid() && !$file->hasMoved()) {
            $file->move('img', $namaGambar);
        }

        $jenisKejahatan = $this->request->getPost('jenis_kejahatan');
        if ($jenisKejahatan === 'lainnya') {
            $customKejahatan = trim($this->request->getPost('custom_kejahatan'));
            if (empty($customKejahatan)) {
                session()->setFlashdata('error', 'Jenis kejahatan lainnya wajib diisi jika memilih "Lainnya".');
                return redirect()->back()->withInput();
            }
            $jenisKejahatan = $customKejahatan;
        }

        $this->db->table('maps')->insert([
            'kelurahan'       => $this->request->getPost('kelurahan'),
            'nama_daerah'     => $this->request->getPost('nama_daerah'),
            'latitude'        => $this->request->getPost('latitude'),
            'longitude'       => $this->request->getPost('longitude'),
            'jenis_kejahatan' => $jenisKejahatan,
            'nama_pelapor'    => $this->request->getPost('nama_pelapor'),
            'no_hp'           => $this->request->getPost('no_hp'),
            'deskripsi'       => $this->request->getPost('deskripsi'),
            'gambar'          => $namaGambar,
            'status'          => 'pending',
            'created_at'      => date('Y-m-d H:i:s')
        ]);

        $this->sendWhatsAppMessage(
            $this->request->getPost('no_hp'),
            "Halo {$this->request->getPost('nama_pelapor')}, laporan Anda telah diterima dan sedang menunggu validasi oleh Polsek Lohbener."
        );

        return redirect()->to('/wilayah/aduan')->with('msg', 'Laporan berhasil dikirim untuk proses.');
    }

    public function aduanTerima($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Anda harus login sebagai admin untuk menerima laporan.');
            return redirect()->to('/login');
        }

        $dataModel = new M_Wilayah();
        $laporan = $dataModel->find($id);

        if ($laporan) {
            $this->db->table('maps')->update(['status' => 'Diproses'], ['id' => $id]);
            $this->sendWhatsAppMessage(
                $laporan->no_hp,
                "Halo {$laporan->nama_pelapor}, laporan Anda sedang diproses oleh Polsek Lohbener."
            );
            session()->setFlashdata('msg', 'Laporan berhasil diterima.');
        } else {
            session()->setFlashdata('error', 'Laporan tidak ditemukan.');
        }

        return redirect()->to('/wilayah');
    }

    public function aduanTolak($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Anda harus login sebagai admin untuk menolak laporan.');
            return redirect()->to('/login');
        }

        $dataModel = new M_Wilayah();
        $laporan = $dataModel->find($id);

        if ($laporan) {
            if ($laporan->gambar != 'danger.png' && file_exists('img/' . $laporan->gambar)) {
                unlink('img/' . $laporan->gambar);
            }
            $this->sendWhatsAppMessage(
                $laporan->no_hp,
                "Halo {$laporan->nama_pelapor}, maaf laporan Anda ditolak oleh Polsek Lohbener karena tidak memenuhi syarat."
            );
            $dataModel->delete($id);
            session()->setFlashdata('msg', 'Laporan ditolak dan dihapus.');
        } else {
            session()->setFlashdata('error', 'Laporan tidak ditemukan.');
        }

        return redirect()->to('/wilayah');
    }

    public function statistik()
    {
        $model = new M_Wilayah();
        $jenis = $this->request->getGet('jenis_kejahatan');
        $tahun = $this->request->getGet('tahun');
        $bulan = $this->request->getGet('bulan');

        $statistikBuilder = $this->db->table('maps');
        $statistikBuilder->select('jenis_kejahatan, COUNT(*) as total')
            ->whereIn('status', ['Diproses', 'Selesai'])
            ->groupBy('jenis_kejahatan')
            ->orderBy('total', 'DESC');

        $rankingBuilder = $this->db->table('maps');
        $rankingBuilder->select('nama_daerah as wilayah, jenis_kejahatan, COUNT(*) as total')
            ->whereIn('status', ['Diproses', 'Selesai'])
            ->groupBy('nama_daerah, jenis_kejahatan')
            ->orderBy('total', 'DESC');

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

        if ($jenis) {
            $statistikBuilder->where('jenis_kejahatan', $jenis);
            $rankingBuilder->where('jenis_kejahatan', $jenis);
        }

        $statistik = $statistikBuilder->get()->getResult();
        $rankingData = $rankingBuilder->get()->getResult();

        $jenisList = $model->select('jenis_kejahatan')
            ->distinct()
            ->whereIn('status', ['Diproses', 'Selesai'])
            ->orderBy('jenis_kejahatan', 'asc')
            ->findAll();

        $data = [
            'title'         => 'Statistik Kriminalitas',
            'statistik'     => $statistik,
            'rankingData'   => $rankingData,
            'jenisList'     => $jenisList,
            'jenisDipilih'  => $jenis,
            'tahun'         => $tahun,
            'bulan'         => $bulan
        ];

        echo view('templates/header', $data);
        echo view('wilayah/statistik', $data);
    }
}