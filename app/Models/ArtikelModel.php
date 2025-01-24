<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table = 'artikel'; // Nama tabel
    protected $primaryKey = 'id'; // Primary key
    protected $allowedFields = ['judul', 'slug', 'konten', 'kategori_id', 'penulis_id', 'status', 'created_at', 'updated_at', 'gambar'];

    // Relasi dengan kategori
    public function getArtikelWithKategori()
    {
        $db = \Config\Database::connect(); // Koneksi database
        $builder = $db->table('artikel'); // Pilih tabel artikel

        // Join dengan tabel kategori
        $builder->select('artikel.*, kategoris.nama as kategori');
        $builder->join('kategoris', 'artikel.kategori_id = kategoris.id', 'left'); 

        $query = $builder->get(); // Eksekusi query
        return $query->getResultArray(); // Return hasil sebagai array
    }
}
