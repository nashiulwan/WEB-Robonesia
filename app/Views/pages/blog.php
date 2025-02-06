<div class="container mt-5">
    <h1 class="text-center mb-4">BLOG</h1>

    <!-- Daftar Kategori -->
    <div class="d-flex justify-content-center mb-4">
        <div class="btn-group" role="group">
            <a href="<?= base_url('blog/kategori/berita'); ?>" class="btn btn-outline-primary">
                <i class="fas fa-newspaper"></i> Berita
            </a>
            <a href="<?= base_url('blog/kategori/kompetisi'); ?>" class="btn btn-outline-success">
                <i class="fas fa-trophy"></i> Kompetisi
            </a>
            <a href="<?= base_url('blog/kategori/event'); ?>" class="btn btn-outline-warning">
                <i class="fas fa-calendar-alt"></i> Event
            </a>
            <a href="<?= base_url('blog/kategori/belajar'); ?>" class="btn btn-outline-info">
                <i class="fas fa-book"></i> Belajar
            </a>
            <a href="<?= base_url('blog/kategori/lainnya'); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-ellipsis-h"></i> Lainnya
            </a>
        </div>
    </div>

    <!-- Daftar Artikel -->
    <div class="row">
        <?php if (!empty($artikel)) : ?>
            <?php foreach ($artikel as $row) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0">
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

                        <div class="card-footer text-muted text-center">
                            <small>
                                <i class="fas fa-folder"></i> <?= esc(ucfirst($row['kategori'])); ?> | 
                                <i class="fas fa-calendar"></i> <?= date('d M Y', strtotime($row['created_at'])); ?>
                            </small>
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
