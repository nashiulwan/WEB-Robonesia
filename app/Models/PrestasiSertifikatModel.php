<?php

namespace App\Models;

use CodeIgniter\Model;

class PrestasiSertifikatModel extends Model
{
    protected $table         = 'prestasi';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['nama_kegiatan', 'jenis', 'tingkat', 'tahun', 'pencapaian', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    public function getUsersByRole($groupId)
    {
        return $this->db->table('auth_groups_users')
            ->join('users', 'users.id = auth_groups_users.user_id')
            ->where('auth_groups_users.group_id', $groupId)
            ->get()
            ->getResultArray();
    }
}
