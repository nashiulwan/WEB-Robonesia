<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<style>
    /* Batasi teks agar hanya menampilkan maksimal 4 baris dengan ellipsis */
    .limited-text {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: normal;
        border: none;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 text-gray-800"><?= esc($title) ?></h1>
        <a href="<?= base_url('admin/artikel/tambah'); ?>" class="btn btn-primary">Tambahkan Artikel</a>
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
            <input type="text" id="searchInput" class="form-control" placeholder="Cari artikel">
        </div>
        <i class="fas fa-search text-muted" style="margin-right:1rem"></i>
    </div>

    <!-- TABEL ARTIKEL -->
    <?php $no = 1; ?>
    <div class="table-responsive">
        <table id="artikelTable" class="table table-bordered table-auto">
            <thead class="table" style="color: black; background-color:#2222">
                <tr>
                    <th style="width: 5%;">NO</th>
                    <th style="width: 15%;">Judul</th>
                    <th style="width: 10%;">Slug</th>
                    <th style="width: 20%;">Konten</th>
                    <th style="width: 10%;">Kategori</th>
                    <!-- <th style="width: 10%;">Penulis</th>
                    <th style="width: 8%;">Status</th> -->
                    <th style="width: 12%;">Created At</th>
                    <th style="width: 12%;">Updated At</th>
                    <th style="width: 12%;">Gambar</th>
                    <th style="width: 5%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($artikel)) : ?>
                    <?php foreach ($artikel as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <!-- Bungkus isi masing-masing kolom dengan div.limited-text -->
                            <td>
                                <div class="limited-text"><?= esc($row['judul']); ?></div>
                            </td>
                            <td>
                                <div class="limited-text"><?= esc($row['slug']); ?></div>
                            </td>
                            <td>
                                <div class="limited-text"><?= esc(strip_tags($row['konten'])); ?></div>
                            </td>
                            <td><?= esc($row['kategori']); ?></td>
                            <!-- <td><?= esc($row['penulis_id']); ?></td>
                            <td><?= esc($row['status']); ?></td> -->
                            <td><?= esc($row['created_at']); ?></td>
                            <td><?= esc($row['updated_at']); ?></td>
                            <td>
                                <?php if (!empty($row['gambar'])) : ?>
                                    <img src="<?= base_url('/uploads/' . $row['gambar']); ?>" alt="Gambar Artikel" class="img-fluid" style="max-width: 100px; height: auto;" onerror="this.onerror=null; this.src='<?= base_url('/images/no-image.png'); ?>'">
                                <?php else : ?>
                                    <span class="text-muted">Tidak ada gambar</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <a href="<?= base_url('admin/artikel/edit/' . esc($row['id'])); ?>" class="btn btn-warning btn-sm w-100 mb-2">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="<?= base_url('admin/artikel/delete/' . esc($row['id'])); ?>" method="post">
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("searchInput");
        const table = document.getElementById("artikelTable");
        const rows = table.getElementsByTagName("tr");

        searchInput.addEventListener("keyup", function() {
            const searchText = searchInput.value.toLowerCase();
            for (let i = 1; i < rows.length; i++) { // Lewati header
                let rowData = rows[i].textContent.toLowerCase();
                rows[i].style.display = rowData.includes(searchText) ? "" : "none";
            }
        });
    });
</script>

<?= $this->endSection() ?>