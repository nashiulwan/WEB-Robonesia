<?= $this->extend('siswa/layout') ?>

<?= $this->section('content') ?>
<!-- Sertakan Cropper CSS dari CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<!-- Sertakan Bootstrap Icons (jika belum disertakan di layout) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    .custom_file::-webkit-file-upload-button {
        margin-top: -10px;
        margin-left: -5px;
    }

    .image-preview-cut-save {
        width: 50vw;
        max-height: 30vw;
    }

    .user-image-now {
        margin-right: 1rem;
    }

    .form-label-now-img {
        display: none;
    }

    /* Styling tambahan untuk ikon toggle password */
    .input-group-eye .input-group-text i {

        cursor: pointer;
        /* Ubah cursor menjadi pointer saat hover */
    }

    @media (max-width: 720px) {
        .profile-container {
            flex-direction: column;
            align-items: center;
        }

        .profile-container img {
            margin-bottom: 5px;
        }

        .image-preview-cut-save {
            max-height: 50vw;
            width: 70vw;
        }

        .user-image-now {
            margin-right: 0rem;
        }

        .form-profil-now {
            display: none;
        }

        .form-label-now {
            display: none;
        }

        .form-label-now-img {
            display: block;
            text-align: center;
            width: 100%;
        }

        .form-input {
            width: 100%;
        }
    }
</style>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- Tampilkan pesan error/sukses jika ada -->
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
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Form Edit Profil -->
    <form action="<?= base_url('siswa/profil/update') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="mb-3 d-flex profile-container">
            <!-- Kolom Foto Profil Lama -->
            <?php if (!empty($user['user_image'])): ?>
                <div class="me-3 user-image-now">
                    <img src="<?= base_url('/uploads/' . $user['user_image']) ?>" alt="Gambar Profil" width="200" class="img-thumbnail">
                    <label for="user_image" class="form-label form-label-now-img">Foto Profil Sekarang</label>
                </div>
            <?php endif; ?>

            <!-- Kolom Unggah Foto Baru & Preview/Crop -->
            <div class="flex-grow-1 form-input">
                <div class="flex-grow-1 mb-3">
                    <label for="user_image" class="form-label form-label-now">Foto Profil Sekarang</label>
                    <input type="text" class="form-control form-profil-now" id="file-name" value="<?= !empty($user['user_image']) ? $user['user_image'] : 'Pilih file gambar' ?>" readonly>
                </div>
                <div class="flex-grow-1 mb-3 new-file-input">
                    <label for="user_image" class="form-label">Unggah Foto Profil Baru <span class="text-danger">*</span></label>
                    <input type="file" class="form-control custom_file" id="user_image" name="user_image" accept="image/*">
                    <small class="text-muted">
                        <span class="text-danger">*</span> Pilih foto baru jika Anda ingin mengganti foto profil saat ini. Jika tidak, biarkan kosong.
                    </small>
                </div>

                <!-- Container Preview & Crop (ditampilkan saat proses crop aktif) -->
                <div id="image-preview-container" class="image-preview-cut-save-group" style="display: none;">
                    <img id="image-preview" class="image-preview-cut-save" alt="Preview">
                    <div id="crop-buttons-container" style="display: flex; gap: 1rem; margin-top: 1rem;">
                        <button type="button" id="crop-button" class="btn btn-primary">Pangkas & Simpan</button>
                        <button type="button" id="cancel-crop-button" class="btn btn-warning">Batal Pangkas</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Profil Pribadi -->
        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= old('email', $user['email']) ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="fullname">Nama Lengkap</label>
            <input type="text" name="fullname" id="fullname" class="form-control" value="<?= old('fullname', $user['fullname']) ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="asal_sekolah">Asal Sekolah</label>
            <input type="text" name="asal_sekolah" id="asal_sekolah" class="form-control" value="<?= old('asal_sekolah', $user['asal_sekolah']) ?>">
        </div>
        <div class="form-group mb-3">
            <label for="kelas">Kelas</label>
            <input type="text" name="kelas" id="kelas" class="form-control" value="<?= old('kelas', $user['kelas']) ?>">
        </div>
        <div class="form-group mb-3">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" rows="3"><?= old('alamat', $user['alamat']) ?></textarea>
        </div>
        <div class="form-group mb-3">
            <label for="nomor_telepon">No HP</label>
            <input type="text" name="nomor_telepon" id="nomor_telepon" class="form-control" value="<?= old('nomor_telepon', $user['nomor_telepon']) ?>">
        </div>

        <!-- Bagian Ganti Password -->
        <h4 class="mt-4">Ganti Password <span class="text-danger">*</span></h4>
        <!-- Password Lama -->
        <div class="form-group mb-3">
            <label for="old_password">Password Lama</label>
            <div class="input-group input-group-eye">
                <input type="password" name="old_password" id="old_password" class="form-control form-control-eye" placeholder="Masukkan password lama">
                <span class="input-group-text"><i class="bi bi-eye" id="toggleOldPassword"></i></span>
            </div>
        </div>
        <!-- Password Baru -->
        <div class="form-group mb-3">
            <label for="new_password">Password Baru</label>
            <div class="input-group input-group-eye">
                <input type="password" name="new_password" id="new_password" class="form-control form-control-eye" placeholder="Masukkan password baru">
                <span class="input-group-text"><i class="bi bi-eye" id="togglePassword"></i></span>
            </div>
        </div>
        <!-- Konfirmasi Password Baru -->
        <div class="form-group mb-3">
            <label for="confirm_password">Konfirmasi Password Baru</label>
            <div class="input-group input-group-eye">
                <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-eye" placeholder="Konfirmasi password baru">
                <span class="input-group-text"><i class="bi bi-eye" id="toggleConfirmPassword"></i></span>
            </div>
        </div>
        <small>
            <span class="text-danger">*</span> Silakan masukkan password lama Anda untuk melakukan verifikasi sebelum mengganti dengan password baru.
        </small><br>
        <small>
            <span class="text-danger">**</span> Bagian ini hanya perlu diisi jika Anda ingin mengganti password.
        </small><br>
        <small>
            <span class="text-danger">***</span> Jika Anda lupa password lama dan ingin menggantinya, silakan hubungi administrator melalui
            <a href="https://wa.me/6282118032898" target="_blank">WhatsApp</a>.
        </small>

        <br><br>
        <button type="submit" class="btn btn-primary" style="width:7rem">Simpan</button>
        <a href="<?= base_url('siswa/profil') ?>" class="btn btn-warning ms-2" style="margin-left:10px; width:7rem">Batal</a>
    </form>
</div>

<!-- Sertakan Cropper JS dari CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let cropper;
    let previousImageSrc;

    // Saat file gambar dipilih untuk crop
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
                    let fileInput = document.getElementById("user_image");
                    let fileName = fileInput.files[0].name;
                    let croppedFile = new File([blob], fileName, {
                        type: "image/jpeg"
                    });
                    // Buat objek FileList baru menggunakan DataTransfer
                    let dataTransfer = new DataTransfer();
                    dataTransfer.items.add(croppedFile);
                    fileInput.files = dataTransfer.files;
                    // Perbarui tampilan gambar profil dengan hasil crop
                    let profileImage = document.querySelector(".user-image-now img");
                    profileImage.src = URL.createObjectURL(blob);
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
        document.getElementById("user_image").value = "";
        // Hapus instance cropper jika ada
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        // Jika ada, kembalikan gambar profil ke kondisi semula
        let profileImage = document.querySelector(".user-image-now img");
        if (profileImage && previousImageSrc) {
            profileImage.src = previousImageSrc;
        }
    });

    // Toggle password untuk "Password Lama"
    document.getElementById("toggleOldPassword").addEventListener("click", function() {
        var field = document.getElementById("old_password");
        var icon = this;
        if (field.type === "password") {
            field.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            field.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    });

    // Toggle password untuk "Password Baru"
    document.getElementById("togglePassword").addEventListener("click", function() {
        var field = document.getElementById("new_password");
        var icon = this;
        if (field.type === "password") {
            field.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            field.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    });

    // Toggle password untuk "Konfirmasi Password Baru"
    document.getElementById("toggleConfirmPassword").addEventListener("click", function() {
        var field = document.getElementById("confirm_password");
        var icon = this;
        if (field.type === "password") {
            field.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            field.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    });
</script>
<?= $this->endSection() ?>