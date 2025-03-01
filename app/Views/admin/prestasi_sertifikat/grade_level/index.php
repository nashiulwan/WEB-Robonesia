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
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table" style="color: black; background-color:#2222">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama Kelas</th>
                    <th style="width: 10%;">Level</th>
                    <th style="width: 10%;">Sub Level</th>
                    <th style="width: 35%;">Proyek Terbaru</th>
                    <th style="width: 10%;">Aksi</th>
                </tr>
            </thead>
            <tbody class="table-group-divider" style="color: black;">
                <?php if (!empty($classes)) : ?>
                    <?php foreach ($classes as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="text-break"><?= esc($row['nama_kelas']); ?></td>
                            <td class="text-break"><?= esc($row['level']); ?></td>
                            <td class="text-break"><?= esc($row['sub_level']); ?></td>
                            <td class="text-break">
                                <?php if (!empty($row['images'])) : ?>
                                    <?php 
                                        // Asumsikan array images sudah diurutkan dengan gambar terbaru di index 0
                                        $latestImage = $row['images'][0]; 
                                    ?>
                                    <img src="<?= base_url('uploads/' . esc($latestImage['image_name'])) ?>" alt="Gambar Terbaru" style="height:60px; margin-right:5px;">
                                <?php else : ?>
                                    <span>Tidak ada gambar</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-2" style="justify-content: space-between;">
                                    <a href="<?= base_url('admin/grade_level/detail/' . esc($row['id'])); ?>" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px;">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('admin/grade_level/edit/' . esc($row['id'])); ?>" class="btn btn-warning btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px;">
                                        <i class="fas fa-pen"></i>
                                    </a>
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
