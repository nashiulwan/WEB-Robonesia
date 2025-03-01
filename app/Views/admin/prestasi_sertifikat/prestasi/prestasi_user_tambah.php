<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<style>
  .custom-checkbox {
    transform: scale(2);
    /* Sesuaikan ukuran */
    margin: 5px;
  }
</style>

<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?>
  </h1>

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

  <!-- Menampilkan pesan error umum -->
  <?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger">
      <?= session()->getFlashdata('error'); ?>
    </div>
  <?php endif; ?>

  <form action="<?= base_url('admin/prestasi/tambah_prestasi/simpan') ?>" method="post" autocomplete="off">
    <?= csrf_field() ?>
    <input type="hidden" name="user_id" value="<?= old('user_id') ?? $user['id'] ?>">

    <div class="form-group mb-3">
      <label for="nama_kegiatan">Nama Kegiatan</label>
      <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" placeholder="Masukkan nama kegiatan" value="<?= old('nama_kegiatan') ?>" required>
    </div>

    <div class="form-group mb-3">
      <label for="jenis">Jenis Prestasi</label>
      <select name="jenis" id="jenis" class="form-control" required>
        <option value="" disabled selected>Pilih Jenis Prestasi</option>
        <option value="Individual" <?= old('jenis') == 'Individual' ? 'selected' : '' ?>>Individual</option>
        <option value="Kelompok" <?= old('jenis') == 'Kelompok' ? 'selected' : '' ?>>Kelompok</option>
      </select>
    </div>

    <div class="form-group mb-3">
      <label for="tingkat">Tingkat</label>
      <select name="tingkat" id="tingkat" class="form-control" required onchange="checkTingkat()">
        <option value="" disabled selected>Pilih Tingkat Prestasi</option>
        <option value="Sekolah" <?= old('tingkat') == 'Sekolah' ? 'selected' : '' ?>>Sekolah</option>
        <option value="Desa/Kelurahan" <?= old('tingkat') == 'Desa' ? 'selected' : '' ?>>Desa</option>
        <option value="Kecamatan" <?= old('tingkat') == 'Kecamatan' ? 'selected' : '' ?>>Kecamatan</option>
        <option value="Kabupaten/Kota" <?= old('tingkat') == 'Kabupaten/Kota' ? 'selected' : '' ?>>Kabupaten/Kota</option>
        <option value="Provinsi" <?= old('tingkat') == 'Provinsi' ? 'selected' : '' ?>>Provinsi</option>
        <option value="Nasional" <?= old('tingkat') == 'Nasional' ? 'selected' : '' ?>>Nasional</option>
        <option value="Internasional" <?= old('tingkat') == 'Internasional' ? 'selected' : '' ?>>Internasional</option>
        <option value="Lainnya" <?= old('tingkat') == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
      </select>
    </div>

    <!-- Input tambahan untuk "Lainnya" -->
    <div class="form-group mb-3" id="tingkat_lainnya_group" style="display: none;">
      <label for="tingkat_lainnya">Masukkan Tingkat Prestasi</label>
      <input type="text" name="tingkat_lainnya" id="tingkat_lainnya" class="form-control">
    </div>

    <div class="form-group mb-3">
      <label for="tahun">Tahun</label>
      <input type="number" name="tahun" id="tahun" class="form-control" min="1000" value="<?= old('tahun') ?>" required placeholder="Masukkan tahun">
      <small id="tahunError" class="text-danger" style="display: none;">Harap masukkan tahun yang valid</small>
    </div>

    <div class="form-group mb-3">
      <label for="pencapaian">Pencapaian</label>
      <input type="text" name="pencapaian" id="pencapaian" class="form-control" placeholder="Masukkan pencapaian" value="<?= old('pencapaian') ?>" required>
    </div>

    <!-- Bagian daftar akun muncul jika jenis = Kelompok -->
    <div id="daftarAkun" style="display: none;">
      <div class="form-group mb-3">
        <label>Daftar Akun (Pilih anggota untuk prestasi kelompok)</label>
        <!-- Search input untuk filter tabel akun -->
        <input type="text" id="searchAkun" class="form-control mb-2" placeholder="Cari akun...">
        <!-- Container tabel dengan scroll, maksimal tampilan 5 baris -->
        <div style="max-height: 250px; overflow-y: auto;">
          <table class="table table-bordered table-sm table-hover">
            <thead style="color: black; background-color:#2222">
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
              <?php if (!empty($users)) : ?>
                <?php foreach ($users as $row) : ?>
                  <?php if ($row['id'] == $user['id']) continue; // Lewati akun yang sedang dipilih 
                  ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= esc($row['username']); ?></td>
                    <td><?= esc($row['email']); ?></td>
                    <td><?= esc($row['fullname']); ?></td>
                    <td class="text-center">
                      <input type="checkbox" name="user_ids[]" value="<?= $row['id'] ?>" id="user<?= $row['id'] ?>" class="custom-checkbox" <?= (old('user_ids') && in_array($row['id'], old('user_ids'))) ? 'checked' : '' ?>>
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
    <a href="<?= base_url('admin/prestasi/prestasi_detail/' . esc($user['id'])) ?>" class="btn btn-warning">Kembali</a>
  </form>
</div>

<!-- JQuery untuk menangani tampilan daftar akun dan fitur pencarian -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
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

    // Set nilai default sesuai tahun sekarang
    tahunInput.value = tahunSekarang;

    // Validasi input agar hanya angka dan dalam rentang yang ditentukan
    tahunInput.addEventListener("input", function() {
      let errorMsg = document.getElementById("tahunError");

      if (!/^\d{4}$/.test(this.value) || this.value < 1900 || this.value > 2099) {
        errorMsg.style.display = "block";
      } else {
        errorMsg.style.display = "none";
      }
    });
  });
</script>

<script>
  $(document).ready(function() {
    // Tampilkan atau sembunyikan daftar akun berdasarkan pilihan jenis prestasi
    $('#jenis').change(function() {
      var selected = $(this).val();
      if (selected === 'Kelompok') {
        $('#daftarAkun').slideDown();
      } else {
        $('#daftarAkun').slideUp();
      }
    });
    // Tampilkan daftar akun jika old value adalah kelompok (misalnya saat validasi gagal)
    if ($('#jenis').val() === 'Kelompok') {
      $('#daftarAkun').show();
    }

    // Fitur pencarian untuk filter baris dalam tabel akun
    $('#searchAkun').on('keyup', function() {
      var value = $(this).val().toLowerCase();
      $('#tableAkunBody tr').filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
      });
    });
  });
</script>

<script>
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
      tingkatLainnyaInput.value = ""; // Reset input jika opsi lain dipilih
    }
  }
</script>


<?= $this->endSection() ?>