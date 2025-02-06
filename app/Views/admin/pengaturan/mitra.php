<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Pengaturan Partner</h1>

    <!-- Button Tambah Partner -->
    <div class="mb-4 text-end">
        <a href="<?= base_url('admin/pengaturan/mitra/tambah'); ?>" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Partner Baru
        </a>
    </div>

    <!-- Tabel Daftar Partner -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
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
                                    <img src="<?= base_url(esc($row['logo'])); ?>" alt="<?= esc($row['partner']); ?>" style="height: 50px; object-fit: contain;">
                                <?php else : ?>
                                    <img src="<?= base_url('uploads/default.jpg'); ?>" alt="No Logo" style="height: 50px; object-fit: contain;">
                                <?php endif; ?>
                            </td>
                            <td><?= esc($row['partner']); ?></td>
                            <td><?= esc($row['alamat']); ?></td>
                            <td><a href="<?= esc($row['maps']); ?>" target="_blank">Lihat Map</a></td>
                            <td>
                                <!-- Button Edit -->
                                <a href="<?= base_url('pengaturan/mitra/edit/' . esc($row['id'])); ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <!-- Button Hapus -->
                                <a href="<?= base_url('pengaturan/mitra/hapus/' . esc($row['id'])); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus partner ini?');">
                                    <i class="fas fa-trash"></i> Hapus
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

<?= $this->endSection() ?>