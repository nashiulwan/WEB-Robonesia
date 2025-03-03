<?php

namespace App\Models;

use CodeIgniter\Model;

class SertifikatModel extends Model
{
    protected $table         = 'sertifikat';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['nama_file', 'deskripsi', 'kategori', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    public function getUsersByRole($groupId)
    {
        return $this->db->table('auth_groups_users')
            ->join('users', 'users.id = auth_groups_users.user_id')
            ->where('auth_groups_users.group_id', $groupId)
            ->get()
            ->getResultArray();
    }

    public function getSertifikatByUser($userId)
    {
        return $this->db->table('sertifikat')
            ->join('sertifikat_recipients', 'sertifikat_recipients.sertifikat_id = sertifikat.id')
            ->where('sertifikat_recipients.target_type', 'users')
            ->where('sertifikat_recipients.target_id', $userId)
            ->get()
            ->getResultArray();
    }

    public function getSertifikatByPrestasi($prestasiId)
    {
        return $this->db->table('sertifikat')
            ->join('sertifikat_recipients', 'sertifikat_recipients.sertifikat_id = sertifikat.id')
            ->where('sertifikat_recipients.target_type', 'prestasi')
            ->where('sertifikat_recipients.target_id', $prestasiId)
            ->get()
            ->getResultArray();
    }

    public function getSertifikatByKelas($kelasId)
    {
        return $this->db->table('sertifikat')
            ->join('sertifikat_recipients', 'sertifikat_recipients.sertifikat_id = sertifikat.id')
            ->where('sertifikat_recipients.target_type', 'manage_kelas')
            ->where('sertifikat_recipients.target_id', $kelasId)
            ->get()
            ->getResultArray();
    }

    public function getAllSertifikats()
    {
        $builder = $this->db->table('sertifikat as s');

        $builder->select(
            's.id, s.nama_file, s.deskripsi, s.kategori, 
         GROUP_CONCAT(
            CASE 
                WHEN sr.target_type = "users" THEN u.fullname
                WHEN sr.target_type = "prestasi" THEN p.nama_kegiatan
                WHEN sr.target_type = "manage_kelas" THEN mk.nama_kelas
                ELSE "Unknown"
            END
         SEPARATOR ", ") as penerima',
            false
        );

        $builder->join('sertifikat_recipients as sr', 'sr.sertifikat_id = s.id', 'left');
        $builder->join('users as u', 'u.id = sr.target_id AND sr.target_type = "users"', 'left');
        $builder->join('prestasi as p', 'p.id = sr.target_id AND sr.target_type = "prestasi"', 'left');
        $builder->join('manage_kelas as mk', 'mk.id = sr.target_id AND sr.target_type = "manage_kelas"', 'left');
        $builder->groupBy('s.id');
        return $builder->get()->getResultArray();
    }
}
