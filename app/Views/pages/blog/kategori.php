<div class="container mt-5">
    <h1 class="mb-4" data-aos="fade-up" data-aos-duration="1000" style="margin-top: 8rem;"><?= esc($title) ?></h1>

    <?php if (!empty($message)) : ?>
        <div class="alert alert-warning"><?= esc($message) ?></div>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($artikel as $item) : ?>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-duration="300"> 
                <div class="card">
                    <?php if (!empty($item['gambar'])) : ?>
                        <img src="<?= base_url('uploads/' . esc($item['gambar'])) ?>" class="card-img-top" alt="Gambar Artikel" style="height: 200px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= esc($item['judul']) ?></h5>
                        <p class="card-text"><?= esc(substr($item['konten'], 0, 100)) ?>...</p>
                        <a href="<?= base_url('blog/' . esc($item['slug'])) ?>" class="btn btn-primary">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="<?= base_url('blog') ?>" class="btn btn-secondary mt-3 mb-5">Kembali ke Blog</a>
</div>
