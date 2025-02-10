<?php

namespace App\Models;

use CodeIgniter\Model;

class Manage_akunModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'username', 'fullname', 'password_hash', 'user_image', 'created_at', 'updated_at', 'active'];

    public function getAllUsersWithRoles()
    {
        return $this->db->table('users')
            ->select("users.id, users.username, users.email, users.fullname, auth_groups_users.group_id AS role")
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left')
            ->get()
            ->getResultArray();
    }

    public function updateUserRole($userId, $newRole)
    {
        // Pastikan nilai role yang dikirim benar
        if (!in_array($newRole, [0, 1, 2, 3])) {
            return false;
        }

        // Cek apakah user sudah ada di auth_groups_users
        $existing = $this->db->table('auth_groups_users')
            ->where('user_id', $userId)
            ->get()
            ->getRow();

        if ($existing) {
            // Jika user sudah ada, update group_id
            return $this->db->table('auth_groups_users')
                ->where('user_id', $userId)
                ->update(['group_id' => $newRole]);
        } else {
            // Jika user belum ada di tabel auth_groups_users, tambahkan baru
            return $this->db->table('auth_groups_users')
                ->insert(['user_id' => $userId, 'group_id' => $newRole]);
        }
    }

    public function simpan($data)
    {
        $role = isset($data['role']) ? $data['role'] : null;
        unset($data['role']); // Hapus role dari data yang akan disimpan di tabel users

        if ($this->insert($data)) {
            $userId = $this->insertID();

            // Simpan role jika tersedia
            if ($role !== null) {
                return $this->assignUserRole($userId, $role);
            }
            return true;
        }

        return false;
    }

    public function assignUserRole($userId, $groupId)
    {
        // Pastikan nilai group_id benar (1 = Admin, 2 = Siswa, 3 = Guru)
        if (!in_array($groupId, [1, 2, 3])) {
            return false;
        }

        // Periksa apakah user sudah memiliki role
        $existing = $this->db->table('auth_groups_users')
            ->where('user_id', $userId)
            ->get()
            ->getRow();

        if ($existing) {
            // Jika sudah ada, update role
            return $this->db->table('auth_groups_users')
                ->where('user_id', $userId)
                ->update(['group_id' => $groupId]);
        } else {
            // Jika belum ada, tambahkan role baru
            return $this->db->table('auth_groups_users')
                ->insert(['user_id' => $userId, 'group_id' => $groupId]);
        }
    }

    public function getUserRole($userId)
    {
        $result = $this->db->table('auth_groups_users')
            ->select('group_id')
            ->where('user_id', $userId)
            ->get()
            ->getRow();

        return $result ? $result->group_id : null; // Jika tidak ditemukan, kembalikan null
    }
}
