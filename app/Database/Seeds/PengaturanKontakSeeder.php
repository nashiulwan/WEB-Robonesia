<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PengaturanKontakSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'no_hp'     => '+6282118032898',
            'email'     => 'robonesia.medan@gmail.com',
            'alamat'    => 'Komplek Permata Jatian Indah, Jl. Jatian Gg. Pribadi, Tembung, Kec. Percut Sei Tuan, Kab. Deli Serdang, Sumatera Utara',
            'maps'      => 'https://maps.app.goo.gl/AwN3DJPqsmCvnd5Z8',
            'facebook'  => 'https://facebook.com/robonesia',
            'instagram' => 'https://instagram.com/robonesia_medan',
            'x'         => 'https://x.com',
            'tiktok'    => 'https://tiktok.com',
            'youtube'   => 'https://youtube.com/'
        ];

        $this->db->table('pengaturan_kontak')->insert($data);
    }
}
