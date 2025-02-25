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
        max-height: 30vw;
    }
</style>

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Artikel</h1>

    <!-- Form Edit Artikel -->
    <form action="<?= base_url('admin/artikel/update/' . $artikel['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="judul">Judul Artikel</label>
            <input type="text" name="judul" id="judul" class="form-control" value="<?= esc($artikel['judul']) ?>" required>
        </div>

        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select name="kategori" id="kategori" class="form-control" required>
                <?php foreach ($kategoriList as $kategori): ?>
                    <option value="<?= esc($kategori) ?>" <?= ($kategori == $artikel['kategori']) ? 'selected' : '' ?>>
                        <?= esc($kategori) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label">Upload Gambar</label>
            <input type="file" class="form-control custom_file" id="gambar" name="gambar" accept="image/*">
            <!-- Container Preview Gambar Saat Ini -->
            <div id="current-image-container" style="margin-top: 1rem;">
                <?php if (!empty($artikel['gambar'])): ?>
                    <p>Gambar saat ini:</p>
                    <img id="current-image" src="<?= base_url('/uploads/' . $artikel['gambar']) ?>" alt="Gambar Artikel" width="200">
                <?php endif; ?>
            </div>
        </div>

        <!-- Container Preview untuk Crop Gambar (ditampilkan saat memilih file baru) -->
        <div id="image-preview-container" class="image-preview-cut-save-group" style="display: none;">
            <img id="image-preview" class="image-preview-cut-save">
            <div id="crop-buttons-container" style="display: flex; gap: 1rem; margin-top: 1rem; margin-bottom:1rem;">
                <button type="button" id="crop-button" class="btn btn-primary">Pangkas & Simpan</button>
                <button type="button" id="cancel-crop-button" class="btn btn-warning">Batal Pangkas</button>
            </div>
        </div>

        <!-- Container Preview Final untuk Gambar Tercrop -->
        <div id="cropped-preview-container" style="display: none; margin-bottom: 1rem;">
            <p>Pratinjau gambar:</p>
            <img id="cropped-preview" src="" alt="Pratinjau Gambar Tercrop" style="max-width: 80%; height: auto; border: 1px solid #888; border-radius:5px">
        </div>

        <div class="form-group">
            <label for="konten">Konten Artikel</label>
            <textarea name="konten" id="konten" class="form-control" rows="10" required><?= esc($artikel['konten']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Artikel</button>
        <a href="<?= base_url('admin/artikel') ?>" class="btn btn-warning" style="margin-left:10px; width:7rem">Kembali</a>
    </form>

</div>

<!-- CKEditor 5 -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
<script>
    CKEDITOR.replace('konten', {
        extraAllowedContent: 'iframe[*];',
        allowedContent: true
    });
</script>
<!-- <script>
    class MyUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }

        upload() {
            return this.loader.file.then(file => {
                return new Promise((resolve, reject) => {
                    if (!file) {
                        reject('File tidak valid.');
                        return;
                    }

                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = () => {
                        this.showCropperModal(reader.result, file, resolve, reject);
                    };

                    reader.onerror = error => reject(error);
                });
            });
        }

        showCropperModal(imageSrc, file, resolve, reject) {
            // Hapus modal sebelumnya jika ada
            let existingModal = document.getElementById('cropperModal');
            if (existingModal) {
                document.body.removeChild(existingModal);
            }

            // Buat modal
            let modal = document.createElement('div');
            modal.id = 'cropperModal';
            modal.innerHTML = `
                <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); display: flex; align-items: center; justify-content: center; z-index: 999;">
                    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2); width: 40%; max-width: 600px; position: relative;">
                        <h3 style="margin: 0 0 10px;">Crop Gambar</h3>
                        <img id="cropperImage" src="${imageSrc}" style="max-width: 100%; height: auto; display: block; margin: 0 auto;"/>
                        <div style="margin-top: 10px; text-align: right;">
                            <button id="cancelCrop" style="background: #ccc; border: none; padding: 8px 12px; cursor: pointer; margin-right: 10px; border-radius: 5px;">Batal</button>
                            <button id="confirmCrop" style="background: #28a745; color: white; border: none; padding: 8px 12px; cursor: pointer; border-radius: 5px;">Crop & Upload</button>
                        </div>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);
            const cropperImage = modal.querySelector("#cropperImage");
            const cropper = new Cropper(cropperImage, {
                viewMode: 2,
                autoCropArea: 1,
            });

            // Tombol Crop & Upload
            modal.querySelector("#confirmCrop").onclick = () => {
                cropper.getCroppedCanvas().toBlob(blob => {
                    this.uploadCroppedImage(blob, file.name, resolve, reject);
                    document.body.removeChild(modal);
                });
            };

            // Tombol Batal
            modal.querySelector("#cancelCrop").onclick = () => {
                document.body.removeChild(modal);
                reject('User membatalkan crop.');
            };
        }

        uploadCroppedImage(blob, filename, resolve, reject) {
            const formData = new FormData();
            formData.append('upload', blob, filename);

            fetch('<?= base_url('admin/artikel/upload') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.url) {
                    resolve({ default: result.url });
                } else {
                    reject(result.error || 'Upload gagal.');
                }
            })
            .catch(error => reject(error));
        }
    }

    function CustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new MyUploadAdapter(loader);
        };
    }

    document.addEventListener("DOMContentLoaded", function () {
        ClassicEditor
            .create(document.querySelector('#konten'), {
                extraPlugins: [CustomUploadAdapterPlugin]
            })
            .catch(error => {
                console.error(error);
            });
    });
</script> -->

<script>
    class MyUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }

        upload() {
            return this.loader.file.then(file => {
                return new Promise((resolve, reject) => {
                    if (!file) {
                        reject('File tidak valid.');
                        return;
                    }

                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = () => {
                        this.showCropperModal(reader.result, file, resolve, reject);
                    };

                    reader.onerror = error => reject(error);
                });
            });
        }

        showCropperModal(imageSrc, file, resolve, reject) {
            // Hapus modal sebelumnya jika ada
            let existingModal = document.getElementById('cropperModal');
            if (existingModal) {
                document.body.removeChild(existingModal);
            }

            // Buat modal
            let modal = document.createElement('div');
            modal.id = 'cropperModal';
            modal.innerHTML = `
                <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); display: flex; align-items: center; justify-content: center; z-index: 999;">
                    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2); width: 90%; max-width: 500px; position: relative; text-align: center;">
                        <h3 style="margin: 0 0 10px;">Crop Gambar</h3>
                        <div style="max-width: 100%; max-height: 400px; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                            <img id="cropperImage" src="${imageSrc}" style="max-width: 100%; max-height: 100%; display: block;"/>
                        </div>
                        <div style="margin-top: 10px; text-align: right;">
                            <button id="cancelCrop" style="background: #ccc; border: none; padding: 8px 12px; cursor: pointer; margin-right: 10px; border-radius: 5px;">Batal</button>
                            <button id="confirmCrop" style="background: #28a745; color: white; border: none; padding: 8px 12px; cursor: pointer; border-radius: 5px;">Crop & Upload</button>
                        </div>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);
            const cropperImage = modal.querySelector("#cropperImage");

            // Perbaikan Cropper agar sesuai modal
            const cropper = new Cropper(cropperImage, {
                viewMode: 2,
                autoCropArea: 1,
                responsive: true,
                restore: false,
                modal: true,
                background: false
            });

            // Tombol Crop & Upload
            modal.querySelector("#confirmCrop").onclick = () => {
                cropper.getCroppedCanvas().toBlob(blob => {
                    this.uploadCroppedImage(blob, file.name, resolve, reject);
                    document.body.removeChild(modal);
                });
            };

            // Tombol Batal
            modal.querySelector("#cancelCrop").onclick = () => {
                document.body.removeChild(modal);
                reject('User membatalkan crop.');
            };
        }

        uploadCroppedImage(blob, filename, resolve, reject) {
            const formData = new FormData();
            formData.append('upload', blob, filename);

            fetch('<?= base_url('admin/artikel/upload') ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.url) {
                        resolve({
                            default: result.url
                        });
                    } else {
                        reject(result.error || 'Upload gagal.');
                    }
                })
                .catch(error => reject(error));
        }
    }

    function CustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new MyUploadAdapter(loader);
        };
    }

    document.addEventListener("DOMContentLoaded", function() {
        ClassicEditor
            .create(document.querySelector('#konten'), {
                extraPlugins: [CustomUploadAdapterPlugin]
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>



<!-- Sertakan JS Cropper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let cropper;

    // Ketika file gambar dipilih
    document.getElementById("gambar").addEventListener("change", function(event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                // Tampilkan container preview crop
                document.getElementById("image-preview-container").style.display = "block";
                // Set sumber gambar untuk preview crop
                document.getElementById("image-preview").src = e.target.result;
                // Jika ada instance cropper sebelumnya, hancurkan terlebih dahulu
                if (cropper) {
                    cropper.destroy();
                }
                // Inisialisasi Cropper.js dengan aspect ratio 16:9 (ubah sesuai kebutuhan)
                cropper = new Cropper(document.getElementById("image-preview"), {
                    aspectRatio: 16 / 9,
                    viewMode: 2,
                    autoCropArea: 1,
                });
                // Jangan sembunyikan container gambar saat ini sampai crop & save diklik
                // Sembunyikan container preview final jika ada
                document.getElementById("cropped-preview-container").style.display = "none";
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
                    let fileInput = document.getElementById("gambar");
                    let fileName = fileInput.files[0].name;
                    let croppedFile = new File([blob], fileName, {
                        type: "image/jpeg"
                    });
                    // Buat objek FileList baru menggunakan DataTransfer
                    let dataTransfer = new DataTransfer();
                    dataTransfer.items.add(croppedFile);
                    fileInput.files = dataTransfer.files;

                    // Tampilkan preview gambar final (hasil crop)
                    document.getElementById("cropped-preview").src = URL.createObjectURL(blob);
                    document.getElementById("cropped-preview-container").style.display = "block";

                    // Sembunyikan container crop preview
                    document.getElementById("image-preview-container").style.display = "none";
                    // Sembunyikan container gambar saat ini (preview sebelumnya)
                    document.getElementById("current-image-container").style.display = "none";
                }, "image/jpeg");
            }
        }
    });

    // Tombol "Batal Pangkas"
    document.getElementById("cancel-crop-button").addEventListener("click", function() {
        // Sembunyikan container preview crop
        document.getElementById("image-preview-container").style.display = "none";
        // Reset input file
        document.getElementById("gambar").value = "";
        // Hapus instance cropper jika ada
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        // Tampilkan kembali container gambar saat ini (preview sebelumnya)
        document.getElementById("current-image-container").style.display = "block";
        // Sembunyikan container preview final
        document.getElementById("cropped-preview-container").style.display = "none";
    });
</script>

<?= $this->endSection() ?>