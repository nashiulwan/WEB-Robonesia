<div class="container mt-5">
    <h1 class="text-center mb-4">BLOG</h1>

    <div class="row">
        <?php if (!empty($artikel)) : ?>
            <?php foreach ($artikel as $row) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <?php if (!empty($row['gambar'])) : ?>
                          <img src="<?= base_url('uploads/' . esc($row['gambar'])); ?>" class="card-img-top img-fluid" style="height: 200px; object-fit: cover;" alt="<?= esc($row['judul']); ?>">
                        <?php else : ?>
                            <img src="<?= base_url('uploads/default.jpg'); ?>" class="card-img-top" alt="No Image">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title"><?= esc($row['judul']); ?></h5>
                            <p class="card-text"><?= esc(substr($row['konten'], 0, 100)); ?>...</p>
                            <a href="<?= base_url('/' . esc($row['slug'])); ?>" class="btn btn-primary">Baca Selengkapnya</a>
                        </div>

                        <div class="card-footer text-muted">
                            <small>Kategori : <?= esc($row['kategori']); ?> | <?= date('d M Y', strtotime($row['created_at'])); ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-12 text-center">
                <p class="alert alert-warning">Belum ada artikel yang dipublikasikan.</p>
            </div>
        <?php endif; ?>
    </div>
</div>




<!-- <div class="header__blog">
            <div class="blog__container">
              <div class="container my-5">
                <div class="row align-items-center">
                  <div class="col-md-4">
                    <img src="/image/galeri_dok1.jpg" alt="Foto" class="img-fluid" />
                  </div>

                  <div class="col-md-8 d-flex flex-column justify-content-center">
                    <a href="/pages/blogdetail" style="text-decoration: none; color: inherit;">
                      <h3 class="fw-bold">Robonesia Sukses Gelar Medan Robotic Competition 2024</h3>
                    </a>
                    <h6 style="color: var(--color-blue)">By: Robonesia <span style="color: var(--color-yellow)">|</span> 29 Februari 2024</h6>
                    <p class="truncate">Medan Robotic Competition 2024 diikuti oleh 48 peserta dari berbagai sekolah dasar di Kota Medan dengan 6 kategori lomba: Basic Assembly Starter, Basic Animation Starter, Creative Robot, Basic Animation Mover, Creative Animation, dan Soccer Bot.</p>
                    <a href="./pages/blogdetail" class="text-primary">Baca selengkapnya...</a>
                  </div>
                </div>
              </div>                 
            </div>
</div> -->