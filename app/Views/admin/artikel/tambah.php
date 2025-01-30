<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Tambah Artikel</h1>

    <!-- Form Tambah Artikel -->
    <form action="<?= base_url('/admin/artikel/simpan') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="judul">Judul Artikel</label>
            <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukkan judul artikel" required>
        </div>

        <div class="form-group">
            <label for="kategori_id">Kategori</label>
            <select name="kategori_id" id="kategori_id" class="form-control" required>
                <option value="">Pilih Kategori</option>
                <?php foreach ($kategoris as $kategori): ?>
                    <option value="<?= $kategori['id'] ?>"><?= $kategori['nama'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label">Upload Gambar</label>
            <input type="file" class="form-control" id="gambar" name="gambar">
        </div>


        <div class="form-group">
            <label for="konten">Konten Artikel</label>
            <textarea name="konten" id="konten" class="form-control" rows="10" placeholder="Tulis konten artikel..." required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Tambah Artikel</button>
    </form>

</div>
<?= $this->endSection() ?>
