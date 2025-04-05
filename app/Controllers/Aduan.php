<?php

namespace App\Controllers;
use App\Models\M_Aduan;
use CodeIgniter\Controller;

class Aduan extends Controller
{
    protected $aduanModel;

    public function __construct()
    {
        $this->aduanModel = new M_Aduan();
        helper(['form', 'url']);
    }

    public function index()
    {
        // Cek apakah user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('errors', ['Silakan login terlebih dahulu.']);
        }

        // Ambil nama user dari session
        $namaPelapor = session()->get('firstname') . ' ' . session()->get('lastname');

        $data = [
            'title' => 'Form Aduan',
            'pelapor' => $namaPelapor
        ];

        echo view('users/templates/header', $data);
        echo view('aduan/form', $data);
        echo view('users/templates/footer');
    }

    public function submit()
    {
        // Validasi input form (tanpa pelapor, karena otomatis)
        if (!$this->validate([
            'jenis_kejahatan' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'daerah' => 'required'
        ])) {
            return redirect()->to('/aduan')->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil nama pelapor dari session
        $namaPelapor = session()->get('firstname') . ' ' . session()->get('lastname');

        // Simpan data ke database
        $this->aduanModel->save([
            'jenis_kejahatan' => $this->request->getPost('jenis_kejahatan'),
            'kecamatan' => $this->request->getPost('kecamatan'),
            'kelurahan' => $this->request->getPost('kelurahan'),
            'daerah' => $this->request->getPost('daerah'),
            'pelapor' => $namaPelapor
        ]);

        session()->setFlashdata('success', 'Laporan berhasil dikirim.');
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
