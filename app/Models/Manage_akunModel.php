<?php

namespace App\Models;

use CodeIgniter\Model;

class Manage_akunModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'fullname'];
}
