<?= $this->extend('siswa/layout') ?>

<?= $this->section('content') ?>
<style>
  /* Untuk kelas dengan warna lebih tajam */
  .border-left-kelas {
    border-left: 5px solid #2979FF;
  }

  .border-left-kelas-basic {
    border-left: 5px solid #2979FF;
  }

  .border-left-kelas-intermediate {
    border-left: 5px solid #FFD600;
  }

  .border-left-kelas-advance {
    border-left: 5px solid #D50000;
  }

  /* Top corner untuk label kelas */
  .toptight-corner-kelas {
    position: absolute;
    top: 0;
    right: 0;
    width: 50px;
    height: 50px;
    background-repeat: no-repeat;
    background-size: cover;
    background-image: url("data:image/svg+xml;utf8,<svg width='800px' height='800px' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' version='1.1' fill='%232979FF' stroke='%23000000' stroke-linecap='round' stroke-linejoin='round' stroke-width='1'><path d='m8 1.75 5.25 2v5c0 2.25-2 4.5-5.25 5.5-3.25-1-5.25-3-5.25-5.5v-5z'/></svg>");
  }

  .toptight-corner-kelas-basic {
    position: absolute;
    top: 0;
    right: 0;
    width: 50px;
    height: 50px;
    background-repeat: no-repeat;
    background-size: cover;
    background-image: url("data:image/svg+xml;utf8,<svg width='800px' height='800px' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' version='1.1' fill='%232979FF' stroke='%23000000' stroke-linecap='round' stroke-linejoin='round' stroke-width='1'><path d='m8 1.75 5.25 2v5c0 2.25-2 4.5-5.25 5.5-3.25-1-5.25-3-5.25-5.5v-5z'/></svg>");
  }

  .toptight-corner-kelas-intermediate {
    position: absolute;
    top: 0;
    right: 0;
    width: 50px;
    height: 50px;
    background-repeat: no-repeat;
    background-size: cover;
    background-image: url("data:image/svg+xml;utf8,<svg width='800px' height='800px' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' version='1.1' fill='%23FFD600' stroke='%23000000' stroke-linecap='round' stroke-linejoin='round' stroke-width='1'><path d='m8 1.75 5.25 2v5c0 2.25-2 4.5-5.25 5.5-3.25-1-5.25-3-5.25-5.5v-5z'/></svg>");
  }

  .toptight-corner-kelas-advance {
    position: absolute;
    top: 0;
    right: 0;
    width: 50px;
    height: 50px;
    background-repeat: no-repeat;
    background-size: cover;
    background-image: url("data:image/svg+xml;utf8,<svg width='800px' height='800px' viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg' version='1.1' fill='%23D50000' stroke='%23000000' stroke-linecap='round' stroke-linejoin='round' stroke-width='1'><path d='m8 1.75 5.25 2v5c0 2.25-2 4.5-5.25 5.5-3.25-1-5.25-3-5.25-5.5v-5z'/></svg>");
  }

  .toptightback-corner-kelas {
    position: absolute;
    top: 0;
    right: 0;
    width: 60px;
    height: 60px;
    background-repeat: repeat;
    background-size: 16px 16px;
    transform: rotate(-90deg);
    background-image: url("data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='4' height='4' viewBox='0 0 16 16'><path fill='%232979FF' d='M6.7 16l9.3-9.3v-1.4l-10.7 10.7z'/><path fill='%232979FF' d='M9.7 16l6.3-6.3v-1.4l-7.7 7.7z'/><path fill='%232979FF' d='M12.7 16l3.3-3.3v-1.4l-4.7 4.7z'/><path fill='%232979FF' d='M15.7 16l0.3-0.3v-1.4l-1.7 1.7z'/></svg>");
  }

  .toptightback-corner-kelas-basic {
    position: absolute;
    top: 0;
    right: 0;
    width: 60px;
    height: 60px;
    background-repeat: repeat;
    background-size: 16px 16px;
    transform: rotate(-90deg);
    background-image: url("data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='4' height='4' viewBox='0 0 16 16'><path fill='%232979FF' d='M6.7 16l9.3-9.3v-1.4l-10.7 10.7z'/><path fill='%232979FF' d='M9.7 16l6.3-6.3v-1.4l-7.7 7.7z'/><path fill='%232979FF' d='M12.7 16l3.3-3.3v-1.4l-4.7 4.7z'/><path fill='%232979FF' d='M15.7 16l0.3-0.3v-1.4l-1.7 1.7z'/></svg>");
  }

  .toptightback-corner-kelas-intermediate {
    position: absolute;
    top: 0;
    right: 0;
    width: 60px;
    height: 60px;
    background-repeat: repeat;
    background-size: 16px 16px;
    transform: rotate(-90deg);
    background-image: url("data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='4' height='4' viewBox='0 0 16 16'><path fill='%23FFD600' d='M6.7 16l9.3-9.3v-1.4l-10.7 10.7z'/><path fill='%23FFD600' d='M9.7 16l6.3-6.3v-1.4l-7.7 7.7z'/><path fill='%23FFD600' d='M12.7 16l3.3-3.3v-1.4l-4.7 4.7z'/><path fill='%23FFD600' d='M15.7 16l0.3-0.3v-1.4l-1.7 1.7z'/></svg>");
  }

  .toptightback-corner-kelas-advance {
    position: absolute;
    top: 0;
    right: 0;
    width: 60px;
    height: 60px;
    background-repeat: repeat;
    background-size: 16px 16px;
    transform: rotate(-90deg);
    background-image: url("data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='4' height='4' viewBox='0 0 16 16'><path fill='%23D50000' d='M6.7 16l9.3-9.3v-1.4l-10.7 10.7z'/><path fill='%23D50000' d='M9.7 16l6.3-6.3v-1.4l-7.7 7.7z'/><path fill='%23D50000' d='M12.7 16l3.3-3.3v-1.4l-4.7 4.7z'/><path fill='%23D50000' d='M15.7 16l0.3-0.3v-1.4l-1.7 1.7z'/></svg>");
  }

  .card {
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  .card-body {
    display: flex;
    flex-direction: column;
  }

  .card-content {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }

  .card-deck {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    height: min-content;
  }

  .container-card {
    margin-right: 1rem;
  }

  @media (max-width: 1200px) {
    .card-deck {
      grid-template-columns: repeat(3, 1fr);
    }
  }

  @media (max-width: 992px) {
    .card-deck {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 576px) {
    .card-deck {
      grid-template-columns: 1fr;
      gap: 0.5rem;
    }

    .container-card {
      margin-right: 0;
    }
  }

  .card-content {
    font-size: 0.875rem;
    color: #555;
    margin: 1rem 0;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    z-index: 9;
  }

  .card-footer {
    display: flex;
    justify-content: flex-end;
    background-color: white;
  }

  .card-text {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    z-index: 9;
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  }

  .card a {
    text-decoration: none;
  }
</style>

<div class="container-fluid">
  <!-- Judul Halaman -->
  <div class="d-flex flex-column flex-md-row justify-content-between mb-3 title">
    <h1 class="h3 text-gray-800"><?= esc($title) ?></h1>
  </div>

  <!-- Form Pencarian Kode Kelas -->
  <form method="GET" action="<?= base_url('siswa/kelas/search') ?>">
    <div class="input-group">
      <input type="text" name="kode" id="kodeKelas" class="form-control" placeholder="Masukkan kode kelas" value="<?= isset($_GET['kode']) ? esc($_GET['kode']) : '' ?>">
      <div class="input-group-append">
        <button class="btn btn-primary" type="submit">
          <i class="fas fa-search"></i> Cari kelas
        </button>
      </div>
    </div>
  </form>

  <!-- Tampilkan Flash Message (hanya setelah pencarian dilakukan) -->
  <?php if (isset($_GET['kode'])): ?>
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success mt-3"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger mt-3"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
  <?php endif; ?>

  <?php if (isset($_GET['kode'])): ?>
    <?php if (!empty($kelas)): ?>
      <div class="container-card mt-3">
        <div class="card-deck ">
          <?php
          // Tentukan warna berdasarkan level kelas
          $grade = strtolower($kelas['level'] ?? '');
          switch ($grade) {
            case 'basic':
              $borderColor = 'border-left-kelas-basic';
              $cornerColor = 'toptight-corner-kelas-basic';
              $cornerColorBack = 'toptightback-corner-kelas-basic';
              break;
            case 'intermediate':
              $borderColor = 'border-left-kelas-intermediate';
              $cornerColor = 'toptight-corner-kelas-intermediate';
              $cornerColorBack = 'toptightback-corner-kelas-intermediate';
              break;
            case 'advance':
              $borderColor = 'border-left-kelas-advance';
              $cornerColor = 'toptight-corner-kelas-advance';
              $cornerColorBack = 'toptightback-corner-kelas-advance';
              break;
            default:
              $borderColor = 'border-left-kelas';
              $cornerColor = 'toptight-corner-kelas';
              $cornerColorBack = 'toptightback-corner-kelas';
              break;
          }
          ?>
          <div class="card shadow mb-2 <?= $borderColor; ?>" style="position: relative;">
            <div class="<?= $cornerColorBack; ?>" style="position: absolute; top: 0; right: 0; width: 45px; height: 45px;"></div>
            <div class="<?= $cornerColor; ?>" style="position: absolute; top: 0; right: 0; width: 50px; height: 50px;"></div>
            <div class="card-body shadow d-flex flex-column py-1">
              <div class="card-content">
                <h4 class="card-title font-weight-bold"><?= esc($kelas['nama_kelas']) ?></h4>
                <h6 class="card-subtitle mb-2 text-muted" style="margin-top: 10px;"><?= esc($kelas['kode_kelas']) ?></h6>
                <p class="card-text"><?= esc($kelas['deskripsi']) ?></p>
              </div>
            </div>
            <div class="card-footer p-0 d-flex justify-content-end">
              <a href="<?= base_url('siswa/kelas/gabung/' . esc($kelas['id']) . '/' . esc($userId)) ?>" class="btn btn-primary m-2">
                Gabung Kelas
              </a>
            </div>
          </div>
        </div>
      </div>
    <?php else: ?>
    <?php endif; ?>
  <?php endif; ?>
</div>

<?= $this->endSection() ?>