<?= $this->extend('siswa/layout') ?>

<?= $this->section('content') ?>
<style>
  /* Untuk kelas anak-anak dengan warna lebih tajam */
  .border-left-kelas {
    border-left: 5px solid #2979FF;
    /* Biru Elektrik */
  }

  .border-left-kelas-basic {
    border-left: 5px solid #2979FF;
    /* Biru Elektrik */
  }

  .border-left-kelas-intermediate {
    border-left: 5px solid #FFD600;
    /* Kuning Neon */
  }

  .border-left-kelas-advance {
    border-left: 5px solid #D50000;
    /* Merah Terang */
  }

  /* Top corner untuk label anak-anak dengan warna lebih tajam */
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
    /* Sesuaikan dengan ukuran asli SVG */
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


    .star-kelas {
        position: absolute;
        top: 50px;
        right: 5px;
        flex-direction: column;
        align-items: center;
    }

    .star-kelas .star-icon {
        margin-left: -4px;
    }
    
  .card {
    display: flex;
    flex-direction: column;
    height: 100%;
    margin-bottom: 1rem;
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
<<<<<<< Updated upstream
    gap: 1rem;
=======
  }

  .container-card {
    margin-right: 1rem;
>>>>>>> Stashed changes
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
    margin-top: 1rem;
    margin-bottom: 1rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    z-index: 9;
  }

  .card-footer {
    display: flex;
    justify-content: flex-end;
    bottom: 0;
  }

  .card-text {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    z-index: 9;
  }

  @media (max-width: 760px) {
    .d-flex {
      justify-content: flex-start;
      width: 100%;
    }

    .title {
      text-align: left;
    }
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    text-decoration: none;
  }

  .card a {
    text-decoration: none;
  }

  .card:hover a {
    text-decoration: none;
  }
</style>

<div class="container-fluid">
  <div class="d-flex flex-column flex-md-row justify-content-between mb-3 title">
    <h1 class="h3 text-gray-800"><?= esc($title) ?></h1>
    <div class="d-flex align-items-center w-100 w-md-auto mt-3 mt-md-0" style="max-width: 320px;">

      <input type="text" id="searchInput" class="form-control" placeholder="Cari kelas" style="flex-grow: 1;">
      <i class="fas fa-search text-muted" style="margin-left: 0.5rem;"></i>
    </div>
  </div>

  <!-- Show Flash Messages -->
  <?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
  <?php endif; ?>

  <!-- Card Grid for Displaying Classes -->
  <div class="container-card">
    <div class="card-deck">
      <?php if (!empty($kelasSaya)): ?>
        <?php foreach ($kelasSaya as $kelas): ?>
          <?php
          // Ambil nilai grade level dan tentukan warna border-nya
          $grade = strtolower($kelas['level'] ?? '');
          switch ($grade) {
            case 'basic':
              $borderColor = 'border-left-kelas-basic';
              break;
            case 'intermediate':
              $borderColor = 'border-left-kelas-intermediate';
              break;
            case 'advance':
              $borderColor = 'border-left-kelas-advance';
              break;
            default:
              $borderColor = 'border-left-kelas';
              break;
          }
          switch ($grade) {
            case 'basic':
              $cornerColor = 'toptight-corner-kelas-basic';
              break;
            case 'intermediate':
              $cornerColor = 'toptight-corner-kelas-intermediate';
              break;
            case 'advance':
              $cornerColor = 'toptight-corner-kelas-advance';
              break;
            default:
              $cornerColor = 'toptight-corner-kelas';
              break;
          }
          switch ($grade) {
            case 'basic':
              $cornerColorBack = 'toptightback-corner-kelas-basic';
              break;
            case 'intermediate':
              $cornerColorBack = 'toptightback-corner-kelas-intermediate';
              break;
            case 'advance':
              $cornerColorBack = 'toptightback-corner-kelas-advance';
              break;
            default:
              $cornerColorBack = 'toptightback-corner-kelas';
              break;
          }

          ?>

          <div class="card border-left-kelas shadow mb-2 <?= $borderColor; ?> " style="position: relative; ">
            <div class="<?= $cornerColorBack; ?>" style="position: absolute; top: 0; right: 0; width: 45px; height: 45px;"></div>
            <div class="<?= $cornerColor; ?>" style="position: absolute; top: 0; right: 0; width: 50px; height: 50px;"></div>
            <!-- 
                        <?php if (isset($kelas['sub_level']) && $kelas['sub_level'] > 0): ?>
                            <div class="star-kelas">
                                <?php for ($i = 0; $i < (int)$kelas['sub_level']; $i++): ?>
                                    <svg fill="#ffd700" width="15px" height="15px" viewBox="0 0 24 24" class="icon star-icon">
                                        <path d="M22,9.81a1,1,0,0,0-.83-.69l-5.7-.78L12.88,3.53a1,1,0,0,0-1.76,0L8.57,8.34l-5.7.78a1,1,0,0,0-.82.69,1,1,0,0,0,.28,1l4.09,3.73-1,5.24A1,1,0,0,0,6.88,20.9L12,18.38l5.12,2.52a1,1,0,0,0,.44.1,1,1,0,0,0,1-1.18l-1-5.24,4.09-3.73A1,1,0,0,0,22,9.81Z"></path>
                                    </svg>
                                <?php endfor; ?>
                            </div>
                        <?php endif; ?> -->

            <div class=" card-body shadow d-flex flex-column py-1">
                <a href="<?= base_url('siswa/kelas/detail/' . esc($kelas['id'])); ?>" class="stretched-link">

                <div class="card-grow card-content">
                  <h4 class="card-title font-weight-bold"><?= esc($kelas['nama_kelas']); ?></h4>
                  <h6 class="card-subtitle mb-2 text-muted" style="margin-top: 10px;"><?= esc($kelas['kode_kelas']); ?></h6>
                  <!-- Tambahan ikon bintang berdasarkan sub_level -->
                  <?php if (isset($kelas['sub_level']) && $kelas['sub_level'] > 0): ?>
                    <div class="star-kelas">
                      <?php for ($i = 0; $i < (int)$kelas['sub_level']; $i++): ?>
                        <svg fill="#ffd700" width="15px" height="15px" style="margin-right: -3px; margin-top:-1rem" viewBox="0 0 24 24" class="icon star-icon">
                          <path d="M22,9.81a1,1,0,0,0-.83-.69l-5.7-.78L12.88,3.53a1,1,0,0,0-1.76,0L8.57,8.34l-5.7.78a1,1,0,0,0-.82.69,1,1,0,0,0,.28,1l4.09,3.73-1,5.24A1,1,0,0,0,6.88,20.9L12,18.38l5.12,2.52a1,1,0,0,0,.44.1,1,1,0,0,0,1-1.18l-1-5.24,4.09-3.73A1,1,0,0,0,22,9.81Z"></path>
                        </svg>
                      <?php endfor; ?>
                    </div>
                  <?php endif; ?>
                  <p style="z-index:0" class="card-text"><?= esc($kelas['deskripsi']); ?></p>
                </div>
              </a>
            </div>
            <div class="card-footer p-0 d-flex justify-content-between align-items-center" style="background-color: white; margin-top:-1rem">

              <small class="text-muted">
              </small>
              <small class="text-muted" style="margin-right: 1rem; margin-bottom: 5px;; margin-top: 5px;">
                <?= esc($kelas['level']) ?> - <?= esc($kelas['sub_level']) ?>
              </small>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="alert alert-warning text-center">Anda belum bergabung di kelas manapun</div>
      <?php endif; ?>
    </div>
  </div>
</div>
<script>
  // Ambil elemen input pencarian dan kartu
  const searchInput = document.getElementById('searchInput');
  const cards = document.querySelectorAll('.card');

  // Fungsi untuk memfilter kelas
  searchInput.addEventListener('input', function() {
    const searchTerm = searchInput.value.toLowerCase();
    cards.forEach(function(card) {
      const className = card.querySelector('.card-title').textContent.toLowerCase();
      if (className.includes(searchTerm)) {
        card.style.removeProperty('display');
      } else {
        card.style.display = 'none';
      }
    });
  });
</script>

<?= $this->endSection() ?>