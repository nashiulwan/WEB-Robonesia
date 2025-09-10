<style>
    .content img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
    }

    /* Flex container untuk title dan button di sampingnya */
    .title-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Pastikan row memiliki item dengan tinggi sama */
    .row.align-items-stretch {
        display: flex;
        align-items: stretch;
    }

    /* Ubah kolom sidebar menjadi flex container dengan arah kolom 
       dan pastikan bisa mengecil dengan menambahkan min-height: 0 */
    .col-md-4 {
        display: flex;
        flex-direction: column;
        min-height: 0;
        /* Penting untuk overflow */
    }

    /* Sidebar container mengisi seluruh tinggi kolom dan jika kontennya melebihi, muncul scrollbar.
       min-height: 0 juga diperlukan agar properti overflow berfungsi dengan benar. */
    .sidebar-container {
        flex: 1;
        min-height: 0;
        /* Penting untuk overflow */
        overflow-y: auto;
    }

    .btn-shop-produk {
        display: inline-block;
        background-color: var(--color-green);
        color: var(--black);
        font-size: 1rem;
        padding: 1rem 2rem;
        border: 2px solid transparent;
        font-weight: 500;
        transition: var(--transition);
    }

    .btn-shop-produk:hover {
        background: transparent;
        border-color: var(--color-green);
    }

    .product-price {
        font-size: 1.3rem;
        display: inline-block;
    }
    
    @media(max-width:500px){
         .atas-btn{
           display: none;
         }
    }
</style>

<?php
function convertOembedToIframe($content)
{
    return str_replace('[embed]', '<iframe>', str_replace('[/embed]', '</iframe>', $content));
}
?>
<div class="container mt-5">
    <div class="row align-items-stretch" style="margin-top: 8rem;">
        <!-- Konten Utama -->
        <div class="col-md-8">
            <div class="title-container">
                <h1 class="mb-4"><?= esc($produk['nama_produk']) ?></h1>
                <!-- Button di sebelah kanan title -->
                <a target="_blank" href="<?= esc('https://api.whatsapp.com/send?phone=' .  esc($kontak['no_hp']) . '&text=' . urlencode('Halo, saya tertarik dengan produk ' . $produk['nama_produk'] . '. Apakah produk ini masih tersedia?' . base_url('shop/' . $produk['nama_produk']))) ?>" class="btn btn-shop-produk atas-btn">
                    <i class="fas fa-cart-arrow-down"></i>
                </a>
            </div>
            <?php if (!empty($produk['gambar_produk'])) : ?>
                <img src="<?= base_url('uploads/shop/' . esc($produk['gambar_produk'])) ?>" alt="Gambar Produk" class="img-fluid mb-4">
            <?php endif; ?>

            <p class="product-price"><strong><?= esc($produk['harga']) ?></strong></p>

            <div class="content lh-lg">
                <?= convertOembedToIframe(html_entity_decode($produk['deskripsi_produk'])) ?>
            </div>

            <a href="<?= base_url('shop') ?>" class="btn btn-secondary mt-3 mb-5" data-aos="fade-up" data-aos-duration="500">Kembali ke Shop</a>
            <a target="_blank" class="btn btn-shop-produk mt-3 mb-5 mx-2" data-aos="fade-up" data-aos-duration="500" href="<?= esc('https://api.whatsapp.com/send?phone=' . $kontak['no_hp'] . '&text=' . urlencode('Halo, saya tertarik dengan produk ' . $produk['nama_produk'] . '. Apakah produk ini masih tersedia?' . base_url('shop/' . $produk['nama_produk']))) ?>">
                <i class="fas fa-cart-arrow-down"></i>
            </a>
        </div>

        <!-- Sidebar Produk Lainnya -->
        <div class="col-md-4">
            <div class="bg-light p-4 rounded sidebar-container" data-aos="fade-left" data-aos-duration="1000">
                <h4 class="mb-3">Produk Lainnya</h4>
                <ul class="list-unstyled">
                    <?php if (!empty($produkLainnya)) : ?>
                        <?php foreach ($produkLainnya as $item) : ?>
                            <li class="mb-4">
                                <?php if (!empty($item['gambar_produk'])) : ?>
                                    <img src="<?= base_url('uploads/shop/' . esc($item['gambar_produk'])) ?>" alt="Gambar Produk" style="height: 150px; object-fit: cover; width: 100%;">
                                <?php endif; ?>
                                <a href="<?= base_url('/shop/' . esc($item['nama_produk'])) ?>" class="text-decoration-none text-dark">
                                    <?= esc($item['nama_produk']) ?>
                                </a>
                                <p><?= esc($item['harga']) ?></p>
                            </li>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <li>Tidak ada produk lainnya.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>