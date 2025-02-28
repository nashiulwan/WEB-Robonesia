<?= $this->extend('siswa/templates/dashboard'); ?>

<?= $this->section('page-content'); ?>

<!-- SECTION ARTIKEL -->
<div class="container mt-4">
    <h2 class="text-center mb-4">Berita & Event Terbaru</h2>
    <!-- Carousel -->
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
                                        
                                        <!-- Kategori -->
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
