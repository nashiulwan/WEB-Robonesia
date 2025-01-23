<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'slug', 'konten', 'kategori_id', 'penulis_id', 'status', 'created_at', 'updated_at', 'gambar'];

    // Relasi dengan kategori
    public function getArtikelWithKategori()
    {
        return $this->select('artikel.*, kategoris.nama as kategori')
                    ->join('kategoris', 'artikels.kategori_id = kategoris.id')
                    ->findAll();
    }
}
