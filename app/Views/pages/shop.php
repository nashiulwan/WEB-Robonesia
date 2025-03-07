<style>
  .card-blog-shop {
    min-height: 300px;
    max-height: 300px;
  }

  .card-img-top {
    flex-shrink: 0;
    height: 200px;
    object-fit: cover;
  }

  .card-body-shop {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    padding: 15px;
  }

  .card-title {
    font-size: 1.2rem;
    font-weight: bold;
    line-height: 1.4;
    height: 2rem;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    margin-bottom: 5px;
  }

  .card-price {
    font-size: 1rem;
    font-weight: bold;
    color: #FFA500;
    margin-bottom: 5px;
  }

  .card-text {
    flex-grow: 1;
    font-size: 0.9rem;
    line-height: 1.5;
    max-height: 5.5rem;
    overflow: hidden;
    word-break: break-word;
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    text-overflow: ellipsis;
    margin-bottom: 10px;
  }

  .card-body-shop2 {
    position: relative;
    display: flex;
    flex-direction: column;
    min-height: 100%;
  }

  .card-bottom {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    display: flex;
    gap: 8px;
    /* Jarak antar tombol */
    padding: 10px;
  }

  .card-bottom .btn {
    flex-grow: 1;
    /* Tombol Selengkapnya akan mengisi ruang tersisa */
    text-align: center;
    /* Pusatkan teks dalam tombol */
  }

  .card-bottom .btn-shop-wa {
    flex-shrink: 0;
    /* Mencegah tombol WA mengecil */
  }

  .card-shop {
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border-radius: 10px;
  }


  .card-shop:hover {
    transform: translateY(-5px) scale(1.03);
    box-shadow: 0 8px 12px rgba(255, 221, 0, 0.5);
  }

  .card-shop:hover img {
    transform: scale(1.05);
  }

  .card-shop img {
    transition: transform 0.2s ease;
    width: 100%;
  }
</style>

<div class="container mt-5">
  <h1 class="text-center mb-4" data-aos="fade-up" data-aos-duration="1000" style="margin-top: 8rem;">SHOP</h1>

  <!-- Form Pencarian -->
  <div class="mb-4 d-flex align-items-center">
    <input type="text" id="searchInput" class="form-control" placeholder="Cari produk">
    <i class="fas fa-search text-muted ms-2"></i>
  </div>

  <!-- Daftar shop -->
  <div class="row" id="shopList">
    <?php if (!empty($shop)) : ?>
      <?php foreach ($shop as $row) : ?>
        <div class="col-md-4 col-sm-6 mb-4 shop-item" data-aos="fade-up" data-aos-duration="300"
          data-title="<?= strtolower(esc($row['nama_produk'])); ?>"
          data-content="<?= strtolower(strip_tags($row['deskripsi_produk'])); ?>">
          <div class="card card-shop shadow-md border-1" style="min-height: 480px;">
            <?php if (!empty($row['gambar_produk'])) : ?>
              <img src="<?= base_url('uploads/shop/' . esc($row['gambar_produk'])); ?>"
                class="card-img-top img-fluid" style="height: 200px; object-fit: cover;"
                alt="<?= esc($row['nama_produk']); ?>">
            <?php else : ?>
              <img src="<?= base_url('uploads/default.jpg'); ?>" class="card-img-top" alt="No Image">
            <?php endif; ?>

            <div class="card-body-shop">
              <h5 class="card-title"><?= esc($row['nama_produk']); ?></h5>
              <p class="card-price"><?= esc($row['harga']); ?></p>
              <p class="card-text"><?= strip_tags($row['deskripsi_produk']); ?></p>
            </div>
            <div class="card-body-shop2">
              <div class="card-bottom">
                <a href="<?= base_url('/shop/' . esc($row['nama_produk'])); ?>" class="btn">Selengkapnya</a>
                <a target="_blank" href="<?= esc('https://api.whatsapp.com/send?phone=' . $kontak['no_hp'] . '&text=' . urlencode('Halo, saya tertarik dengan produk ' . $row['nama_produk'] . '. Apakah produk ini masih tersedia?')) ?>" class="btn-shop-wa">
                  <i class="fas fa-cart-arrow-down"></i>
                </a>
                <!-- <a target="_blank" href="<?= esc('https://api.whatsapp.com/send?phone=' .  esc($kontak['no_hp']) . '&text=' . urlencode('Halo, saya tertarik dengan produk ' . $row['nama_produk'] . '. Apakah produk ini masih tersedia?' . ('uploads/shop/' . $row['gambar_produk']))) ?>" class="btn-shop-wa">
                  <i class="fas fa-cart-arrow-down"></i>
                </a> -->

              </div>
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