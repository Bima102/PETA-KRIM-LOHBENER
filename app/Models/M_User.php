<?php

namespace App\Models;

use CodeIgniter\Model;

class M_User extends Model
{
    protected $table = 'users';

    protected $allowedFields = [
        'firstname',
        'lastname',
        'email',
        'role',
        'password',
        'phone'
    ];
}