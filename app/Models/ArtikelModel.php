<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'slug', 'konten', 'kategori', 'penulis_id', 'status', 'created_at', 'updated_at', 'gambar'];

    public function getPublishedArticles()
    {
        return $this->where('status', 'publish')->orderBy('created_at', 'DESC')->findAll();
    }
}
