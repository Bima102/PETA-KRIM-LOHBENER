<?php

namespace App\Controllers;
use App\Models\M_Aduan; // Menggunakan model M_Aduan
use CodeIgniter\Controller;

class Aduan extends Controller
{
    protected $aduanModel;

    public function __construct()
    {
        $this->aduanModel = new M_Aduan(); // Menggunakan model M_Aduan
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title' => 'Form Aduan'
        ];
        echo view('users/templates/header', $data);
        echo view('aduan/form', $data);
        echo view('users/templates/footer');
    }

    public function submit()
    {
        // Validasi input
        if (!$this->validate([
            'jenis_kejahatan' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'daerah' => 'required',
            'pelapor' => 'required'
        ])) {
            return redirect()->to('/aduan')->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan data ke database
        $this->aduanModel->save([
            'jenis_kejahatan' => $this->request->getPost('jenis_kejahatan'),
            'kecamatan' => $this->request->getPost('kecamatan'),
            'kelurahan' => $this->request->getPost('kelurahan'),
            'daerah' => $this->request->getPost('daerah'),
            'pelapor' => $this->request->getPost('pelapor')
        ]);

        // Set session flashdata untuk pesan sukses
        session()->setFlashdata('success', 'Laporan berhasil dikirim.');

        // Tetap di halaman form aduan
        return redirect()->to('/aduan');
    }

    public function laporan()
    {
        $data = [
            'title' => 'Laporan Aduan',
            'aduan' => $this->aduanModel->findAll()
        ];
        echo view('users/templates/header', $data);
        echo view('aduan/laporan', $data);
        echo view('users/templates/footer');
    }

    public function delete($id)
    {
        $this->aduanModel->delete($id);
        return redirect()->to('/aduan/laporan');
    }
}
