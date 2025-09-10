<?php

namespace App\Models;

use CodeIgniter\Model;

class SertifikatModel extends Model
{
    protected $table         = 'sertifikat';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['nama_file', 'deskripsi', 'kategori', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    public function getSertifikatById($id)
    {
        return $this->where('id', $id)->first();
    }
    public function getSertifikatDetailById($sertifikatId)
    {
        return $this->select(
            's.id, s.nama_file, s.deskripsi, sr.target_type, 
             GROUP_CONCAT(DISTINCT 
                CASE 
                    WHEN sr.target_type = "users" THEN u.fullname
                    WHEN sr.target_type = "prestasi" THEN p.nama_kegiatan
                    WHEN sr.target_type = "manage_kelas" THEN mk.nama_kelas
                    ELSE "-"
                END
             SEPARATOR ", ") as penerima'
        )
            ->from('sertifikat as s')
            ->join('sertifikat_recipients as sr', 'sr.sertifikat_id = s.id', 'left')
            ->join('users as u', 'u.id = sr.target_id AND sr.target_type = "users"', 'left')
            ->join('prestasi as p', 'p.id = sr.target_id AND sr.target_type = "prestasi"', 'left')
            ->join('manage_kelas as mk', 'mk.id = sr.target_id AND sr.target_type = "manage_kelas"', 'left')
            ->where('s.id', $sertifikatId)
            ->groupBy('s.id, sr.target_type')
            ->first();
    }

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
    
    public function getSertifikatByKelasDanUser($userId, $username)
    {
        // Ambil semua sertifikat kategori "manage_kelas"
        $sertifikatList = $this->db->table('sertifikat')
            ->select('sertifikat.id, sertifikat.nama_file, sertifikat.deskripsi, manage_kelas.nama_kelas')
            ->join('sertifikat_recipients', 'sertifikat_recipients.sertifikat_id = sertifikat.id')
            ->join('manage_kelas', 'manage_kelas.id = sertifikat_recipients.target_id')
            ->where('sertifikat_recipients.target_type', 'manage_kelas')
            ->get()
            ->getResultArray();
    
        $filteredSertifikat = [];
    
        // Loop melalui semua sertifikat dan cek apakah nama file cocok dengan user
        foreach ($sertifikatList as $sertifikat) {
            // Coba decode JSON, jika gagal anggap sebagai string biasa
            $files = json_decode($sertifikat['nama_file'], true);
    
            // Jika gagal decode atau bukan array, ubah menjadi array dengan satu elemen
            if (!is_array($files)) {
                $files = [$sertifikat['nama_file']];
            }
    
            // Filter file yang mengandung nama user di depannya
            $matchingFiles = array_filter($files, function ($file) use ($username) {
                return strpos($file, $username . "_") === 0; // Cek apakah file diawali dengan nama user
            });
    
            if (!empty($matchingFiles)) {
                $filteredSertifikat[$sertifikat['nama_kelas']][] = [
                    'deskripsi' => $sertifikat['deskripsi'],
                    'nama_file' => array_values($matchingFiles), // Reset array index
                ];
            }
        }
    
        return $filteredSertifikat;
    }





    public function getAllSertifikats()
    {
        $builder = $this->db->table('sertifikat as s');

        $builder->select(
            's.id, s.nama_file, s.deskripsi, s.kategori, 
             GROUP_CONCAT(
                CASE 
                    WHEN sr.target_type = "users" THEN CONCAT(u.fullname, " [Akun]")
                    WHEN sr.target_type = "prestasi" THEN CONCAT(p.nama_kegiatan, " [Prestasi]")
                    WHEN sr.target_type = "manage_kelas" THEN CONCAT(mk.nama_kelas, " [Kelas]")
                    ELSE "-"
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
