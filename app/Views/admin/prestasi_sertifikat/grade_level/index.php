<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<style>
    .border-left-kelas {
        border-left: 4px solid #1cc88a !important;
    }

    .card {
        display: flex;
        flex-direction: column;
        height: 100%;
        /* Memastikan tinggi kartu penuh */
    }

    .card-body {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        /* Memastikan body kartu tumbuh memenuhi kartu */
    }

    .card-content {
        flex-grow: 1;
        /* Membantu mendorong footer ke bawah */
        display: flex;
        flex-direction: column;
    }

    .card-deck {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        height: min-content;
    }

    .container-card {
        margin-right: 1rem;
    }

    @media (max-width: 1200px) {
        .card-deck {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 992px) {
        .card-deck {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .card-deck {
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }

        .container-card {
            margin-right: 0;
        }
    }

    .card-content {
        font-size: 0.875rem;
        color: #555;
        margin-top: 1rem;
        margin-bottom: 1rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        z-index: 9;

    }

    .card-footer {
        display: flex;
        justify-content: flex-end;
        bottom: 0;
    }

    .card-text {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: normal;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        z-index: 9;
    }

    @media (max-width: 760px) {
        .d-flex {
            justify-content: flex-start;
            width: 100%;
        }

        .title {
            text-align: left;
        }
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        text-decoration: none;
    }

    .card a {
        text-decoration: none;
    }

    .card:hover a {
        text-decoration: none;
    }
</style>

<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between mb-3 title">
        <h1 class="h3 text-gray-800"><?= esc($title) ?></h1>
        <div class="d-flex align-items-center w-100 w-md-auto mt-3 mt-md-0" style="max-width: 320px;">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari kelas berdasarkan nama" style="flex-grow: 1;">
            <i class="fas fa-search text-muted" style="margin-left: 0.5rem;"></i>
        </div>
    </div>

    <!-- Show Flash Messages -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <!-- Card Grid for Displaying Classes -->
    <div class="container-card">
        <div class="card-deck">
            <?php if (!empty($classes)): ?>
                <?php foreach ($classes as $kelas): ?>
                    <div class="card border-left-kelas shadow mb-2">
                        <div class=" card-body shadow d-flex flex-column py-1">
                            <a href="<?= base_url('admin/manage_kelas/kelola_anggota/detail/' . esc($kelas['id'])); ?>" class="stretched-link">
                                <div class="card-grow card-content">
                                    <h4 class="card-title font-weight-bold"><?= esc($kelas['nama_kelas']); ?></h4>
                                    <h6 class="card-subtitle mb-2 text-muted"><?= esc($kelas['kode_kelas']); ?></h6>
                                    <p class="card-text"><?= esc($kelas['deskripsi']); ?></p>
                                </div>
                            </a>
                        </div>
                        <div class="card-footer p-0" style="background-color: white; justify-items:right; ">
                            <small class="text-muted" style="margin-right:1rem; margin-bottom:5px"><?= esc($kelas['jumlah_anggota'] ?? '0') ?> anggota</small>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-warning text-center">Tidak ada data kelas ditemukan</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    // Ambil elemen input pencarian dan kartu
    const searchInput = document.getElementById('searchInput');
    const cards = document.querySelectorAll('.card');

    // Fungsi untuk memfilter kelas
    searchInput.addEventListener('input', function() {
        const searchTerm = searchInput.value.toLowerCase();
        cards.forEach(function(card) {
            const className = card.querySelector('.card-title').textContent.toLowerCase();
            if (className.includes(searchTerm)) {
                card.style.removeProperty('display');
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>

<?= $this->endSection() ?>