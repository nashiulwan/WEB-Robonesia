<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Anggota Tim</h1>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <a href="<?= base_url('admin/pengaturan/tim/tambah') ?>" class="btn btn-primary mb-3">Tambah Anggota Tim</a>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 5%" ;>Foto</th>
                            <th style="width: 30%" ;>Nama</th>
                            <th style="width: 20%" ;>Peran</th>
                            <th style="width: 25%" ;>Media Sosial</th>
                            <th style="width: 20%" ;>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tim as $t) : ?>
                            <tr>
                                <td><img src="<?= base_url('uploads/tim/' . esc($t['foto'])) ?>" alt="Foto" width="50" style="border-radius: 50%;"></td>
                                <td><?= esc($t['nama']) ?></td>
                                <td><?= esc($t['peran']) ?></td>
                                <td>
                                    <?php if ($t['facebook']) : ?>
                                        <a href="<?= esc($t['facebook']) ?>" target="_blank">Facebook</a><br>
                                    <?php endif; ?>
                                    <?php if ($t['whatsapp']) : ?>
                                        <a href="https://wa.me/<?= esc($t['whatsapp']) ?>" target="_blank">WhatsApp</a><br>
                                    <?php endif; ?>
                                    <?php if ($t['twitter']) : ?>
                                        <a href="<?= esc($t['twitter']) ?>" target="_blank">Twitter</a><br>
                                    <?php endif; ?>
                                    <?php if ($t['instagram']) : ?>
                                        <a href="<?= esc($t['instagram']) ?>" target="_blank">Instagram</a><br>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/pengaturan/tim/edit/' . $t['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="<?= base_url('admin/pengaturan/tim/hapus/' . $t['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus anggota tim ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>