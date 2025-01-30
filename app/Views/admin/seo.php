<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
    
    <!-- Pengaturan Umum -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pengaturan SEO</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/seo/simpan'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="meta_title">Meta Title:</label>
                    <input type="text" class="form-control" id="meta_title" name="meta_title" value="<?= $meta_title ?? '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="meta_description">Meta Description:</label>
                    <input type="text" class="form-control" id="meta_description" name="meta_description" value="<?= $meta_description ?? '' ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>