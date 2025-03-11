<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'username', 'fullname', 'password_hash', 'user_image', 'created_at', 'updated_at', 'active',  'asal_sekolah',  'kelas',  'alamat',  'nomor_telepon'];


    public function getUsersByRole($groupId)
    {
        return $this->db->table('auth_groups_users')
            ->join('users', 'users.id = auth_groups_users.user_id')
            ->where('auth_groups_users.group_id', $groupId)
            ->get()
            ->getResultArray();
    }

    public function getUserById($userId)
    {
        return $this->where('id', $userId)->first();
    }
}
