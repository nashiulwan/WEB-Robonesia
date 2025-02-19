<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<style>
    .table-detail tbody tr:nth-of-type(odd) {
        background-color: rgba(78, 115, 223, 0.1) !important;
    }

    .table-detail tbody tr:nth-of-type(even) {
        background-color: white !important;
    }

    .desc-container {
        max-height: 6em;
        overflow-y: auto;
        line-height: 1.5em;
    }

    .bg-green {
        background-color: rgba(0, 255, 156, 0.2) !important;
    }

    /* Container untuk anggota dengan scroll vertikal */
    .members-container {
        max-height: 25vh;
        overflow-y: auto;
    }

    .members-container table thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #2222;
    }
</style>

<div class="container-fluid">
    <h1 class="h3 text-gray-800 mb-4"><?= esc($title) ?></h1>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <!-- SECTION 1: Anggota Kelas -->
    <div class="mb-4">
        <h5>Anggota Kelas</h5>
        <div class="members-container">
            <?php
            // Filter data untuk anggota yang sudah ditambahkan
            $members = array_filter($users, function ($user) use ($member_ids) {
                return in_array($user['id'], $member_ids);
            });
            ?>
            <?php if (!empty($members)) : ?>
                <!-- Membungkus tabel dengan div untuk scroll horizontal -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm">
                        <thead class="table" style="color: black; background-color:#2222">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 25%;">Nama Pengguna</th>
                                <th style="width: 35%;">Email</th>
                                <th style="width: 35%;">Nama Lengkap</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($members as $row) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= esc($row['username']); ?></td>
                                    <td><?= esc($row['email']); ?></td>
                                    <td><?= esc($row['fullname']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>Tidak ada anggota yang ditambahkan.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- SECTION 2: Pencarian dan Daftar Akun Siswa (yang belum ditambahkan) -->
    <div class="mb-3 d-flex align-items-center justify-content-between">
        <div class="flex-grow-1 me-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari akun berdasarkan username, nama, atau email">
        </div>
        <i class="fas fa-search text-muted"></i>
    </div>

    <?php
    // Filter data untuk akun yang belum ditambahkan
    $nonMembers = array_filter($users, function ($user) use ($member_ids) {
        return !in_array($user['id'], $member_ids);
    });
    ?>

    <!-- Membungkus tabel dengan div untuk scroll horizontal -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="nonMemberTable">
            <thead class="table" style="color: black; background-color:#2222">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama Pengguna</th>
                    <th style="width: 30%;">Email</th>
                    <th style="width: 35%;">Nama Lengkap</th>
                    <th style="width: 5%;">Aksi</th>
                </tr>
            </thead>
            <tbody class="table-group-divider" style="color:black;">
                <?php if (!empty($nonMembers)) : ?>
                    <?php $no = 1; ?>
                    <?php foreach ($nonMembers as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= esc($row['username']); ?></td>
                            <td><?= esc($row['email']); ?></td>
                            <td><?= esc($row['fullname']); ?></td>
                            <td>
                                <!-- Form untuk menambahkan anggota ke kelas -->
                                <form action="<?= base_url('admin/manage_kelas/kelola_anggota/tambah_anggota'); ?>" method="post" onsubmit="return confirm('Tambah akun ini ke kelas?')">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="kelas_id" value="<?= esc($class_id); ?>">
                                    <input type="hidden" name="user_id" value="<?= esc($row['id']); ?>">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data ditemukan</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- jQuery dan Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#nonMemberTable tbody tr").each(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

<?= $this->endSection() ?>