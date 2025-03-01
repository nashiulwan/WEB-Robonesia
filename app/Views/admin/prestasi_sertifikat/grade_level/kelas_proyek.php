<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<!-- Custom CSS untuk styling tampilan -->
<style>
  /* Menghilangkan efek fokus pada button filter (jika diperlukan nantinya) */
  .btn-filter-role:focus,
  .btn-filter-role:active {
    background: none !important;
    border: none !important;
    box-shadow: none !important;
    outline: none !important;
  }

  /* Hilangkan caret default pada dropdown button */
  #filterRoleButton::after {
    display: none;
  }
</style>

<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 text-gray-800"><?= esc($title) ?></h1>
    <a href="<?= base_url('admin/grade_level/proyek/tambah/' . esc($kelas['id'])) ?>" class="btn btn-primary">
      Tambah Proyek
    </a>
  </div>

  <!-- Tampilkan Flash Message jika ada -->
  <?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
  <?php endif; ?>

  <!-- Form Pencarian -->
  <div class="mb-3 d-flex align-items-center justify-content-between">
    <div class="flex-grow-1 me-3" style="margin-right:1rem">
      <input type="text" id="searchInput" class="form-control" placeholder="Cari proyek berdasarkan nama atau deskripsi">
    </div>
    <i class="fas fa-search text-muted" style="margin-right:1rem"></i>
  </div>

  <?php
  // Urutkan array $proyek berdasarkan created_at secara descending
  if (!empty($proyek)) {
    usort($proyek, function ($a, $b) {
      return strtotime($b['created_at']) - strtotime($a['created_at']);
    });
  }
  ?>

  <!-- Tabel Responsive -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead class="table" style="color: black; background-color:#2222">
        <tr>
          <th style="width: 5%;">No</th>
          <th style="width: 25%;">Proyek</th>
          <th style="width: 26%;">Deskripsi</th>
          <th style="width: 15%;">Dibuat Tanggal</th>
          <th style="width: 15%;">Diupdate Tanggal</th>
          <th style="width: 9%;">Aksi</th>
        </tr>
      </thead>
      <tbody class="table-group-divider" style="color: black;">
        <?php $no = 1; ?>
        <?php if (!empty($proyek)) : ?>
          <?php foreach ($proyek as $img) : ?>
            <tr>
              <td><?= $no++; ?></td>
              <td>
                <img src="<?= base_url('uploads/proyek/' . esc($img['image_name'])) ?>" alt="Gambar" style="max-height:100px;"><br>
              </td>
              <td><?= esc($img['deskripsi']); ?></td>
              <td><?= esc($img['created_at']); ?></td>
              <td><?= esc($img['updated_at']); ?></td>
              <td>
                <div class="d-flex flex-wrap gap-2" style="justify-content: space-between;">
                  <a href="<?= base_url('admin/grade_level/proyek/edit/' . esc($kelas['id']) . '/' . esc($img['id'])) ?>" class="btn btn-warning btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;  margin-bottom: 10px;">
                    <i class="fas fa-pen"></i>
                  </a>
                  <a href="<?= base_url('admin/grade_level/proyek/delete/' . esc($kelas['id']) . '/' . esc($img['id'])) ?>" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" onclick="return confirm('Apakah Anda yakin ingin menghapus proyek ini?');">
                    <i class="fas fa-trash"></i>
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td colspan="6" class="text-center">Tidak ada data proyek</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Pastikan jQuery dan Bootstrap JS telah dimuat untuk fitur pencarian -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  // Fitur pencarian: filter baris tabel berdasarkan teks yang diketik
  $("#searchInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("table tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
</script>

<?= $this->endSection() ?>