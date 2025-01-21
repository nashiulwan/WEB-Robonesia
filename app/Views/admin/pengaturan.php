<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
    
    <!-- Pengaturan Umum -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pengaturan Umum</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/pengaturan/simpan'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="site_name">Nama Situs</label>
                    <input type="text" class="form-control" id="site_name" name="site_name" value="<?= $site_name ?? 'Robonesia' ?>" required>
                </div>
                <div class="form-group">
                    <label for="site_email">Email Situs</label>
                    <input type="email" class="form-control" id="site_email" name="site_email" value="<?= $site_email ?? 'info@robonesia.com' ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>