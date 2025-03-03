<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 text-gray-800"><?= esc($title) ?></h1>
    <a href="<?= base_url('admin/prestasi/tambah_prestasi/' . esc($user['id'])); ?>" class="btn btn-primary">Tambah Prestasi Siswa</a>

  </div>

  <!-- Pesan error validasi, sukses, dan error umum -->
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

  <?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger">
      <?= session()->getFlashdata('error'); ?>
    </div>
  <?php endif; ?>

  <div class="mb-3 d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center flex-grow-1 me-3" style="min-width: 0; ">
      <input type="text" id="searchInput" class="form-control flex-grow-1" placeholder="Cari prestasi" style="min-width: 0; max-width:30rem; margin-right:1rem">
      <i class="fas fa-search text-muted ms-2" id="iconSearch" style="margin-right:1rem"></i>
    </div>
    <!-- Tombol di sebelah kanan -->
    <a href="<?= base_url('admin/prestasi/'); ?>" class="btn btn-warning" id="tambahPrestasiBtn">Kembali</a>
  </div>

  <!-- Tabel prestasi user -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead style="color: black; background-color:#2222">
        <tr>
          <th style="width: 5%;">No</th>
          <th style="width: 30%;">Nama Kegiatan</th>
          <th style="width: 12%;">Jenis</th>
          <th style="width: 15%;">Tingkat</th>
          <th style="width: 10%;">Tahun</th>
          <th style="width: 14%;">Pencapaian</th>
          <th style="width: 14%;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; ?>
        <?php if (!empty($prestasis)): ?>
          <?php foreach ($prestasis as $prestasi): ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= esc($prestasi['nama_kegiatan']); ?></td>
              <td><?= esc($prestasi['jenis']); ?></td>
              <td><?= esc($prestasi['tingkat']); ?></td>
              <td><?= esc($prestasi['tahun']); ?></td>
              <td><?= esc($prestasi['pencapaian']); ?></td>
              <td>
                <div class="d-flex flex-wrap gap-2" style="justify-content: space-between;">
                  <a href="<?= base_url('admin/prestasi/prestasi_detail/info/' . esc($user['id']) . '/' . esc($prestasi['id'])); ?>" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px;">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="<?= base_url('admin/prestasi/prestasi_detail/edit/' . esc($user['id']) . '/' . esc($prestasi['id'])); ?>" class="btn btn-warning btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px;">
                    <i class="fas fa-pen"></i>
                  </a>
                  <form action="<?= base_url('admin/prestasi/prestasi_detail/delete/' . esc($prestasi['id'])); ?>" method="post">
                    <?= csrf_field(); ?>
                    <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px" onclick="return confirm('Apakah Anda yakin ingin menghapus prestasi ini?');">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </form>
                </div>

              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="text-center">Belum ada prestasi untuk user ini.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $("#searchInput").on("keyup", function() {
    var value = $(this).val().toLowerCase().trim();

    $("table tbody tr").each(function() {
      var nama_kegiatan = $(this).find("td:nth-child(2)").text().toLowerCase().trim();
      var jenis = $(this).find("td:nth-child(3)").text().toLowerCase().trim();
      var tingkat = $(this).find("td:nth-child(4)").text().toLowerCase().trim();
      var tahun = $(this).find("td:nth-child(4)").text().toLowerCase().trim();
      var pencapaian = $(this).find("td:nth-child(5)").text().toLowerCase().trim();
      if (nama_kegiatan.includes(value) || jenis.includes(value || tingkat.includes(value) || tahun
          .includes(value) || pencapaian.includes(value))) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  });
</script>
<?= $this->endSection() ?>