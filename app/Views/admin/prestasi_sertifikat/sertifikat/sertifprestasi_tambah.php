<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<style>
  .custom_file::-webkit-file-upload-button {
    margin-top: -10px;
    margin-left: -5px;
  }

  #previewContainer {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 10px;
    justify-content: center;
  }

  .preview-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    width: 100%;
    max-width: 15rem;
    /* Batasi lebar agar grid tetap rapi */
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
    /* Bayangan lebih halus */
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

  <form action="<?= base_url('admin/sertifikat/prestasi/simpan/' . esc($prestasi['id'])) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="form-group mb-3">
      <label for="nama_file">Sertifikat <span class="text-danger">*</span> </label>
      <input type="file" name="nama_file[]" id="nama_file" class="form-control custom_file" multiple required>
      <small><span class="text-danger">*</span> Sertifikat dapat berupa file gambar dan PDF</small>
    </div>

    <!-- Container preview file -->
    <div id="previewContainer" class="mt-3"></div>

    <div class="form-group mb-3">
      <label for="deskripsi">Deskripsi</label>
      <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi sertifikat" required><?= old('deskripsi') ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('admin/sertifikat/prestasi/' . esc($prestasi['id'])) ?>" class="btn btn-warning">Kembali</a>
  </form>
</div>

<!-- Modal Popup untuk Preview -->
<div id="fileModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeModal">&times;</span>
    <div id="modalContent"></div>
  </div>
</div>

<!-- JQuery dan script preview file serta modal -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function openModal(dataUrl, fileType) {
    var modal = document.getElementById("fileModal");
    var modalContent = document.getElementById("modalContent");
    modalContent.innerHTML = ""; // Bersihkan konten modal
    if (fileType.startsWith("image/")) {
      var img = document.createElement("img");
      img.src = dataUrl;
      img.style.height = "100%"; // Gunakan 100% tinggi modal
      img.style.width = "auto"; // Sesuaikan lebar berdasarkan aspek rasio
      img.style.display = "block";
      img.style.margin = "auto"; // Tengahkan gambar secara horizontal
      modalContent.appendChild(img);

      // Tambahkan tombol download untuk gambar
      var downloadButton = document.createElement("a");
      downloadButton.href = dataUrl;
      downloadButton.download = "image_download"; // Nama default file
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

      // Tambahkan tombol download untuk PDF
      var downloadButton = document.createElement("a");
      downloadButton.href = dataUrl;
      downloadButton.download = "sertifikat.pdf"; // Nama default file
      downloadButton.textContent = "Download PDF";
      downloadButton.className = "btn-download btn btn-primary download-btn";
      modalContent.appendChild(downloadButton);
    } else {
      modalContent.innerHTML = "<p class='text-center p-3'>Preview tidak tersedia untuk file ini.</p>";
    }

    modal.style.display = "block";
  }


  // Fungsi untuk menutup modal
  function closeModal() {
    document.getElementById("fileModal").style.display = "none";
  }

  // Event listener untuk tombol close modal
  document.getElementById("closeModal").addEventListener("click", closeModal);

  // Event listener untuk menutup modal jika klik di luar konten modal
  window.addEventListener("click", function(event) {
    var modal = document.getElementById("fileModal");
    if (event.target == modal) {
      closeModal();
    }
  });

  // Preview file saat input file berubah
  document.getElementById('nama_file').addEventListener('change', function() {
    const previewContainer = document.getElementById('previewContainer');
    previewContainer.innerHTML = ''; // Hapus preview sebelumnya
    const files = this.files;

    for (let i = 0; i < files.length; i++) {
      let file = files[i];

      // Buat container untuk preview file
      let container = document.createElement('div');
      container.className = 'preview-container';

      // Variabel untuk menyimpan data URL file
      let dataUrl = '';

      // Baca file menggunakan FileReader
      let reader = new FileReader();
      reader.onload = function(e) {
        dataUrl = e.target.result;

        let previewElement;
        if (file.type.startsWith('image/')) {
          // Jika file berupa gambar
          previewElement = document.createElement('img');
          previewElement.src = dataUrl;
        } else if (file.type === 'application/pdf') {
          // Jika file PDF, tampilkan preview embed kecil
          previewElement = document.createElement('embed');
          previewElement.src = dataUrl;
          previewElement.type = 'application/pdf';
          previewElement.style.height = "13rem";
        } else if (file.type === 'application/msword' || file.type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
          previewElement = document.createElement('i');
          previewElement.className = 'fas fa-file-word';
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

      // Tampilkan nama file dengan ellipsis jika terlalu panjang
      let fileName = document.createElement('p');
      fileName.textContent = file.name;
      fileName.style.fontSize = '0.8rem';
      fileName.style.wordBreak = 'break-word';
      fileName.style.overflow = 'hidden';
      fileName.style.textOverflow = 'ellipsis';
      fileName.style.whiteSpace = 'nowrap';
      fileName.style.paddingTop = '5px';
      fileName.style.marginBottom = '2px';
      fileName.style.width = '90%'; // Pastikan lebar sesuai container
      container.appendChild(fileName);

      previewContainer.appendChild(container);
    }
  });
</script>
<?= $this->endSection() ?>