<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <h1>Tambah Artikel Baru</h1>
    <form>
      <div class="mb-3">
        <label for="judul" class="form-label">Judul Artikel</label>
        <input type="text" class="form-control" id="judul" placeholder="Masukkan judul artikel">
      </div>
      <div class="mb-3">
        <label for="kategori" class="form-label">Kategori</label>
        <select class="form-select" id="kategori">
          <option>Pilih Kategori</option>
          <option>Teknologi</option>
          <option>Bisnis</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="konten" class="form-label">Konten Artikel</label>
        <textarea class="form-control" id="konten" rows="5" placeholder="Tulis isi artikel..."></textarea>
      </div>
      <button type="submit" class="btn btn-success">Simpan Artikel</button>
    </form>
  </div>

  <?= $this->endSection() ?>