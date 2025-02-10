<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users'; // Nama tabel di database
    protected $primaryKey = 'id';    // Primary key tabel
    protected $allowedFields = ['email', 'username', 'fullname', 'password_hash', 'user_image', 'created_at', 'updated_at', 'active'];
}
