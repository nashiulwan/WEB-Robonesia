<?= $this->extend('siswa/templates/dashboard'); ?>

<?= $this->section('page-content'); ?>
<div class="container mt-5">
    <h2 class="text-center fw-bold">Sertifikat Saya</h2>

    <!-- Sertifikat berdasarkan akun -->
    <div class="mt-4">
        <h4 class="fw-bold">Individu</h4>
        <div class="row">
            <?php if (!empty($sertifikatUser)) : ?>
                <?php foreach ($sertifikatUser as $sertifikat) : ?>
                    <div class="col-md-6">
                        <div class="card shadow-lg p-4 mb-3">
                            <h5 class="fw-bold">Sertifikat</h5>
                            <p class="text-muted"><?= esc($sertifikat['deskripsi']); ?></p>

                            <?php 
                                $fileNames = json_decode($sertifikat['nama_file'], true);
                                if (!is_array($fileNames)) {
                                    $fileNames = [$sertifikat['nama_file']];
                                }
                            ?>

                            <?php foreach ($fileNames as $fileName) : ?>
                                <button type="button" class="btn btn-warning mt-2" data-bs-toggle="modal" data-bs-target="#modalPreview" data-file="<?= base_url('uploads/sertifikat/' . urlencode($fileName)); ?>">
                                    Lihat Sertifikat
                                </button>
                                <a href="<?= base_url('uploads/sertifikat/' . urlencode($fileName)); ?>" class="btn btn-success mt-2" target="_blank">Download</a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-muted">Tidak ada sertifikat berdasarkan akun.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Sertifikat berdasarkan prestasi -->
    <div class="mt-5">
        <h4 class="fw-bold">Prestasi</h4>
        <?php if (!empty($sertifikatPrestasi)) : ?>
            <?php foreach ($sertifikatPrestasi as $prestasi => $sertifikats) : ?>
                <h5 class="text-primary"><?= esc($prestasi); ?></h5>
                <div class="row">
                    <?php foreach ($sertifikats as $sertifikat) : ?>
                        <div class="col-md-6">
                            <div class="card shadow-lg p-4 mb-3">
                                <h5 class="fw-bold">Sertifikat</h5>
                                <p class="text-muted"><?= esc($sertifikat['deskripsi']); ?></p>

                                <?php 
                                    $fileNames = json_decode($sertifikat['nama_file'], true);
                                    if (!is_array($fileNames)) {
                                        $fileNames = [$sertifikat['nama_file']];
                                    }
                                ?>

                                <?php foreach ($fileNames as $fileName) : ?>
                                    <button type="button" class="btn btn-warning mt-2" data-bs-toggle="modal" data-bs-target="#modalPreview" data-file="<?= base_url('uploads/sertifikat/' . urlencode($fileName)); ?>">
                                        Lihat Sertifikat
                                    </button>
                                    <a href="<?= base_url('uploads/sertifikat/' . urlencode($fileName)); ?>" class="btn btn-success mt-2" target="_blank">Download</a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="text-muted">Tidak ada sertifikat berdasarkan prestasi.</p>
        <?php endif; ?>
    </div>

    <!-- Sertifikat berdasarkan kelas -->
    <div class="mt-5">
        <h4 class="fw-bold">Kelas</h4>
        <?php if (!empty($sertifikatKelas)) : ?>
            <?php foreach ($sertifikatKelas as $kelas => $sertifikats) : ?>
                <h5 class="text-success"><?= esc($kelas); ?></h5>
                <div class="row">
                    <?php foreach ($sertifikats as $sertifikat) : ?>
                        <div class="col-md-6">
                            <div class="card shadow-lg p-4 mb-3">
                                <h5 class="fw-bold">Sertifikat</h5>
                                <p class="text-muted"><?= esc($sertifikat['deskripsi']); ?></p>

                                <?php 
                                    $fileNames = json_decode($sertifikat['nama_file'], true);
                                    if (!is_array($fileNames)) {
                                        $fileNames = [$sertifikat['nama_file']];
                                    }
                                ?>

                                <?php foreach ($fileNames as $fileName) : ?>
                                    <button type="button" class="btn btn-warning mt-2" data-bs-toggle="modal" data-bs-target="#modalPreview" data-file="<?= base_url('uploads/sertifikat/' . urlencode($fileName)); ?>">
                                        Lihat Sertifikat
                                    </button>
                                    <a href="<?= base_url('uploads/sertifikat/' . urlencode($fileName)); ?>" class="btn btn-success mt-2" target="_blank">Download</a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="text-muted">Tidak ada sertifikat berdasarkan kelas.</p>
        <?php endif; ?>
    </div>

    <!-- Modal Preview Sertifikat -->
    <div class="modal fade" id="modalPreview" tabindex="-1" aria-labelledby="modalPreviewLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPreviewLabel">Preview Sertifikat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <embed id="sertifikatPreview" src="" width="100%" height="500px"></embed>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var modalPreview = document.getElementById('modalPreview');
        modalPreview.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var fileUrl = button.getAttribute('data-file');
            document.getElementById('sertifikatPreview').src = fileUrl;
        });
    });
</script>

<?= $this->endSection(); ?>
