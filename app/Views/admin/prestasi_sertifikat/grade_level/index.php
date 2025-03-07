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

    /* Styling untuk grid gambar proyek */
    .project-images-grid {
        display: grid;
        grid-auto-flow: column;
        gap: 10px;
        overflow: hidden;
    }

    .project-images-grid img {
        height: 60px;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 text-gray-800"><?= esc($title) ?></h1>
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
                    <th style="width: 22%;">Nama Kelas</th>
                    <th style="width: 15%;">Level</th>
                    <th style="width: 10%;">Sub Level</th>
                    <th style="width: 30%;">Proyek Terbaru</th>
                    <th style="width: 13%;">Aksi</th>
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
                                    <div class="project-images-grid">
                                        <?php
                                        // Sort gambar berdasarkan created_at secara descending
                                        $images = $row['images'];
                                        usort($images, function ($a, $b) {
                                            return strtotime($b['created_at']) - strtotime($a['created_at']);
                                        });
                                        // Ambil hanya 3 gambar terbaru
                                        $displayImages = array_slice($images, 0, 3);
                                        ?>
                                        <?php foreach ($displayImages as $image) : ?>
                                            <img src="<?= base_url('uploads/proyek/' . esc($image['image_name'])) ?>" alt="Gambar Proyek">
                                        <?php endforeach; ?>
                                    </div>
                                <?php else : ?>
                                    <span>Tidak ada gambar</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-2" style="justify-content: space-between;">
                                    <a href="<?= base_url('admin/grade_level/detail/' . esc($row['id'])); ?>" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px;">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('admin/grade_level/level/' . esc($row['id'])); ?>" class="btn btn-warning btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px;">
                                        <i class="fas fa-layer-group"></i>
                                    </a>
                                    <a href="<?= base_url('admin/grade_level/proyek/' . esc($row['id'])); ?>" class="btn btn-info btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px;">
                                        <i class="fas fa-image"></i>
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
        // Search functionality for filtering table rows based on class name
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