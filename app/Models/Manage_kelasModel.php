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

    public function getAnggotaByKelas($kelasId)
    {
        return $this->db->table($this->tableAnggota)
            ->select('kelas_anggota.id as anggota_id, kelas_anggota.id_user, users.username, users.fullname, users.email')
            ->join('users', 'users.id = kelas_anggota.id_user')
            ->where('kelas_anggota.id_kelas', $kelasId)
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
        // Log nilai yang diterima
        log_message('debug', 'addAnggota: Received kelasId = ' . $kelasId . ', userId = ' . $userId);

        // Cek apakah kelas dengan ID tersebut ada
        if (!$this->find($kelasId)) {
            log_message('error', 'addAnggota: Kelas dengan ID ' . $kelasId . ' tidak ditemukan.');
            return false;
        }

        // Ambil data user dari tabel 'users'
        $user = $this->getUserById($userId);
        if (!$user) {
            log_message('error', 'addAnggota: User dengan ID ' . $userId . ' tidak ditemukan.');
            return false;
        }

        // Cek apakah pasangan kelas dan user sudah ada di tabel kelas_anggota
        $existing = $this->db->table($this->tableAnggota)
            ->where('id_kelas', $kelasId)
            ->where('id_user', $userId)
            ->get()
            ->getRow();
        if ($existing) {
            log_message('debug', 'addAnggota: User ' . $userId . ' sudah bergabung di kelas ' . $kelasId);
            // Mengembalikan string khusus agar controller bisa menampilkan pesan bahwa user sudah bergabung
            return 'already_joined';
        }

        $data = [
            'id_kelas'   => $kelasId,
            'id_user'    => $userId,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Lakukan insert ke tabel kelas_anggota
        $insert = $this->db->table($this->tableAnggota)->insert($data);
        if (!$insert) {
            log_message('error', 'addAnggota: Gagal melakukan insert ke kelas_anggota. Data: ' . json_encode($data));
            return false;
        }

        log_message('debug', 'addAnggota: Insert berhasil. Data: ' . json_encode($data));

        return [
            'username'     => $user['username'],
            'fullname'     => $user['fullname'],
            'asal_sekolah' => $user['asal_sekolah']
        ];
    }

    public function removeMemberById($id)
    {
        $this->db->table($this->tableAnggota)
            ->where('id', $id)
            ->delete();
        log_message('debug', 'Affected rows: ' . $this->db->affectedRows());
        return $this->db->affectedRows() > 0;
    }
}
