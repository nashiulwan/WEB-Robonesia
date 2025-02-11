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
    <h1 class="h3 mb-4 text-gray-800">Tambah Anggota Tim</h1>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form action="<?= base_url('admin/pengaturan/tim/simpan') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label for="foto">Foto Profil</label>
                    <input type="file" name="foto" id="foto" class="form-control" required>
                </div>

                <!-- Preview Gambar Tercrop yang ditampilkan di bawah input file -->
                <div id="cropped-preview-container" style="display: none; margin-bottom: 1rem;">
                    <p>Pratinjau Foto</p>
                    <img id="cropped-preview" src="" alt="Preview Foto Tercrop" style="max-width: 20%; height: auto; border: 1px solid #888; border-radius: 5px; margin-bottom:1rem">
                </div>

                <!-- Container Preview untuk Crop (ditampilkan saat proses crop aktif) -->
                <div id="image-preview-container" class="image-preview-cut-save-group" style="display: none;">
                    <img id="image-preview" class="image-preview-cut-save">
                    <div id="crop-buttons-container" style="display: flex; gap: 1rem; margin-top: 1rem; margin-bottom: 2rem">
                        <button type="button" id="crop-button" class="btn btn-primary">Pangkas & Simpan</button>
                        <button type="button" id="cancel-crop-button" class="btn btn-warning">Batal Pangkas</button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                </div>

                <div class="form-group">
                    <label for="peran">Peran dalam Tim</label>
                    <input type="text" name="peran" id="peran" class="form-control" placeholder="Misal: Developer, Designer, Manager" required>
                </div>

                <div class="form-group">
                    <label for="facebook">Facebook</label>
                    <input type="url" name="facebook" id="facebook" class="form-control" placeholder="Masukkan URL Facebook">
                </div>

                <div class="form-group">
                    <label for="whatsapp">WhatsApp</label>
                    <input type="text" name="whatsapp" id="whatsapp" class="form-control" value="https://wa.me/">
                </div>

                <div class="form-group">
                    <label for="twitter">Twitter</label>
                    <input type="url" name="twitter" id="twitter" class="form-control" placeholder="Masukkan URL Twitter">
                </div>

                <div class="form-group">
                    <label for="instagram">Instagram</label>
                    <input type="url" name="instagram" id="instagram" class="form-control" placeholder="Masukkan URL Instagram">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('admin/pengaturan/tim') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<!-- Sertakan JS Cropper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let cropper;

    // Ketika file gambar dipilih
    document.getElementById("foto").addEventListener("change", function(event) {
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
                    let fileInput = document.getElementById("foto");
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
        document.getElementById("foto").value = "";
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
