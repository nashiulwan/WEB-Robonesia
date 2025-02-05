<div class="container mt-5">
    <div class="row">
        <!-- Konten Utama -->
        <div class="col-md-8">
            <h1 class="mb-4"><?= esc($artikel['judul']) ?></h1>
            <p><strong>Kategori:</strong> <?= esc($artikel['kategori']) ?></p>
            <p><strong>Diposting pada:</strong> <?= esc($artikel['created_at']) ?></p>

            <?php if (!empty($artikel['gambar'])) : ?>
                <img src="<?= base_url('uploads/' . esc($artikel['gambar'])) ?>" alt="Gambar Artikel" class="img-fluid mb-4">
            <?php endif; ?>

            <div class="content">
                <?= esc($artikel['konten']) ?>
            </div>

            <a href="<?= base_url('blog') ?>" class="btn btn-secondary mt-3 mb-5">Kembali ke Blog</a>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <div class="bg-light p-4 rounded">
                <!-- Daftar Artikel Terbaru -->
                <h4 class="mb-3">Artikel Terbaru</h4>
                <ul class="list-unstyled">
                    <?php if (!empty($artikel_terbaru)) : ?>
                        <?php foreach ($artikel_terbaru as $artikel) : ?>
                            <li class="mb-2">
                                <a href="<?= base_url('blog/' . esc($artikel['slug'])) ?>" class="text-decoration-none text-dark">
                                    <?= esc($artikel['judul']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <li>Tidak ada artikel terbaru.</li>
                    <?php endif; ?>
                </ul>

                <!-- Daftar Kategori -->
                <h4 class="mt-4 mb-3">Kategori</h4>
                <ul class="list-unstyled">
                    <?php if (!empty($kategori)) : ?>
                        <?php foreach ($kategori as $kat) : ?>
                            <li class="mb-2">
                                <a href="<?= base_url('blog/kategori/' . esc($kat['slug'])) ?>" class="text-decoration-none text-dark">
                                    <?= esc($kat['nama_kategori']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <li>Tidak ada kategori.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>