<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Database\Migrations\ManageKelas;
use App\Models\Manage_kelasModel;
use App\Models\Manage_akunModel;
use Myth\Auth\Models\UserModel;

class Manage_kelasController extends BaseController
{
    protected $manageKelasModel;
    protected $userModel;

    public function __construct()
    {
        $this->manageKelasModel = new Manage_kelasModel();
        $this->userModel = new UserModel();
    }

    // Daftar Kelas
    public function index()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        // Mengambil semua kelas beserta jumlah anggota
        $classes = $this->manageKelasModel->getAllClassesWithMemberCount(); // Memanggil method untuk ambil kelas beserta jumlah anggotanya
        $data = [
            'title' => 'Daftar Kelas',
            'classes' => $classes,
        ];

        return view('admin/manage_kelas/index', $data);
    }

    // Form Tambah Kelas
    public function tambah()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Tambah Kelas',
        ];

        return view('admin/manage_kelas/tambah', $data);
    }

    // Simpan Kelas
    public function simpan()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_kelas' => [
                'rules'  => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required'   => 'Nama kelas harus diisi.',
                    'min_length' => 'Nama kelas harus memiliki minimal 3 karakter.',
                    'max_length' => 'Nama kelas tidak boleh lebih dari 255 karakter.'
                ]
            ],
            'deskripsi' => [
                'rules'  => 'permit_empty',
                'errors' => [
                    'permit_empty' => 'Deskripsi dapat dikosongkan.'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal, tampilkan error
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Ambil data dari form
        $kelas_nama = $this->request->getPost('nama_kelas');
        $kelas_deskripsi = $this->request->getPost('deskripsi');
        $kelas_status = $this->request->getPost('status'); // Ambil nilai status

        // Generate kode kelas jika tidak ada
        $kelas_kode = $this->generateClassCode($kelas_nama); // Fungsi untuk membuat kode kelas otomatis

        // Siapkan data untuk disimpan
        $data = [
            'nama_kelas' => $kelas_nama,
            'deskripsi' => $kelas_deskripsi,
            'kode_kelas' => $kelas_kode,
            'status' => $kelas_status, // Simpan status sesuai input (1 untuk aktif, 0 untuk tidak aktif)
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Simpan data kelas ke database
        $this->manageKelasModel->saveKelas($data);

        // Redirect ke halaman manage kelas
        return redirect()->to('admin/manage_kelas')->with('success', 'Kelas berhasil disimpan.');
    }

    private function generateClassCode($kelas_nama)
    {
        // Ambil kata pertama dari setiap suku kata dengan mempertimbangkan huruf besar/kecil
        $words = explode(' ', strtoupper($kelas_nama)); // Ubah jadi uppercase untuk akurasi
        $code = '';

        // Ambil huruf pertama dari setiap kata
        foreach ($words as $word) {
            $code .= substr($word, 0, 1);
        }

        // Kode kelas harus terdiri dari huruf besar dan kecil, tambahkan huruf acak (besar/kecil)
        $randomChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $randomLetter = $randomChars[random_int(0, strlen($randomChars) - 1)];
        $code .= $randomLetter;

        // Tambahkan angka acak 1 digit
        $code .= random_int(0, 9); // Angka acak 1 digit

        // Jika kode kelas kurang dari 6 karakter, tambahkan huruf atau angka acak sampai 6
        while (strlen($code) < 6) {
            $randomChar = $randomChars[random_int(0, strlen($randomChars) - 1)];
            $code .= $randomChar;
        }

        // Jika kode kelas lebih dari 6 karakter, potong menjadi 6 karakter
        $code = substr($code, 0, 6);

        return $code;
    }


    // Form Edit Kelas
    public function edit($id)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $kelas = $this->manageKelasModel->find($id);
        $data = [
            'title' => 'Edit Kelas',
            'kelas' => $kelas,
        ];

        return view('admin/manage_kelas/edit', $data);
    }

    // Update Kelas
    public function update($id)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_kelas' => [
                'rules'  => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required'   => 'Nama kelas harus diisi.',
                    'min_length' => 'Nama kelas harus memiliki minimal 3 karakter.',
                    'max_length' => 'Nama kelas tidak boleh lebih dari 255 karakter.'
                ]
            ],
            'deskripsi' => [
                'rules'  => 'permit_empty',
                'errors' => [
                    'permit_empty' => 'Deskripsi dapat dikosongkan.'
                ]
            ],
            'status' => [
                'rules'  => 'required',
                'errors' => [
                    'required'   => 'Status kelas harus diisi.'
                ]
            ],
        ]);

        // Cek apakah validasi gagal
        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal, tampilkan error
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Ambil data dari form
        $data = [
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'status'     => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        try {
            // Update data kelas ke database
            $this->manageKelasModel->updateKelas($id, $data);

            // Redirect ke halaman manage kelas
            return redirect()->to('admin/manage_kelas')->with('success', 'Kelas berhasil diupdate.');
        } catch (\Exception $e) {
            // Jika terjadi error saat update data, tampilkan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate kelas: ' . $e->getMessage());
        }
    }

    // Hapus Kelas
    public function delete($id)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $this->manageKelasModel->deleteKelas($id);
        return redirect()->to('admin/manage_kelas');
    }
    public function kelola_anggota()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        // Mengambil semua kelas beserta jumlah anggota
        $classes = $this->manageKelasModel->getAllClassesWithMemberCount();

        // Filter hanya kelas dengan status aktif (status = 1)
        $activeClasses = array_filter($classes, function ($kelas) {
            return $kelas['status'] == 1; // Pastikan tipe data sesuai (integer atau string)
        });

        $data = [
            'title'   => 'Kelola Anggota Kelas',
            'classes' => $activeClasses,
        ];

        return view('admin/manage_kelas/kelola_anggota', $data);
    }
    public function detail($id)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        // Ambil detail kelas (termasuk jumlah anggota)
        $class = $this->manageKelasModel->getClassWithMemberCountById($id);
        // Ambil data anggota kelas
        $members = $this->manageKelasModel->getAnggotaByKelas($id);

        $data = [
            'title'   => 'Detail Anggota Kelas',
            'class'   => $class,
            'members' => $members,
        ];

        return view('admin/manage_kelas/detail_kelas', $data);
    }


    // public function tambah_anggota($id)
    // {
    //     if (!logged_in()) {
    //         return redirect()->to('/login');
    //     }

    //     // Ambil detail kelas berdasarkan $id
    //     $class = $this->manageKelasModel->getKelasById($id);
    //     if (!$class) {
    //         return redirect()->to('admin/manage_kelas')->with('error', 'Kelas tidak ditemukan.');
    //     }

    //     // Ambil semua user dengan role "siswa"
    //     $users = $this->manageKelasModel->getUsersByRole('siswa');

    //     $data = [
    //         'title' => 'Tambah Anggota Kelas',
    //         'class' => $class,
    //         'users' => $users
    //     ];

    //     return view('admin/manage_kelas/tambah_anggota', $data);
    // }

    // public function tambah_anggota_proses($classId)
    // {
    //     if (!logged_in()) {
    //         return redirect()->to('/login');
    //     }

    //     $userId = $this->request->getPost('id_user');

    //     // Panggil fungsi model untuk menambahkan anggota
    //     $result = $this->manageKelasModel->addAnggota($classId, $userId);

    //     if (!$result) {
    //         return redirect()->back()->with('error', 'Gagal menambahkan anggota. Pastikan user tersedia.');
    //     }

    //     return redirect()->to('admin/manage_kelas/detail/' . $classId)
    //         ->with('success', 'Anggota ' . $result['fullname'] . ' berhasil ditambahkan.');
    // }


    // // Evaluasi Pembelajaran
    // public function evaluasi()
    // {
    //     if (!logged_in()) {
    //         return redirect()->to('/login');
    //     }

    //     // Menampilkan data evaluasi pembelajaran
    //     $evaluasiData = $this->manageKelasModel->getEvaluasiData();
    //     $data = [
    //         'title' => 'Evaluasi Pembelajaran',
    //         'evaluasi' => $evaluasiData,
    //     ];

    //     return view('admin/manage_kelas/evaluasi', $data);
    // }

    // // Update Evaluasi Pembelajaran
    // public function update_evaluasi()
    // {
    //     if (!logged_in()) {
    //         return redirect()->to('/login');
    //     }

    //     $evaluasiData = [
    //         'kelas_id' => $this->request->getPost('kelas_id'),
    //         'nilai' => $this->request->getPost('nilai'),
    //         'feedback' => $this->request->getPost('feedback'),
    //     ];

    //     $this->manageKelasModel->updateEvaluasi($evaluasiData);
    //     return redirect()->to('/manage_kelas/evaluasi');
    // }

    public function tambah_anggota($id)
    {
        $manage_akunModel = new Manage_akunModel();

        // Ambil semua user dengan role "siswa" (role == 2)
        $users = $manage_akunModel->getAllUsersWithRoles();
        $filteredUsers = array_filter($users, function ($user) {
            return $user['role'] == 2;
        });

        // Ambil anggota yang sudah terdaftar di kelas ini
        $members = $this->manageKelasModel->getAnggotaByKelas($id);
        // Buat array dari kolom 'id_user'
        $member_ids = array_column($members, 'id_user');

        // (Opsional) Debugging: Log isi $member_ids
        log_message('debug', 'Member IDs: ' . print_r($member_ids, true));

        $data = [
            'title'      => 'Daftar Akun',
            'users'      => $filteredUsers,
            'class_id'   => $id,
            'member_ids' => $member_ids,
        ];

        return view('admin/manage_kelas/tambah_anggota', $data);
    }


    public function addMemberToClass()
    {
        $kelasId = $this->request->getPost('kelas_id');
        $userId  = $this->request->getPost('user_id');

        $result = $this->manageKelasModel->addAnggota($kelasId, $userId);

        if ($result === 'already_joined') {
            return redirect()->to('/admin/manage_kelas/kelola_anggota/tambah/' . $kelasId)
                ->with('error', 'Akun telah bergabung di kelas ini.');
        } elseif ($result) {
            return redirect()->to('/admin/manage_kelas/kelola_anggota/tambah/' . $kelasId)
                ->with('success', 'Anggota berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan anggota.');
        }
    }

    public function hapus_anggota($id)
    {
        // $id di sini adalah ID record dari tabel kelas_anggota
        if ($this->manageKelasModel->removeMemberById($id)) {
            return redirect()->back()->with('success', 'Anggota berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus anggota.');
        }
    }

    public function removeMember($kelas_id, $user_id)
    {
        return $this->db->table('kelas_anggota')
            ->where(['kelas_id' => $kelas_id, 'user_id' => $user_id])
            ->delete();
    }
}
