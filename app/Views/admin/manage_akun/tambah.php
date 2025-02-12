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
    <h1 class="h3 mb-4 text-gray-800">Tambah Akun</h1>

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

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>

    <!-- Menampilkan pesan error umum -->
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Form Tambah Akun -->
    <form action="<?= base_url('admin/manage_akun/simpan') ?>" method="post" enctype="multipart/form-data" autocomplete="off">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="username">Nama Pengguna</label>
            <input type="text" name="username" id="username" class="form-control <?= (session()->getFlashdata('errors') && array_key_exists('username', session()->getFlashdata('errors'))) ? 'is-invalid' : '' ?>" value="<?= old('username') ?>" placeholder="Masukkan nama pengguna" required autocomplete="off">
            <?php if (session()->getFlashdata('errors') && array_key_exists('username', session()->getFlashdata('errors'))) : ?>
                <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors')['username'] ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="fullname">Nama Lengkap</label>
            <input type="text" name="fullname" id="fullname" class="form-control <?= (session()->getFlashdata('errors') && array_key_exists('fullname', session()->getFlashdata('errors'))) ? 'is-invalid' : '' ?>" value="<?= old('fullname') ?>" placeholder="Masukkan nama lengkap" autocomplete="off">
            <?php if (session()->getFlashdata('errors') && array_key_exists('fullname', session()->getFlashdata('errors'))) : ?>
                <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors')['fullname'] ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Alamat Email</label>
            <input type="email" name="email" id="email" class="form-control <?= (session()->getFlashdata('errors') && array_key_exists('email', session()->getFlashdata('errors'))) ? 'is-invalid' : '' ?>" value="<?= old('email') ?>" placeholder="Masukkan alamat email" autocomplete="off">
            <?php if (session()->getFlashdata('errors') && array_key_exists('email', session()->getFlashdata('errors'))) : ?>
                <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors')['email'] ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="role">Hak Akses</label>
            <select class="custom-select" name="role" required>
                <option value="" disabled selected>Pilih Role</option>
                <option value="1">Admin</option>
                <option value="3">Guru</option>
                <option value="2">Siswa</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="user_image" class="form-label">Unggah Foto Profil</label>
            <input type="file" class="form-control <?= (session()->getFlashdata('errors') && array_key_exists('user_image', session()->getFlashdata('errors'))) ? 'is-invalid' : '' ?> custom_file" id="user_image" name="user_image" accept="image/*">
            <?php if (session()->getFlashdata('errors') && array_key_exists('user_image', session()->getFlashdata('errors'))) : ?>
                <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors')['user_image'] ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Preview Gambar Tercrop yang ditampilkan di bawah input file -->
        <div id="cropped-preview-container" style="display: none; margin-bottom: 1rem;">
            <p>Pratinjau Foto Profil</p>
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

        <div class="form-group">
            <label for="password">Kata Sandi</label>
            <input type="password" name="password" id="password" class="form-control <?= (session()->getFlashdata('errors') && array_key_exists('password', session()->getFlashdata('errors'))) ? 'is-invalid' : '' ?>" placeholder="Masukkan kata sandi" required autocomplete="new-password">
            <?php if (session()->getFlashdata('errors') && array_key_exists('password', session()->getFlashdata('errors'))) : ?>
                <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors')['password'] ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="confirm_password">Konfirmasi Kata Sandi</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control <?= (session()->getFlashdata('errors') && array_key_exists('confirm_password', session()->getFlashdata('errors'))) ? 'is-invalid' : '' ?>" placeholder="Masukkan kata sandi" required autocomplete="new-password">
            <?php if (session()->getFlashdata('errors') && array_key_exists('confirm_password', session()->getFlashdata('errors'))) : ?>
                <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors')['confirm_password'] ?>
                </div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Tambah Akun</button>
        <a href="<?= base_url('admin/manage_akun') ?>" class="btn btn-warning" style="margin-left:10px; width:7rem">Kembali</a>
    </form>
</div>

<!-- Sertakan Cropper JS dari CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let cropper;
    let previousImageSrc;

    // Ketika file gambar dipilih
    document.getElementById("user_image").addEventListener("change", function(event) {
        let file = event.target.files[0];
        if (file) {
            if (!file.type.startsWith('image/')) {
                alert("File yang dipilih bukan gambar!");
                return;
            }
            let reader = new FileReader();
            reader.onload = function(e) {
                let imagePreview = document.getElementById("image-preview");
                imagePreview.src = e.target.result;
                // Tampilkan container preview crop
                document.getElementById("image-preview-container").style.display = "block";
                // Sembunyikan preview final (jika ada)
                document.getElementById("cropped-preview-container").style.display = "none";
                // Simpan src gambar profil sebelumnya (untuk opsi batal crop)
                let currentProfile = document.querySelector(".user-image-now img");
                if (currentProfile) {
                    previousImageSrc = currentProfile.src;
                }
                // Hancurkan instance cropper yang sudah ada (jika ada)
                if (cropper) {
                    cropper.destroy();
                }
                // Inisialisasi Cropper.js dengan aspect ratio 1:1 untuk foto profil
                cropper = new Cropper(imagePreview, {
                    aspectRatio: 1,
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
                    let fileInput = document.getElementById("user_image");
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
        // Reset input file (gunakan id "user_image")
        document.getElementById("user_image").value = "";
        // Hapus instance cropper jika ada
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        // Sembunyikan preview final (jika ada)
        document.getElementById("cropped-preview-container").style.display = "none";
    });
</script>
<?= $this->endSection() ?>