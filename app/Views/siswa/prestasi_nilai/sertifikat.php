<?= $this->extend('siswa/templates/dashboard'); ?>

<?= $this->section('page-content'); ?>
<style>
/* Custom Modal Size */
#previewModal .modal-dialog {
  max-width: 90vw;
  width: 90vw;
}

#previewModal .modal-content {
  height: 95vh;
}

#pdfPreview {
  width: 100%;
  height: calc(100% - 60px);
  overflow: auto;
  position: relative;
}

#pdfCanvas {
  width: 100% !important;
  height: auto !important;
  max-width: 100%;
}

.zoom-controls {
  position: absolute;
  top: 10px;
  right: 10px;
  z-index: 1000;
  background: rgba(255, 255, 255, 0.8);
  padding: 5px;
  border-radius: 5px;
}

@media (max-width: 768px) {
  #previewModal .modal-dialog {
    max-width: 95vw;
    width: 95vw;
    height: 90vh;
  }
  #previewModal .modal-content {
  height: 90vh;
}
  #pdfPreview {
    height: calc(80vh - 120px);
  }
}

.nav-tabs .nav-link {
    color: #6c757d !important; 
}

.nav-tabs .nav-link.active {
    color: #000000 !important; 
}

</style>

<div class="container mt-5">
        <h2 class="text-center fw-bold mb-4">Sertifikat Saya</h2>

       <!-- Modal Preview -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">Preview Sertifikat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-0">
                    <div id="pdfPreview" style="display: none;">
                        <div class="zoom-controls" style="display:none">
                            <button class="btn btn-sm btn-primary zoom-in">+</button>
                            <button class="btn btn-sm btn-secondary reset-zoom">100%</button>
                            <button class="btn btn-sm btn-primary zoom-out">-</button>
                        </div>
                        <canvas id="pdfCanvas"></canvas>
                    </div>
                    <iframe id="pdfFrame" style="display: none; width: 100%; height: 100%; border: none;"></iframe>
                    <img id="imagePreview" src="" alt="Preview Gambar" style="display: none; max-width: 100%;">
                </div>
                <div class="modal-footer" style="max-height:4rem">
                    <a id="downloadBtn" href="#" target="_blank" class="btn btn-success" style="display: none;">
                        <i class="fas fa-download"></i> Download
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
     
<!-- Nav Tabs -->
    <ul class="nav nav-tabs mb-3" id="sertifikatTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="individu-tab" data-bs-toggle="tab" data-bs-target="#individu" type="button" role="tab" aria-controls="individu" aria-selected="true">
                Individu
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="prestasi-tab" data-bs-toggle="tab" data-bs-target="#prestasi" type="button" role="tab" aria-controls="prestasi" aria-selected="false">
                Prestasi
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="kelas-tab" data-bs-toggle="tab" data-bs-target="#kelas" type="button" role="tab" aria-controls="kelas" aria-selected="false">
                Kelas
            </button>
        </li>
    </ul>
    <!-- Sertifikat berdasarkan akun -->
<div class="tab-content">
      <div class="tab-pane fade show active" id="individu" role="tabpanel" aria-labelledby="individu-tab">
     <div class="mb-3">
        <h4 class="fw-bold">Individu</h4>
        <div class="row">
            <?php if (!empty($sertifikatUser)) : ?>
                <?php foreach ($sertifikatUser as $sertifikat) : ?>
                    <div class="col-md-6">
                        <div class="card shadow-lg p-4 mb-3">
                             <div class="d-flex justify-content-between">
                                 <h5 class="fw-bold"><?= esc($sertifikat['judul'] ?? 'Sertifikat') ?></h5>
                                 
                             </div>
                            
                            <p class="text-muted"><?= esc($sertifikat['deskripsi']); ?></p>

                            <?php 
                                $fileNames = json_decode($sertifikat['nama_file'], true) ?? [$sertifikat['nama_file']];
                            ?>

                            <?php foreach ($fileNames as $fileName) : 
                                $fileUrl = base_url('uploads/sertifikat/' . urlencode($fileName));
                                $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                            ?>
<div class="d-flex gap-3 w-100 mt-2">
    <button class="btn btn-warning preview-btn flex-grow-1" 
        data-file-url="<?= $fileUrl ?>"
        data-file-type="<?= $fileExt ?>">
        <i class="fas fa-eye"></i> Lihat
    </button>
    <a href="<?= $fileUrl ?>" class="btn btn-success flex-grow-1" download>
        <i class="fas fa-download"></i> Download
    </a>
</div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-muted">Tidak ada sertifikat berdasarkan akun.</p>
            <?php endif; ?>
        </div>
    </div></div>

    <!-- Sertifikat berdasarkan prestasi -->
            <div class="tab-pane fade" id="prestasi" role="tabpanel" aria-labelledby="prestasi-tab">

    <div class="mb-3">
        <h4 class="fw-bold">Prestasi</h4>
        <?php if (!empty($sertifikatPrestasi)) : ?>
            <?php foreach ($sertifikatPrestasi as $prestasi => $sertifikats) : ?>
                <h5 class="text-primary"><?= esc($prestasi); ?></h5>
                <div class="row">
                    <?php foreach ($sertifikats as $sertifikat) : ?>
                        <div class="col-md-6">
                            <div class="card shadow-lg p-4 mb-3">
                                <div class="d-flex justify-content-between">
                                 <h5 class="fw-bold"><?= esc($sertifikat['judul'] ?? 'Sertifikat') ?></h5>
                                 
                             </div>
                                <p class="text-muted"><?= esc($sertifikat['deskripsi']); ?></p>

                                <?php 
                                    $fileNames = json_decode($sertifikat['nama_file'], true) ?? [$sertifikat['nama_file']];
                                ?>

                                <?php foreach ($fileNames as $fileName) : 
                                    $fileUrl = base_url('uploads/sertifikat/' . urlencode($fileName));
                                    $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                                ?>
<div class="d-flex gap-3 w-100 mt-2">
    <button class="btn btn-warning preview-btn flex-grow-1" 
        data-file-url="<?= $fileUrl ?>"
        data-file-type="<?= $fileExt ?>">
        <i class="fas fa-eye"></i> Lihat
    </button>
    <a href="<?= $fileUrl ?>" class="btn btn-success flex-grow-1" download>
        <i class="fas fa-download"></i> Download
    </a>
</div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="text-muted">Tidak ada sertifikat berdasarkan prestasi.</p>
        <?php endif; ?>
    </div></div>

    <!-- Sertifikat Berdasarkan Kelas -->
            <div class="tab-pane fade" id="kelas" role="tabpanel" aria-labelledby="kelas-tab">

    <div class="mt-5">
        <h4 class="fw-bold">Kelas</h4>
        <?php if (!empty($sertifikatKelas)) : ?>
            <?php foreach ($sertifikatKelas as $kelas => $sertifikats) : ?>
                <h5 class="text-success"><?= esc($kelas); ?></h5>
                <div class="row">
                    <?php foreach ($sertifikats as $sertifikat) : ?>
                        <div class="col-md-6">
                            <div class="card shadow-lg p-4 mb-3">
                              <div class="d-flex justify-content-between">
                                 <h5 class="fw-bold"><?= esc($sertifikat['judul'] ?? 'Sertifikat') ?></h5>
                                 
                             </div>
                                <p class="text-muted"><?= esc($sertifikat['deskripsi']); ?></p>
                                
                                <?php 
                                    $fileNames = $sertifikat['nama_file'] ?? [];
                                    if (!is_array($fileNames)) {
                                        $fileNames = [$fileNames];
                                    }
                                ?>

                                <?php foreach ($fileNames as $fileName) : 
                                    $fileUrl = base_url('uploads/sertifikat/' . urlencode($fileName));
                                    $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                                ?>
<div class="d-flex gap-3 w-100 mt-2">
    <button class="btn btn-warning preview-btn flex-grow-1" 
        data-file-url="<?= $fileUrl ?>"
        data-file-type="<?= $fileExt ?>">
        <i class="fas fa-eye"></i> Lihat
    </button>
    <a href="<?= $fileUrl ?>" class="btn btn-success flex-grow-1" download>
        <i class="fas fa-download"></i> Download
    </a>
</div>
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
    </div>
</div>
   
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPdf = null;
    let currentScale = 1;
    const maxScale = 3;
    const minScale = 0.5;
    
    // Zoom handlers
    document.querySelector('.zoom-in').addEventListener('click', () => adjustZoom(0.2));
    document.querySelector('.zoom-out').addEventListener('click', () => adjustZoom(-0.2));
    document.querySelector('.reset-zoom').addEventListener('click', () => resetZoom());

    function adjustZoom(amount) {
        currentScale = Math.min(maxScale, Math.max(minScale, currentScale + amount));
        renderPage(currentScale);
    }

    function resetZoom() {
        currentScale = 1;
        renderPage(currentScale);
    }

    async function renderPage(scale) {
        const canvas = document.getElementById('pdfCanvas');
        const page = await currentPdf.getPage(1);
        const viewport = page.getViewport({ scale: scale });
        
        canvas.height = viewport.height;
        canvas.width = viewport.width;
        
        const context = canvas.getContext('2d');
        await page.render({
            canvasContext: context,
            viewport: viewport
        }).promise;
    }

    document.querySelectorAll('.preview-btn').forEach(button => {
        button.addEventListener('click', async function() {
            const fileUrl = this.dataset.fileUrl;
            const fileType = this.dataset.fileType.toLowerCase();
            const modal = new bootstrap.Modal(document.getElementById('previewModal'));
            
            // Reset tampilan
            document.getElementById('pdfPreview').style.display = 'none';
            document.getElementById('pdfFrame').style.display = 'none';
            document.getElementById('imagePreview').style.display = 'none';

            if (fileType === 'pdf') {
                const isMobile = window.innerWidth <= 768;
                
                if(isMobile) {
                    // Render dengan PDF.js + zoom
                    document.getElementById('pdfPreview').style.display = 'block';
                    try {
                        currentPdf = await pdfjsLib.getDocument(fileUrl).promise;
                        currentScale = 1;
                        await renderPage(currentScale);
                    } catch(error) {
                        console.error('Error loading PDF:', error);
                        alert('Gagal memuat PDF!');
                    }
                } else {
                    // Desktop: Gunakan iframe dengan fitur zoom browser
                    document.getElementById('pdfFrame').style.display = 'block';
                    document.getElementById('pdfFrame').src = `${fileUrl}#view=FitH&zoom=100`;
                }
            } 
            else if (['jpg', 'jpeg', 'png', 'gif'].includes(fileType)) {
                document.getElementById('imagePreview').src = fileUrl;
                document.getElementById('imagePreview').style.display = 'block';
            }
            
            document.getElementById('downloadBtn').href = fileUrl;
            modal.show();
        });
    });
});
</script>

<?= $this->endSection(); ?>