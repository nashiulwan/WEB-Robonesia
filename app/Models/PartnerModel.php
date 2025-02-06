<?php

namespace App\Models;

use CodeIgniter\Model;

class PartnerModel extends Model
{
    protected $table = 'pengaturan_partner';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'partner', 'alamat', 'maps', 'logo'
    ];
}