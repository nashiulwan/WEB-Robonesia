<?= $this->extend('guru/layout') ?>

<?= $this->section('content') ?>
<!-- Sertakan Cropper CSS dari CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<style>
    .custom_file::-webkit-file-upload-button {
        margin-top: -10px;
        margin-left: -5px;
    }

    /* Styling untuk preview crop yang aktif (sebelum disimpan) */
    .image-preview-cut-save {
        width: 50vw;
        max-height: 30vw;
    }
</style>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Galeri Siswa</h1>

    <!-- Tampilkan pesan error validasi -->
    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Tampilkan pesan sukses -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('guru/galeri/update/' . esc($user['id']) . '/' . esc($galeri['id'])) ?>" method="post" enctype="multipart/form-data" autocomplete="off">
        <?= csrf_field() ?>

        <!-- Field Judul -->
        <div class="form-group">
            <label for="judul">Judul</label>
            <input type="text" name="judul" id="judul" class="form-control" value="<?= old('judul', $galeri['judul']) ?>" placeholder="Masukkan judul">
        </div>

        <!-- Field Deskripsi -->
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" placeholder="Masukkan deskripsi"><?= old('deskripsi', $galeri['deskripsi']) ?></textarea>
        </div>

        <!-- Field Level -->
        <div class="form-group">
            <label for="level">Level</label>
            <select name="level" id="level" class="form-control" required>
                <option value="" disabled <?= ($galeri['level'] == '' ? 'selected' : '') ?>>Tentukan Level</option>
                <option value="Basic" <?= ($galeri['level'] == 'Basic' ? 'selected' : '') ?>>Basic</option>
                <option value="Intermediate" <?= ($galeri['level'] == 'Intermediate' ? 'selected' : '') ?>>Intermediate</option>
                <option value="Advance" <?= ($galeri['level'] == 'Advance' ? 'selected' : '') ?>>Advanced</option>
                <option value="Lainnya" <?= (!in_array($galeri['level'], ['Basic', 'Intermediate', 'Advance']) ? 'selected' : '') ?>>Lainnya</option>
            </select>
        </div>
        <!-- Field Level Lainnya (jika diperlukan) -->
        <div class="form-group" id="subLevelContainer" style="display: <?= (!in_array($galeri['level'], ['Basic', 'Intermediate', 'Advance']) ? 'block' : 'none') ?>;">
            <input type="text" name="level_lainnya" id="level_lainnya" class="form-control" placeholder="Masukkan level lain" value="<?= (!in_array($galeri['level'], ['Basic', 'Intermediate', 'Advance']) ? $galeri['level'] : '') ?>">
        </div>

        <!-- Field Sub Level -->
        <div class="form-group">
            <label for="sub_level">Sub Level</label>
            <input type="text" name="sub_level" id="sub_level" class="form-control" value="<?= old('sub_level', $galeri['sub_level']) ?>" placeholder="Masukkan sub level">
        </div>

        <!-- Tampilkan gambar saat ini -->
        <div class="form-group">
            <label for="gambar">Gambar Saat Ini</label>
            <?php if (!empty($galeri['gambar'])) : ?>
                <div>
                    <img src="<?= base_url('uploads/galeri/' . $galeri['gambar']); ?>" alt="Gambar Galeri" class="img-fluid" style="max-width: 200px; height: auto;">
                </div>
            <?php else : ?>
                <p>Tidak ada gambar</p>
            <?php endif; ?>
        </div>

        <!-- Field Unggah Gambar Baru dengan Cropper -->
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
                <label for="gambar">Unggah Gambar Baru</label>
                <input type="file" class="form-control custom_file" id="gambar" name="gambar" accept="image/*">
            </div>
        </div>

        <!-- Preview Gambar Tercrop -->
        <div id="cropped-preview-container" style="display: none; margin-bottom: 1rem;">
            <p>Pratinjau Gambar</p>
            <img id="cropped-preview" src="" alt="Preview Gambar Tercrop" style="max-height: 400px; border: 1px solid #888; border-radius: 5px; margin-bottom:1rem">
        </div>

        <!-- Container Preview untuk Crop -->
        <div id="image-preview-container" class="image-preview-cut-save-group" style="display: none;">
            <img id="image-preview" class="image-preview-cut-save">
            <div id="crop-buttons-container" style="display: flex; gap: 1rem; margin-top: 1rem; margin-bottom: 2rem">
                <button type="button" id="crop-button" class="btn btn-primary">Pangkas & Simpan</button>
                <button type="button" id="cancel-crop-button" class="btn btn-warning">Batal Pangkas</button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width:7rem">Simpan</button>
        <a href="<?= base_url('guru/galeri/detail/' . esc($user['id'])) ?>" class="btn btn-warning" style=" width:7rem">Kembali</a>
    </form>
</div>

<!-- Sertakan Cropper JS dari CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let cropper;
    const inputFile = document.getElementById("gambar");
    const imagePreviewContainer = document.getElementById("image-preview-container");
    const imagePreview = document.getElementById("image-preview");
    const cropButton = document.getElementById("crop-button");
    const cancelCropButton = document.getElementById("cancel-crop-button");
    const aspectRatioSelect = document.getElementById("aspectRatio");
    const croppedPreview = document.getElementById("cropped-preview");

    function initializeCropper(aspectRatio) {
        if (cropper) {
            cropper.destroy();
        }
        cropper = new Cropper(imagePreview, {
            aspectRatio: aspectRatio,
            viewMode: 2,
            autoCropArea: 1,
        });
    }

    function getAspectRatio(value) {
        let parts = value.split("/");
        return parseFloat(parts[0]) / parseFloat(parts[1]);
    }

    inputFile.addEventListener("change", function(event) {
        const file = event.target.files[0];
        if (file && file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreviewContainer.style.display = "block";
                initializeCropper(getAspectRatio(aspectRatioSelect.value));
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
                    let newFile = new File([blob], inputFile.files[0].name, {
                        type: "image/jpeg"
                    });
                    let dt = new DataTransfer();
                    dt.items.add(newFile);
                    inputFile.files = dt.files;

                    croppedPreview.src = URL.createObjectURL(blob);
                    document.getElementById("cropped-preview-container").style.display = "block";

                    imagePreviewContainer.style.display = "none";
                    cropper.destroy();
                    cropper = null;
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

    // Tampilkan/sembunyikan field level lainnya
    const levelSelect = document.getElementById("level");
    const subLevelContainer = document.getElementById("subLevelContainer");
    levelSelect.addEventListener("change", function() {
        if (this.value === "Lainnya") {
            subLevelContainer.style.display = "block";
        } else {
            subLevelContainer.style.display = "none";
        }
    });
</script>
<?= $this->endSection() ?>