<?= $this->extend('siswa/templates/dashboard'); ?>

<?= $this->section('page-content'); ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Galeri Kegiatan</h2>

    <!-- Looping Level -->
    <?php if (!empty($galeri)) : ?>
        <?php foreach ($galeri as $level => $subLevels) : ?>
            <div class="mb-3">
                <button class="btn bg-primary bg-success w-100 text-start level-toggle" data-bs-toggle="collapse" data-bs-target="#level-<?= esc($level); ?>" style="color: white;">
                    📁 Level <?= esc($level); ?>
                </button>

                <div id="level-<?= esc($level); ?>" class="collapse mt-2">
                    <!-- Looping Sub-Level -->
                    <?php foreach ($subLevels as $subLevel => $images) : ?>
                        <div class="mb-2">
                            <button class="btn btn-secondary bg-warning w-100 text-start sublevel-toggle" data-bs-toggle="collapse" data-bs-target="#sublevel-<?= esc($level) . '-' . esc($subLevel); ?>">
                                📂 <?= esc($subLevel ?: 'Tanpa Sub-Level'); ?>
                            </button>

                            <div id="sublevel-<?= esc($level) . '-' . esc($subLevel); ?>" class="collapse mt-2">
                                <!-- Swiper Gallery -->
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        <?php foreach ($images as $image) : ?>
                                            <?php 
                                                $imgPath = base_url('uploads/galeri/' . esc($image['gambar'])); 
                                                $imgTitle = esc($image['judul']);
                                                $imgDesc = esc($image['deskripsi']);
                                            ?>
                                            <div class="swiper-slide">
                                                <img src="<?= $imgPath; ?>" class="img-fluid rounded shadow preview-image"
                                                    data-img="<?= $imgPath; ?>" 
                                                    data-title="<?= $imgTitle; ?>" 
                                                    data-desc="<?= $imgDesc; ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <a href="<?= base_url('siswa/galeri/detail/' . esc($level) . '/' . esc($subLevel)); ?>" class="btn bg-success mt-2" style="color: white;">Lihat Selengkapnya →</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p class="text-center">Belum ada foto yang diunggah.</p>
    <?php endif; ?>
</div>

<!-- Modal Preview Gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="imageTitle">Judul Gambar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid rounded">
                <p class="mt-2 text-muted" id="imageDescription">Deskripsi gambar...</p>
            </div>
            <div class="modal-footer">
                <a id="downloadButton" class="btn btn-success" download>Simpan</a>
            </div>
        </div>
    </div>
</div>

<!-- SwiperJS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let openDropdowns = [];

    document.querySelectorAll(".swiper-container").forEach(swiper => {
        new Swiper(swiper, {
            slidesPerView: 3,
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            
            breakpoints: {
                640: { slidesPerView: 2 },
                768: { slidesPerView: 3 },
                1024: { slidesPerView: 3 }
            }
        });
    });

    document.querySelectorAll(".preview-image").forEach(img => {
        img.addEventListener("click", function() {
            let imgSrc = this.getAttribute("data-img");
            let imgTitle = this.getAttribute("data-title");
            let imgDesc = this.getAttribute("data-desc");

            document.getElementById("modalImage").src = imgSrc;
            document.getElementById("downloadButton").href = imgSrc;
            document.getElementById("downloadButton").setAttribute("download", imgSrc.split('/').pop());
            document.getElementById("imageTitle").textContent = imgTitle;
            document.getElementById("imageDescription").textContent = imgDesc;

            openDropdowns = [...document.querySelectorAll(".collapse.show")].map(el => el.id);
            new bootstrap.Modal(document.getElementById("imageModal")).show();
        });
    });

    document.getElementById("imageModal").addEventListener("hidden.bs.modal", function() {
        openDropdowns.forEach(id => {
            let element = document.getElementById(id);
            if (element) {
                new bootstrap.Collapse(element, { toggle: false }).show();
            }
        });
    });

    document.querySelectorAll(".level-toggle, .sublevel-toggle").forEach(button => {
        button.addEventListener("click", function(event) {
            let targetId = this.getAttribute("data-bs-target");
            let targetElement = document.querySelector(targetId);
            if (targetElement.classList.contains("show")) {
                new bootstrap.Collapse(targetElement, { toggle: false }).hide();
            } else {
                new bootstrap.Collapse(targetElement, { toggle: false }).show();
            }
            event.stopPropagation();
        });
    });    

    document.addEventListener("click", function(event) {
        let clickedElement = event.target;
        let isInsideDropdown = clickedElement.closest(".collapse");
        let isToggleButton = clickedElement.matches("[data-bs-toggle='collapse']");
        
        if (!isInsideDropdown && !isToggleButton) {
            document.querySelectorAll(".collapse.show").forEach(collapse => {
                new bootstrap.Collapse(collapse, { toggle: false }).hide();
            });
        }
    });
});
</script>

<?= $this->endSection(); ?>
