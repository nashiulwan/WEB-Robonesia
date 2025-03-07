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
    <h1 class="text-center mb-4" data-aos="fade-up" data-aos-duration="1000" style="margin-top: 8rem;">SHOP</h1>

    <!-- Form Pencarian -->
    <div class="mb-4 d-flex align-items-center">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan judul atau isi konten...">
        <i class="fas fa-search text-muted ms-2"></i>
    </div>

    <!-- Daftar shop -->
    <div class="row" id="shopList">
        <?php if (!empty($shop)) : ?>
            <?php foreach ($shop as $row) : ?>
                <div class="col-md-4 col-sm-6 mb-4 shop-item" data-aos="fade-up" data-aos-duration="300"
                    data-title="<?= strtolower(esc($row['nama_produk'])); ?>"
                    data-content="<?= strtolower(strip_tags($row['deskripsi_produk'])); ?>">
                    <div class="card card-blog shadow-sm border-1" style="min-height: 500px;">
                        <?php if (!empty($row['gambar_produk'])) : ?>
                            <img src="<?= base_url('uploads/shop/' . esc($row['gambar_produk'])); ?>"
                                class="card-img-top img-fluid" style="height: 200px; object-fit: cover;"
                                alt="<?= esc($row['nama_produk']); ?>">
                        <?php else : ?>
                            <img src="<?= base_url('uploads/default.jpg'); ?>" class="card-img-top" alt="No Image">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title"><?= esc($row['nama_produk']); ?></h5>
                            <p class="card-text"><?= strip_tags($row['deskripsi_produk']); ?></p>
                            <a href="<?= base_url('/' . esc($row['nama_produk'])); ?>" class="btn btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-12 text-center">
                <p class="alert alert-warning">Belum ada shop yang dipublikasikan.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- Tombol WhatsApp & Maps -->
<div class="floating-buttons">
    <a target="_blank" href="<?= esc('https://wa.me/' . $kontak['no_hp']) ?>" class="btn-floating btn-whatsapp" title='Hubungi Kami'>
        <i class="ri-whatsapp-fill"></i>
    </a>
    <a target="_blank" href="https://maps.app.goo.gl/Cu246KuzoBk2Dvph8" class="btn-floating btn-shop" title="Shop">
        <i class="ri-shopping-bag-fill"></i>
    </a>
</div>
<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        let searchValue = this.value.toLowerCase();
        let articles = document.querySelectorAll('.shop-item');

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