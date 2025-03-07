

<?= $this->extend('siswa/templates/dashboard'); ?>
<?= $this->section('page-content'); ?>
<!-- SwiperJS CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<!-- SECTION ARTIKEL DAN EVENT TERBARU -->
<!-- <div class="container mt-5">
    <h2 class="text-center mb-4">Event Terbaru</h2>
    <div id="eventCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php foreach (array_chunk($event_artikel, 3) as $index => $chunk) : ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <div class="row">
                        <?php foreach ($chunk as $artikel) : ?>
                            <div class="col-md-4">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body text-center d-flex flex-column gap-2">
                                        <?php if (!empty($artikel['gambar'])) : ?>
                                            <img src="<?= base_url('uploads/' . esc($artikel['gambar'])); ?>" 
                                                class="card-img-top img-fluid" style="height: 200px; object-fit: cover;" 
                                                alt="<?= esc($artikel['judul']); ?>">
                                        <?php else : ?>
                                            <img src="<?= base_url('uploads/default.jpg'); ?>" class="card-img-top" alt="No Image">
                                        <?php endif; ?>
                                        
                                        <span class="badge 
                                            <?= ($artikel['kategori'] === 'event') ? 'bg-success' : 
                                                (($artikel['kategori'] === 'kompetisi') ? 'bg-danger' : 'bg-primary'); ?>">
                                            <?= ucfirst($artikel['kategori']); ?>
                                        </span>

                                        <h5 class="card-title"><?= esc($artikel['judul']); ?></h5>
                                        <p class="text-muted small"><?= date('d M Y', strtotime($artikel['created_at'])); ?></p>
                                        <a href="<?= base_url('/' . esc($artikel['slug'])); ?>" class="btn btn-primary">
                                            Baca Selengkapnya
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</div> -->


<!-- KELAS -->
<div class="container mt-5">
    <!-- Judul -->
    <h2 class="text-center mb-4 fw-bold">Informasi Kelas Saya</h2>
    
    <div class="row justify-content-center">
        <?php if (!empty($kelasSaya)) : ?>
            <div class="col-md-8">
                <div class="card shadow-lg border-0 p-4 rounded-4"
                     style="border-left: 8px solid 
                            <?= ($kelasSaya['level'] == 'Basic') ? '#1cc88a' : 
                                (($kelasSaya['level'] == 'Intermediate') ? '#f6c23e' : '#e74a3b'); ?>;">
                    
                    <div class="card-body">
                        
                        
                        <div class="row mt-4">
                            <h4 class="card-title text-center fw-bold d-flex flex-column gap-2">
                                <i class="fas fa-chalkboard-teacher me-2 text-primary" style="font-size: 1.8rem;"></i>
                                <?= esc($kelasSaya['nama_kelas']); ?>
                                <span class="badge bg-primary fs-6"><?= esc($kelasSaya['kode_kelas']); ?></span>
                            </h4>
                            <p class="text-muted text-center fst-italic py-4"><?= esc($kelasSaya['deskripsi']); ?></p>

                            <div class="col-4 text-center p-2">
                                <i class="fas fa-layer-group text-success" style="font-size: 2rem;"></i>
                                <p class="mb-0"><strong>Level:</strong></p>
                                <p class="fw-bold"><?= esc($kelasSaya['level']); ?></p>
                            </div>
                            <div class="col-4 text-center p-2">
                                <i class="fas fa-sitemap text-warning" style="font-size: 2rem;"></i>
                                <p class="mb-0"><strong>Sub-Level:</strong></p>
                                <p class="fw-bold"><?= esc($kelasSaya['sub_level']); ?></p>
                            </div>
                            <div class="col-4 text-center p-2">
                                <i class="fas fa-toggle-on <?= ($kelasSaya['status'] == '1') ? 'text-success' : 'text-danger'; ?>" style="font-size: 2rem;"></i>
                                <p class="mb-0"><strong>Status:</strong></p>
                                <span class="badge <?= ($kelasSaya['status'] == '1') ? 'bg-success' : 'bg-danger'; ?> fs-6">
                                    <?= ($kelasSaya['status'] == '1') ? 'Aktif' : 'Tidak Aktif'; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <div class="col-md-6">
                <div class="alert alert-warning text-center p-4 rounded-4">
                    <i class="fas fa-exclamation-triangle text-danger" style="font-size: 2.5rem;"></i>
                    <h5 class="mt-3">Anda belum terdaftar dalam kelas.</h5>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- EVENT -->
<div class="container-fluid mt-5">
    <h2 class="text-center mb-4 fw-bold">Event Terbaru</h2>

    <div class="swiper-container px-5">
        <div class="swiper-wrapper">
            <?php foreach ($event_artikel as $artikel) : ?>
                <div class="swiper-slide">
                    <div class="card shadow-sm border-0 rounded-4">
                        <?php if (!empty($artikel['gambar'])) : ?>
                            <img src="<?= base_url('uploads/' . esc($artikel['gambar'])); ?>" 
                                 class="card-img-top img-fluid rounded-top-4" 
                                 style="height: 220px; object-fit: cover;" 
                                 alt="<?= esc($artikel['judul']); ?>">
                        <?php else : ?>
                            <img src="<?= base_url('uploads/default.jpg'); ?>" class="card-img-top" alt="No Image">
                        <?php endif; ?>

                        <div class="card-body text-right">
                            <span class="badge 
                                <?= ($artikel['kategori'] === 'event') ? 'bg-success' : 
                                    (($artikel['kategori'] === 'kompetisi') ? 'bg-danger' : 'bg-primary'); ?>">
                                <?= ucfirst($artikel['kategori']); ?>
                            </span>

                            <h5 class="card-title mt-2"><?= esc($artikel['judul']); ?></h5>
                            <p class="text-muted small"><?= date('d M Y', strtotime($artikel['created_at'])); ?></p>
                            <a href="<?= base_url('/' . esc($artikel['slug'])); ?>" class="btn btn-primary btn-sm">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Navigasi Swiper -->
        <!-- <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div> -->
    </div>
</div>



<!-- SwiperJS JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".swiper-container", {
        slidesPerView: 1, // Menampilkan 4 artikel sekaligus
        spaceBetween: 20,
        loop: true, // Looping tanpa batas
        autoplay: {
            delay: 3000, // Geser otomatis setiap 3 detik
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
</script>

<?= $this->endSection(); ?>