<?php

namespace App\Models;

use CodeIgniter\Model;

class UserPrestasiModel extends Model
{
    protected $table         = 'user_prestasi';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['user_id', 'prestasi_id', 'created_at'];
    protected $useTimestamps = true;

    // Mengambil data user yang terkait dengan suatu prestasi
    public function getUsersByPrestasiId($prestasi_id)
    {
        return $this->db->table($this->table)
            ->select('users.*')
            ->join('users', 'users.id = user_prestasi.user_id')
            ->where('prestasi_id', $prestasi_id)
            ->get()
            ->getResultArray();
    }

    // Menghapus data pivot berdasarkan prestasi_id
    public function deleteByPrestasiId($prestasi_id)
    {
        return $this->where('prestasi_id', $prestasi_id)->delete();
    }
}
