<style>
    .card-blog {
        min-height: 400px;
        max-height: 400px;
    }

    .card-img-top {
        flex-shrink: 0;
        height: 200px;
        object-fit: cover;
    }

    .card-body {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: bold;
        line-height: 1.4;
        height: 3.6rem;
        /* 1.8rem x 2 baris */
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .card-text {
        flex-grow: 1;
        font-size: 0.9rem;
        line-height: 1.5;
        max-height: 5rem;
        overflow: hidden;
        word-break: break-word;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        text-overflow: ellipsis;
    }
</style>
<div class="container mt-5">
    <h1 class="text-center mb-4" data-aos="fade-up" data-aos-duration="1000" style="margin-top: 8rem;">BLOG</h1>

    <!-- Daftar Kategori -->
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-4"
        data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
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

    <!-- Form Pencarian -->
    <div class="mb-4 d-flex align-items-center">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan judul atau isi konten...">
        <i class="fas fa-search text-muted ms-2"></i>
    </div>

    <!-- Daftar Artikel -->
    <div class="row" id="artikelList">
        <?php if (!empty($artikel)) : ?>
            <?php foreach ($artikel as $row) : ?>
                <div class="col-md-4 col-sm-6 mb-4 artikel-item"
                    data-title="<?= strtolower(esc($row['judul'])); ?>"
                    data-content="<?= strtolower(strip_tags($row['konten'])); ?>">
                    <div class="card card-blog shadow-sm border-1" style="min-height: 500px;">
                        <?php if (!empty($row['gambar'])) : ?>
                            <img src="<?= base_url('uploads/' . esc($row['gambar'])); ?>"
                                class="card-img-top img-fluid" style="height: 200px; object-fit: cover;"
                                alt="<?= esc($row['judul']); ?>">
                        <?php else : ?>
                            <img src="<?= base_url('uploads/default.jpg'); ?>" class="card-img-top" alt="No Image">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title"><?= esc($row['judul']); ?></h5>
                            <p class="card-text"><?= strip_tags($row['konten']); ?></p>
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

<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        let searchValue = this.value.toLowerCase();
        let articles = document.querySelectorAll('.artikel-item');

        articles.forEach(article => {
            let title = article.getAttribute('data-title');
            let content = article.getAttribute('data-content');

            if (title.includes(searchValue) || content.includes(searchValue)) {
                article.style.display = 'block';
            } else {
                article.style.display = 'none';
            }
        });
    });
</script>