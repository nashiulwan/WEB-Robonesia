<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><?= esc($title) ?></h1>
    
    <!-- Tombol Tambah Artikel -->
    <a href="<?= base_url('admin/artikel/tambah'); ?>" class="btn btn-primary mb-4">Tambahkan Artikel</a>

    <!-- Tampilkan Flash Message -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <!-- TABEL ARTIKEL -->
    <div class="container mt-4">
        <h1 class="mb-3">Daftar Artikel</h1>
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($artikel)) : ?>
                    <?php foreach ($artikel as $row) : ?>
                        <tr>
                            <td><?= esc($row['id']); ?></td>
                            <td><?= esc($row['judul']); ?></td>
                            <td><?= esc($row['slug']); ?></td>
                            <td><?= esc(substr($row['konten'], 0, 50)); ?>...</td>
                            <td><?= esc($row['kategori_id']); ?></td>
                            <td><?= esc($row['penulis_id']); ?></td>
                            <td><?= esc($row['status']); ?></td>
                            <td><?= esc($row['created_at']); ?></td>
                            <td><?= esc($row['updated_at']); ?></td>
                            <td>
                                <?php if (!empty($row['gambar'])) : ?>
                                    <img src="<?= base_url('/uploads/' . $row['gambar']); ?>" alt="Gambar Artikel" width="100" onerror="this.onerror=null; this.src='<?= base_url('/images/no-image.png'); ?>'">

                                <?php else : ?>
                                    <span class="text-muted">Tidak ada gambar</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/artikel/edit/' . esc($row['id'])); ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?= base_url('admin/artikel/hapus/' . esc($row['id'])); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">Hapus</a>
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
<?= $this->endSection() ?>
