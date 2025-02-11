<?php

namespace App\Models;

use CodeIgniter\Model;

class TimModel extends Model
{
    protected $table = 'pengaturan_tim';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'peran', 'foto', 'facebook', 'whatsapp', 'twitter', 'instagram'];
}