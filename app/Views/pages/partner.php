    <div class="kontak__container__top" style="margin-top: 10%;">
      <!-- Foto dokumentasi -->
      <img src="/image/partner.png" alt="Robonesia" class="full-image">
    </div>

    <!-- HEADER PARTNER -->
    <header class="header__partner">
      <h1 class="mb-4" data-aos="fade-up" data-aos-duration="1000">Daftar Mitra Robonesia</h1>
    </header>
    <!-- HEADER PARTNER END -->

    <!-- PARTNER SECTION -->
    <section class="py-5">
      <div class="container-lg text-center">
        <div class="container">
          <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php if (!empty($partner)) : ?>
              <?php foreach ($partner as $row) : ?>
                <div class="col">
                  <div class="partner_items d-flex align-items-center p-3 border rounded shadow-sm"  data-aos="fade-up" data-aos-duration="1000">
                    <?php if (!empty($row['logo'])) : ?>
                      <img src="<?= base_url('uploads/' . esc($row['logo'])); ?>" class="card-img-top img-fluid" style="width: 150px; height: 150px; object-fit: cover;" alt="<?= esc($row['partner']); ?>">
                    <?php else : ?>
                      <img src="<?= base_url('uploads/default.jpg'); ?>" class="card-img-top" alt="No Image">
                    <?php endif; ?>  
                    <div class="ms-3 text-start">
                      <h4 class="mb-1"><?= esc($row['partner']) ?></h4>
                      <a target="_blank" href="<?= esc($row['maps']) ?>" style="color:black;"><?= esc($row['alamat']) ?></a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else : ?>
              <p class="alert alert-warning">Belum ada partner.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
    <!-- PARTNER SECTION END -->