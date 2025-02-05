<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
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

    <!-- TABEL ARTIKEL -->
    <table class="table table-bordered table-striped table-auto">
        <thead class="table-dark">
            <tr>
                <th style="width: 5%;">ID</th>
                <th style="width: 15%;">Judul</th>
                <th style="width: 10%;">Slug</th>
                <th style="width: 25%;">Konten</th>
                <th style="width: 10%;">Kategori</th>
                <th style="width: 10%;">Penulis</th>
                <th style="width: 8%;">Status</th>
                <th style="width: 10%;">Created At</th>
                <th style="width: 10%;">Updated At</th>
                <th style="width: 12%;">Gambar</th>
                <th style="width: 12%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($artikel)) : ?>
                <?php foreach ($artikel as $row) : ?>
                    <tr>
                        <td><?= esc($row['id']); ?></td>
                        <td class="text-break"><?= esc($row['judul']); ?></td>
                        <td class="text-break"><?= esc($row['slug']); ?></td>
                        <td class="text-break"><?= esc(substr($row['konten'], 0, 100)); ?>...</td>
                        <td><?= esc($row['kategori']); ?></td>
                        <td><?= esc($row['penulis_id']); ?></td>
                        <td><?= esc($row['status']); ?></td>
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
                                <a href="<?= base_url('admin/artikel/edit/' . esc($row['id'])); ?>" class="btn btn-warning btn-sm w-100 mb-2">Edit</a>
                                <form action="<?= base_url('admin/artikel/delete/' . esc($row['id'])); ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">
                                        Hapus
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
<?= $this->endSection() ?>