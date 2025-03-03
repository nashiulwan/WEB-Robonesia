<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">

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

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Form edit Akun -->

    <form action="<?= base_url('admin/manage_akun/update/' . $users['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="mb-3 d-flex profile-container">
            <!-- Menampilkan gambar profil lama jika ada -->
            <?php if (!empty($users['user_image'])): ?>
                <div class="me-3 user-image-now">
                    <img src=" <?= base_url('/uploads/' . $users['user_image']) ?>" alt="Gambar Profil" width="200" class="img-thumbnail">
                    <label for="user_image" class="form-label form-label-now-img">Foto Profil Sekarang</label>
                </div>
            <?php endif; ?>

            <div class="flex-grow-1 form-input">
                <div class="flex-grow-1 mb-3">
                    <label for="user_image" class="form-label form-label-now">Foto Profil Sekarang</label>
                    <input type="text" class="form-control form-profil-now" id="file-name" value="<?= !empty($users['user_image']) ? $users['user_image'] : 'Pilih file gambar' ?>" readonly>
                </div>
                <div class="flex-grow-1 mb-3 new-file-input">
                    <label for="user_image" class="form-label">
                        Unggah Foto Profil Baru <span class="text-danger">*</span>
                    </label>
                    <input type="file" class="form-control custom_file " id="user_image" name="user_image" accept="image/*">
                    <small class="text-muted"><span class="text-danger">*</span> Pilih foto baru jika ingin mengganti foto profil saat ini. Jika tidak, biarkan kosong.</small>
                </div>

                <!-- Tempat Preview dan Crop -->
                <div id="image-preview-container" class="image-preview-cut-save-group" style="display: none;">
                    <img id="image-preview" class="image-preview-cut-save">
                    <div id="crop-buttons-container" style="display: flex; gap: 1rem; margin-top: 1rem;">
                        <button type="button" id="crop-button" class="btn btn-primary">Pangkas & Simpan</button>
                        <button type="button" id="cancel-crop-button" class="btn btn-warning">Batal Pangkas</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="username">Nama Pengguna</label>
            <input type="text" name="username" id="username" class="form-control" value="<?= old('username', $users['username']) ?>" required>
        </div>

        <div class="form-group">
            <label for="fullname">Nama Lengkap</label>
            <input type="text" name="fullname" id="fullname" class="form-control" value="<?= old('fullname', $users['fullname']) ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Alamat Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= old('email', $users['email']) ?>" required>
        </div>

        <div class="form-group">
            <label for="role">Hak Akses</label>
            <select class="custom-select" name="role" required>
                <option value="1" <?= ($role == '1') ? 'selected' : '' ?>>Admin</option>
                <option value="3" <?= ($role == '3') ? 'selected' : '' ?>>Guru</option>
                <option value="2" <?= ($role == '2') ? 'selected' : '' ?>>Siswa</option>
                <option value="0" <?= ($role == '0') ? 'selected' : '' ?>>-</option>
            </select>
        </div>

        <div class="form-group">
            <label for="status">Status Akun</label>
            <select class="custom-select" name="status" required>
                <option value="1" <?= ($users['status'] == '1') ? 'selected' : '' ?>>Aktif</option>
                <option value="0" <?= ($users['status'] == '0') ? 'selected' : '' ?>>Tidak Aktif</option>
            </select>
        </div>
        <div class="form-group">
            <label for="password">Kata Sandi Baru (Opsional) <span class="text-danger">*</span></label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin diubah" autocomplete="new-password">
            <small class="text-muted"><span class="text-danger">*</span> Masukkan kata sandi baru jika ingin mengubahnya. Jika tidak, biarkan kosong.</small>
        </div>


        <div class="form-group">
            <label for="confirm_password">Konfirmasi Kata Sandi</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Masukkan kembali kata sandi baru" autocomplete="new-password">
        </div>
        <button type="submit" class="btn btn-primary">Update Akun</button>
        <a href="<?= base_url('admin/manage_akun') ?>" class="btn btn-warning" style="margin-left:10px; width:7rem">Kembali</a>

    </form>
</div>



<script>
    document.getElementById("user_image").addEventListener("change", function() {
        var fileName = this.files[0] ? this.files[0].name : "Pilih file gambar";
        document.getElementById("file-name").value = fileName;
    });

    document.getElementById("user_image").addEventListener("change", function(event) {
        var file = event.target.files[0];
        var preview = document.querySelector(".user-image-now img");
        var fileNameInput = document.getElementById("file-name");

        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result; // Ganti src dengan gambar yang baru dipilih
            };
            reader.readAsDataURL(file);

            fileNameInput.value = file.name; // Perbarui input teks dengan nama file
        } else {
            fileNameInput.value = "Pilih file gambar";
        }
    });

    let cropper;
    let previousImageSrc = document.querySelector(".user-image-now img").src;

    document.getElementById("user_image").addEventListener("change", function(event) {
        let file = event.target.files[0];

        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                let imagePreview = document.getElementById("image-preview");
                imagePreview.src = e.target.result;
                document.getElementById("image-preview-container").style.display = "block";

                // Hapus cropper sebelumnya jika ada
                if (cropper) {
                    cropper.destroy();
                }

                // Simpan gambar sebelumnya sebelum diubah
                previousImageSrc = document.querySelector(".user-image-now img").src;

                // Inisialisasi Cropper.js dengan rasio 1:1
                cropper = new Cropper(imagePreview, {
                    aspectRatio: 1,
                    viewMode: 2,
                    autoCropArea: 1,
                });
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById("crop-button").addEventListener("click", function() {
        let canvas = cropper.getCroppedCanvas();

        if (canvas) {
            canvas.toBlob((blob) => {
                let fileInput = document.getElementById("user_image");
                let fileName = fileInput.files[0].name;
                let croppedFile = new File([blob], fileName, {
                    type: "image/jpeg"
                });

                // Buat objek FileList baru (agar bisa dikirim ke form)
                let dataTransfer = new DataTransfer();
                dataTransfer.items.add(croppedFile);
                fileInput.files = dataTransfer.files;

                // Perbarui tampilan gambar profil sebelumnya dengan hasil crop
                let profileImage = document.querySelector(".user-image-now img");
                profileImage.src = URL.createObjectURL(blob);

                // Sembunyikan preview setelah crop selesai
                document.getElementById("image-preview-container").style.display = "none";
            }, "image/jpeg");
        }
    });

    // Event listener untuk tombol "Batal Pangkas"
    document.getElementById("cancel-crop-button").addEventListener("click", function() {
        document.getElementById("image-preview-container").style.display = "none";

        // Kembalikan gambar sebelumnya
        let profileImage = document.querySelector(".user-image-now img");
        profileImage.src = previousImageSrc;

        // Hapus file yang baru dipilih dari input file
        document.getElementById("user_image").value = "";

        // Hapus instance cropper jika ada
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<?= $this->endSection() ?>