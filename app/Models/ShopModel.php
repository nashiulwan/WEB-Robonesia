<?php

namespace App\Models;

use CodeIgniter\Model;

class ShopModel extends Model
{
    protected $table         = 'shop';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['nama_produk', 'gambar_produk', 'deskripsi_produk', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

}
