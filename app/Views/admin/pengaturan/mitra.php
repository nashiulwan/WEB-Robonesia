<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Pengaturan Partner</h1>

    <!-- Button Tambah Partner -->
    <div class="mb-4 text-end">
        <a href="<?= base_url('admin/pengaturan/mitra/tambah'); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Partner Baru
        </a>
    </div>

    <!-- Form Pencarian -->
    <div class="mb-3 d-flex align-items-center justify-content-between">
        <div class="flex-grow-1 me-3" style="margin-right:1rem">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari mitra">
        </div>
        <i class="fas fa-search text-muted" style="margin-right:1rem"></i>
    </div>

    <!-- Tabel Daftar Partner -->
    <div class="table-responsive">
        <div class="table-responsive"></div>
        <table class="table table-bordered table-striped" id="mitraTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Logo</th>
                    <th>Nama Partner</th>
                    <th>Alamat</th>
                    <th>Link Map</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($mitra)) : ?>
                    <?php $no = 1; ?>
                    <?php foreach ($mitra as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <?php if (!empty($row['logo'])) : ?>
                                    <img src="<?= base_url('uploads/' . esc($row['logo'])); ?>" alt="<?= esc($row['partner']); ?>" style="height: 50px; object-fit: contain;">
                                <?php else : ?>
                                    <img src="<?= base_url('uploads/default.jpg'); ?>" alt="No Logo" style="height: 50px; object-fit: contain;">
                                <?php endif; ?>
                            </td>
                            <td><?= esc($row['partner']); ?></td>
                            <td><?= esc($row['alamat']); ?></td>
                            <td><a href="<?= esc($row['maps']); ?>" target="_blank">Lihat Map</a></td>
                            <td>
                                <!-- Button Edit -->
                                <a href="<?= base_url('admin/pengaturan/mitra/edit/' . esc($row['id'])); ?>" class="btn btn-warning btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px;">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <!-- Button Hapus -->
                                <a href="<?= base_url('admin/pengaturan/mitra/hapus/' . esc($row['id'])); ?>" <?= csrf_field(); ?>
                                    <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">
                                    <i class="fas fa-trash-alt"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data partner.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("searchInput");
        const table = document.getElementById("mitraTable");
        const rows = table.getElementsByTagName("tr");

        searchInput.addEventListener("keyup", function() {
            const searchText = searchInput.value.toLowerCase();
            for (let i = 1; i < rows.length; i++) { // Lewati header
                let rowData = rows[i].textContent.toLowerCase();
                rows[i].style.display = rowData.includes(searchText) ? "" : "none";
            }
        });
    })
</script>
<?= $this->endSection() ?>