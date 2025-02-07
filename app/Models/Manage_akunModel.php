<?php

namespace App\Models;

use CodeIgniter\Model;

class Manage_akunModel extends Model
{
    protected $table = 'users';  // Tabel utama
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'fullname'];

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
}
