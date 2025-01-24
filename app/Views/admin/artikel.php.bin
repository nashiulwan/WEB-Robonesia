<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
    
    <!-- Tambah Artikel -->
    <a href="<?= base_url('admin/artikel/tambah'); ?>" class="btn btn-primary mb-4">Tambahkan Artikel</a>

    <!-- TABEL ARTIKEL LENGKAP -->
    <div class="container mt-5">
        <h1 class="mb-4">Daftar Artikel</h1>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Slug</th>
                    <th>Konten</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Gambar</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rows)) : ?>
                    <?php foreach ($artikel as $row) : ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['judul']; ?></td>
                            <td><?= $row['slug']; ?></td>
                            <td><?= substr($row['konten'], 0, 50); ?>...</td>
                            <td><?= $row['kategori_id']; ?></td>
                            <td><?= $row['penulis_id']; ?></td>
                            <td><?= $row['status']; ?></td>
                            <td><?= $row['created_at']; ?></td>
                            <td><?= $row['updated_at']; ?></td>
                            <td>
                                <?php if (!empty($row['gambar'])) : ?>
                                    <img src="<?= base_url('uploads/' . $row['gambar']); ?>" alt="Gambar" width="50">
                                <?php else : ?>
                                    <span class="text-muted">Tidak ada gambar</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada data ditemukan</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
