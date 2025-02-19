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
</style>

<div class="container-fluid my-4">
    <h1 class="h3 mb-4 text-gray-800">Informasi Kelas</h1>
    <table class="table table-borderless table-striped table-detail" style="color: black;">
        <tr>
            <th style="width:35%;">Nama Kelas</th>
            <td><?= esc($class['nama_kelas']) ?></td>
        </tr>
        <tr>
            <th>Deskripsi</th>
            <td>
                <div class="desc-container">
                    <?= esc($class['deskripsi']) ?>
                </div>
            </td>
        </tr>
        <tr>
            <th>Kode Kelas</th>
            <td><?= esc($class['kode_kelas']) ?></td>
        </tr>
        <tr>
            <th>Status Kelas</th>
            <td><?= esc($class['status']) ?></td>
        </tr>
        <tr>
            <th>Jumlah Anggota</th>
            <td><?= esc($class['jumlah_anggota']) ?></td>
        </tr>
    </table>

    <!-- Daftar Anggota Kelas -->
    <div class="d-flex justify-content-between align-items-center mb-3" style="padding-top: 1rem;">
        <h4 class="mb-2">Daftar Anggota Kelas</h4>
        <a href="<?= base_url('admin/manage_kelas/kelola_anggota/tambah/' . esc($class['id'])); ?>" class="btn btn-primary">Tambahkan Anggota</a>
    </div>

    <!-- Search Box -->
    <div class="mb-3">
        <input type="text" id="searchMemberInput" class="form-control" placeholder="Cari anggota berdasarkan username, nama, atau email">
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover tabel-akun">
            <thead style="color: black; background-color:#2222">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Username</th>
                    <th style="width: 35%;">Nama</th>
                    <th style="width: 30%;">Email</th>
                    <th style="width: 5%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php if (!empty($members)) : ?>
                    <?php foreach ($members as $member) : ?>
                        <tr class="bg-green">
                            <td><?= $no++; ?></td>
                            <td><?= esc($member['username']); ?></td>
                            <td><?= esc($member['fullname']); ?></td>
                            <td><?= esc($member['email']); ?></td>
                            <td>
                                <form action="<?= base_url('admin/manage_kelas/kelola_anggota/hapus/' . esc($member['anggota_id'])); ?>" method="post" style="display:inline;" onsubmit="return confirm('Hapus anggota ini?');">
                                    <?= csrf_field(); ?>
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-user-times"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada anggota ditemukan</td>
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
        $("#searchMemberInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".tabel-akun tbody tr").each(function() {
                var username = $(this).find("td:nth-child(2)").text().toLowerCase();
                var fullname = $(this).find("td:nth-child(3)").text().toLowerCase();
                var email = $(this).find("td:nth-child(4)").text().toLowerCase();
                if (username.includes(value) || fullname.includes(value) || email.includes(value)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>