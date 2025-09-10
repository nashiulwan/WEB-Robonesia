<?php

namespace App\Libraries;

class CaptchaLib
{
  // Fungsi untuk menghasilkan gambar CAPTCHA
  public function generateCaptcha()
  {
    // Angka acak untuk soal matematika
    $num1 = rand(10, 25);
    $num2 = rand(4, 9);
    $result = $num1 + $num2;

    // Simpan hasil CAPTCHA dalam session
    session()->set('captcha_result', $result);
    // Log CAPTCHA yang disimpan dalam session
    log_message('debug', 'Captcha yang disimpan di session: ' . session('captcha_result'));

    // Buat gambar dengan ukuran 120x40
    $width = 120;
    $height = 40;
    $image = imagecreate($width, $height);

    // Warna latar belakang, teks, garis, dan titik acak
    $bgColor = imagecolorallocate($image, 255, 255, 255); // Putih
    $textColor = imagecolorallocate($image, 0, 0, 0); // Hitam
    $lineColor = imagecolorallocate($image, 200, 200, 200); // Abu-abu
    $dotColor = imagecolorallocate($image, 150, 150, 150); // Abu-abu muda

    // Tambahkan garis acak untuk noise
    for ($i = 0; $i < 5; $i++) {
      imageline(
        $image,
        rand(0, $width),
        rand(0, $height),
        rand(0, $width),
        rand(0, $height),
        $lineColor
      );
    }

    // Tambahkan titik acak untuk noise
    for ($i = 0; $i < 50; $i++) {
      imagesetpixel($image, rand(0, $width), rand(0, $height), $dotColor);
    }

    // Set path ke file font TrueType (.ttf)
    // Pastikan file font tersedia dan path-nya sudah benar
    $fontPath = 'font/arial.ttf'; // Ubah path sesuai dengan lokasi file font di server Anda
    $fontSize = 16; // Ukuran font
    $x = 10;      // Koordinat x awal
    $y = 30;      // Koordinat y sebagai baseline teks

    /*
      Komponen soal CAPTCHA:
      - Angka dan tanda tanya akan dirotasi dengan sudut acak antara -15 dan 15 derajat.
      - Tanda '+' dan '=' tidak dirotasi (sudut 0 derajat).
    */
    $components = [
      ['text' => $num1,  'rotate' => true],
      ['text' => ' + ',  'rotate' => false],
      ['text' => $num2,  'rotate' => true],
      ['text' => ' = ',  'rotate' => false],
      ['text' => '?',   'rotate' => true],
    ];

    // Gambar masing-masing komponen dengan atau tanpa rotasi
    foreach ($components as $component) {
      // Jika 'rotate' true, pilih sudut acak antara -15 dan 15 derajat,
      // jika tidak, gunakan sudut 0 derajat.
      $angle = $component['rotate'] ? rand(-15, 15) : 0;

      // Dapatkan bounding box untuk menentukan lebar teks
      $bbox = imagettfbbox($fontSize, $angle, $fontPath, $component['text']);
      $textWidth = abs($bbox[2] - $bbox[0]);

      // Gambar teks dengan rotasi
      imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontPath, $component['text']);

      // Perbarui posisi x untuk komponen selanjutnya (tambahkan spasi ekstra 5 piksel)
      $x += $textWidth + 5;
    }

    // Simpan gambar CAPTCHA dalam bentuk base64
    ob_start();
    imagepng($image);
    $imageData = ob_get_clean();
    imagedestroy($image);

    return 'data:image/png;base64,' . base64_encode($imageData);
  }

  // Validasi CAPTCHA dengan input yang diberikan oleh pengguna
  public function validateCaptcha($input)
  {
    // Ambil nilai CAPTCHA yang disimpan dalam session
    $sessionCaptcha = session('captcha_result');
    log_message('debug', 'Session CAPTCHA: ' . $sessionCaptcha);

    // Cek jika session captcha kosong
    if ($sessionCaptcha === null) {
      log_message('error', 'Captcha session tidak ditemukan.');
      return false;
    }

    log_message('debug', 'Input CAPTCHA: ' . $input);

    // Pastikan input valid dan sesuai dengan CAPTCHA yang disimpan di session
    if (intval($input) === intval($sessionCaptcha)) {
      $this->clearCaptcha(); // Hapus CAPTCHA setelah valid
      return true;
    }

    return false;
  }

  // Hapus CAPTCHA dari session setelah digunakan
  public function clearCaptcha()
  {
    session()->remove('captcha_result');
  }
}
