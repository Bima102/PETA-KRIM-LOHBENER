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

        echo view('users/templates/header', $data);
        echo view('login');
        echo view('users/templates/footer');
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
    
            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $model = new M_User();
                $newData = [
                    'firstname' => $this->request->getVar('firstname'),
                    'lastname' => $this->request->getVar('lastname'),
                    'email' => $this->request->getVar('email'),
                    'password' => $this->request->getVar('password'), // Tanpa hashing di sini
                ];
                $model->save($newData);
    
                session()->setFlashdata('success', 'Pendaftaran berhasil. Silakan login.');
                return redirect()->to('/login');
            }
        }
    
        echo view('users/templates/header', $data);
        echo view('register');
        echo view('users/templates/footer');
    }    

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
