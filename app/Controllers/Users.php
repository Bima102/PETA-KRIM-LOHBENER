<?php

namespace App\Controllers;

// Mengimpor kelas M_User untuk mengakses model pengguna
use App\Models\M_User;

// Kelas Users mewarisi BaseController untuk fungsi dasar controller
class Users extends BaseController
{
    // Fungsi index: Menangani proses login pengguna
    public function index()
    {
        // Menyiapkan data untuk judul halaman
        $data = ['title' => 'Login'];

        // Memuat helper form untuk membantu validasi dan pengolahan form
        helper(['form']);

        // Memeriksa apakah request adalah POST (pengiriman form login)
        if ($this->request->getMethod() === 'post') {
            // Membuat instance model M_User untuk interaksi dengan database
            $model = new M_User();

            // Mengambil input email dari form
            $email = $this->request->getVar('email');

            // Mengambil input password dari form
            $password = $this->request->getVar('password');

            // Mencari data pengguna berdasarkan email di database
            $user = $model->where('email', $email)->first();

            // Memeriksa apakah email terdaftar
            if (!$user) {
                // Jika email tidak ditemukan, redirect kembali dengan pesan error
                return redirect()->back()->with('error', 'Email tidak terdaftar.');
            }

            // Memverifikasi apakah password cocok dengan hash di database
            if (!password_verify($password, $user['password'])) {
                // Jika password salah, redirect kembali dengan pesan error
                return redirect()->back()->with('error', 'Password salah.');
            }

            // Jika login berhasil, menyimpan data pengguna ke session
            $this->setUserSession($user);

            // Redirect ke halaman dashboard setelah login berhasil
            return redirect()->to('dashboard');
        }

        // Menampilkan view templates/header dengan data judul
        echo view('templates/header', $data);

        // Menampilkan view login
        echo view('login');
    }

    // Fungsi setUserSession: Menyimpan data pengguna ke session setelah login
    private function setUserSession($user)
    {
        // Menyiapkan data pengguna untuk disimpan di session
        $data = [
            'id'         => $user['id'],          // Menyimpan ID pengguna
            'firstname'  => $user['firstname'],   // Menyimpan nama depan pengguna
            'lastname'   => $user['lastname'],    // Menyimpan nama belakang pengguna
            'email'      => $user['email'],       // Menyimpan email pengguna
            'role'       => $user['role'],        // Menyimpan peran pengguna
            'isLoggedIn' => true,                 // Menandakan pengguna telah login
        ];

        // Menyimpan data ke session
        session()->set($data);

        // Mengembalikan true untuk menandakan session berhasil diset
        return true;
    }

    // Fungsi register: Menangani proses pendaftaran pengguna baru
    public function register()
    {
        // Menyiapkan data untuk judul halaman
        $data = ['title' => 'Register'];

        // Memuat helper form untuk membantu validasi dan pengolahan form
        helper(['form']);

        // Memeriksa apakah request adalah POST (pengiriman form registrasi)
        if ($this->request->getMethod() === 'post') {
            // Aturan validasi untuk input form registrasi
            $rules = [
                'firstname'       => 'required|min_length[3]|max_length[20]', // Nama depan wajib, min 3, max 20 karakter
                'lastname'        => 'required|min_length[3]|max_length[20]', // Nama belakang wajib, min 3, max 20 karakter
                'email'           => 'required|valid_email|is_unique[users.email]', // Email wajib, valid, dan unik
                'password'        => 'required|min_length[8]|max_length[255]', // Password wajib, min 8, max 255 karakter
                'password_confirm' => 'matches[password]', // Konfirmasi password harus sama dengan password
            ];

            // Pesan error kustom dalam bahasa Indonesia
            $messages = [
                'firstname' => [
                    'required'   => 'Nama depan wajib diisi.',
                    'min_length' => 'Nama depan minimal 3 karakter.',
                    'max_length' => 'Nama depan maksimal 20 karakter.',
                ],
                'lastname' => [
                    'required'   => 'Nama belakang wajib diisi.',
                    'min_length' => 'Nama belakang minimal 3 karakter.',
                    'max_length' => 'Nama belakang maksimal 20 karakter.',
                ],
                'email' => [
                    'required'    => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique'   => 'Email sudah terdaftar, silakan gunakan email lain.',
                ],
                'password' => [
                    'required'   => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 8 karakter.',
                    'max_length' => 'Password maksimal 255 karakter.',
                ],
                'password_confirm' => [
                    'matches' => 'Konfirmasi password tidak cocok.',
                ],
            ];

            // Memvalidasi input berdasarkan aturan dan pesan di atas
            if (!$this->validate($rules, $messages)) {
                // Jika validasi gagal, simpan error validasi ke data
                $data['validation'] = $this->validator;
            } else {
                // Jika validasi berhasil, buat instance model M_User
                $model = new M_User();

                // Menyiapkan data pengguna baru untuk disimpan ke database
                $newData = [
                    'firstname' => $this->request->getVar('firstname'), // Nama depan dari input
                    'lastname'  => $this->request->getVar('lastname'),  // Nama belakang dari input
                    'email'     => $this->request->getVar('email'),     // Email dari input
                    'password'  => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT), // Hash password
                ];

                // Menyimpan data pengguna ke database
                $model->save($newData);

                // Menyimpan pesan sukses ke session flashdata
                session()->setFlashdata('success', 'Pendaftaran berhasil. Silakan login.');

                // Redirect ke halaman login setelah registrasi berhasil
                return redirect()->to('/login');
            }
        }

        // Menampilkan view templates/header dengan data judul
        echo view('templates/header', $data);

        // Menampilkan view register dengan data (termasuk error validasi jika ada)
        echo view('register', $data);
    }

    // Fungsi logout: Menghapus session pengguna dan mengarahkan ke halaman login
    public function logout()
    {
        // Menghapus semua data session
        session()->destroy();

        // Redirect ke rute login
        return redirect()->to(route_to('login'));
    }
}