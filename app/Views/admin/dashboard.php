<?= $this->extend('admin/templates/dashboard'); ?>

<?= $this->section('page-content'); ?>
<!-- Tambahkan CSS untuk line clamp dan styling footer -->
<style>
  /* --- Border left untuk Prestasi berdasarkan jenis --- */
  .border-left-prestasi-individual {
    border-left: 5px solid #42a5f5;
    /* contoh: biru kebiruan */
  }

  .border-left-prestasi-kelompok {
    border-left: 5px solid #43a047;
    /* contoh: merah muda */
  }

  /* --- Corner SVG untuk Prestasi berdasarkan tingkat (gunakan data URI dan rotasi) --- */
  .toptight-corner-prestasi {
    position: absolute;
    top: 0;
    right: 0;
    width: 60px;
    height: 60px;
    background-repeat: no-repeat;
    background-size: cover;
    transform: rotate(-90deg);
  }

  /* Setiap tingkat, ganti warnanya di data URI */
  .toptight-corner-prestasi-sekolah {
    position: absolute;
    top: 0;
    right: 0;
    width: 60px;
    height: 60px;
    background-repeat: no-repeat;
    background-size: cover;
    transform: rotate(-90deg);
    background-image: url("data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'><path fill='%2366bb6a' d='M6.7 16l9.3-9.3v-1.4l-10.7 10.7z'/><path fill='%2366bb6a' d='M9.7 16l6.3-6.3v-1.4l-7.7 7.7z'/><path fill='%2366bb6a' d='M12.7 16l3.3-3.3v-1.4l-4.7 4.7z'/><path fill='%2366bb6a' d='M15.7 16l0.3-0.3v-1.4l-1.7 1.7z'/></svg>");
  }

  .toptight-corner-prestasi-desa {
    position: absolute;
    top: 0;
    right: 0;
    width: 60px;
    height: 60px;
    background-repeat: no-repeat;
    background-size: cover;
    transform: rotate(-90deg);
    background-image: url("data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'><path fill='%2343a047' d='M6.7 16l9.3-9.3v-1.4l-10.7 10.7z'/><path fill='%2343a047' d='M9.7 16l6.3-6.3v-1.4l-7.7 7.7z'/><path fill='%2343a047' d='M12.7 16l3.3-3.3v-1.4l-4.7 4.7z'/><path fill='%2343a047' d='M15.7 16l0.3-0.3v-1.4l-1.7 1.7z'/></svg>");
  }

  .toptight-corner-prestasi-kecamatan {
    position: absolute;
    top: 0;
    right: 0;
    width: 60px;
    height: 60px;
    background-repeat: no-repeat;
    background-size: cover;
    transform: rotate(-90deg);
    background-image: url("data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'><path fill='%2342a5f5' d='M6.7 16l9.3-9.3v-1.4l-10.7 10.7z'/><path fill='%2342a5f5' d='M9.7 16l6.3-6.3v-1.4l-7.7 7.7z'/><path fill='%2342a5f5' d='M12.7 16l3.3-3.3v-1.4l-4.7 4.7z'/><path fill='%2342a5f5' d='M15.7 16l0.3-0.3v-1.4l-1.7 1.7z'/></svg>");
  }

  .toptight-corner-prestasi-kabupaten {
    position: absolute;
    top: 0;
    right: 0;
    width: 60px;
    height: 60px;
    background-repeat: no-repeat;
    background-size: cover;
    transform: rotate(-90deg);
    background-image: url("data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'><path fill='%231e88e5' d='M6.7 16l9.3-9.3v-1.4l-10.7 10.7z'/><path fill='%231e88e5' d='M9.7 16l6.3-6.3v-1.4l-7.7 7.7z'/><path fill='%231e88e5' d='M12.7 16l3.3-3.3v-1.4l-4.7 4.7z'/><path fill='%231e88e5' d='M15.7 16l0.3-0.3v-1.4l-1.7 1.7z'/></svg>");
  }

  .toptight-corner-prestasi-provinsi {
    position: absolute;
    top: 0;
    right: 0;
    width: 60px;
    height: 60px;
    background-repeat: no-repeat;
    background-size: cover;
    transform: rotate(-90deg);
    background-image: url("data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'><path fill='%23ff9800' d='M6.7 16l9.3-9.3v-1.4l-10.7 10.7z'/><path fill='%23ff9800' d='M9.7 16l6.3-6.3v-1.4l-7.7 7.7z'/><path fill='%23ff9800' d='M12.7 16l3.3-3.3v-1.4l-4.7 4.7z'/><path fill='%23ff9800' d='M15.7 16l0.3-0.3v-1.4l-1.7 1.7z'/></svg>");
  }

  .toptight-corner-prestasi-nasional {
    position: absolute;
    top: 0;
    right: 0;
    width: 60px;
    height: 60px;
    background-repeat: no-repeat;
    background-size: cover;
    transform: rotate(-90deg);
    background-image: url("data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'><path fill='%23f44336' d='M6.7 16l9.3-9.3v-1.4l-10.7 10.7z'/><path fill='%23f44336' d='M9.7 16l6.3-6.3v-1.4l-7.7 7.7z'/><path fill='%23f44336' d='M12.7 16l3.3-3.3v-1.4l-4.7 4.7z'/><path fill='%23f44336' d='M15.7 16l0.3-0.3v-1.4l-1.7 1.7z'/></svg>");
  }

  .toptight-corner-prestasi-internasional {
    position: absolute;
    top: 0;
    right: 0;
    width: 60px;
    height: 60px;
    background-repeat: no-repeat;
    background-size: cover;
    transform: rotate(-90deg);
    background-image: url("data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'><path fill='%23ffd700' d='M6.7 16l9.3-9.3v-1.4l-10.7 10.7z'/><path fill='%23ffd700' d='M9.7 16l6.3-6.3v-1.4l-7.7 7.7z'/><path fill='%23ffd700' d='M12.7 16l3.3-3.3v-1.4l-4.7 4.7z'/><path fill='%23ffd700' d='M15.7 16l0.3-0.3v-1.4l-1.7 1.7z'/></svg>");
  }

  .toptight-corner-prestasi-lainnya {
    position: absolute;
    top: 0;
    right: 0;
    width: 60px;
    height: 60px;
    background-repeat: no-repeat;
    background-size: cover;
    transform: rotate(-90deg);
    background-image: url("data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'><path fill='%239c27b0' d='M6.7 16l9.3-9.3v-1.4l-10.7 10.7z'/><path fill='%239c27b0' d='M9.7 16l6.3-6.3v-1.4l-7.7 7.7z'/><path fill='%239c27b0' d='M12.7 16l3.3-3.3v-1.4l-4.7 4.7z'/><path fill='%239c27b0' d='M15.7 16l0.3-0.3v-1.4l-1.7 1.7z'/></svg>");
  }

  /* --- Untuk Kelas (warna tetap, bisa dikembangkan) --- */
  .border-left-kelas {
    border-left: 5px solid #673ab7;
  }

  /* --- Untuk Artikel --- */
  .border-left-artikel {
    border-left: 5px solid #009688;
  }

  /* --- Kelas tambahan untuk kategori artikel --- */
  .kategori-event {
    border-left: 5px solid #2196f3;
  }

  .kategori-kompetisi {
    border-left: 5px solid #ff9800;
  }

  .kategori-belajar {
    border-left: 5px solid #4caf50;
  }

  .kategori-lainnya {
    border-left: 5px solid #9c27b0;
  }

  /* --- Properti lain --- */
  .text-ellipsis-2 {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
  }

  .card-item .card-footer {
    padding: 0.25rem 0;
  }

  .search {
    max-width: 15rem;
  }

  @media (max-width: 720px) {
    .search {
      max-width: 10rem;
    }
  }
</style>

<div class="app-content">
  <div class="container-fluid">
    <div class="row">

      <!--BOX PENGUNJUNG-->
      <div class="col-lg-4 col-6">
        <div class="small-box text-bg-success">
          <div class="inner">
            <h3>X</h3>
            <p>Pengunjung</p>
          </div>
          <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"></path>
          </svg>
          <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
            Google Analytics <i class="bi bi-link-45deg"></i>
          </a>
        </div>
      </div>

      <!--BOX PENGGUNA -->
      <div class="col-lg-4 col-6">
        <div class="small-box text-bg-warning">
          <div class="inner">
            <h3><?= $jumlahPengguna ?></h3>
            <p>Jumlah Pengguna</p>
          </div>
          <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"></path>
          </svg>
          <a href="/admin/pengguna" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
            Manajemen Akun <i class="bi bi-link-45deg"></i>
          </a>
        </div>
      </div>

      <!--BOX ARTIKEL-->
      <div class="col-lg-4 col-6">
        <div class="small-box text-bg-danger">
          <div class="inner">
            <h3><?= $jumlahArtikel; ?></h3>
            <p>Jumlah Artikel</p>
          </div>
          <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"></path>
            <path clip-rule="evenodd" fill-rule="evenodd" d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"></path>
          </svg>
          <a href="/admin/artikel" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
            Manajemen Artikel <i class="bi bi-link-45deg"></i>
          </a>
        </div>
      </div>
    </div>
    <!-- Baris Card Data -->
    <div class="row">
      <!-- Kolom Kiri: Card Prestasi dan Card Kelas -->
      <div class="col-lg-6">
        <!-- Card Prestasi -->
        <div class="card mb-4" style="position: relative;">
          <div class="card-header py-3" style="background-color:#4e73df; color:white">
            <div class="d-flex align-items-center">
              <a href="#collapseLeft1" data-toggle="collapse" role="button" aria-expanded="true"
                aria-controls="collapseLeft1" style="text-decoration:none; color:inherit;">
                <h5 class="m-0 font-weight-bold">Prestasi</h5>
              </a>
              <div class="flex-grow-1 ms-auto search" style="padding-left:1rem;">
                <input type="text" id="searchPrestasi" class="form-control" style="height:2rem;" placeholder="Cari prestasi">
              </div>
              <a href="#collapseLeft1" data-toggle="collapse" role="button" aria-expanded="true"
                aria-controls="collapseLeft1" class="ms-3">
                <i class="fas fa-chevron-down text-white" id="iconCollapseLeft1"></i>
              </a>
            </div>
          </div>
          <div class="collapse show" id="collapseLeft1">
            <div class="card-body" style="height:250px; overflow-y:auto; margin-bottom:1rem">
              <?php if (!empty($prestasi)): ?>
                <?php foreach ($prestasi as $item): ?>
                  <?php
                  // Tentukan kelas border left berdasarkan 'jenis' prestasi (individual atau kelompok)
                  $jenis = strtolower($item['jenis'] ?? 'individual');
                  switch ($jenis) {
                    case 'individual':
                      $borderClass = 'border-left-prestasi-individual';
                      break;
                    case 'kelompok':
                      $borderClass = 'border-left-prestasi-kelompok';
                      break;
                    default:
                      $borderClass = 'border-left-prestasi-individual';
                      break;
                  }
                  // Tentukan kelas corner berdasarkan 'tingkat'
                  $tingkat = strtolower($item['tingkat'] ?? 'lainnya');
                  switch ($tingkat) {
                    case 'sekolah':
                      $cornerClass = 'toptight-corner-prestasi-sekolah';
                      break;
                    case 'desa/kelurahan':
                      $cornerClass = 'toptight-corner-prestasi-desa';
                      break;
                    case 'kecamatan':
                      $cornerClass = 'toptight-corner-prestasi-kecamatan';
                      break;
                    case 'kabupaten/kota':
                      $cornerClass = 'toptight-corner-prestasi-kabupaten';
                      break;
                    case 'provinsi':
                      $cornerClass = 'toptight-corner-prestasi-provinsi';
                      break;
                    case 'nasional':
                      $cornerClass = 'toptight-corner-prestasi-nasional';
                      break;
                    case 'internasional':
                      $cornerClass = 'toptight-corner-prestasi-internasional';
                      break;
                    default:
                      $cornerClass = 'toptight-corner-prestasi-lainnya';
                      break;
                  }
                  ?>
                  <div class="card mb-2" style="height:5rem; position: relative;">
                    <!-- Card body dengan border left berdasarkan jenis dan corner SVG berdasarkan tingkat -->
                    <div class="card-body <?= $borderClass; ?> shadow h-100 d-flex flex-column py-1" style="position: relative;">
                      <div class="<?= $cornerClass; ?>" style="position: absolute; top: 0; right: 0; width: 60px; height: 60px;"></div>
                      <div class="flex-grow-1">
                        <div class="text-ellipsis-2" style="font-weight: bold;">
                          <?= esc($item['nama_kegiatan'] ?? 'Nama Kegiatan') ?>
                        </div>
                        <div>
                          <?= esc(($item['jenis'] ?? 'Jenis') . ' | ' . ($item['tingkat'] ?? 'Tingkat')) ?>
                        </div>
                      </div>
                      <div class="card-footer p-0" style="background-color: transparent; justify-items:right;">
                        <small class="text-muted"><?= esc($item['tahun'] ?? 'Tahun') ?></small>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <p>Tidak ada data prestasi.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Card Kelas (tetap contoh sederhana) -->
        <div class="card mb-4">
          <div class="card-header py-3" style="background-color:#4e73df; color:white">
            <div class="d-flex align-items-center">
              <a href="#collapseLeft2" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseLeft2" style="text-decoration:none; color:inherit;">
                <h5 class="m-0 font-weight-bold">Kelas</h5>
              </a>
              <div class="flex-grow-1 ms-auto search" style="padding-left:1rem;">
                <input type="text" id="searchKelas" class="form-control" style="height:2rem;" placeholder="Cari kelas">
              </div>
              <a href="#collapseLeft2" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseLeft2" class="ms-3">
                <i class="fas fa-chevron-down text-white" id="iconCollapseLeft2"></i>
              </a>
            </div>
          </div>
          <div class="collapse show" id="collapseLeft2">
            <div class="card-body" style="height:250px; overflow-y:auto; margin-bottom:1rem">
              <?php if (!empty($classes)): ?>
                <?php foreach ($classes as $kelas): ?>
                  <div class="card mb-2" style="height:5rem;">
                    <div class="card-body border-left-kelas shadow h-100 d-flex flex-column py-1">
                      <div class="flex-grow-1">
                        <div class="text-ellipsis-2" style="font-weight: bold;">
                          <?= esc($kelas['nama_kelas'] ?? 'Nama Kelas') ?>
                        </div>
                        <div>
                          <?= esc($kelas['kode_kelas'] ?? 'Kode Kelas') ?>
                        </div>
                      </div>
                      <div class="card-footer p-0" style="background-color: transparent; justify-items:right;">
                        <small class="text-muted"><?= esc($kelas['jumlah_anggota'] ?? '0') ?> anggota</small>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <p>Tidak ada data kelas.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Kolom Kanan: Card Artikel -->
      <div class="col-lg-6">
        <div class="card mb-4">
          <div class="card-header py-3" style="background-color:#4e73df; color:white">
            <div class="d-flex align-items-center">
              <a href="#collapseRight" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseRight" style="text-decoration:none; color:inherit;">
                <h5 class="m-0 font-weight-bold">Artikel Terbaru</h5>
              </a>
              <div class="flex-grow-1 ms-auto search" style="padding-left:1rem;">
                <input type="text" id="searchArtikel" class="form-control" style="height:2rem;" placeholder="Cari artikel">
              </div>
              <a href="#collapseRight" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseRight" class="ms-3">
                <i class="fas fa-chevron-down text-white" id="iconCollapseRight"></i>
              </a>
            </div>
          </div>
          <div class="collapse show" id="collapseRight">
            <div class="card-body" style="height:607px; overflow-y:auto; margin-bottom:1rem">
              <?php if (!empty($artikel)): ?>
                <?php foreach ($artikel as $a): ?>
                  <?php
                  // Jika kategori mempengaruhi styling, tentukan kelas kategori di sini
                  $kategori = strtolower($a['kategori'] ?? 'lainnya');
                  switch ($kategori) {
                    case 'event':
                      $kategoriClass = 'kategori-event';
                      break;
                    case 'kompetisi':
                      $kategoriClass = 'kategori-kompetisi';
                      break;
                    case 'belajar':
                      $kategoriClass = 'kategori-belajar';
                      break;
                    default:
                      $kategoriClass = 'kategori-lainnya';
                      break;
                  }
                  ?>
                  <div class="card mb-2" style="height:5rem;">
                    <div class="card-body border-left-artikel topright-corner-artikel <?= $kategoriClass; ?> shadow h-100 d-flex flex-column py-1">
                      <div class="flex-grow-1">
                        <div class="text-ellipsis-2" style="font-weight: bold;">
                          <?= esc($a['judul'] ?? 'Judul Artikel') ?>
                        </div>
                        <div>
                          <?= esc($a['kategori'] ?? 'Kategori') ?>
                        </div>
                      </div>
                      <div class="card-footer p-0" style="background-color: transparent; justify-items:right;">
                        <small class="text-muted">
                          <?= esc(($a['updated_at'] ?? '') . ($a['tanggal'] ?? '')) ?>
                        </small>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <p>Tidak ada data artikel.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>


<!-- Pastikan jQuery dan Bootstrap JS dimuat -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Filter Prestasi
  document.getElementById('searchPrestasi').addEventListener('keyup', function() {
    var searchText = this.value.toLowerCase();
    document.querySelectorAll('#collapseLeft1 .card.mb-2').forEach(function(item) {
      item.style.display = item.textContent.toLowerCase().includes(searchText) ? '' : 'none';
    });
  });
  // Filter Kelas
  document.getElementById('searchKelas').addEventListener('keyup', function() {
    var searchText = this.value.toLowerCase();
    document.querySelectorAll('#collapseLeft2 .card.mb-2').forEach(function(item) {
      item.style.display = item.textContent.toLowerCase().includes(searchText) ? '' : 'none';
    });
  });
  // Filter Artikel
  document.getElementById('searchArtikel').addEventListener('keyup', function() {
    var searchText = this.value.toLowerCase();
    document.querySelectorAll('#collapseRight .card.mb-2').forEach(function(item) {
      item.style.display = item.textContent.toLowerCase().includes(searchText) ? '' : 'none';
    });
  });

  // Toggle ikon collapse
  $('#collapseLeft1').on('show.bs.collapse', function() {
    $('#iconCollapseLeft1').removeClass('fa-chevron-down').addClass('fa-chevron-up');
  });
  $('#collapseLeft1').on('hide.bs.collapse', function() {
    $('#iconCollapseLeft1').removeClass('fa-chevron-up').addClass('fa-chevron-down');
  });
  $('#collapseLeft2').on('show.bs.collapse', function() {
    $('#iconCollapseLeft2').removeClass('fa-chevron-down').addClass('fa-chevron-up');
  });
  $('#collapseLeft2').on('hide.bs.collapse', function() {
    $('#iconCollapseLeft2').removeClass('fa-chevron-up').addClass('fa-chevron-down');
  });
  $('#collapseRight').on('show.bs.collapse', function() {
    $('#iconCollapseRight').removeClass('fa-chevron-down').addClass('fa-chevron-up');
  });
  $('#collapseRight').on('hide.bs.collapse', function() {
    $('#iconCollapseRight').removeClass('fa-chevron-up').addClass('fa-chevron-down');
  });
</script>

<?= $this->endSection(); ?>