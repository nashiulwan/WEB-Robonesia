<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Edit mitra</h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="<?= base_url('admin/mitra/update/' . esc($mitra['id'])); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <!-- Nama mitra -->
                <div class="mb-3">
                    <label for="mitra" class="form-label">Nama mitra</label>
                    <input type="text" class="form-control" id="mitra" name="mitra" value="<?= esc($mitra['mitra']); ?>" required>
                </div>

                <!-- Alamat -->
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" value="<?= esc($mitra['alamat']); ?>" required>
                </div>

                <!-- Link Google Maps -->
                <div class="mb-3">
                    <label for="maps" class="form-label">Link Google Maps</label>
                    <input type="url" class="form-control" id="maps" name="maps" value="<?= esc($mitra['maps']); ?>" required>
                </div>

                <!-- Logo mitra -->
                <div class="mb-3">
                    <label class="form-label">Logo mitra</label>
                    <div class="mb-2">
                        <?php if (!empty($mitra['logo'])) : ?>
                            <img src="<?= base_url('image/' . esc($mitra['logo'])); ?>" alt="Logo mitra" class="img-thumbnail" style="max-height: 100px;">
                        <?php else : ?>
                            <p class="text-muted">Belum ada logo</p>
                        <?php endif; ?>
                    </div>
                    <input type="file" class="form-control" name="logo">
                    <small class="text-muted">Upload logo baru jika ingin mengganti.</small>
                </div>

                <!-- Tombol Submit -->
                <div class="d-flex justify-content-between">
                    <a href="<?= base_url('admin/mitra'); ?>" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
