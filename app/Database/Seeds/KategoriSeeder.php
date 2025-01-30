<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'Berita'],
            ['nama' => 'Kompetisi'],
            ['nama' => 'Event'],
            ['nama' => 'Belajar'],
            ['nama' => 'Tutorial'],
        ];

        // Masukkan data ke tabel kategoris
        $this->db->table('kategoris')->insertBatch($data);
    }
}
