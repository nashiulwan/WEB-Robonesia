<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<style>
    /* Tabel Data Detail: Baris pertama biru transparan 20%, kedua putih */
    .table-detail tbody tr:nth-of-type(odd) {
        background-color: rgba(78, 115, 223, 0.1) !important;
        /* Biru dengan opacity 20% */
    }

    .table-detail tbody tr:nth-of-type(even) {
        background-color: white !important;
    }

    .table-account tbody tr:nth-of-type(odd) {
        background-color: white !important;
    }

    .table-account tbody tr:nth-of-type(even) {
        background-color: rgba(78, 115, 223, 0.1) !important;
        /* Biru dengan opacity 20% */
    }

    .th-data-akun {
        width: 51.5%;
    }

    @media (max-width: 750px) {
        .th-data-akun {
            width: 35%;
        }
    }
</style>


<div class="container-fluid my-4">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <!-- Baris pertama: Foto Profil dan Data Detail -->
            <div class="row align-items-center">
                <!-- Kolom Foto Profil -->
                <div class="col-md-3 text-center mb-2 mb-md-0">
                    <img src=" <?= base_url('uploads/' . $user['user_image']) ?>" alt="Foto Profil" class="img-fluid rounded" style="max-width:220px; object-fit:cover;">
                </div>
                <!-- Kolom Data Detail -->
                <div class="col-md-9" style="margin-top: 1rem;">
                    <table class="table table-borderless table-striped table-detail" style="color: black;">
                        <tr>
                            <th style="width:35%;">Nama Lengkap</th>
                            <td><?= esc($user['fullname']) ?></td>
                        </tr>
                        <tr>
                            <th>Asal Sekolah</th>
                            <td><?= esc($user['asal_sekolah']) ?></td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td><?= esc($user['kelas']) ?></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td><?= esc($user['alamat']) ?></td>
                        </tr>
                        <tr>
                            <th>No HP</th>
                            <td><?= esc($user['nomor_telepon']) ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Baris kedua: Data Akun -->
            <div class="row">
                <div class="col-md-12 data-akun" style="margin-top: -1rem;">
                    <table class="table table-borderless table-striped table-account" style="color:black">
                        <tr>
                            <th class="th-data-akun">Username</th>
                            <td><strong><?= esc($user['username']) ?></strong></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= esc($user['email']) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- Tombol Edit Profil -->
            <div class="text-end">
                <a href="<?= base_url('admin/profil/edit') ?>" class="btn btn-primary" style="margin-top:1rem">Edit Profil</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>