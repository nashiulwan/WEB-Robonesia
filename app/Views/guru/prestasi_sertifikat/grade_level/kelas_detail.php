<?= $this->extend('guru/layout') ?>

<?= $this->section('content') ?>
<style>
  /* Styling tabel informasi dan level kelas */
  .table-detail tbody tr:nth-of-type(odd) {
    background-color: rgba(78, 115, 223, 0.1) !important;
  }

  .table-detail tbody tr:nth-of-type(even) {
    background-color: white !important;
  }

  .desc-container {
    max-height: 6em;
    overflow-y: auto;
    line-height: 1.5em;
  }

  /* Styling grid kartu untuk Proyek Kelas */
  .card-deck {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1rem;
  }

  .card {
    max-width: 30rem;
    border: 1px solid #ddd;
    border-radius: 0.25rem;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    background-color: white;
  }

  .card img {
    width: 100%;
    height: auto;
    object-fit: cover;
    margin-bottom: -3rem;
    -webkit-mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 1) 70%, rgba(0, 0, 0, 0.6) 80%, rgba(0, 0, 0, 0));
    mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 1) 70%, rgba(0, 0, 0, 0.6) 80%, rgba(0, 0, 0, 0));
  }

  .card-body {
    height: 3rem;
    flex-grow: 1;
  }

  .card-text {
    overflow: hidden;
    color: black;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 4;
    /* Batasi 4 baris */
    -webkit-box-orient: vertical;
  }

  .card-footer {
    background-color: #f8f9fc;
    padding: 0.1rem 1rem;
    font-size: 0.875rem;
    color: #858796;
    text-align: right;
  }

  .section-title {
    margin-top: 2rem;
    margin-bottom: 1rem;
  }
</style>

<div class="container-fluid my-4">
  <!-- Informasi Kelas -->
  <h1 class="h3 mb-4 text-gray-800">Informasi Kelas</h1>
  <table class="table table-borderless table-striped table-detail" style="color: black;">
    <tr>
      <th style="width:35%;">Nama Kelas</th>
      <td><?= esc($class['nama_kelas']) ?></td>
    </tr>
    <tr>
      <th>Kode Kelas</th>
      <td><?= esc($class['kode_kelas']) ?></td>
    </tr>
    <tr>
      <th>Jumlah Anggota</th>
      <td><?= esc($class['jumlah_anggota']) ?></td>
    </tr>
    <tr>
      <th>Grade/Level</th>
      <td><?= esc($class['level']) ?></td>
    </tr>
    <tr>
      <th>Sub Level</th>
      <td><?= esc($class['sub_level'] ?? '-') ?></td>
    </tr>
  </table>

  <!-- Proyek Kelas -->
  <h2 class="h4 section-title">Proyek Kelas</h2>
  <?php if (!empty($proyek)): ?>
    <div class="card-deck">
      <?php foreach ($proyek as $proyek): ?>
        <div class="card shadow">
          <?php if (!empty($proyek['image_name'])): ?>
            <img src="<?= base_url('uploads/proyek/' . esc($proyek['image_name'])) ?>" alt="Gambar Proyek">
          <?php else: ?>
            <img src="<?= base_url('assets/img/no-image.png') ?>" alt="No Image">
          <?php endif; ?>
          <div class="card-body">
            <p class="card-text"><?= esc($proyek['deskripsi']) ?></p>
          </div>
          <div class="card-footer">
            <small class="text-muted">
              <?= esc(date('d M Y', strtotime($proyek['created_at']))) ?> |
              <?= esc(date('d M Y', strtotime($proyek['updated_at']))) ?>
            </small>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p class="text-muted">Tidak ada data proyek kelas.</p>
  <?php endif; ?>

  <div class="mt-3">
    <a href="<?= base_url('guru/grade_level') ?>" class="btn btn-warning" style="min-width:7rem">Kembali</a>
  </div>
</div>
<?= $this->endSection() ?>