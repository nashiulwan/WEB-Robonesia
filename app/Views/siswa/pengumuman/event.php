<?= $this->extend('siswa/templates/dashboard'); ?>

<?= $this->section('page-content'); ?>

<!-- EVENT SECTION -->
<div class="container mt-4">
    <h2 class="text-center mb-4">Seluruh Event dan Lomba</h2>
    <!-- Carousel -->
    <div id="eventCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php foreach (array_chunk($event_artikel, 9) as $index => $chunk) : ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <div class="row">
                        <?php foreach ($chunk as $event) : ?>
                            <div class="col-md-4">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body text-center d-flex flex-column gap-2">
                                        <?php if (!empty($event['gambar'])) : ?>
                                            <img src="<?= base_url('uploads/' . esc($event['gambar'])); ?>" 
                                                class="card-img-top img-fluid" style="height: 200px; object-fit: cover;" 
                                                alt="<?= esc($event['judul']); ?>">
                                        <?php else : ?>
                                            <img src="<?= base_url('uploads/default.jpg'); ?>" class="card-img-top" alt="No Image">
                                        <?php endif; ?>
                                        <!-- Kategori -->
                                        <span class="badge bg-danger">
                                            <?= ucfirst($event['kategori']); ?>
                                        </span>
                                        <h5 class="card-title"><?= esc($event['judul']); ?></h5>
                                        <a href="<?= base_url('/' . esc($event['slug'])); ?>" class="btn btn-primary">
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

        <!-- Tombol Navigasi -->
        <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</div>

        
<?= $this->endSection(); ?>