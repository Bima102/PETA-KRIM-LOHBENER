<?php

namespace App\Models;

// Mengimpor kelas Model dari CodeIgniter untuk fungsi dasar model
use CodeIgniter\Model;

// Kelas M_User mewarisi Model untuk mengelola data pengguna
class M_User extends Model
{
    // Menentukan nama tabel di database
    protected $table = 'users';

    // Daftar kolom yang diizinkan untuk mass assignment
    protected $allowedFields = [
        'firstname',
        'lastname',
        'email',
        'role',
        'password'
    ];

    // Menentukan callback sebelum insert data
    protected $beforeInsert = ['beforeInsert'];

    // Menentukan callback sebelum update data
    protected $beforeUpdate = ['beforeUpdate'];

    // Fungsi beforeInsert: Memproses data sebelum disimpan ke database
    protected function beforeInsert(array $data)
    {
        // Meng-hash password jika ada dalam data
        $data = $this->passwordHash($data);

        // Mengembalikan data yang telah diproses
        return $data;
    }

    // Fungsi beforeUpdate: Memproses data sebelum diperbarui di database
    protected function beforeUpdate(array $data)
    {
        // Meng-hash password jika ada dalam data
        $data = $this->passwordHash($data);

        // Mengembalikan data yang telah diproses
        return $data;
    }

    // Fungsi passwordHash: Meng-hash password untuk keamanan
    protected function passwordHash(array $data)
    {
        // Memeriksa apakah kolom password ada dalam data
        if (isset($data['data']['password'])) {
            // Meng-hash password menggunakan algoritma PASSWORD_DEFAULT
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }

        // Mengembalikan data yang telah diproses
        return $data;
    }
}