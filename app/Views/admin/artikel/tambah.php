<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<style>
    .custom_file::-webkit-file-upload-button {
        margin-top: -10px;
        margin-left: -5px;
    }
</style>
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Tambah Artikel</h1>

    <!-- Form Tambah Artikel -->
    <form action="<?= base_url('admin/artikel/simpan') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="judul">Judul Artikel</label>
            <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukkan judul artikel" required>
        </div>

        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select name="kategori" id="kategori" class="form-control" required>
                <?php foreach ($kategoriList as $kategori): ?>
                    <option value="<?= esc($kategori) ?>"><?= esc($kategori) ?></option>
                <?php endforeach; ?>
            </select>
        </div>


        <div class="mb-3">
            <label for="gambar" class="form-label ">Upload Gambar</label>
            <input type="file" class="form-control custom_file" id="gambar" name="gambar">
        </div>


        <div class="form-group">
            <label for="konten">Konten Artikel</label>
            <textarea name="konten" id="konten" class="form-control" rows="10" placeholder="Tulis konten artikel..." required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Tambah Artikel</button>
    </form>

</div>

<!-- CKEditor 5 -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#konten'))
        .catch(error => {
            console.error(error);
        });
</script>

<?= $this->endSection() ?>