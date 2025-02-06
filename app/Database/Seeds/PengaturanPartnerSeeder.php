<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PengaturanPartnerSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('pengaturan_partner')->insertBatch([
            [
                'partner' => 'AL-AZHAR ASY SYARIF SUMATERA UTARA',
                'alamat' => 'Jl. Mahoni Ps II, Bandar Klippa, Kec. Percut Sei Tuan, Kabupaten Deli Serdang, Sumatera Utara 20371',
                'maps' => 'https://maps.app.goo.gl/1UZwWYbEJ7VdGuum7',
                'logo' => '/image/logo_al_azhar.png',
            ],
            [
                'partner' => 'Avicenna Childhood Homeschooling',
                'alamat' => 'Tasbih, Jl. Canna Raya No.1A 1 blok.H no, Tj. Sari, Kec. Medan Selayang, Kota Medan, Sumatera Utara 20122',
                'maps' => 'https://maps.app.goo.gl/ytNe94H2q94SPHNU9',
                'logo' => '/image/logo_avicenna.png',
            ],
            [
                'partner' => 'Sds Al-Washliyah 09',
                'alamat' => 'Jl. Gedung Arca No.12, Teladan Bar., Kec. Medan Kota, Kota Medan, Sumatera Utara 20216',
                'maps' => 'https://maps.app.goo.gl/aQconFmpmj6DEUs8A',
                'logo' => '/image/logo_hijau.png',
            ],
            [
                'partner' => 'Homeschooling HSPG Medan',
                'alamat' => 'Jl. Sei Putih Baru No.10, Babura, Kec. Medan Baru, Kota Medan, Sumatera Utara 20154',
                'maps' => 'https://maps.app.goo.gl/BESbcTPsYWGP8cin6',
                'logo' => '/image/logo_hsvg.png',
            ],
            [
                'partner' => 'Methodist Charles Wesley',
                'alamat' => 'Suka Damai, Kec. Medan Polonia, Kota Medan, Sumatera Utara 20157',
                'maps' => 'https://maps.app.goo.gl/vGkz98S7RCx62oBP8',
                'logo' => '/image/logo_methodist.png',
            ],
            [
                'partner' => 'Pineapple Premier School',
                'alamat' => 'Jl. T. Amir Hamzah No.F - 86, Helvetia Tim., Kec. Medan Helvetia, Kota Medan, Sumatera Utara 20114',
                'maps' => 'https://maps.app.goo.gl/UpiApyADG5RgE8Y49',
                'logo' => '/image/logo_pineapple.png',
            ],
            [
                'partner' => 'SDS IT Siti Hajar',
                'alamat' => 'JL. Letjen Jamin Ginting, Jl. Paya Bundung No.Km 11, Simpang Selayang, Kec. Medan Tuntungan, Kota Medan, Sumatera Utara 20135',
                'maps' => 'https://maps.app.goo.gl/w3XQPFLfi73bYYmGA',
                'logo' => '/image/logo_siti_hajar.png',
            ],
            [
                'partner' => 'Nuur Ar Radiyah',
                'alamat' => 'Jl. Pangkalan Brandan, KM 63, Dusun Harapan, Desa Pematang Tengah, Kecamatan Tanjung Pura, Kabupaten Langkat, Provinsi Sumatera Utara',
                'maps' => 'https://maps.app.goo.gl/hpxMmMCEn8dx8Ewq7',
                'logo' => '/image/logo_tanjung_pura.png',
            ],
            [
                'partner' => 'SD Ulul Ilmi Islamic School',
                'alamat' => 'Jl. Denai No.241, Tegal Sari Mandala II, Kec. Medan Denai, Kota Medan, Sumatera Utara 20371',
                'maps' => 'https://maps.app.goo.gl/PE9qcGzfG1bfADxdA',
                'logo' => '/image/logo_ulul_ilmu.png',
            ],
            [
                'partner' => 'Yayasan Pendidikan Shafiyyatul Amaliyyah (YPSA)',
                'alamat' => 'Jl. Setia Budi No.191, Tj. Rejo, Kec. Medan Sunggal, Kota Medan, Sumatera Utara 20122',
                'maps' => 'https://maps.app.goo.gl/RGaN4cj1UC5vbpnc9',
                'logo' => '/image/logo_ypsa.png',
            ],
            [
                'partner' => 'Az-Zakiyah Islamic Leadership',
                'alamat' => 'Jl. Meteorologi IV, Indra Kasih, Kec. Medan Tembung, Kota Medan, Sumatera Utara 20221',
                'maps' => 'https://maps.app.goo.gl/RmTqKFK5gJpcHezi8',
                'logo' => '/image/logo_zakiyah.png',
            ],
            [
                'partner' => 'Edu Global Medan',
                'alamat' => 'Komplek OCBC, Jl. Gagak Hitam No. A1A-A4B, Asam Kumbang, Kec. Medan Selayang, Kota Medan, Sumatera Utara 20133',
                'maps' => 'https://maps.app.goo.gl/iZDHB3Lm5kZtyE589',
                'logo' => '/image/logo_edu_global.png',
            ],
        ]);
    }
}
