<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Tambah Mitra</h1>

    <!-- Form Tambah Mitra -->
    <form action="<?= base_url('admin/pengaturan/mitra/simpan') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <!-- Nama Mitra -->
        <div class="form-group">
            <label for="partner">Nama Mitra</label>
            <input type="text" name="partner" id="partner" class="form-control" placeholder="Masukkan nama sekolah/partner" required>
        </div>

        <!-- Alamat -->
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Masukkan alamat sekolah/partner" required>
        </div>

        <!-- Link Google Maps -->
        <div class="form-group">
            <label for="maps">Link Google Maps</label>
            <input type="url" name="maps" id="maps" class="form-control" placeholder="Masukkan link Google Maps sekolah/partner" required>
        </div>

        <!-- Upload Logo -->
        <div class="mb-3">
            <label for="logo" class="form-label">Upload Logo</label>
            <input type="file" class="form-control" id="logo" name="logo" required>
        </div>

        <button type="submit" class="btn btn-primary">Tambah Partner</button>
    </form>

</div>
<?= $this->endSection() ?>
