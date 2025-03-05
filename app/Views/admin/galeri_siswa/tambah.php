<?= $this->extend('admin/layout') ?>

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
    <h1 class="h3 mb-4 text-gray-800">Tambah Galeri Siswa</h1>

    <!-- Menampilkan pesan error validasi -->
    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Menampilkan pesan sukses -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/galeri/simpan/' . esc($user['id'])) ?>" method="post" enctype="multipart/form-data" autocomplete="off">
        <?= csrf_field() ?>

        <!-- Field Judul -->
        <div class="form-group">
            <label for="judul">Judul</label>
            <input type="text" name="judul" id="judul" class="form-control <?= (session()->getFlashdata('errors') && array_key_exists('judul', session()->getFlashdata('errors'))) ? 'is-invalid' : '' ?>" value="<?= old('judul') ?>" placeholder="Masukkan judul">
            <?php if (session()->getFlashdata('errors') && array_key_exists('judul', session()->getFlashdata('errors'))) : ?>
                <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors')['judul'] ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Field Deskripsi -->
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control <?= (session()->getFlashdata('errors') && array_key_exists('deskripsi', session()->getFlashdata('errors'))) ? 'is-invalid' : '' ?>" placeholder="Masukkan deskripsi"><?= old('deskripsi') ?></textarea>
            <?php if (session()->getFlashdata('errors') && array_key_exists('deskripsi', session()->getFlashdata('errors'))) : ?>
                <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors')['deskripsi'] ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Field Level -->
        <div class="form-group">
            <label for="level">Level</label>
            <select name="level" id="level" class="form-control" required>
                <option value="" disabled selected>Tentukan Level</option>
                <option value="Basic">Basic</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Advance">Advanced</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>
        <!-- Field Level Lainnya (hanya muncul jika opsi 'Lainnya' dipilih) -->
        <div class="form-group" id="subLevelContainer" style="display: none;">
            <input type="text" name="level_lainnya" id="level_lainnya" class="form-control" placeholder="Masukkan level lain" value="">
        </div>

        <!-- Field Sub Level -->
        <div class="form-group">
            <label for="sub_level">Sub Level</label>
            <input type="text" name="sub_level" id="sub_level" class="form-control <?= (session()->getFlashdata('errors') && array_key_exists('sub_level', session()->getFlashdata('errors'))) ? 'is-invalid' : '' ?>" value="<?= old('sub_level') ?>" placeholder="Masukkan sub level">
            <?php if (session()->getFlashdata('errors') && array_key_exists('sub_level', session()->getFlashdata('errors'))) : ?>
                <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors')['sub_level'] ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Field Unggah Gambar dengan Cropper dan Aspect Ratio -->
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
                <label for="gambar" class="form-label">Unggah Gambar</label>
                <input type="file" class="form-control <?= (session()->getFlashdata('errors') && array_key_exists('gambar', session()->getFlashdata('errors'))) ? 'is-invalid' : '' ?> custom_file" id="gambar" name="gambar" accept="image/*" required>
                <?php if (session()->getFlashdata('errors') && array_key_exists('gambar', session()->getFlashdata('errors'))) : ?>
                    <div class="invalid-feedback">
                        <?= session()->getFlashdata('errors')['gambar'] ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Preview Gambar Tercrop -->
        <div id="cropped-preview-container" style="display: none; margin-bottom: 1rem;">
            <p>Pratinjau Gambar</p>
            <img id="cropped-preview" src="" alt="Preview Gambar Tercrop" style="max-height: 400px; border: 1px solid #888; border-radius: 5px; margin-bottom:1rem">
        </div>

        <!-- Container Preview untuk Crop (ditampilkan saat proses crop aktif) -->
        <div id="image-preview-container" class="image-preview-cut-save-group" style="display: none;">
            <img id="image-preview" class="image-preview-cut-save">
            <div id="crop-buttons-container" style="display: flex; gap: 1rem; margin-top: 1rem; margin-bottom: 2rem">
                <button type="button" id="crop-button" class="btn btn-primary">Pangkas & Simpan</button>
                <button type="button" id="cancel-crop-button" class="btn btn-warning">Batal Pangkas</button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('admin/galeri_siswa') ?>" class="btn btn-warning" style="margin-left:10px; width:7rem">Kembali</a>
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

    // Inisialisasi Cropper dengan aspek rasio dari select
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

    // Mengonversi value select (misal "16/9") ke nilai numerik
    function getAspectRatio(value) {
        let parts = value.split("/");
        return parseFloat(parts[0]) / parseFloat(parts[1]);
    }

    // Listener untuk input file gambar
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

    // Ubah aspek rasio cropper ketika select berubah
    aspectRatioSelect.addEventListener("change", function() {
        if (cropper) {
            cropper.setAspectRatio(getAspectRatio(this.value));
        }
    });

    // Listener tombol crop & simpan
    cropButton.addEventListener("click", function() {
        if (cropper) {
            let canvas = cropper.getCroppedCanvas();
            if (canvas) {
                canvas.toBlob(blob => {
                    // Buat file baru dari hasil crop
                    let newFile = new File([blob], inputFile.files[0].name, {
                        type: "image/jpeg"
                    });
                    // Update input file dengan file hasil crop menggunakan DataTransfer
                    let dt = new DataTransfer();
                    dt.items.add(newFile);
                    inputFile.files = dt.files;

                    // Tampilkan preview hasil crop
                    croppedPreview.src = URL.createObjectURL(blob);
                    document.getElementById("cropped-preview-container").style.display = "block";

                    // Sembunyikan container cropper dan hancurkan cropper
                    imagePreviewContainer.style.display = "none";
                    cropper.destroy();
                    cropper = null;
                }, "image/jpeg");
            }
        }
    });

    // Listener tombol batal crop
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