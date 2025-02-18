<?php

namespace App\Models;

use CodeIgniter\Model;

class Manage_kelasModel extends Model
{
    protected $table      = 'manage_kelas'; // Tabel utama untuk kelas
    protected $primaryKey = 'id'; // Primary key tabel manage_kelas

    // Tabel dan kolom yang bisa diubah
    protected $allowedFields = ['nama_kelas', 'deskripsi', 'kode_kelas', 'status', 'created_at', 'updated_at'];

    // Tabel relasi untuk kelas anggota
    protected $tableAnggota = 'kelas_anggota';

    const STATUS_AKTIF = 'aktif';
    const STATUS_NONAKTIF = 'nonaktif';
    // Definisikan relasi ke tabel 'users' untuk mencari pengguna berdasarkan ID
    public function getUserById($id)
    {
        return $this->db->table('users')
            ->where('id', $id)
            ->get()
            ->getRowArray();
    }

    // Ambil semua kelas beserta jumlah anggotanya
    public function getAllClassesWithMemberCount()
    {
        return $this->db->table('manage_kelas')
            ->select('manage_kelas.id, manage_kelas.nama_kelas, manage_kelas.deskripsi, manage_kelas.kode_kelas, manage_kelas.status, COUNT(kelas_anggota.id) as jumlah_anggota')
            ->join('kelas_anggota', 'kelas_anggota.id_kelas = manage_kelas.id', 'left')
            ->groupBy('manage_kelas.id')
            ->get()
            ->getResultArray();
    }

    public function getUsersByRole($role)
    {
        return $this->db->table('auth_groups_users')
            ->join('users', 'users.id = auth_groups_users.user_id')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
            ->where('auth_groups.name', $role) // Filter berdasarkan role
            ->get()
            ->getResultArray();
    }

    // Menghapus anggota dari kelas
    public function removeAnggota($kelasId, $userId)
    {
        return $this->db->table($this->tableAnggota)
            ->where('kelas_id', $kelasId)
            ->where('user_id', $userId)
            ->delete();
    }

    // Mendapatkan semua anggota kelas
    public function getAnggotaByKelas($kelasId)
    {
        return $this->db->table($this->tableAnggota)
            ->join('users', 'users.id = kelas_anggota.user_id')
            ->where('kelas_anggota.kelas_id', $kelasId)
            ->get()
            ->getResultArray();
    }

    // Mendapatkan semua kelas yang tersedia
    public function getAllKelas()
    {
        return $this->db->table($this->table)
            ->get()
            ->getResultArray();
    }

    // Menyimpan data kelas baru
    public function saveKelas($data)
    {
        return $this->db->table($this->table)
            ->insert($data);
    }

    // Mengupdate data kelas
    public function updateKelas($id, $data)
    {
        return $this->db->table($this->table)
            ->where('id', $id)
            ->update($data);
    }

    // Menghapus kelas
    public function deleteKelas($id)
    {
        return $this->db->table($this->table)
            ->where('id', $id)
            ->delete();
    }

    public function getClassWithMemberCountById($id)
    {
        return $this->db->table('manage_kelas')
            ->select('manage_kelas.id, manage_kelas.nama_kelas, manage_kelas.deskripsi, manage_kelas.kode_kelas, manage_kelas.status, COUNT(kelas_anggota.id) as jumlah_anggota')
            ->join('kelas_anggota', 'kelas_anggota.id_kelas = manage_kelas.id', 'left')
            ->where('manage_kelas.id', $id)
            ->groupBy('manage_kelas.id')
            ->get()
            ->getRowArray();
    }

    public function addAnggota($kelasId, $userId)
    {
        // Ambil data user berdasarkan id dari tabel 'users'
        $user = $this->getUserById($userId);

        // Jika user tidak ditemukan, kembalikan false atau lakukan penanganan error
        if (!$user) {
            return false;
        }

        // Siapkan data untuk insert ke tabel kelas_anggota
        $data = [
            'id_kelas'   => $kelasId,
            'id_user'    => $userId,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Insert data ke tabel kelas_anggota
        $this->db->table($this->tableAnggota)->insert($data);

        // Kembalikan data user yang diperlukan
        return [
            'username'     => $user['username'],
            'fullname'     => $user['fullname'],
            'asal_sekolah' => $user['asal_sekolah']
        ];
    }
}
