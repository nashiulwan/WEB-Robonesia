<?= $this->extend('siswa/templates/dashboard'); ?>

<?= $this->section('page-content'); ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Prestasi Saya</h2>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Kegiatan</th>
                <th>Jenis</th>
                <th>Tingkat</th>
                <th>Tahun</th>
                <th>Pencapaian</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($prestasi)) : ?>
                <tr>
                    <td colspan="6" class="text-center">Belum ada data prestasi.</td>
                </tr>
            <?php else : ?>
                <?php $no = 1; foreach ($prestasi as $p) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= esc($p['nama_kegiatan']); ?></td>
                        <td><?= esc($p['jenis']); ?></td>
                        <td><?= esc($p['tingkat']); ?></td>
                        <td><?= esc($p['tahun']); ?></td>
                        <td><?= esc($p['pencapaian']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>
