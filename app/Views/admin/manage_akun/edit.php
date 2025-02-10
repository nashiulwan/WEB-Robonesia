<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Artikel</h1>

    <!-- Form Edit Artikel -->
    <form action="<?= base_url('admin/artikel/update/' . $artikel['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="judul">Judul Artikel</label>
            <input type="text" name="judul" id="judul" class="form-control" value="<?= esc($artikel['judul']) ?>" required>
        </div>

        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select name="kategori" id="kategori" class="form-control" required>
                <?php foreach ($kategoriList as $kategori): ?>
                    <option value="<?= esc($kategori) ?>" <?= ($kategori == $artikel['kategori']) ? 'selected' : '' ?>>
                        <?= esc($kategori) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label">Upload Gambar</label>
            <input type="file" class="form-control" id="gambar" name="gambar">
            <?php if (!empty($artikel['gambar'])): ?>
                <p>Gambar saat ini:</p>
                <img src="<?= base_url('/uploads/' . $artikel['gambar']) ?>" alt="Gambar Artikel" width="150">
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="konten">Konten Artikel</label>
            <textarea name="konten" id="konten" class="form-control" rows="10" required><?= esc($artikel['konten']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Artikel</button>
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
