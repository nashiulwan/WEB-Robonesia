<?php

namespace App\Models;

use CodeIgniter\Model;

class KontakModel extends Model
{
    protected $table = 'pengaturan_kontak';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'no_hp', 'email', 'alamat', 'maps', 'facebook', 'instagram', 'x', 'tiktok', 'youtube'
    ];
}