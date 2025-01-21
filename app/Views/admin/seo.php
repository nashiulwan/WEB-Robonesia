<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<h1>Pengaturan SEO</h1>
<form>
    <label for="meta_title">Meta Title:</label>
    <input type="text" id="meta_title" name="meta_title" class="form-control">
    <label for="meta_description">Meta Description:</label>
    <textarea id="meta_description" name="meta_description" class="form-control"></textarea>
    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
</form>

<?= $this->endSection() ?>