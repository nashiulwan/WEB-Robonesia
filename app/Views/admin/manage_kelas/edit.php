<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Kelas</h1>

    <!-- Menampilkan pesan error validasi -->
    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>

    <!-- Menampilkan pesan error umum -->
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Form Edit Kelas -->
    <form action="<?= base_url('admin/manage_kelas/update/' . $kelas['id']) ?>" method="post" autocomplete="off">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="nama_kelas">Nama Kelas</label>
            <input type="text" name="nama_kelas" id="class_name" class="form-control <?= (session()->getFlashdata('errors') && array_key_exists('class_name', session()->getFlashdata('errors'))) ? 'is-invalid' : '' ?>" value="<?= old('class_name', $kelas['nama_kelas']) ?>" placeholder="Masukkan nama kelas" required autocomplete="off">
            <?php if (session()->getFlashdata('errors') && array_key_exists('class_name', session()->getFlashdata('errors'))) : ?>
                <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors')['class_name'] ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="kelas_deskripsi">Deskripsi Kelas</label>
            <textarea name="deskripsi" id="class_description" class="form-control <?= (session()->getFlashdata('errors') && array_key_exists('class_description', session()->getFlashdata('errors'))) ? 'is-invalid' : '' ?>" placeholder="Masukkan deskripsi kelas" rows="3"><?= old('class_description', $kelas['deskripsi']) ?></textarea>
            <?php if (session()->getFlashdata('errors') && array_key_exists('class_description', session()->getFlashdata('errors'))) : ?>
                <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors')['class_description'] ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="status">Status Kelas</label>
            <div class="form-group">
                <label for="status">Status Kelas</label>
                <select class="custom-select" name="status" required>
                    <option value="" disabled>Pilih Status Kelas</option>
                    <option value="1" <?= old('status', $kelas['status']) == '1' ? 'selected' : '' ?>>Aktif</option>
                    <option value="0" <?= old('status', $kelas['status']) == '0' ? 'selected' : '' ?>>Tidak Aktif</option>
                </select>
            </div>


        </div>


        <button type="submit" class="btn btn-primary">Update Kelas</button>
        <a href="<?= base_url('admin/manage_kelas') ?>" class="btn btn-warning" style="margin-left:10px; width:7rem">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>