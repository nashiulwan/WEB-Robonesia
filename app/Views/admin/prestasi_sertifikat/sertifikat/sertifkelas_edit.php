<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<style>
  .custom_file::-webkit-file-upload-button {
    margin-top: -10px;
    margin-left: -5px;
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

  .modal-content embed {
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
</style>

<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><?= esc($title) ?></h1>

  <!-- Pesan error validasi dan sukses -->
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

  <!-- Form Update Sertifikat -->
  <form action="<?= base_url('admin/sertifikat/kelas/update/' . esc($kelas) . '/' . esc($sertifikat['id'])) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <!-- Deskripsi Sertifikat -->
    <div class="form-group mb-3">
      <label for="deskripsi">Deskripsi</label>
      <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi sertifikat" required><?= old('deskripsi', $sertifikat['deskripsi']) ?></textarea>
    </div>

    <!-- Tampilan File yang Sudah Ada -->
    <div class="form-group mb-3">
      <label>File Existing:</label>
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
              <button type="button" class="remove-existing-file" onclick="event.stopPropagation(); removeExistingFile(this)">×</button>
              <!-- Hidden input agar file yang tidak dihapus tetap terkirim -->
              <input type="hidden" name="existing_files[]" value="<?= esc($file) ?>">
            </div>
        <?php
          endforeach;
        endif;
        ?>
      </div>
    </div>

    <!-- Tambah File Baru -->
    <div class="form-group mb-3">
      <label for="nama_file">Tambah File Baru (opsional)</label>
      <input type="file" name="nama_file[]" id="nama_file" class="form-control custom_file" multiple>
      <small>Sertifikat dapat berupa file gambar dan PDF</small>
    </div>

    <!-- Preview File Baru -->
    <div id="previewContainer" class="mt-3 mb-3"></div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= base_url('admin/sertifikat/kelas/' . esc($kelas)) ?>" class="btn btn-warning">Kembali</a>
  </form>
</div>

<!-- Modal Popup untuk Preview -->
<div id="fileModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeModal">&times;</span>
    <div id="modalContent"></div>
  </div>
</div>

<!-- JQuery dan Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  // Fungsi untuk menghapus file existing
  function removeExistingFile(button) {
    $(button).closest('.preview-container').remove();
  }

  function openModal(dataUrl, fileType) {
    var modal = document.getElementById("fileModal");
    var modalContent = document.getElementById("modalContent");
    modalContent.innerHTML = "";
    if (fileType.startsWith("image/")) {
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
      var embed = document.createElement("embed");
      embed.src = dataUrl;
      embed.type = "application/pdf";
      embed.style.width = "100%";
      embed.style.height = "100%";
      modalContent.appendChild(embed);
      var downloadButton = document.createElement("a");
      downloadButton.href = dataUrl;
      downloadButton.download = "sertifikat.pdf";
      downloadButton.textContent = "Download PDF";
      downloadButton.className = "btn-download btn btn-primary download-btn";
      modalContent.appendChild(downloadButton);
    } else {
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

  // Preview file baru saat input file berubah
  document.getElementById('nama_file').addEventListener('change', function() {
    const previewContainer = document.getElementById('previewContainer');
    previewContainer.innerHTML = '';
    const files = this.files;
    for (let i = 0; i < files.length; i++) {
      let file = files[i];
      let container = document.createElement('div');
      container.className = 'preview-container';
      let dataUrl = '';
      let reader = new FileReader();
      reader.onload = function(e) {
        dataUrl = e.target.result;
        let previewElement;
        if (file.type.startsWith('image/')) {
          previewElement = document.createElement('img');
          previewElement.src = dataUrl;
        } else if (file.type === 'application/pdf') {
          previewElement = document.createElement('embed');
          previewElement.src = dataUrl;
          previewElement.type = 'application/pdf';
          previewElement.style.height = "13rem";
        } else {
          previewElement = document.createElement('i');
          previewElement.className = 'fas fa-file';
          previewElement.style.height = "13rem";
        }
        container.insertBefore(previewElement, container.firstChild);
        container.addEventListener('click', function() {
          if (dataUrl) {
            openModal(dataUrl, file.type);
          } else {
            alert('File belum siap untuk preview.');
          }
        });
      };
      reader.readAsDataURL(file);
      let fileName = document.createElement('p');
      fileName.textContent = file.name;
      fileName.style.fontSize = '0.8rem';
      fileName.style.wordBreak = 'break-word';
      fileName.style.overflow = 'hidden';
      fileName.style.textOverflow = 'ellipsis';
      fileName.style.whiteSpace = 'nowrap';
      fileName.style.paddingTop = '5px';
      fileName.style.marginBottom = '2px';
      fileName.style.width = '90%';
      container.appendChild(fileName);
      previewContainer.appendChild(container);
    }
  });
</script>
<?= $this->endSection() ?>