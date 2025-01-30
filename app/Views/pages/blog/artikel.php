
<div class="container mt-5">
    <h1 class="mb-4"><?= esc($artikel['judul']) ?></h1>
    <p><strong>Kategori:</strong> <?= esc($artikel['kategori']) ?></p>
    <p><strong>Diposting pada:</strong> <?= esc($artikel['created_at']) ?></p>

    <?php if (!empty($artikel['gambar'])) : ?>
        <img src="<?= base_url('uploads/' . esc($artikel['gambar'])) ?>" alt="Gambar Artikel" class="img-fluid mb-4">
    <?php endif; ?>

    <div class="content">
        <?= esc($artikel['konten']) ?>
    </div>
    
    <a href="<?= base_url('blog') ?>" class="btn btn-secondary mt-3">Kembali ke Blog</a>
</div>
