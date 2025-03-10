<?= $this->extend('siswa/layout') ?>

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
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 text-gray-800"><?= esc($title) ?></h1>
        <a href="<?= base_url('siswa/kelas') ?>" class="btn btn-warning" style="margin-left:10px; width:7rem">Kembali</a>
    </div>

    <table class="table table-borderless table-striped table-detail" style="color: black;">
        <tr>
            <th style="width:35%;">Nama Kelas</th>
            <td><?= esc($kelas['nama_kelas']) ?></td>
        </tr>
        <tr>
            <th>Deskripsi</th>
            <td>
                <div class="desc-container">
                    <?= esc($kelas['deskripsi']) ?>
                </div>
            </td>
        </tr>
        <tr>
            <th>Kode Kelas</th>
            <td><?= esc($kelas['kode_kelas']) ?></td>
        </tr>
        <tr>
            <th>Status Kelas</th>
            <td><?= esc($kelas['status']) ?></td>
        </tr>
        <tr>
            <th>Jumlah Anggota</th>
            <td><?= esc($kelas['jumlah_anggota']) ?></td>
        </tr>
    </table>

    <form action="<?= base_url('siswa/kelas/keluar/'  . esc($kelas['id']) . '/' . esc($userId)) ?>" method="post">
        <?= csrf_field(); ?>
        <button type="submit" class="btn btn-danger d-flex align-items-center justify-content-center" onclick="return confirm('Apakah Anda yakin ingin keluar dari kelas ini?');">Keluar dari Kelas</button>
    </form>

    <!-- Daftar Sertifikat -->
    <!-- <div class="d-flex justify-content-between align-items-center mb-3" style="padding-top: 1rem;">
        <h4 class="mb-2">Sertifikat</h4>
    </div> -->

    <!-- Daftar Anggota Kelas -->
    <div class="d-flex justify-content-between align-items-center mb-3" style="padding-top: 1rem;">
        <h4 class="mb-2">Anggota Kelas</h4>
    </div>

    <!-- Search Box -->
    <div class="mb-3">
        <input type="text" id="searchMemberInput" class="form-control" placeholder="Cari anggota">
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover tabel-akun">
            <thead style="color: black; background-color:#2222">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 95%;">Nama</th>
                </tr>
            </thead>
        </table>
        <div style="max-height: 200px; overflow-y: auto;">
            <table class="table table-bordered table-hover tabel-akun">
                <tbody>
                    <?php $no = 1; ?>
                    <?php if (!empty($members)) : ?>
                        <?php foreach ($members as $member) : ?>
                            <tr class="bg-green">
                                <td style="width: 5%;"><?= $no++; ?></td>
                                <td style="width: 95%;"><?= esc($member['fullname']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="2" class="text-center">Tidak ada anggota ditemukan</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
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
                var fullname = $(this).find("td:nth-child(2)").text().toLowerCase();
                if (fullname.includes(value)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>