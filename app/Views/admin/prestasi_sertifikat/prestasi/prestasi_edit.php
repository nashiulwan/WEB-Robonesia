<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<style>
  .custom-checkbox {
    transform: scale(2);
    margin: 5px;
  }
</style>

<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <!-- Pesan error validasi, sukses, dan error umum -->
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
      <?= session()->getFlashdata('error'); ?>
    </div>
  <?php endif; ?>

  <!-- Form edit prestasi -->
  <form action="<?= base_url('admin/prestasi/update/' . esc($prestasi['id'])) ?>" method="post" autocomplete="off">
    <?= csrf_field() ?>
    <!-- Hidden field -->
    <input type="hidden" name="prestasi_id" value="<?= $prestasi['id'] ?>">

    <div class="form-group mb-3">
      <label for="nama_kegiatan">Nama Kegiatan</label>
      <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" placeholder="Masukkan nama kegiatan" value="<?= old('nama_kegiatan', $prestasi['nama_kegiatan']) ?>" required>
    </div>

    <div class="form-group mb-3">
      <label for="jenis">Jenis Prestasi</label>
      <select name="jenis" id="jenis" class="form-control" required>
        <option value="" disabled>Pilih Jenis Prestasi</option>
        <option value="Individual" <?= old('jenis', $prestasi['jenis']) == 'Individual' ? 'selected' : '' ?>>Individual</option>
        <option value="Kelompok" <?= old('jenis', $prestasi['jenis']) == 'Kelompok' ? 'selected' : '' ?>>Kelompok</option>
      </select>
    </div>

    <div class="form-group mb-3">
      <label for="tingkat">Tingkat</label>
      <?php
      // Daftar nilai valid
      $validTingkat = ['Sekolah', 'Desa/Kelurahan', 'Kecamatan', 'Kabupaten/Kota', 'Provinsi', 'Nasional', 'Internasional'];
      // Ambil nilai dari old() atau dari data prestasi
      $tingkatValue = old('tingkat', $prestasi['tingkat']);
      if (!in_array($tingkatValue, $validTingkat)) {
        $tingkatValue = 'Lainnya';
      }
      ?>
      <select name="tingkat" id="tingkat" class="form-control" required onchange="checkTingkat()">
        <option value="" disabled>Pilih Tingkat Prestasi</option>
        <option value="Sekolah" <?= $tingkatValue == 'Sekolah' ? 'selected' : '' ?>>Sekolah</option>
        <option value="Desa/Kelurahan" <?= $tingkatValue == 'Desa/Kelurahan' ? 'selected' : '' ?>>Desa/Kelurahan</option>
        <option value="Kecamatan" <?= $tingkatValue == 'Kecamatan' ? 'selected' : '' ?>>Kecamatan</option>
        <option value="Kabupaten/Kota" <?= $tingkatValue == 'Kabupaten/Kota' ? 'selected' : '' ?>>Kabupaten/Kota</option>
        <option value="Provinsi" <?= $tingkatValue == 'Provinsi' ? 'selected' : '' ?>>Provinsi</option>
        <option value="Nasional" <?= $tingkatValue == 'Nasional' ? 'selected' : '' ?>>Nasional</option>
        <option value="Internasional" <?= $tingkatValue == 'Internasional' ? 'selected' : '' ?>>Internasional</option>
        <option value="Lainnya" <?= $tingkatValue == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
      </select>

      <!-- Input tambahan untuk "Lainnya" -->
      <div class="form-group mb-3" id="tingkat_lainnya_group" style="display: <?= $tingkatValue == 'Lainnya' ? 'block' : 'none' ?>; margin-top:1rem">
        <label for="tingkat_lainnya">Masukkan Tingkat Prestasi</label>
        <input type="text" name="tingkat_lainnya" id="tingkat_lainnya" class="form-control" value="<?= old('tingkat_lainnya', $prestasi['tingkat_lainnya'] ?? '') ?>">
      </div>
    </div>

    <div class="form-group mb-3" style="margin-top: 1rem;">
      <label for="tahun">Tahun</label>
      <input type="number" name="tahun" id="tahun" class="form-control" min="1000" value="<?= old('tahun', $prestasi['tahun']) ?>" required placeholder="Masukkan tahun">
      <small id="tahunError" class="text-danger" style="display: none;">Harap masukkan tahun yang valid</small>
    </div>

    <div class="form-group mb-3">
      <label for="pencapaian">Pencapaian</label>
      <input type="text" name="pencapaian" id="pencapaian" class="form-control" placeholder="Masukkan pencapaian" value="<?= old('pencapaian', $prestasi['pencapaian']) ?>" required>
    </div>

    <!-- Bagian daftar akun untuk prestasi -->
    <div id="daftarAkun">
      <div class="form-group mb-3">
        <label>Daftar Akun<span class="text-danger">*</span></label>
        <br>
        <small>
          <span class="text-danger">*</span> Hanya dapat memilih satu untuk jenis prestasi Individual.
        </small><br>
        <small>
          <span class="text-danger">**</span> Pilih lebih dari satu untuk jenis prestasi Kelompok.
        </small><br>

        <!-- Input pencarian -->
        <input type="text" id="searchAkun" style="margin-top: 1rem;" class="form-control mb-2" placeholder="Cari akun...">
        <!-- Tabel daftar akun -->

        <!-- Pesan peringatan khusus untuk Individual -->
        <div id="individualWarning" class="small text-danger" style="display: none;">Hanya dapat memilih satu untuk jenis prestasi Individual.</div>
        <div style="max-height: 250px; overflow-y: auto;">
          <?php
          // Gunakan data dari old() jika ada, jika tidak, ambil user_id dari pivot
          $selectedUserIds = old('user_ids') ? old('user_ids') : array_column($anggota, 'user_id');

          // Urutkan data akun agar yang terpilih berada di atas
          $selectedUsers = [];
          $nonSelectedUsers = [];
          foreach ($users as $row) {
            if (in_array($row['id'], $selectedUserIds)) {
              $selectedUsers[] = $row;
            } else {
              $nonSelectedUsers[] = $row;
            }
          }
          $orderedUsers = array_merge($selectedUsers, $nonSelectedUsers);
          ?>
          <table class="table table-bordered table-sm table-hover">
            <thead style="color: black; background-color:#2222;">
              <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 20%;">Nama Pengguna</th>
                <th style="width: 28%;">Email</th>
                <th style="width: 30%;">Nama Lengkap</th>
                <th style="width: 5%;">Pilih</th>
              </tr>
            </thead>
            <tbody id="tableAkunBody" style="color: black;">
              <?php $no = 1; ?>
              <?php if (!empty($orderedUsers)) : ?>
                <?php foreach ($orderedUsers as $row) : ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= esc($row['username']); ?></td>
                    <td><?= esc($row['email']); ?></td>
                    <td><?= esc($row['fullname']); ?></td>
                    <td class="text-center">
                      <input type="checkbox" name="user_ids[]" value="<?= $row['id'] ?>" id="user<?= $row['id'] ?>" class="custom-checkbox">
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="5" class="text-center">Tidak ada data akun</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>


      </div>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('admin/prestasi') ?>" class="btn btn-warning">Kembali</a>
  </form>
</div>

<!-- JQuery dan script tambahan -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  // Validasi input tahun
  document.getElementById("tahun").addEventListener("input", function() {
    let tahunInput = this.value;
    let errorMsg = document.getElementById("tahunError");
    if (!/^\d{4}$/.test(tahunInput) || tahunInput < 1900 || tahunInput > 2099) {
      errorMsg.style.display = "block";
    } else {
      errorMsg.style.display = "none";
    }
  });

  document.addEventListener("DOMContentLoaded", function() {
    let tahunInput = document.getElementById("tahun");
    let tahunSekarang = new Date().getFullYear();
    if (!tahunInput.value) {
      tahunInput.value = tahunSekarang;
    }
    tahunInput.addEventListener("input", function() {
      let errorMsg = document.getElementById("tahunError");
      if (!/^\d{4}$/.test(this.value) || this.value < 1900 || this.value > 2099) {
        errorMsg.style.display = "block";
      } else {
        errorMsg.style.display = "none";
      }
    });

    // Panggil fungsi checkIndividualSelection pada awalnya
    checkIndividualSelection();
  });

  // Fungsi untuk menampilkan input "tingkat lainnya"
  function checkTingkat() {
    var tingkat = document.getElementById("tingkat");
    var tingkatLainnyaGroup = document.getElementById("tingkat_lainnya_group");
    var tingkatLainnyaInput = document.getElementById("tingkat_lainnya");

    if (tingkat.value === "Lainnya") {
      tingkatLainnyaGroup.style.display = "block";
      tingkatLainnyaInput.setAttribute("required", "true");
    } else {
      tingkatLainnyaGroup.style.display = "none";
      tingkatLainnyaInput.removeAttribute("required");
      tingkatLainnyaInput.value = "";
    }
  }

  // Fungsi untuk membatasi pilihan akun jika jenis Individual
  function checkIndividualSelection() {
    // Periksa apakah jenis prestasi Individual
    if ($("#jenis").val() === "Individual") {
      var checked = $("input[name='user_ids[]']:checked");
      if (checked.length >= 1) {
        // Jika sudah ada yang terpilih, nonaktifkan checkbox lainnya
        $("input[name='user_ids[]']").not(":checked").prop("disabled", true);
        // Tampilkan peringatan
        $("#individualWarning").show();
      } else {
        // Jika tidak ada yang terpilih, aktifkan semua
        $("input[name='user_ids[]']").prop("disabled", false);
        $("#individualWarning").hide();
      }
    } else {
      // Jika jenis bukan Individual, pastikan semua checkbox aktif dan sembunyikan peringatan
      $("input[name='user_ids[]']").prop("disabled", false);
      $("#individualWarning").hide();
    }
  }

  // Event handler: saat checkbox akun berubah, periksa kembali
  $(document).on("change", "input[name='user_ids[]']", function() {
    checkIndividualSelection();
  });

  // Event handler: saat jenis prestasi berubah, periksa kembali pilihan akun
  $("#jenis").on("change", function() {
    checkIndividualSelection();
  });

  // Fitur pencarian untuk filter akun
  $(document).ready(function() {
    $('#searchAkun').on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $('#tableAkunBody tr').filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
      });
    });
  });
</script>
<?= $this->endSection() ?>