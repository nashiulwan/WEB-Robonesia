<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PengaturanKontakSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'no_hp'     => '082118032898',
            'email'     => 'robonesia.medan@gmail.com',
            'alamat'    => 'Komplek Permata Jatian Indah, Jl. Jatian Gg. Pribadi, Tembung, Kec. Percut Sei Tuan, Kab. Deli Serdang, Sumatera Utara',
            'maps'      => 'https://www.google.com/maps/embed?...',
            'facebook'  => 'https://facebook.com/robonesia',
            'instagram' => 'https://instagram.com/robonesia',
            'x'         => '#',
            'tiktok'    => '#',
            'youtube'   => '#'
        ];

        $this->db->table('pengaturan_kontak')->insert($data);
    }
}