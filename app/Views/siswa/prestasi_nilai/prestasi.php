<?= $this->extend('siswa/templates/dashboard'); ?>

<?= $this->section('page-content'); ?>

<div class="container mt-5">
    <h2 class="text-center mb-5"><i class="fas fa-trophy text-warning"></i> Prestasi Saya</h2>

    <?php if (empty($prestasi)) : ?>
        <div class="alert alert-warning text-center fs-4" role="alert">
            <i class="fas fa-exclamation-circle"></i> Belum ada prestasi yang tercatat.
        </div>
    <?php else : ?>
        <div class="row">
            <?php foreach ($prestasi as $p) : ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-4">
                            <h4 class="card-title fw-bold px-2">
                                <i class="fas fa-medal text-success"></i> <?= esc($p['nama_kegiatan']); ?>
                            </h4>
                            <div class="mb-2">
                                <span class="badge bg-primary fs-6"><i class="fas fa-tag"></i> <?= esc($p['jenis']); ?></span>
                                <span class="badge bg-secondary fs-6"><i class="fas fa-globe"></i> <?= esc($p['tingkat']); ?></span>
                            </div>
                            <p class="fs-5 mb-1 px-2"><i class="fas fa-calendar-alt"></i> <strong>Tahun :</strong> <?= esc($p['tahun']); ?></p>
                            <p class="fs-5 mb-0 px-2"><i class="fas fa-award text-warning"></i> <strong>Pencapaian :</strong> <?= esc($p['pencapaian']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>
