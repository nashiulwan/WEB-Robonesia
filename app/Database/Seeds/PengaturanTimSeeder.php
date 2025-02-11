<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PengaturanTimSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nama' => 'Hanif',
            'peran' => 'Founder',
            'foto' => 'pp_hanif.jpg', // Gunakan gambar default jika belum ada
            'facebook' => 'https://facebook.com/',
            'whatsapp' => 'https://wa.me/6282118032898',
            'twitter' => 'https://twitter.com/',
            'instagram' => 'https://instagram.com/'
        ];

        // Insert ke database
        $this->db->table('pengaturan_tim')->insert($data);
    }
}
