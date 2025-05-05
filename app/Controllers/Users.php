<?php

namespace App\Controllers;

use App\Models\M_User;

class Users extends BaseController
{
    public function index()
    {
        $data = ['title' => 'Login'];
        helper(['form']);

        if ($this->request->getMethod() == 'post') {
            $model = new M_User();
            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');

            // Cek apakah email ada di database
            $user = $model->where('email', $email)->first();

            if (!$user) {
                return redirect()->back()->with('error', 'Email tidak terdaftar.');
            }

            // Verifikasi password
            if (!password_verify($password, $user['password'])) {
                return redirect()->back()->with('error', 'Password salah.');
            }

            // Set session jika login berhasil
            $this->setUserSession($user);
            return redirect()->to('dashboard');
        }

        echo view('templates/header', $data); 
        echo view('login');                     
    }

    private function setUserSession($user)
    {
        $data = [
            'id' => $user['id'],
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'email' => $user['email'],
            'role' => $user['role'],
            'isLoggedIn' => true,
        ];

        session()->set($data);
        return true;
    }

    public function register()
    {
        $data = ['title' => 'Register'];
        helper(['form']);

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'firstname' => 'required|min_length[3]|max_length[20]',
                'lastname' => 'required|min_length[3]|max_length[20]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]|max_length[255]',
                'password_confirm' => 'matches[password]',
            ];

            // Pesan kustom berbahasa Indonesia
            $messages = [
                'firstname' => [
                    'required' => 'Nama depan wajib diisi.',
                    'min_length' => 'Nama depan minimal 3 karakter.',
                    'max_length' => 'Nama depan maksimal 20 karakter.',
                ],
                'lastname' => [
                    'required' => 'Nama belakang wajib diisi.',
                    'min_length' => 'Nama belakang minimal 3 karakter.',
                    'max_length' => 'Nama belakang maksimal 20 karakter.',
                ],
                'email' => [
                    'required' => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
                ],
                'password' => [
                    'required' => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 8 karakter.',
                    'max_length' => 'Password maksimal 255 karakter.',
                ],
                'password_confirm' => [
                    'matches' => 'Konfirmasi password tidak cocok.',
                ],
            ];

            if (!$this->validate($rules, $messages)) {
                $data['validation'] = $this->validator;
            } else {
                $model = new M_User();
                $newData = [
                    'firstname' => $this->request->getVar('firstname'),
                    'lastname' => $this->request->getVar('lastname'),
                    'email' => $this->request->getVar('email'),
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                ];
                $model->save($newData);

                session()->setFlashdata('success', 'Pendaftaran berhasil. Silakan login.');
                return redirect()->to('/login');
            }
        }

        echo view('templates/header', $data); 
        echo view('register', $data);               
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(route_to('login'));
    }
}
