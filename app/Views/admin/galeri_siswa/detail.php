<?= $this->extend('admin/layout') ?>

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
        <div>
            <a href="<?= base_url('admin/galeri'); ?>" class="btn btn-warning" style="margin-right: 10px;" title='kembali'><i class="fas fa-arrow-left"></i></a>
            <a href="<?= base_url('admin/galeri/tambah/' . esc($user['id'])); ?>" class="btn btn-primary" title='tambah foto'><i class="fas fa-plus"></i></a>
        </div>
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
            <input type="text" id="searchInput" class="form-control" placeholder="Cari galeri">
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
                    <th style="width: 20%;">Gambar</th>
                    <th style="width: 20%;">Judul</th>
                    <th style="width: 20%;">Deskripsi</th>
                    <th style="width: 15%;">Level</th>
                    <th style="width: 10%;">Sub Level</th>
                    <th style="width: 10%;">Aksi</th>
                </tr>
            </thead>
            <tbody class="table-group-divider" style="color: black;">
                <?php if (!empty($galeri)) : ?>
                    <?php foreach ($galeri as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <?php if (!empty($row['gambar'])) : ?>
                                    <img src="<?= base_url('uploads/galeri/' . $row['gambar']); ?>" alt="Gambar Galeri" class="img-fluid" style="max-width: 150px; max-height: 100px;" onerror="this.onerror=null; this.src='<?= base_url('/images/no-image.png'); ?>'">
                                <?php else : ?>
                                    <span class="text-muted">Tidak ada gambar</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-break"><?= esc($row['judul']); ?></td>
                            <td class="text-break"><?= esc($row['deskripsi']); ?></td>
                            <td class="text-break"><?= esc($row['level']); ?></td>
                            <td class="text-break"><?= esc($row['sub_level']); ?></td>
                            <td>
                                <div class="d-flex flex-wrap gap-2" style="justify-content: space-between;">
                                    <a href="<?= base_url('admin/galeri/edit/' . esc($user['id']) . '/' . esc($row['id'])); ?>" class="btn btn-warning btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px;">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="<?= base_url('admin/galeri/delete/' . esc($user['id']) . '/' . esc($row['id'])); ?>" method="post">
                                        <?= csrf_field(); ?>
                                        <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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
                var judul = $(this).find("td:nth-child(3)").text().toLowerCase();
                var deskripsi = $(this).find("td:nth-child(4)").text().toLowerCase();
                var level = $(this).find("td:nth-child(5)").text().toLowerCase();

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