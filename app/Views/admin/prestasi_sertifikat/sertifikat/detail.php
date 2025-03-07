<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<style>
  .table-detail tbody tr:nth-of-type(odd) {
    background-color: rgba(78, 115, 223, 0.1) !important;
  }

  .table-detail tbody tr:nth-of-type(even) {
    background-color: white !important;
  }

  .table-account tbody tr:nth-of-type(odd) {
    background-color: white !important;
  }

  .table-account tbody tr:nth-of-type(even) {
    background-color: rgba(78, 115, 223, 0.1) !important;
  }

  #previewContainer,
  #existingFilesContainer {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 10px;
    justify-content: center;
  }

  .preview-container {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    width: 100%;
    max-width: 15rem;
    height: 14rem;
    padding: 4px;
    border: 1px solid #ccc;
    border-radius: 8px;
    overflow: hidden;
    background: #f9f9f9;
    cursor: pointer;
  }

  .preview-container img,
  .preview-container embed {
    max-width: 100%;
    max-height: 13rem;
    object-fit: contain;
  }

  /* Tombol hapus pada preview file */
  .remove-existing-file {
    position: absolute;
    top: 2px;
    right: 2px;
    background: rgba(255, 0, 0, 0.8);
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 1.5rem;
    height: 1.5rem;
    font-size: 0.8rem;
    line-height: 1.5rem;
    text-align: center;
    cursor: pointer;
    z-index: 2;
  }

  /* Modal CSS */
  .modal {
    display: none;
    position: fixed;
    z-index: 10000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.8);
  }

  .modal-content {
    position: relative;
    margin: 1rem auto;
    padding: 0;
    height: 90%;
    width: 80%;
    background: #fff;
    display: flex;
    flex-direction: column;
  }

  /* Untuk object/pdf */
  .modal-content object {
    width: 100%;
    height: 100%;
    flex-grow: 1;
    display: block;
  }

  .modal-content img {
    max-height: 90vh;
    display: block;
    margin: auto;
    object-fit: contain;
  }

  #modalContent {
    flex: 1;
    position: relative;
  }

  .close {
    position: absolute;
    top: 4px;
    right: 10px;
    color: white;
    background: black;
    border-radius: 50%;
    width: 2rem;
    height: 2rem;
    font-size: 1.5rem;
    font-weight: bold;
    cursor: pointer;
    z-index: 10001;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.9);
  }

  .btn-download {
    position: absolute;
    bottom: 4px;
    left: 10px;
  }

  /* Responsive adjustments untuk mobile */
  @media (max-width: 576px) {
    .modal-content {
      width: 95%;
      height: 95%;
      margin: 0.5rem auto;
    }

    .preview-container {
      max-width: 100%;
      height: auto;
    }

    .preview-container img,
    .preview-container embed {
      max-height: 10rem;
    }
  }
</style>

<div class="container-fluid my-4">
  <h1 class="h3 mb-4 text-gray-800">Detail Sertifikat</h1>
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

<!-- JQuery dan Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function openModal(dataUrl, fileType) {
    var modal = document.getElementById("fileModal");
    var modalContent = document.getElementById("modalContent");
    modalContent.innerHTML = "";

    if (fileType.startsWith("image/")) {
      // Tampilkan gambar
      var img = document.createElement("img");
      img.src = dataUrl;
      img.style.height = "100%";
      img.style.width = "auto";
      img.style.display = "block";
      img.style.margin = "auto";
      modalContent.appendChild(img);

      var downloadButton = document.createElement("a");
      downloadButton.href = dataUrl;
      downloadButton.download = "image_download";
      downloadButton.textContent = "Download Gambar";
      downloadButton.className = "btn-download btn btn-primary download-btn";
      modalContent.appendChild(downloadButton);

    } else if (fileType === "application/pdf") {
      // Gunakan <object> dengan fallback
      var objectEl = document.createElement("object");
      objectEl.data = dataUrl;
      objectEl.type = "application/pdf";
      objectEl.style.width = "100%";
      objectEl.style.height = "100%";
      modalContent.appendChild(objectEl);

      // Fallback text jika PDF tidak muncul
      var fallbackText = document.createElement("p");
      fallbackText.style.padding = "1rem";
      fallbackText.innerText = "Jika PDF tidak muncul, silakan unduh melalui tombol di bawah:";
      modalContent.appendChild(fallbackText);

      var downloadButton = document.createElement("a");
      downloadButton.href = dataUrl;
      downloadButton.download = "sertifikat.pdf";
      downloadButton.textContent = "Download PDF";
      downloadButton.className = "btn-download btn btn-primary download-btn";
      modalContent.appendChild(downloadButton);

    } else {
      // Jika bukan gambar atau PDF
      modalContent.innerHTML = "<p class='text-center p-3'>Preview tidak tersedia untuk file ini.</p>";
    }

    modal.style.display = "block";
  }

  function closeModal() {
    document.getElementById("fileModal").style.display = "none";
  }

  document.getElementById("closeModal").addEventListener("click", closeModal);
  window.addEventListener("click", function(event) {
    var modal = document.getElementById("fileModal");
    if (event.target == modal) {
      closeModal();
    }
  });
</script>

<?= $this->endSection() ?>