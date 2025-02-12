<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<!-- Sertakan CSS Cropper.js -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">

<style>
    .custom_file::-webkit-file-upload-button {
        margin-top: -10px;
        margin-left: -5px;
    }

    /* Styling untuk preview crop yang aktif (sebelum disimpan) */
    .image-preview-cut-save {
        width: 50vw;
        max-height: 20vw;
    }
</style>


<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Mitra</h1>

    <!-- Form Edit Mitra -->
    <form action="<?= base_url('admin/pengaturan/mitra/update/' . $mitra['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <!-- Nama Mitra -->
        <div class="form-group">
            <label for="partner">Nama Mitra</label>
            <input type="text" name="partner" id="partner" class="form-control" placeholder="Masukkan nama sekolah/partner" value="<?= $mitra['partner'] ?>" required>
        </div>

        <!-- Alamat -->
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Masukkan alamat sekolah/partner" value="<?= $mitra['alamat'] ?>" required>
        </div>

        <!-- Link Google Maps -->
        <div class="form-group">
            <label for="maps">Link Google Maps</label>
            <input type="url" name="maps" id="maps" class="form-control" placeholder="Masukkan link Google Maps sekolah/partner" value="<?= $mitra['maps'] ?>" required>
        </div>

        <!-- Upload Logo -->
        <div class="mb-3">
            <label for="logo" class="form-label">Upload Logo</label>
            <input type="file" class="form-control" id="logo" name="logo">
            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti logo.</small>

            <!-- Preview Logo Saat Ini -->
            <?php if ($mitra['logo']) : ?>
                <div class="mt-3">
                    <label>Logo Saat Ini:</label>
                    <img src="<?= base_url('uploads/' . $mitra['logo']) ?>" alt="Logo Saat Ini" style="max-width: 150px;">
                </div>
            <?php endif; ?>
        </div>

        <!-- Preview Gambar Tercrop yang ditampilkan di bawah input file -->
        <div id="cropped-preview-container" style="display: none; margin-bottom: 1rem;">
            <p>Pratinjau Foto</p>
            <img id="cropped-preview" src="" alt="Preview Foto Tercrop" style="max-width: 20%; height: auto; border: 1px solid #888; border-radius: 5px; margin-bottom:1rem">
        </div>

        <!-- Container Preview untuk Crop (ditampilkan saat proses crop aktif) -->
        <div id="image-preview-container" class="image-preview-cut-save-group" style="display: none;width: 400px;">
            <img id="image-preview" class="image-preview-cut-save">
            <div id="crop-buttons-container" style="display: flex; gap: 1rem; margin-top: 1rem; margin-bottom: 2rem">
                    <button type="button" id="crop-button" class="btn btn-primary">Pangkas & Simpan</button>
                    <button type="button" id="cancel-crop-button" class="btn btn-warning">Batal Pangkas</button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Partner</button>
        <a href="<?= base_url('admin/pengaturan/mitra') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>

<!-- Sertakan JS Cropper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let cropper;

    // Ketika file gambar dipilih
    document.getElementById("logo").addEventListener("change", function(event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                let imagePreview = document.getElementById("image-preview");
                imagePreview.src = e.target.result;
                // Tampilkan container preview crop
                document.getElementById("image-preview-container").style.display = "block";
                // Jika ada preview final sebelumnya, sembunyikan
                document.getElementById("cropped-preview-container").style.display = "none";
                // Jika cropper sudah ada, hancurkan terlebih dahulu
                if (cropper) {
                    cropper.destroy();
                }
                // Inisialisasi Cropper.js dengan aspect ratio 16:9 (ubah sesuai kebutuhan)
                cropper = new Cropper(imagePreview, {
                    aspectRatio: 1 / 1,
                    viewMode: 2,
                    autoCropArea: 1,
                });
            };
            reader.readAsDataURL(file);
        }
    });

    // Tombol "Pangkas & Simpan"
    document.getElementById("crop-button").addEventListener("click", function() {
        if (cropper) {
            let canvas = cropper.getCroppedCanvas();
            if (canvas) {
                canvas.toBlob((blob) => {
                    // Buat file baru dari hasil crop
                    let fileInput = document.getElementById("logo");
                    let fileName = fileInput.files[0].name;
                    let croppedFile = new File([blob], fileName, {
                        type: "image/jpeg"
                    });
                    // Buat objek FileList baru menggunakan DataTransfer
                    let dataTransfer = new DataTransfer();
                    dataTransfer.items.add(croppedFile);
                    fileInput.files = dataTransfer.files;

                    // Tampilkan preview gambar final di bawah input file
                    let finalPreview = document.getElementById("cropped-preview");
                    finalPreview.src = URL.createObjectURL(blob);
                    document.getElementById("cropped-preview-container").style.display = "block";

                    // Sembunyikan container preview crop
                    document.getElementById("image-preview-container").style.display = "none";
                }, "image/jpeg");
            }
        }
    });

    // Tombol "Batal Pangkas"
    document.getElementById("cancel-crop-button").addEventListener("click", function() {
        // Sembunyikan container preview crop
        document.getElementById("image-preview-container").style.display = "none";
        // Reset input file
        document.getElementById("logo").value = "";
        // Hapus instance cropper jika ada
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        // Sembunyikan preview final jika ada
        document.getElementById("cropped-preview-container").style.display = "none";
    });
</script>

<?= $this->endSection() ?>
