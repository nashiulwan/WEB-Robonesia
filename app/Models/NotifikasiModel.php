<?php

namespace App\Models;

use CodeIgniter\Model;

class NotifikasiModel extends Model
{
    protected $table = 'notifikasisiswatable';
    protected $primaryKey = 'id';
    protected $allowedFields = ['siswa_id', 'judul', 'slug', 'status', 'created_at'];
}
