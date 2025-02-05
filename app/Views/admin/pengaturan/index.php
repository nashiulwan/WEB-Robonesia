<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Pengaturan Website</h1>
    <p>Kelola pengaturan di Website disini.</p>

    <div class="row">
        <!-- Kontak -->
        <div class="col-md-4">
            <a href="<?= base_url('admin/pengaturan/kontak') ?>" class="card shadow text-decoration-none">
                <div class="card-body text-center">
                    <i class="fas fa-address-book fa-3x mb-2"></i>
                    <h5 class="card-title">Kontak</h5>
                    <p class="card-text">Atur informasi kontak perusahaan.</p>
                </div>
            </a>
        </div>

        <!-- Galeri -->
        <div class="col-md-4">
            <a href="<?= base_url('admin/pengaturan/galeri') ?>" class="card shadow text-decoration-none">
                <div class="card-body text-center">
                    <i class="fas fa-images fa-3x mb-2"></i>
                    <h5 class="card-title">Galeri</h5>
                    <p class="card-text">Kelola gambar dan foto dalam galeri.</p>
                </div>
            </a>
        </div>

        <!-- Mitra -->
        <div class="col-md-4">
            <a href="<?= base_url('admin/pengaturan/mitra') ?>" class="card shadow text-decoration-none">
                <div class="card-body text-center">
                    <i class="fas fa-handshake fa-3x mb-2"></i>
                    <h5 class="card-title">Mitra</h5>
                    <p class="card-text">Kelola daftar mitra kerja.</p>
                </div>
            </a>
        </div>

        <!-- Tim -->
        <div class="col-md-4 mt-3">
            <a href="<?= base_url('admin/pengaturan/tim') ?>" class="card shadow text-decoration-none">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x mb-2"></i>
                    <h5 class="card-title">Tim</h5>
                    <p class="card-text">Kelola anggota tim atau staf.</p>
                </div>
            </a>
        </div>

        <!-- Prestasi -->
        <div class="col-md-4 mt-3">
            <a href="<?= base_url('admin/pengaturan/prestasi') ?>" class="card shadow text-decoration-none">
                <div class="card-body text-center">
                    <i class="fas fa-trophy fa-3x mb-2"></i>
                    <h5 class="card-title">Prestasi</h5>
                    <p class="card-text">Kelola prestasi yang telah diraih.</p>
                </div>
            </a>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
