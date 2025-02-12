<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfilModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'email',
        'username',
        'fullname',
        'password_hash',
        'user_image',
        'kelas',
        'alamat',
        'nomor_telepon',
        'asal_sekolah'
    ];

    // Fungsi untuk mengambil data user berdasarkan ID yang sedang login
    public function getUserById($id)
    {
        return $this->where('id', $id)->first(); // Mengembalikan satu baris data user
    }

    // Fungsi untuk menyimpan data (insert/update)
    public function simpan($data)
    {
        return $this->save($data);
    }
}
