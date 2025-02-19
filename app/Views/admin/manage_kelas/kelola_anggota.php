<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<style>
    .card-deck {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1rem;
    }

    .container-card {
        margin-right: 1rem;
    }

    .card {
        display: flex;
        flex-direction: column;
        padding: 5px;
        position: relative;
        overflow: hidden;
        background-color: #f8f9fc;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        height: 200px;
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

    .card-body {
        font-size: 0.875rem;
        color: #555;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        z-index: 9;
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

    .card-footer {
        border: none;
        position: absolute;
        bottom: 10px;
        right: 10px;
        color: black;
        font-size: 0.75rem;
        padding: 5px 10px;
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

    .wave-top {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        margin-top: -15px;
        width: 100%;
        height: auto;
        transition: all 0.3s ease-in-out;
        z-index: 0;
    }

    .wave {
        position: absolute;
        bottom: 0;
        width: 110%;
        height: auto;
        transition: all 0.3s ease-in-out;
        z-index: 0;
        margin-left: -10px;
        margin-right: -10px;
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
            <?php if (!empty($classes)) : ?>
                <?php
                $i = 0;
                // Array definisi warna gradient (sesuai urutan yang diinginkan)
                $gradients = [
                    ['start' => '#25D366', 'end' => '#ffdd00'],
                    ['start' => '#33cccc', 'end' => '#ffdd00'],
                    ['start' => '#33cccc', 'end' => '#25D366'],
                    ['start' => '#ffdd00', 'end' => '#33cccc'],
                    ['start' => '#25D366', 'end' => '#33cccc'],
                    ['start' => '#ffdd00', 'end' => '#25D366']
                ];
                ?>
                <?php foreach ($classes as $row) : ?>
                    <?php
                    $gradientIndex = $i % count($gradients);
                    $startColor = $gradients[$gradientIndex]['start'];
                    $endColor   = $gradients[$gradientIndex]['end'];
                    $uniqueId   = esc($row['id']);
                    // Buat ID gradient yang unik untuk tiap kartu
                    $gradientId = "sw-gradient-{$gradientIndex}-{$uniqueId}";
                    ?>
                    <div class="card shadow mb-4">
                        <!-- SVG Gelombang Atas (Top Wave) -->
                        <svg class="wave-top" style="transform:rotate(180deg); transition: 0.3s" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="<?= $gradientId ?>" x1="0" x2="0" y1="1" y2="0">
                                    <stop stop-color="<?= $startColor ?>" offset="0%"></stop>
                                    <stop stop-color="<?= $endColor ?>" offset="100%"></stop>
                                </linearGradient>
                            </defs>
                            <path style="transform:translate(0, 0px); opacity:1" fill="url(#<?= $gradientId ?>)" d="M0,13L48,21.7C96,30,192,48,288,60.7C384,74,480,82,576,88.8C672,95,768,100,864,99.7C960,100,1056,95,1152,88.8C1248,82,1344,74,1440,60.7C1536,48,1632,30,1728,28.2C1824,26,1920,39,2016,41.2C2112,43,2208,35,2304,36.8C2400,39,2496,52,2592,65C2688,78,2784,91,2880,93.2C2976,95,3072,87,3168,73.7C3264,61,3360,43,3456,41.2C3552,39,3648,52,3744,62.8C3840,74,3936,82,4032,91C4128,100,4224,108,4320,93.2C4416,78,4512,39,4608,36.8C4704,35,4800,69,4896,78C4992,87,5088,69,5184,71.5C5280,74,5376,95,5472,106.2C5568,117,5664,117,5760,117C5856,117,5952,117,6048,106.2C6144,95,6240,74,6336,60.7C6432,48,6528,43,6624,43.3C6720,43,6816,48,6864,49.8L6912,52L6912,130L6864,130C6816,130,6720,130,6624,130C6528,130,6432,130,6336,130C6240,130,6144,130,6048,130C5952,130,5856,130,5760,130C5664,130,5568,130,5472,130C5376,130,5280,130,5184,130C5088,130,4992,130,4896,130C4800,130,4704,130,4608,130C4512,130,4416,130,4320,130C4224,130,4128,130,4032,130C3936,130,3840,130,3744,130C3648,130,3552,130,3456,130C3360,130,3264,130,3168,130C3072,130,2976,130,2880,130C2784,130,2688,130,2592,130C2496,130,2400,130,2304,130C2208,130,2112,130,2016,130C1920,130,1824,130,1728,130C1632,130,1536,130,1440,130C1344,130,1248,130,1152,130C1056,130,960,130,864,130C768,130,672,130,576,130C480,130,384,130,288,130C192,130,96,130,48,130L0,130Z"></path>
                        </svg>
                        <a href="<?= base_url('admin/manage_kelas/kelola_anggota/detail/' . esc($row['id'])); ?>" class="stretched-link">
                            <div class="card-body">
                                <h4 class="card-title font-weight-bold"><?= esc($row['nama_kelas']); ?></h4>
                                <h6 class="card-subtitle mb-2 text-muted"><?= esc($row['kode_kelas']); ?></h6>
                                <p class="card-text"><?= esc($row['deskripsi']); ?></p>
                            </div>
                            <div class="card-footer">
                                <span><?= esc($row['jumlah_anggota']); ?> anggota</span>
                            </div>
                        </a>
                        <!-- SVG Gelombang Bawah (Bottom Wave) -->
                        <svg class="wave" style="transform:rotate(0deg); transition: 0.3s" viewBox="0 0 1440 300" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="<?= $gradientId ?>-bottom" x1="0" x2="0" y1="1" y2="0">
                                    <stop stop-color="<?= $startColor ?>" offset="0%"></stop>
                                    <stop stop-color="<?= $endColor ?>" offset="100%"></stop>
                                </linearGradient>
                            </defs>
                            <path style="transform:translate(0, 0px); opacity:0.6" fill="url(#<?= $gradientId ?>-bottom)" d="M0,150L60,130C120,110,240,70,360,85C480,100,600,170,720,210C840,250,960,260,1080,255C1200,250,1320,230,1440,215C1560,200,1680,190,1800,175C1920,160,2040,140,2160,155C2280,170,2400,220,2520,245C2640,270,2760,270,2880,265C3000,260,3120,250,3240,210C3360,170,3480,100,3600,70C3720,40,3840,50,3960,90C4080,130,4200,200,4320,205C4440,210,4560,150,4680,110C4800,70,4920,50,5040,80C5160,110,5280,190,5400,225C5520,260,5640,250,5760,205C5880,160,6000,80,6120,55C6240,30,6360,60,6480,85C6600,110,6720,130,6840,140C6960,150,7080,150,7200,125C7320,100,7440,50,7560,50C7680,50,7800,100,7920,120C8040,140,8160,130,8280,115C8400,100,8520,80,8580,70L8640,60L8640,300L8580,300C8520,300,8400,300,8280,300C8160,300,8040,300,7920,300C7800,300,7680,300,7560,300C7440,300,7320,300,7200,300C7080,300,6960,300,6840,300C6720,300,6600,300,6480,300C6360,300,6240,300,6120,300C6000,300,5880,300,5760,300C5640,300,5520,300,5400,300C5280,300,5160,300,5040,300C4920,300,4800,300,4680,300C4560,300,4440,300,4320,300C4200,300,4080,300,3960,300C3840,300,3720,300,3600,300C3480,300,3360,300,3240,300C3120,300,3000,300,2880,300C2760,300,2640,300,2520,300C2400,300,2280,300,2160,300C2040,300,1920,300,1800,300C1680,300,1560,300,1440,300C1320,300,1200,300,1080,300C960,300,840,300,720,300C600,300,480,300,360,300C240,300,120,300,60,300L0,300Z"></path>
                        </svg>
                    </div>
                    <?php $i++; ?>
                <?php endforeach; ?>
            <?php else : ?>
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