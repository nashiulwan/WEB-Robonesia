<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><?= esc($title) ?></h1>

  <!-- Form Edit Kelas (termasuk level/sub level dan data gambar) -->
  <form action="<?= base_url('admin/grade_level/update/' . $kelas['id']) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <!-- Field Level -->
    <div class="form-group">
      <label for="level">Level</label>
      <select name="level" id="level" class="form-control">
        <option value="Basic" <?= ($kelas['level'] == 'Basic') ? 'selected' : '' ?>>Basic</option>
        <option value="Intermediate" <?= ($kelas['level'] == 'Intermediate') ? 'selected' : '' ?>>Intermediate</option>
        <option value="Advance" <?= ($kelas['level'] == 'Advance') ? 'selected' : '' ?>>Advanced</option>
        <option value="Lainnya" <?= ($kelas['level'] == 'Lainnya') ? 'selected' : '' ?>>Lainnya</option>
      </select>
    </div>
    <div class="form-group" id="subLevelContainer" style="display: <?= ($kelas['level'] == 'Lainnya') ? 'block' : 'none'; ?>;">
      <input type="text" name="level_lainnya" id="level_lainnya" class="form-control" placeholder="Masukkan level lain" value="<?= isset($kelas['level_lainnya']) ? $kelas['level_lainnya'] : '' ?>">
    </div>
    <!-- Field Sub Level -->
    <div class="form-group">
      <label for="sub_level">Sub Level</label>
      <input type="text" name="sub_level" id="sub_level" class="form-control" placeholder="Masukkan sub-level" value="<?= $kelas['sub_level'] ?>">
    </div>

    <hr>

    <!-- Tabel Data Gambar (yang sudah tersimpan) -->
    <h4>Daftar Proyek</h4>
    <table class="table table-bordered table-hover">
      <thead style="background-color: #f8f9fa;">
        <tr>
          <th style="width: 5%;">No</th>
          <th style="width: 30%;">Proyek</th>
          <th style="width: 35%;">Deskripsi</th>
          <th style="width: 15%;">Dibuat Tanggal</th>
          <th style="width: 15%;">Di Update Tanggal</th>
        </tr>
      </thead>
      <tbody id="imagesTableBody">
        <?php $no = 1; ?>
        <?php if (!empty($existingImages)) : ?>
          <?php foreach ($existingImages as $img) : ?>
            <tr>
              <td><?= $no++; ?></td>
              <td>
                <?= esc($img['image_name']); ?>
                <br>
                <!-- Thumbnail gambar -->
                <img src="<?= base_url('uploads/images/' . esc($img['filename'])) ?>" alt="Gambar" style="max-height:80px;">
                <!-- Input hidden untuk mempertahankan gambar lama -->
                <input type="hidden" name="existing_images[]" value="<?= esc($img['id']) ?>">
              </td>
              <td><?= esc($img['deskripsi']); ?></td>
              <td><?= esc($img['created_at']); ?></td>
              <td><?= esc($img['updated_at']); ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td colspan="5" class="text-center">Tidak ada data proyek</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>

    <!-- Area untuk menambahkan gambar baru -->
    <div class="mb-3">
      <button type="button" id="addNewImageBtn" class="btn btn-secondary">Tambah Gambar Baru</button>
      <!-- File input tersembunyi -->
      <input type="file" id="newImageInput" name="new_images[]" accept="image/*" style="display:none;" multiple>
    </div>
    <!-- Container untuk preview gambar baru -->
    <div id="newImagesPreview"></div>

    <button type="submit" class="btn btn-primary">Simpan Semua Gambar & Update Kelas</button>
    <a href="<?= base_url('admin/manage_kelas') ?>" class="btn btn-warning ml-2">Kembali</a>
  </form>
</div>

<script>
  // Menampilkan input "Level Lainnya" jika opsi "Lainnya" dipilih
  document.getElementById('level').addEventListener('change', function() {
    const subLevelContainer = document.getElementById('subLevelContainer');
    if (this.value === 'Lainnya') {
      subLevelContainer.style.display = 'block';
    } else {
      subLevelContainer.style.display = 'none';
      document.getElementById('level_lainnya').value = '';
    }
  });

  // Trigger file input ketika tombol "Tambah Gambar Baru" diklik
  document.getElementById('addNewImageBtn').addEventListener('click', function() {
    document.getElementById('newImageInput').click();
  });

  // Container untuk preview gambar baru
  const newImagesPreview = document.getElementById('newImagesPreview');
  // Ketika file baru dipilih
  document.getElementById('newImageInput').addEventListener('change', function(event) {
    const files = event.target.files;
    for (let i = 0; i < files.length; i++) {
      addNewImagePreview(files[i]);
    }
    // Reset file input supaya bisa memilih file yang sama lagi jika diperlukan
    event.target.value = "";
  });

  // Fungsi untuk membuat preview gambar baru dan menambahkan hidden input
  function addNewImagePreview(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      // Buat container untuk satu gambar baru
      const container = document.createElement('div');
      container.classList.add('new-image-preview');
      container.style.marginBottom = '1rem';

      // Buat elemen gambar
      const img = document.createElement('img');
      img.src = e.target.result;
      img.style.maxHeight = '80px';
      img.style.marginRight = '10px';
      img.classList.add('img-thumbnail');

      // Opsional: aktifkan cropper di sini jika ingin langsung crop (bisa menambahkan tombol crop jika perlu)
      // Misalnya, langsung ambil canvas crop dan ubah data gambar, kemudian perbarui nilai hidden input

      // Buat hidden input untuk menyimpan data gambar (misalnya Base64 encoded)
      const hiddenInput = document.createElement('input');
      hiddenInput.type = 'hidden';
      hiddenInput.name = 'new_images_encoded[]';
      // Simpan data gambar dalam bentuk Base64 (dari e.target.result)
      hiddenInput.value = e.target.result;

      // Buat tombol hapus gambar baru
      const deleteBtn = document.createElement('button');
      deleteBtn.type = 'button';
      deleteBtn.className = 'btn btn-danger btn-sm';
      deleteBtn.textContent = 'Hapus';
      deleteBtn.addEventListener('click', function() {
        container.remove();
      });

      // Gabungkan elemen ke container
      container.appendChild(img);
      container.appendChild(hiddenInput);
      container.appendChild(deleteBtn);
      newImagesPreview.appendChild(container);
    };
    reader.readAsDataURL(file);
  }
</script>
<?= $this->endSection() ?>