<?= $this->extend('guru/layout') ?>

<?= $this->section('content') ?>
<!-- Custom CSS untuk menghilangkan efek fokus pada button filter -->
<style>
    .btn-filter-role:focus,
    .btn-filter-role:active {
        background: none !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
    }

    /* Hilangkan caret default pada dropdown button */
    #filterRoleButton::after {
        display: none;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 text-gray-800"><?= esc($title) ?></h1>
    </div>

    <!-- Tampilkan Flash Message -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <!-- Form Pencarian -->
    <div class="mb-3 d-flex align-items-center justify-content-between">
        <div class="flex-grow-1 me-3" style="margin-right:1rem">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari akun berdasarkan username, nama, atau email">
        </div>
        <i class="fas fa-search text-muted" style="margin-right:1rem"></i>
    </div>

    <!-- TABEL -->
    <?php $no = 1; ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table" style="color: black; background-color:#2222">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 20%;">Nama pengguna</th>
                    <th style="width: 35%;">Email</th>
                    <th style="width: 35%;">Nama Lengkap</th>
                    <th style="width: 5%;">Aksi</th>
                </tr>
            </thead>
            <tbody class="table-group-divider" style="color: black;">
                <?php if (!empty($users)) : ?>
                    <?php foreach ($users as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="text-break"><?= esc($row['username']); ?></td>
                            <td class="text-break"><?= esc($row['email']); ?></td>
                            <td class="text-break"><?= esc($row['fullname']); ?></td>

                            <td>
                                <div class="d-flex flex-wrap gap-2" style="justify-content: space-between;">
                                    <a href="<?= base_url('guru/galeri/detail/' . esc($row['id'])); ?>" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px;">
                                        <i class="fas fa-camera"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="11" class="text-center">Tidak ada data ditemukan</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- Pastikan jQuery dan Bootstrap JS telah dimuat -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Fitur pencarian: filter baris tabel berdasarkan username,  atau fullname
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("table tbody tr").each(function() {
                var username = $(this).find("td:nth-child(2)").text().toLowerCase();
                var email = $(this).find("td:nth-child(3)").text().toLowerCase();
                var fullname = $(this).find("td:nth-child(4)").text().toLowerCase();

                if (username.includes(value) || email.includes(value) || fullname.includes(value)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

    });
</script>

<?= $this->endSection() ?>