<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<style>
  .custom_file::-webkit-file-upload-button {
    margin-top: -10px;
    margin-left: -5px;
  }

  .image-preview-cut-save {
    max-width: 20rem;
  }

  /* Tambahkan margin atas untuk preview cropper dan hasil crop */
  #imagePreview,
  #croppedImagePreview {
    margin-top: 2rem;
  }
</style>

<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><?= esc($title); ?></h1>

  <div class="mb-3" style="display: <?= !empty($proyek['image_name']) ? 'block' : 'none'; ?>;">
    <?php if (!empty($proyek['image_name'])): ?>
      <label>Gambar Proyek Saat Ini</label>
      <div>
        <img src="<?= base_url('uploads/proyek/' . esc($proyek['image_name'])) ?>" alt="Gambar Proyek Saat Ini" style="max-width:20rem; display:block;">
      </div>
    <?php endif; ?>
  </div>


  <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
      <?php foreach (session()->getFlashdata('errors') as $error): ?>
        <p><?= esc($error); ?></p>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <form action="<?= base_url('admin/grade_level/proyek/simpan/' . $kelas['id']) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="d-flex align-items-center" style="gap:10px; margin-bottom:1rem">
      <div style="min-width: 7rem;">
        <label for="aspectRatio" class="form-label">Rasio</label>
        <select id="aspectRatio" class="form-control">
          <option value="16/9" selected>16:9</option>
          <option value="4/3">4:3</option>
          <option value="1/1">1:1</option>
          <option value="3/4">3:4</option>
        </select>
      </div>
      <div class="flex-grow-1">
        <label for="gambar" class="form-label">Pilih File Gambar Proyek</label>
        <input type="file" name="gambar" id="gambar" class="form-control custom_file" accept="image/*" required>
      </div>
    </div>

    <!-- Pesan peringatan -->
    <small class="text-danger d-block mb-3">
      * Mengupload gambar baru akan menggantikan gambar proyek yang lama.
    </small>

    <!-- Container Preview: Menampilkan preview untuk cropper dan hasil crop -->
    <div id="image-preview-container" class="image-preview-cut-save-group" style="display: none;">
      <!-- Preview untuk cropper -->
      <img id="imagePreview" style="max-width: 20rem; display: block;" alt="Preview Gambar">
      <!-- Preview hasil crop, disembunyikan awalnya -->
      <img id="croppedImagePreview" style="max-width: 20rem; display: none;" alt="Hasil Pangkas">
      <div style="display: flex; gap: 1rem; margin-top: 1rem;">
        <button type="button" id="crop-button" class="btn btn-primary">Pangkas & Simpan</button>
        <button type="button" id="cancel-crop-button" class="btn btn-warning">Batal Pangkas</button>
      </div>
    </div>

    <input type="hidden" name="cropped_image" id="cropped_image" class="cropped_image">

    <div class="form-group mt-3">
      <label for="deskripsi">Deskripsi Proyek</label>
      <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control" placeholder="Masukkan deskripsi proyek" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    <a href="<?= base_url('admin/grade_level/proyek/' . $kelas['id']) ?>" class="btn btn-warning mt-3" style="width:7rem">Kembali</a>
  </form>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
  let cropper;
  const inputFile = document.getElementById("gambar");
  const imagePreviewContainer = document.getElementById("image-preview-container");
  const imagePreview = document.getElementById("imagePreview"); // Elemen preview untuk cropper
  const cropButton = document.getElementById("crop-button");
  const cancelCropButton = document.getElementById("cancel-crop-button");
  const aspectRatioSelect = document.getElementById("aspectRatio");
  const croppedImagePreview = document.getElementById("croppedImagePreview");

  function initializeCropper(aspectRatio) {
    if (cropper) {
      cropper.destroy(); // Hancurkan cropper lama jika ada
    }
    cropper = new Cropper(imagePreview, {
      aspectRatio: aspectRatio,
      viewMode: 2,
      autoCropArea: 1,
      dragMode: 'move',
      movable: true,
      zoomable: true
    });
  }

  function getAspectRatio(value) {
    let ratioParts = value.split("/");
    return parseFloat(ratioParts[0]) / parseFloat(ratioParts[1]);
  }

  inputFile.addEventListener("change", function(event) {
    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function(e) {
        // Set preview untuk cropper
        imagePreview.src = e.target.result;
        imagePreview.onload = function() {
          imagePreviewContainer.style.display = "block";
          // Tampilkan preview cropper dan sembunyikan preview hasil crop jika sebelumnya pernah ada
          imagePreview.style.display = "block";
          croppedImagePreview.style.display = "none";
          cropButton.style.display = "inline-block";
          cancelCropButton.style.display = "inline-block";
          aspectRatioSelect.style.display = "inline-block";
          initializeCropper(getAspectRatio(aspectRatioSelect.value));
        };
      };
      reader.readAsDataURL(file);
    } else {
      alert("File yang dipilih bukan gambar!");
    }
  });

  aspectRatioSelect.addEventListener("change", function() {
    if (cropper) {
      cropper.setAspectRatio(getAspectRatio(this.value));
    }
  });

  cropButton.addEventListener("click", function() {
    if (cropper) {
      let canvas = cropper.getCroppedCanvas();
      if (canvas) {
        canvas.toBlob(blob => {
          let croppedFile = new File([blob], inputFile.files[0].name, {
            type: "image/jpeg"
          });
          let dataTransfer = new DataTransfer();
          dataTransfer.items.add(croppedFile);
          inputFile.files = dataTransfer.files;

          // Hancurkan cropper setelah selesai
          cropper.destroy();
          cropper = null;

          // Tampilkan preview gambar hasil crop
          croppedImagePreview.src = URL.createObjectURL(blob);
          croppedImagePreview.style.display = "block";
          // Sembunyikan area cropper dan kontrol terkait
          imagePreview.style.display = "none";
          cropButton.style.display = "none";
          cancelCropButton.style.display = "none";
          // Tidak mengupdate currentImageContainer agar gambar lama tetap tampil hingga form disubmit
        }, "image/jpeg");
      }
    }
  });

  cancelCropButton.addEventListener("click", function() {
    imagePreviewContainer.style.display = "none";
    inputFile.value = "";
    if (cropper) {
      cropper.destroy();
      cropper = null;
    }
  });
</script>
<?= $this->endSection() ?>