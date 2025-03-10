<?= $this->extend('siswa/templates/dashboard'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid my-4">
  <h1 class="h3 mb-4 text-gray-800">Sertifikat</h1>
  <div class="card shadow-sm">
    <div class="card-body">
      <table class="table table-borderless table-striped table-detail" style="color: black;">
        <tr>
          <th style="width:35%;">Deskripsi</th>
          <td><?= esc($sertifikat['deskripsi']) ?></td>
        </tr>
        <tr>
          <th>Sasaran Sertifikat</th>
          <td><?= esc($sertifikat['target_type']) ?></td>
        </tr>
        <tr>
          <th>Penerima</th>
          <td><?= esc($sertifikat['penerima']) ?></td>
        </tr>
      </table>

      <!-- Modal -->
      <div id="fileModal" class="modal">
        <div class="modal-content">
          <span id="closeModal" class="close">&times;</span>
          <div id="modalContent"></div>
        </div>
      </div>

      <!-- Tampilan File yang Sudah Ada -->
      <div class="form-group mb-3">
        <label>File Sertifikat:</label>
        <div id="existingFilesContainer" class="mt-2">
          <?php
          $existingFiles = json_decode($sertifikat['nama_file'], true);
          if (!empty($existingFiles)):
            foreach ($existingFiles as $file):
              $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
              $fileUrl = base_url('uploads/sertifikat/' . $file);
              // Tentukan tipe file untuk modal (PDF atau image)
              $fileType = ($ext === 'pdf') ? 'application/pdf' : 'image/' . $ext;
          ?>
              <div class="preview-container" data-filename="<?= esc($file) ?>" onclick="openModal('<?= $fileUrl ?>', '<?= $fileType ?>')">
                <?php if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg'])): ?>
                  <img src="<?= $fileUrl ?>" alt="Preview">
                <?php elseif ($ext === 'pdf'): ?>
                  <embed src="<?= $fileUrl ?>" type="application/pdf" style="height:13rem;">
                <?php else: ?>
                  <i class="fas fa-file"></i>
                <?php endif; ?>
                <p style="font-size:0.8rem; word-break: break-word; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; padding-top: 5px; margin-bottom: 2px; width: 90%;"><?= esc($file) ?></p>
              </div>
          <?php
            endforeach;
          endif;
          ?>
        </div>
      </div>
      <a href="<?= base_url('admin/sertifikat') ?>" class="btn btn-warning" style="width:7rem">Kembali</a>
    </div>
  </div>
</div>


<?= $this->endSection(); ?>
