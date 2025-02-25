<style>
  .text-truncate-custom {
    display: -webkit-box;
    -webkit-line-clamp: 4;
    /* Maksimum 4 baris */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  /* Grid Container */
  .grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 16px;
    border-radius: 5px;
  }

  /* Grid Item */
  .grid-item {
    height: 220px;
  }

  .versi-1100,
  .versi-945,
  .versi-770,
  .versi-610,
  .versi-575 {
    display: none;
  }

  /* Style khusus untuk line dua (artikel sekunder) */
  .content-line2 {
    font-size: 0.8rem;
    /* teks lebih kecil */
    display: -webkit-box;
    -webkit-line-clamp: 2;
    /* minimal 2 baris dengan ellipsis */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .judul-line1 {

    display: -webkit-box;
    -webkit-line-clamp: 2;
    /* Batasi ke 2 baris */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    /* Pastikan tinggi baris sesuai */
    white-space: normal;

  }

  .judul-line2 {

    display: -webkit-box;
    -webkit-line-clamp: 2;
    /* Batasi ke 2 baris */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    max-height: 3em;
    /* Sesuaikan dengan ukuran font */
    line-height: 1.5em;
    /* Pastikan tinggi baris sesuai */
    white-space: normal;

  }

  .img-line2 {
    /* Tambahkan styling khusus untuk gambar di line dua jika diperlukan */
  }

  .lihat-selengkapnya {
    /* Tambahkan custom style untuk tombol Lihat Selengkapnya jika perlu */
  }

  /* Responsif untuk layar kecil */
  @media (max-width: 1100px) {
    .grid-container .grid-item:nth-child(n+6) {
      display: none;
    }

    .versi-normal,
    .versi-945,
    .versi-770,
    .versi-610,
    .versi-575 {
      display: none;
    }

    .versi-1100 {
      display: inline;
    }
  }

  @media (max-width: 945px) {
    .grid-container .grid-item:nth-child(n+5) {
      display: none;
    }

    .versi-normal,
    .versi-1100,
    .versi-770,
    .versi-610,
    .versi-575 {
      display: none;
    }

    .versi-945 {
      display: inline;
    }
  }

  @media (max-width: 770px) {
    #line-pertama .col-md-4:nth-child(n+3) {
      display: none;
    }

    .grid-container .grid-item:nth-child(n+4) {
      display: none;
    }

    .versi-normal,
    .versi-1100,
    .versi-945,
    .versi-610,
    .versi-575 {
      display: none;
    }

    .versi-770 {
      display: inline;
    }
  }

  @media (max-width: 620px) {

    #line-pertama .col-md-4:nth-child(n+2) {
      display: none;
    }

    #line-pertama .col-md-4 {
      width: 100%;
    }

    .grid-container .grid-item:nth-child(n+4) {
      display: inline;
    }

    .versi-normal,
    .versi-1100,
    .versi-945,
    .versi-770,
    .versi-575 {
      display: none;
    }

    .versi-610 {
      display: inline;
    }
  }

  @media (max-width: 575) {

    .versi-normal,
    .versi-1100,
    .versi-945,
    .versi-770,
    .versi-610 {
      display: none;
    }

    .versi-575 {
      display: inline;
    }
  }

  .card-hover {
    cursor: pointer;
    transition: transform 0.2s ease;
    border-radius: 10px;

  }

  .card-hover:hover {
    transform: translateY(-5px) scale(1.03);
  }

  .card-link {
    text-decoration: none;
    color: inherit;
  }

  .card-link :hover {
    transition: transform 0.2s ease;
    text-decoration: none;

  }

  .card-artikel-line1 {
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border-radius: 10px;
  }


  .card-artikel-line1:hover {
    transform: translateY(-5px) scale(1.03);
    box-shadow: 0 8px 12px rgba(51, 204, 204, 0.5);
  }

  .card-artikel-line1:hover img {
    transform: scale(1.05);
  }

  .card-artikel-line1 img {
    transition: transform 0.2s ease;
    width: 100%;
  }

  .card-artikel {
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border-radius: 10px;
  }


  .card-artikel:hover {
    transform: translateY(-5px) scale(1.03);
    box-shadow: 0 8px 12px rgba(51, 204, 204, 0.5);
  }

  .card-artikel:hover img {
    transform: scale(1.05);
  }

  .card-artikel img {
    transition: transform 0.2s ease;
    width: 100%;
  }
</style>

<section>
  <header class="header__container" style="margin-top: 10%;">
    <div class="header__image">
      <div class="header__image__card header__image__card-1" data-aos="fade-right">
        SCIENCE
      </div>
      <div class="header__image__card header__image__card-2" data-aos="fade-left" data-aos-delay="200">
        TECH
      </div>
      <div class="header__image__card header__image__card-3" data-aos="fade-right" data-aos-delay="300">
        ENGINEERING
      </div>
      <div class="header__image__card header__image__card-4" data-aos="fade-left" data-aos-delay="400">
        MATH
      </div>
      <img src="image/header.png" alt="header" />
    </div>
    <div class="header__content">
      <h1 data-aos="fade-right" data-aos-duration="300">
        SELAMAT DATANG DI <span>ROBONESIA!</span>
        <br>RUMAH ROBOT INDONESIA
      </h1>
      <p data-aos="fade-right" data-aos-duration="600" data-aos-delay="300">
        Robonesia adalah Lembaga yang konsen
        dalam dunia pendidikan khususnya robotika.
        Basis pembelajarannya berupa ekstrakurikuler
        Robotik di sekolah-sekolah, kelas robotik
        online, dan privat robotik. Goals robonesia
        Menjadi Perusahaan pembelajaran teknologi
        dan robotik terbesar di Indonesia, sehingga
        dengan bonus demografi penduduknya
        menjadi salah satu negara dengan sumber
        daya manusia teknologi yang handal.
      </p>
      <form action="/" data-aos="fade-right" data-aos-duration="200" data-aos-delay="100">
        <div class="input__row">
          <div class="input__group">
            <h5>Lokasi</h5>
            <div>
              <span><i id="logo-lokasi" class="ri-map-pin-line"></i></span>
              <p style="font-weight: bold; margin-bottom: 0;">Medan, Sumatera Utara</p>
            </div>
          </div>
          <div class="button__row">
            <a target="_blank" href="<?= esc('https://wa.me/' . $kontak['no_hp']) ?>" type="button" class="btn-a btn-whatsapp">
              <i class="ri-whatsapp-fill"></i>
            </a>
            <a target="_blank" href="https://maps.app.goo.gl/Cu246KuzoBk2Dvph8" type="button" class="btn-a btn-maps">
              <i class="ri-map-pin-fill"></i>
            </a>
          </div>
        </div>
      </form>
    </div>
  </header>

  <!-- ARTIKEL MULAI -->
  <div class="artikel-container">

    <div class="row p-3">
      <?php if (!empty($artikel)) : ?>
        <!-- Line Pertama -->
        <div class="col-12 ">
          <div class="row" id="line-pertama">
            <?php
            // Ambil artikel terbaru untuk line pertama (3 artikel)
            $main_articles = array_slice($artikel, 0, 3);
            ?>
            <?php foreach ($main_articles as $index => $row) : ?>
              <div class="col-md-4 col-sm-6 col-12 mb-4" data-aos="fade-up" data-aos-duration="1000">
                <a href="<?= base_url('/' . esc($row['slug'])); ?>" class="card-link">
                  <div class="card shadow-md border-0 card-artikel-line1">
                    <?php if (!empty($row['gambar'])) : ?>
                      <img src="<?= base_url('uploads/' . esc($row['gambar'])); ?>"
                        class="card-img-top img-fluid" style="height: 200px; object-fit: cover;"
                        alt="<?= esc($row['judul']); ?>">
                    <?php else : ?>
                      <img src="<?= base_url('uploads/default.jpg'); ?>"
                        class="card-img-top" alt="No Image">
                    <?php endif; ?>

                    <div class="card-body" style="height:200px;">
                      <h5 class="card-title judul-line1"><?= esc($row['judul']); ?></h5>
                      <p class="card-text text-truncate-custom">
                        <?= esc(strip_tags($row['konten'])); ?>
                      </p>
                    </div>

                    <div class="card-footer text-muted text-center">
                      <small>
                        <i class="fas fa-folder"></i> <?= esc(ucfirst($row['kategori'])); ?> |
                        <i class="fas fa-calendar"></i> <?= date('d M Y', strtotime($row['created_at'])); ?>
                      </small>
                    </div>
                  </div>
                </a>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Line Kedua - Versi Normal -->
        <div class="col-12 versi-normal" data-aos="fade-up" data-aos-duration="200" data-aos-delay="100">
          <div class="grid-container">
            <?php
            $secondary_articles = array_slice($artikel, count($main_articles), 5);
            ?>
            <?php foreach ($secondary_articles as $index => $row) : ?>
              <div class="grid-item card-artikel">
                <a href="<?= base_url('/' . esc($row['slug'])); ?>" class="card-link">
                  <div class="card shadow-sm border-0 h-100">
                    <?php if (!empty($row['gambar'])) : ?>
                      <img src="<?= base_url('uploads/' . esc($row['gambar'])); ?>"
                        class="card-img-top img-line2"
                        style="height: 100px; object-fit: cover;"
                        alt="<?= esc($row['judul']); ?>">
                    <?php else : ?>
                      <img src="<?= base_url('uploads/default.jpg'); ?>"
                        class="card-img-top img-line2"
                        style="height: 100px; object-fit: cover;"
                        alt="No Image">
                    <?php endif; ?>
                    <div class="card-body d-flex align-items-center" style="height: 120px;">
                      <h6 class="card-title content-line2 judul-line2 text-truncate">
                        <?= esc($row['judul']); ?>
                      </h6>
                    </div>
                    <div class="card-footer text-muted text-center">
                      <small>
                        <?= esc(ucfirst($row['kategori'])); ?>
                      </small>
                    </div>
                  </div>
                </a>

              </div>
            <?php endforeach; ?>

            <!-- Card Lihat Selengkapnya -->
            <div class="grid-item card-lain">
              <a href="<?= base_url('blog'); ?>" class="card-link-lain">
                <div class="card shadow-sm border-0 d-flex align-items-center justify-content-center h-100 card-hover" style="background: #ffdd00">
                  <h6 class="text-center">
                    Lihat Berita <br> Lainnya <i class="fas fa-arrow-right ms-2"></i>
                  </h6>
                </div>
              </a>
            </div>
          </div>
        </div>

        <!-- Line Kedua - Versi 1100 -->
        <div class="col-12 versi-1100" data-aos="fade-up" data-aos-duration="200" data-aos-delay="100">
          <div class="grid-container">
            <?php
            $secondary_articles = array_slice($artikel, count($main_articles), 4);
            ?>
            <?php foreach ($secondary_articles as $index => $row) : ?>
              <div class="grid-item card-artikel">
                <a href="<?= base_url('/' . esc($row['slug'])); ?>" class="card-link"><a href="">
                    <div class="card shadow-sm border-0 h-100">
                      <?php if (!empty($row['gambar'])) : ?>
                        <img src="<?= base_url('uploads/' . esc($row['gambar'])); ?>"
                          class="card-img-top img-line2"
                          style="height: 100px; object-fit: cover;"
                          alt="<?= esc($row['judul']); ?>">
                      <?php else : ?>
                        <img src="<?= base_url('uploads/default.jpg'); ?>"
                          class="card-img-top img-line2"
                          style="height: 100px; object-fit: cover;"
                          alt="No Image">
                      <?php endif; ?>
                      <div class="card-body d-flex align-items-center" style="height: 100px;">
                        <h6 class="card-title content-line2 judul-line2 text-truncate">
                          <?= esc($row['judul']); ?>
                        </h6>
                      </div>
                      <div class="card-footer text-muted text-center">
                        <small>
                          <?= esc(ucfirst($row['kategori'])); ?>
                        </small>
                      </div>
                    </div>
                  </a>

              </div>
            <?php endforeach; ?>

            <!-- Card Lihat Selengkapnya -->
            <div class="grid-item card-lain">
              <a href="<?= base_url('blog'); ?>" class="card-link-lain">
                <div class="card shadow-sm border-0 d-flex align-items-center justify-content-center h-100 card-hover" style="background: #ffdd00">
                  <h6 class="text-center">
                    Lihat Berita <br> Lainnya <i class="fas fa-arrow-right ms-2"></i>
                  </h6>
                </div>
              </a>
            </div>
          </div>
        </div>

        <!-- Line Kedua - Versi 945 -->
        <div class="col-12 versi-945" data-aos="fade-up" data-aos-duration="200" data-aos-delay="100">
          <div class="grid-container">
            <?php
            $secondary_articles = array_slice($artikel, 2, 3);
            ?>
            <?php foreach ($secondary_articles as $index => $row) : ?>
              <div class="grid-item card-artikel">
                <a href="<?= base_url('/' . esc($row['slug'])); ?>" class="card-link">
                  <div class="card shadow-sm border-0 h-100">
                    <?php if (!empty($row['gambar'])) : ?>
                      <img src="<?= base_url('uploads/' . esc($row['gambar'])); ?>"
                        class="card-img-top img-line2"
                        style="height: 100px; object-fit: cover;"
                        alt="<?= esc($row['judul']); ?>">
                    <?php else : ?>
                      <img src="<?= base_url('uploads/default.jpg'); ?>"
                        class="card-img-top img-line2"
                        style="height: 100px; object-fit: cover;"
                        alt="No Image">
                    <?php endif; ?>
                    <div class="card-body d-flex align-items-center" style="height: 100px;">
                      <h6 class="card-title content-line2 judul-line2 text-truncate">
                        <?= esc($row['judul']); ?>
                      </h6>
                    </div>
                    <div class="card-footer text-muted text-center">
                      <small>
                        <?= esc(ucfirst($row['kategori'])); ?>
                      </small>
                    </div>
                  </div>
                </a>

              </div>
            <?php endforeach; ?>

            <!-- Card Lihat Selengkapnya -->
            <div class="grid-item card-lain">
              <a href="<?= base_url('blog'); ?>" class="card-link-lain">
                <div class="card shadow-sm border-0 d-flex align-items-center justify-content-center h-100 card-hover" style="background: #ffdd00">
                  <h6 class="text-center">
                    Lihat Berita <br> Lainnya <i class="fas fa-arrow-right ms-2"></i>
                  </h6>
                </div>
              </a>
            </div>
          </div>
        </div>

        <!-- Line Kedua - Versi 770 -->
        <div class="col-12 versi-770" data-aos="fade-up" data-aos-duration="200" data-aos-delay="100">
          <div class="grid-container">
            <?php
            $secondary_articles = array_slice($artikel, 2, 2);
            ?>
            <?php foreach ($secondary_articles as $index => $row) : ?>
              <div class="grid-item card-artikel">
                <a href="<?= base_url('/' . esc($row['slug'])); ?>" class="card-link">
                  <div class="card shadow-sm border-0 h-100">
                    <?php if (!empty($row['gambar'])) : ?>
                      <img src="<?= base_url('uploads/' . esc($row['gambar'])); ?>"
                        class="card-img-top img-line2"
                        style="height: 100px; object-fit: cover;"
                        alt="<?= esc($row['judul']); ?>">
                    <?php else : ?>
                      <img src="<?= base_url('uploads/default.jpg'); ?>"
                        class="card-img-top img-line2"
                        style="height: 100px; object-fit: cover;"
                        alt="No Image">
                    <?php endif; ?>
                    <div class="card-body d-flex align-items-center" style="height: 100px;">
                      <h6 class="card-title content-line2 judul-line2 text-truncate">
                        <?= esc($row['judul']); ?>
                      </h6>
                    </div>
                    <div class="card-footer text-muted text-center">
                      <small>
                        <?= esc(ucfirst($row['kategori'])); ?>
                      </small>
                    </div>
                  </div>
                </a>

              </div>
            <?php endforeach; ?>

            <!-- Card Lihat Selengkapnya -->
            <div class="grid-item card-lain">
              <a href="<?= base_url('blog'); ?>" class="card-link-lain">
                <div class="card shadow-sm border-0 d-flex align-items-center justify-content-center h-100 card-hover" style="background: #ffdd00">
                  <h6 class="text-center">
                    Lihat Berita <br> Lainnya <i class="fas fa-arrow-right ms-2"></i>
                  </h6>
                </div>
              </a>
            </div>
          </div>
        </div>

        <!-- Line Kedua - Versi 610 -->
        <div class="col-12 versi-610" data-aos="fade-up" data-aos-duration="200" data-aos-delay="100">
          <div class="grid-container">
            <?php
            $secondary_articles = array_slice($artikel, 1, 3);
            ?>
            <?php foreach ($secondary_articles as $index => $row) : ?>
              <div class="grid-item card-artikel">
                <a href="<?= base_url('/' . esc($row['slug'])); ?>" class="card-link">
                  <div class="card shadow-sm border-0 h-100">
                    <?php if (!empty($row['gambar'])) : ?>
                      <img src="<?= base_url('uploads/' . esc($row['gambar'])); ?>"
                        class="card-img-top img-line2"
                        style="height: 100px; object-fit: cover;"
                        alt="<?= esc($row['judul']); ?>">
                    <?php else : ?>
                      <img src="<?= base_url('uploads/default.jpg'); ?>"
                        class="card-img-top img-line2"
                        style="height: 100px; object-fit: cover;"
                        alt="No Image">
                    <?php endif; ?>
                    <div class="card-body d-flex align-items-center" style="height: 100px;">
                      <h6 class="card-title content-line2 judul-line2 text-truncate">
                        <?= esc($row['judul']); ?>
                      </h6>
                    </div>
                    <div class="card-footer text-muted text-center">
                      <small>
                        <?= esc(ucfirst($row['kategori'])); ?>
                      </small>
                    </div>
                  </div>
                </a>
              </div>
            <?php endforeach; ?>

            <!-- Card Lihat Selengkapnya -->
            <div class="grid-item card-lain">
              <a href="<?= base_url('blog'); ?>" class="card-link-lain">
                <div class="card shadow-sm border-0 d-flex align-items-center justify-content-center h-100 card-hover" style="background: #ffdd00">
                  <h6 class="text-center">
                    Lihat Berita <br> Lainnya <i class="fas fa-arrow-right ms-2"></i>
                  </h6>
                </div>
              </a>
            </div>
          </div>
        </div>

        <!-- Line Kedua - Versi 575 -->
        <div class="col-12 versi-575" data-aos="fade-up" data-aos-duration="200" data-aos-delay="100">
          <div class="grid-container">
            <?php
            $secondary_articles = array_slice($artikel, 1, 3);
            ?>
            <?php foreach ($secondary_articles as $index => $row) : ?>
              <div class="grid-item card-artikel">
                <a href="<?= base_url('/' . esc($row['slug'])); ?>" class="card-link">
                  <div class="card shadow-sm border-0 h-100">
                    <?php if (!empty($row['gambar'])) : ?>
                      <img src="<?= base_url('uploads/' . esc($row['gambar'])); ?>"
                        class="card-img-top img-line2"
                        style="height: 100px; object-fit: cover;"
                        alt="<?= esc($row['judul']); ?>">
                    <?php else : ?>
                      <img src="<?= base_url('uploads/default.jpg'); ?>"
                        class="card-img-top img-line2"
                        style="height: 100px; object-fit: cover;"
                        alt="No Image">
                    <?php endif; ?>
                    <div class="card-body d-flex align-items-center" style="height: 100px;">
                      <h6 class="card-title content-line2 judul-line2 text-truncate">
                        <?= esc($row['judul']); ?>
                      </h6>
                    </div>
                    <div class="card-footer text-muted text-center">
                      <small>
                        <?= esc(ucfirst($row['kategori'])); ?>
                      </small>
                    </div>
                  </div>
                </a>
              </div>
            <?php endforeach; ?>

            <!-- Card Lihat Selengkapnya -->
            <div class="grid-item card-lain">
              <a href="<?= base_url('blog'); ?>" class="card-link-lain">
                <div class="card shadow-sm border-0 d-flex align-items-center justify-content-center h-100 card-hover" style="background: #ffdd00">
                  <h6 class="text-center">
                    Lihat Berita <br> Lainnya <i class="fas fa-arrow-right ms-2"></i>
                  </h6>
                </div>
              </a>
            </div>
          </div>
        </div>
      <?php else : ?>
        <div class="col-12 text-center">
          <p class="alert alert-warning">Belum ada artikel yang dipublikasikan.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <!-- ARTIKEL SELESAI -->
</section>
<!-- SELESAI -->

<section>

</section>
<!-- VISI DAN MISI -->
<section>
  <div class="visi-misi__container">
    <h1 data-aos="fade-up">VISI</h1>
    <div class="visi" data-aos="fade-up"
      data-aos-anchor-placement="bottom-bottom" data-aos-delay="100">
      <p>Learning Robotic for better education</p>
    </div>

    <h1 class="misi-tittle" data-aos="fade-up" data-aos-delay="200">MISI</h1>
    <div class="misi" data-aos="fade-up"
      data-aos-anchor-placement="bottom-bottom" data-aos-delay="200">
      <ul>
        <li>Menumbuhkan integritas dalam diri anak
          anak dengan mengarahkan potensi anak
          melalui pembelajaran berbasis projek
        </li>
        <li>Melatih anak-anak agar memiliki
          keterampilan dalam teknologi dan sains</li>
        <li>Menyediakan alat pelatihan yang
          sesuai dengan tumbuh kembang anak</li>
      </ul>
    </div>
  </div>
</section>
<!-- END VISI MISI -->


<!-- KOMITMEN -->
<section>
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="#33cccc" fill-opacity="1" d="M0,224L48,208C96,192,192,160,288,128C384,96,480,64,576,80C672,96,768,160,864,165.3C960,171,1056,117,1152,96C1248,75,1344,85,1392,90.7L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
  </svg>
  <div class="commitment__container">
    <div class="commitment__left">
      <h1 data-aos="fade-right" data-aos-duration="300">KOMITMEN KAMI</h1>
      <p class="intro" data-aos="fade-right" data-aos-duration="500" data-aos-delay="200">Kami berdedikasi untuk mendukung pendidikan anak-anak melalui teknologi dan robotik, menciptakan masa depan yang lebih cerah.</p>
      <a href="/tentang" class="btn" data-aos="fade-right" data-aos-duration="700" data-aos-delay="300">Pelajari Lebih Lanjut</a>
    </div>
    <div class="commitment__right">
      <article class="commitment" data-aos="zoom-in" data-aos-duration="500">
        <p>Mengembangkan program robotik untuk anak usia dini</p>
      </article>
      <article class="commitment" data-aos="zoom-in" data-aos-duration="750">
        <p>Membimbing anak Indonesia untuk mengenal teknologi sejak usia dini</p>
      </article>
      <article class="commitment" data-aos="zoom-in" data-aos-duration="1000">
        <p>Kami mencintai anak-anak dan meyakini bahwa mereka adalah aset tak ternilai untuk masa depan</p>
      </article>
      <article class="commitment" data-aos="zoom-in" data-aos-duration="1250">
        <p>Menyediakan layanan belajar yang relevan</p>
      </article>
      <article class="commitment" data-aos="zoom-in" data-aos-duration="1500">
        <p>Membuat sistem belajar alternatif yang menyenangkan</p>
      </article>
    </div>
  </div>
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="#33cccc" fill-opacity="1" d="M0,32L60,48C120,64,240,96,360,106.7C480,117,600,107,720,106.7C840,107,960,117,1080,144C1200,171,1320,213,1380,234.7L1440,256L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z"></path>
  </svg>
</section>
<!-- END KOMITMEN  -->

<!-- TESTIMONI -->

<section>
  <div class="testimoni__container swiper text-center">
    <h1 data-aos="fade-up" data-aos-anchor-placement="bottom-bottom">Kata Mereka yang sudah</h1>
    <h1 data-aos="fade-up" data-aos-anchor-placement="bottom-bottom">Belajar di <span class="gradient-text">Robonesia</span></h1>
    <div class="testimoni-card-wrapper">
      <ul class="testimoni-card-list swiper-wrapper">
        <li class="testimoni-card-item swiper-slide">
          <a href="#" class="testimoni-card-link">
            <img src="image/testimoni-2.jpg" alt="" class="testimoni-card-image">
            <h5 class="testimoni-card-title" style="color:black">Peluang Emas bagi Lulusan & PKL SMK untuk Berkembang di Dunia Robotik</h5>
            <p class="testimoni-badge">Guru SMKN 11 Bandung</p>
            <p class="testimoni-card-text" style="color:black">Alhamdulillah, Robonesia membuka peluang untuk siswa/i lulusan atau PKL SMK untuk menjadi bagian dari pendidikan robotik, membuka peluang untuk berkembang dan berinovasi sesuai perkembangan teknologi yang berjalan pesat</p>
            <button class="testimoni-card-button material-symbols-rounded">arrow_forward</button>
          </a>
        </li>

        <li class="testimoni-card-item swiper-slide">
          <a href="#" class="testimoni-card-link">
            <img src="image/testimoni-3.jpg" alt="" class="testimoni-card-image">
            <h5 class="testimoni-card-title" style="color:black">Dari Hobi Ngoprek hingga Prestasi Internasional bersama Robonesia</h5>
            <p class="testimoni-badge">Orangtua Siswa</p>
            <p class="testimoni-card-text" style="color:black">Alhamdulillah bisa kenal dengan Robonesia. Anak saya bisa menyalurkan hobinya yang suka "ngoprek" apalagi sering diadain lomba, jadi terus terasah. Alhamdulillah juga bisa menambah pengalaman di kancah internasional. Semoga bisa terus berkembang dan maju</p>
            <button class="testimoni-card-button material-symbols-rounded">arrow_forward</button>
          </a>
        </li>

        <li class="testimoni-card-item swiper-slide">
          <a href="#" class="testimoni-card-link">
            <img src="image/testimoni-1.jpg" alt="" class="testimoni-card-image">
            <h5 class="testimoni-card-title" style="color:black">Belajar Coding Seru Bersama Kakak Mentor</h5>
            <p class="testimoni-badge">Siswa</p>
            <p class="testimoni-card-text" style="color:black">Aku senang sekali bisa belajar robotik di Robonesia. Bisa belajar coding dari kecil dan kakak-kakak pengajarannya seru. Terutama KaK Ali dan Kak Susan. Semoga aku bisa ikut lomba di Rusia.</p>
            <button class="testimoni-card-button material-symbols-rounded">arrow_forward</button>
          </a>
        </li>

        <li class="testimoni-card-item swiper-slide">
          <a href="#" class="testimoni-card-link">
            <img src="image/testimoni-4.jpg" alt="" class="testimoni-card-image">
            <h5 class="testimoni-card-title" style="color:black">Ekskul Robotik di Roboneisa: Seru, Interaktif, dan Dinantikan!</h5>
            <p class="testimoni-badge">Penanggung Jawab Ekskul Sekolah Alasba</p>
            <p class="testimoni-card-text" style="color:black">Kami sekolah sangat berterimakasih kepada Robonesia, ekskul ini sangat bagus sekali terutama untuk anak yang memang senang dunia robotik. Untuk materinya juga sangat bagus. anak tidak bosan. Sangat ditunggu sekali kalau robotik ekskulnya offline.</p>
            <button class="testimoni-card-button material-symbols-rounded">arrow_forward</button>
          </a>
        </li>

        <li class="testimoni-card-item swiper-slide">
          <a href="#" class="testimoni-card-link">
            <img src="image/testimoni-5.jpg" alt="" class="testimoni-card-image">
            <h5 class="testimoni-card-title" style="color:black">Ekskul Robotic telah sampai ke Lomba Internasional</h5>
            <p class="testimoni-badge">Penanggung Jawab Ekskul Sekolah Alam Gaharu</p>
            <p class="testimoni-card-text" style="color:black">Ekskul robotika di SAG berjalan dengan baik dan peserta setiap tahun selalu bertambah, kegiatan ekskul dikemas menarik melalui proyek bervariatif. Anak anak berkesempatan mengikuti lomba Internasional IYRC 2018 Thailand.</p>
            <button class="testimoni-card-button material-symbols-rounded">arrow_forward</button>
          </a>
        </li>

        <li class="testimoni-card-item swiper-slide">
          <a href="#" class="testimoni-card-link">
            <img src="image/testimoni-6.jpg" alt="" class="testimoni-card-image">
            <h5 class="testimoni-card-title" style="color:black">Belajar Robotik Seru, Bermimpi ke Rusia!</h5>
            <p class="testimoni-badge">Siswa</p>
            <p class="testimoni-card-text" style="color:black">Aku senang sekali bisa belajar robotik di Robonesia. Bisa belajar coding dari kecil dan kakak-kakak pengajarnya seru. Harapannya bisa mengikuti lomba di Rusia</p>
            <button class="testimoni-card-button material-symbols-rounded">arrow_forward</button>
          </a>
        </li>


      </ul>
      <div class="swiper-pagination"></div>
      <div class="swipper-slide-button swiper-button-prev"></div>
      <div class="swipper-slide-button swiper-button-next"></div>
    </div>
  </div>

</section>
<!-- TESTIMONI END -->

<!-- KEUNGGULAN KAMI -->
<section>
  <div class="keunggulan-kami__container">
    <h1 data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-duration="500">KEUNGGULAN KAMI</h1>
    <div class="project-based-learning" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-duration="700">
      <h2>Project Based Learning</h2>
      <p>Metode pembelajaran yang menggunakan
        proyek/kegiatan sebagai media pembelajaran
        dan pengembangan dasar kurikulum. Peserta
        didik melakukan eksplorasi, penilaian,
        interpretasi, sintesis, dan informasi untuk
        memahami berbagai bentuk hasil kompetensi</p>
    </div>
    <div class="stem">
      <h2 data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-duration="300">STEM METHOD</h2>
      <div class="stem-grid">
        <article class="keunggulan-kami">
          <!-- <img src="/image/keunggulan-kami-1.png" alt=""> -->
          <h4 data-aos="fade-right" data-aos-duration="300">Science</h4>
          <p data-aos="fade-right" data-aos-duration="300">Memberikan pengetahuan kepada peserta didik mengenai hukum-hukum dan konsep-konsep yang berlaku di alam</p>
        </article>
        <article class="keunggulan-kami">
          <!-- <img src="./assets/keunggulan-kami-1.png" alt=""> -->
          <h4 data-aos="fade-left" data-aos-duration="300">Tech</h4>
          <p data-aos="fade-left" data-aos-duration="300">Keterampilan atau sebuah sistem yang digunakan dalam mengatur masyarakat, organisasi, pengetahuan atau mendesain serta menggunakan sebuah alat buatan yang dapat memudahkan pekerjaan</p>
        </article>
        <article class="keunggulan-kami">
          <!-- <img src="./assets/keunggulan-kami-1.png" alt=""> -->
          <h4 data-aos="fade-right" data-aos-duration="300">Engineering</h4>
          <p data-aos="fade-right" data-aos-duration="300">Pengetahuan untuk mengoperasikan atau mendesain sebuah prosedur untuk menyelesaikan sebuah masalah</p>
        </article>
        <article class="keunggulan-kami">
          <!-- <img src="./assets/keunggulan-kami-1.png" alt=""> -->
          <h4 data-aos="fade-left" data-aos-duration="300">Math</h4>
          <p data-aos="fade-left" data-aos-duration="300">Ilmu yang menghubungkan antara besaran, angka dan ruang yang hanya membutuhkan argumen logis tanpa atau di sertai dengan bukti empiris</p>
        </article>
      </div>
      <a href="/pages/program" class="btn" data-aos="fade-up" data-aos-duration="300">Program Belajar</a>
    </div>
  </div>
</section>
<!-- KEUNGGULAN KAMI END -->

<!-- GALLERY -->
<section class="gallery">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="#ffdd00" fill-opacity="1" d="M0,288L30,266.7C60,245,120,203,180,192C240,181,300,203,360,208C420,213,480,203,540,181.3C600,160,660,128,720,122.7C780,117,840,139,900,122.7C960,107,1020,53,1080,58.7C1140,64,1200,128,1260,144C1320,160,1380,128,1410,112L1440,96L1440,320L1410,320C1380,320,1320,320,1260,320C1200,320,1140,320,1080,320C1020,320,960,320,900,320C840,320,780,320,720,320C660,320,600,320,540,320C480,320,420,320,360,320C300,320,240,320,180,320C120,320,60,320,30,320L0,320Z"></path>
  </svg>
  <div class="gallery__container">
    <div class="background-image"></div>
    <h1 class="gallery__title" data-aos="fade-up" data-aos-duration="800">Galeri Dokumentasi</h1>
    <div class="galleryimage">
      <!-- Foto akan dimuat secara dinamis dengan JavaScript -->
    </div>
    <div class="bullets">
      <!-- Bullet akan dimuat secara dinamis dengan JavaScript -->
    </div>
  </div>
  <svg style="padding-top: -10px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="#ffdd00" fill-opacity="1" d="M0,224L60,240C120,256,240,288,360,266.7C480,245,600,171,720,165.3C840,160,960,224,1080,245.3C1200,267,1320,245,1380,234.7L1440,224L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z"></path>
  </svg>
</section>
<!-- GALLERY END -->

<!-- SCHOOL PARTNER -->
<section class="py-5">
  <div class="container-lg text-center">
    <h1 class="mb-4" data-aos="fade-up" data-aos-duration="500">Sekolah yang Sudah Bermitra dengan Kami</h1>
    <div class="container text-center">
      <div class="row row-cols-2 row-cols-md-4 g-4" id="home-partner-items" data-aos="fade-up" data-aos-duration="600">
        <?php foreach ($partner as $item) : ?>
          <div class="col">
            <div class="p-3 border rounded shadow-sm logo-card">
              <img class="img-fluid mx-auto d-block" src="<?= base_url('uploads/' . $item['logo']); ?>"
                alt="<?= esc($item['partner']); ?>" style="max-width: 100px; height: 100px;">
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- SCHOOL PARTNER END -->

<!-- PRESTASI -->
<section class="py-5">
  <div class="container-lg text-center">
    <h1 class="mb-4" data-aos="fade-up" data-aos-duration="500">Prestasi Siswa Kami</h1>
    <div class="table-responsive mx-auto" style="max-width: 800px;">
      <table class="table table-striped table-hover text-start">
        <tbody>
          <tr data-aos="fade-up" data-aos-delay="200">
            <td><span class="me-2">🏆</span>Juara Umum Walikota Bandung Robo Expo & Competition 2018 <span class="badge bg-primary ms-2">20 Kategori</span></td>
          </tr>
          <tr data-aos="fade-up" data-aos-delay="200">
            <td><span class="me-2">🥇</span>Juara Gemilang RoboCompetition 2018 - Bandung <span class="badge bg-success ms-2">14 Kategori</span></td>
          </tr>
          <tr data-aos="fade-up" data-aos-delay="200">
            <td><span class="me-2">🏆</span>Juara Umum Piala Gubernur Jawa Barat 2019 <span class="badge bg-warning text-dark ms-2">32 Kategori</span></td>
          </tr>
          <tr data-aos="fade-up" data-aos-delay="200">
            <td><span class="me-2">💻</span>Juara 1 Kategori Coding Mission Padjajaran Robotics Competition 2021</td>
          </tr>
          <tr data-aos="fade-up" data-aos-delay="200">
            <td><span class="me-2">🌍</span>Juara Umum Science & Robotics Fair Medan 2022 <span class="badge bg-info text-dark ms-2">Internasional</span></td>
          </tr>
          <tr data-aos="fade-up" data-aos-delay="200">
            <td><span class="me-2">🇹🇭</span>Youth Robot Competition (IYRC) 2018, Thailand <span class="badge bg-danger ms-2">Juara 2 Internasional</span></td>
          </tr>
          <tr data-aos="fade-up" data-aos-delay="200">
            <td><span class="me-2">🇰🇷</span>Youth Robot Competition (IYRC) 2019, Korea Selatan</td>
          </tr>
          <tr data-aos="fade-up" data-aos-delay="200">
            <td><span class="me-2">🤖</span>Juara Umum Medan Robotics Competition 2024</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>
<!-- PRESTASI END -->