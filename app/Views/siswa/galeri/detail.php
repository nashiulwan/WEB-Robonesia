<?= $this->extend('siswa/templates/dashboard'); ?>

<?= $this->section('page-content'); ?>

<div class="container mt-4">
    <h2 class="text-center mb-4 fw-bold">
        <?= esc($subLevel ? "Sublevel $subLevel" : "Level $level"); ?>
    </h2>

    <div class="container">
        <div class="row">
            <?php foreach ($galeri as $g) : ?>
                <?php 
                    $imgPath = base_url('uploads/galeri/' . esc($g['gambar'])); 
                    $imgTitle = esc($g['judul']);
                    $imgDesc = esc($g['deskripsi']);
                ?>
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="card shadow-lg">
                        <img src="<?= $imgPath; ?>" class="card-img-top preview-image"
                            data-img="<?= $imgPath; ?>" 
                            data-title="<?= $imgTitle; ?>" 
                            data-desc="<?= $imgDesc; ?>">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Modal Preview Gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageTitle">Judul Gambar</h5>
                <button type="button" class="btn-close close-modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid rounded">
                <p class="mt-2 text-muted" id="imageDescription">Deskripsi gambar...</p>
            </div>
            <div class="modal-footer">
                <a id="downloadButton" class="btn btn-success" download>⬇ Download</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let previousDropdownState = {};

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

            // Simpan state dropdown sebelum modal dibuka
            document.querySelectorAll(".dropdown-menu").forEach((menu, index) => {
                previousDropdownState[index] = menu.classList.contains("show");
            });

            new bootstrap.Modal(document.getElementById("imageModal")).show();
        });
    });

    document.querySelectorAll(".close-modal").forEach(button => {
        button.addEventListener("click", function() {
            let modal = bootstrap.Modal.getInstance(document.getElementById("imageModal"));
            modal.hide();

            // Kembalikan state dropdown setelah modal ditutup
            document.querySelectorAll(".dropdown-menu").forEach((menu, index) => {
                if (previousDropdownState[index]) {
                    menu.classList.add("show");
                } else {
                    menu.classList.remove("show");
                }
            });
        });
    });
});
</script>

<?= $this->endSection(); ?>
