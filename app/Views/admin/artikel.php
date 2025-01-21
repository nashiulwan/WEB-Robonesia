<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
    
    <!-- Tambah Artikel -->
    <a href="<?= base_url('admin/artikel/tambah'); ?>" class="btn btn-primary mb-4">Tambahkan Artikel</a>

    <!-- Tabel Daftar Artikel -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Artikel</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Waktu Terbit</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($artikels as $artikel): ?>
                            <tr>
                                <td><?= $artikel['id'] ?></td>
                                <td><?= $artikel['judul'] ?></td>
                                <td><?= $artikel['penulis'] ?></td>
                                <td><?= $artikel['tanggal_terbit'] ?></td>
                                <td>
                                    <a href="<?= base_url('admin/artikel/edit/'.$artikel['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="<?= base_url('admin/artikel/hapus/'.$artikel['id']); ?>" class="btn btn-danger btn-sm">Hapus</a>
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
