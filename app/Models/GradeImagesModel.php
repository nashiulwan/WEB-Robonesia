<?php

namespace App\Models;

use CodeIgniter\Model;

class GradeImagesModel extends Model
{
  protected $table = 'grade_images';
  protected $primaryKey = 'id';
  protected $allowedFields = ['kelas_id', 'image_name', 'deskripsi', 'created_at', 'updated_at'];
  protected $useTimestamps = true;

  // Ambil semua data gambar
  public function getAllImages()
  {
    return $this->findAll();
  }

  // Ambil gambar berdasarkan kelas (kelas_id)
  public function getImagesByKelas($kelas_id)
  {
    return $this->where('kelas_id', $kelas_id)->findAll();
  }
}
