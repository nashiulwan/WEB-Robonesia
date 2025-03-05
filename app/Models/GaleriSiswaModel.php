<?php

namespace App\Models;

use CodeIgniter\Model;

class GaleriSiswaModel extends Model
{
  protected $table            = 'galeri_siswa';
  protected $primaryKey       = 'id';
  protected $useAutoIncrement = true;
  protected $returnType       = 'array';
  protected $useSoftDeletes   = false;

  protected $allowedFields    = [
    'user_id',
    'judul',
    'deskripsi',
    'level',
    'sub_level',
    'gambar',
    'created_at',
    'updated_at'
  ];

  protected $useTimestamps = true;
  protected $createdField  = 'created_at';
  protected $updatedField  = 'updated_at';

  public function getGaleryByUserId($userId)
  {
    return $this->where('user_id', $userId)->findAll();
  }
}
