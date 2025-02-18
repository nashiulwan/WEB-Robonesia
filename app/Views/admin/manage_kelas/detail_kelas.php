<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<style>
    .table-detail tbody tr:nth-of-type(odd) {
        background-color: rgba(78, 115, 223, 0.1) !important;
    }

    .table-detail tbody tr:nth-of-type(even) {
        background-color: white !important;
    }

    /* Container untuk deskripsi: maksimal 4 baris dan scroll vertical jika lebih */
    .desc-container {
        max-height: 6em;
        /* Sesuaikan dengan line-height; misalnya jika line-height 1.5, 1.5 x 4 = 6em */
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

    <!-- Pencarian Anggota -->
    <div class="mt-4 mb-3 d-flex align-items-center justify-content-between">
        <div class="flex-grow-1 me-3">
            <input type="text" id="searchMemberInput" class="form-control" placeholder="Cari anggota berdasarkan nama">
        </div>
        <i class="fas fa-search text-muted" style="margin-right:1rem"></i>
    </div>

    <!-- Daftar Anggota Kelas -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-3">Daftar Anggota Kelas</h5>
        <a href="<?= base_url('admin/manage_kelas/kelola_anggota/tambah/' . esc($class['id'])); ?>" class="btn btn-primary">Tambahkan Anggota</a>
    </div>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 45%;">Nama</th>
                <th style="width: 25%;">Email</th>
                <th style="width: 25%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php if (!empty($members)) : ?>
                <?php foreach ($members as $member) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= esc($member['nama']); ?></td>
                        <td><?= esc($member['email']); ?></td>
                        <td>
                            <a href="<?= base_url('admin/manage_kelas/remove_member/' . esc($member['id'])); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus anggota ini?');">
                                <i class="fas fa-user-times"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4" class="text-center">Tidak ada anggota ditemukan</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $("#searchMemberInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("table tbody tr").each(function() {
                var memberName = $(this).find("td:nth-child(2)").text().toLowerCase();
                $(this).toggle(memberName.includes(value));
            });
        });
    });
</script>

<?= $this->endSection() ?>