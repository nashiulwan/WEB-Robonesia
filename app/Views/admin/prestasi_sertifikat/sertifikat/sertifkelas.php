<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 text-gray-800"><?= esc($title) ?></h1>
    <a href="<?= base_url('admin/sertifikat/kelas/tambah/' . esc($kelas['id'])); ?>" class="btn btn-primary">Tambah Sertifikat</a>
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

  <!-- Tabel sertifikat -->
  <div class="mb-3 d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center flex-grow-1 me-3" style="min-width: 0; ">
      <input type="text" id="searchInput" class="form-control flex-grow-1" placeholder="Cari sertifikat" style="min-width: 0; max-width:30rem; margin-right:1rem">
      <i class="fas fa-search text-muted ms-2" id="iconSearch" style="margin-right:1rem"></i>
    </div>
    <!-- Tombol di sebelah kanan -->
    <a href="<?= base_url('admin/sertifikat/'); ?>" class="btn btn-warning" id="tambahPrestasiBtn">Kembali</a>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead style="color: black; background-color:#2222">
        <tr>
          <th style="width: 5%;">No</th>
          <th style="width: 29%;">Sertifikat</th>
          <th style="width: 26%;">Deskripsi</th>
          <th style="width: 15%;">Dibuat</th>
          <th style="width: 15%;">Diubah</th>
          <th style="width: 10%;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; ?>
        <?php if (!empty($sertifikat)): ?>
          <?php foreach ($sertifikat as $row): ?>
            <tr>
              <td><?= $no++; ?></td>
              <td>
                <?php
                // Decode data JSON menjadi array
                $files = json_decode($row['nama_file'], true);
                if (!empty($files)):
                  $totalFiles = count($files);
                  $displayCount = ($totalFiles > 3) ? 3 : $totalFiles;
                  for ($i = 0; $i < $displayCount; $i++):
                    $fileName = $files[$i];
                    // Jika nama file terlalu panjang, potong agar tidak mengganggu lebar tabel
                    if (strlen($fileName) > 25) {
                      $ext  = pathinfo($fileName, PATHINFO_EXTENSION);
                      $base = pathinfo($fileName, PATHINFO_FILENAME);

                      $base = substr($base, 0, 15) . '...' . substr($base, -3);
                      $fileName = $base . '.' . $ext;
                    }
                    echo esc($fileName) . '<br>';
                  endfor;
                  if ($totalFiles > 3):
                    echo '... (total: ' . $totalFiles . ')';
                  endif;
                endif;
                ?>
              </td>
              <td><?= esc($row['deskripsi']); ?></td>
              <td><?= esc(date("d-m-Y H:i", strtotime($row['created_at']))); ?></td>
              <td><?= esc(date("d-m-Y H:i", strtotime($row['updated_at']))); ?></td>
              <td>
                <div class="d-flex flex-wrap gap-2" style="justify-content: space-between;">
                  <a href="<?= base_url('admin/sertifikat/kelas/edit/' . esc($kelas['id'])) . '/' . esc($row['id']); ?>" class="btn btn-warning btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px;">
                    <i class="fas fa-pen"></i>
                  </a>
                  <form action="<?= base_url('admin/sertifikat/kelas/delete/' . esc($kelas['id'])) . '/' . esc($row['id']); ?>" method="post">
                    <?= csrf_field(); ?>
                    <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px" onclick="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?');">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="text-center">Belum ada sertifikat untuk kelas ini.</td>
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
      var sertifikat = $(this).find("td:nth-child(2)").text().toLowerCase().trim(); // Kolom Sertifikat
      var deskripsi = $(this).find("td:nth-child(3)").text().toLowerCase().trim(); // Kolom Deskripsi

      if (sertifikat.includes(value) || deskripsi.includes(value)) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  });
</script>
<?= $this->endSection() ?>