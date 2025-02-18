<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<style>
    .btn-filter-role:focus,
    .btn-filter-role:active {
        background: none !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
    }

    #filterRoleButton::after {
        display: none;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 text-gray-800"><?= esc($title) ?></h1>
        <a href="<?= base_url('admin/manage_kelas/tambah'); ?>" class="btn btn-primary">Tambahkan Kelas</a>
    </div>

    <!-- Show Flash Messages -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <!-- Search Form -->
    <div class="mb-3 d-flex align-items-center justify-content-between">
        <div class="flex-grow-1 me-3" style="margin-right:1rem">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari kelas berdasarkan nama">
        </div>
        <i class="fas fa-search text-muted" style="margin-right:1rem"></i>
    </div>

    <!-- Table for Displaying Classes -->
    <?php $no = 1; ?>
    <table class="table table-bordered table-hover">
        <thead class="table" style="color: black; background-color:#2222">
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 20%;">Nama Kelas</th>
                <th style="width: 15%;">Kode Kelas</th> <!-- Added Kode Kelas Column -->
                <th style="width: 10%;">Jumlah Anggota</th>
                <th style="width: 10%;">Status Kelas</th>
                <th style="width: 10%;">Aksi</th>
            </tr>
        </thead>
        <tbody class="table-group-divider" style="color: black;">
            <?php if (!empty($classes)) : ?>
                <?php foreach ($classes as $row) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td class="text-break"><?= esc($row['nama_kelas']); ?></td>
                        <td class="text-break"><?= esc($row['kode_kelas']); ?></td> <!-- Display the class code -->
                        <td class="text-break"><?= esc($row['jumlah_anggota']); ?></td>
                        <td class="text-break"> <?= esc($row['status'] == 1 ? 'Aktif' : 'Tidak Aktif'); ?></td>
                        <td>
                            <div class="d-flex flex-wrap gap-2" style="justify-content: space-between;">
                                <!-- Button for adding members -->
                                <a href="<?= base_url('admin/manage_kelas/kelola_anggota/tambah/' . esc($row['id'])); ?>" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px;">
                                    <i class="fas fa-user-plus"></i>
                                </a>
                                <a href="<?= base_url('admin/manage_kelas/edit/' . esc($row['id'])); ?>" class="btn btn-warning btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px;">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form action="<?= base_url('admin/manage_kelas/delete/' . esc($row['id'])); ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px" onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data kelas ditemukan</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Ensure jQuery and Bootstrap JS are loaded -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Search functionality for filtering table rows based on class name, teacher name, etc.
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("table tbody tr").each(function() {
                var className = $(this).find("td:nth-child(2)").text().toLowerCase();
                if (className.includes(value)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>