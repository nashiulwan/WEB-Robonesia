<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users'; // Nama tabel di database
    protected $primaryKey = 'id';    // Primary key tabel
    protected $allowedFields = ['username', 'email', 'password']; // Kolom yang diizinkan untuk disimpan
}
