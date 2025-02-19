<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('admin/dashboard'); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="/image/logo-robonesia.png" alt="logo">
        </div>
        <div class="sidebar-brand-text mx-3">Robonesia</div>
    </a>

    <!-- Cek apakah user adalah siswa -->
    <?php if (in_groups('siswa')) : ?>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Menu Akademik -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('siswa/dashboard'); ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Menu Prestasi & Pencapaian -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePrestasi" aria-expanded="true" aria-controls="collapsePrestasi">
                <i class="fas fa-fw fa-award"></i>
                <span>Prestasi dan Nilai</span>
            </a>
            <div id="collapsePrestasi" class="collapse" aria-labelledby="headingPrestasi" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= base_url('siswa/nilai'); ?>">Nilai</a>
                    <a class="collapse-item" href="<?= base_url('siswa/sertifikat'); ?>">Sertifikat yang Diperoleh</a>
                    <a class="collapse-item" href="<?= base_url('siswa/prestasi'); ?>">Daftar Prestasi</a>
                    <a class="collapse-item" href="<?= base_url('siswa/level'); ?>">Sertifikat Level & Pencapaian</a>
                </div>
            </div>
        </li>

        <!-- Menu Informasi -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInfo" aria-expanded="true" aria-controls="collapseInfo">
                <i class="fas fa-fw fa-bullhorn"></i>
                <span>Informasi</span>
            </a>
            <div id="collapseInfo" class="collapse" aria-labelledby="headingInfo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= base_url('siswa/pengumuman/sekolah'); ?>">Informasi Sekolah</a>
                    <a class="collapse-item" href="<?= base_url('siswa/pengumuman/event'); ?>">Event dan Lomba</a>
                    <a class="collapse-item" href="<?= base_url('siswa/jadwal'); ?>">Jadwal Event/Lomba</a>
                </div>
            </div>
        </li>

        <!-- Menu Kegiatan & Proyek -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKegiatan" aria-expanded="true" aria-controls="collapseKegiatan">
                <i class="fas fa-fw fa-tasks"></i>
                <span>Kegiatan & Proyek</span>
            </a>
            <div id="collapseKegiatan" class="collapse" aria-labelledby="headingKegiatan" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= base_url('siswa/galeri'); ?>">Galeri Kegiatan</a>
                </div>
            </div>
        </li>

        <!-- Menu Komunikasi -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('siswa/hubungi_guru'); ?>">
                <i class="fas fa-fw fa-comments"></i>
                <span>Hubungi Guru</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('siswa/notifikasi'); ?>">
                <i class="fas fa-fw fa-bell"></i>
                <span>Notifikasi</span>
            </a>
        </li>
    <?php endif; ?>

    <!-- Nav Item - Logout -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('auth/logout'); ?>" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

    <!-- Sidebar Toggle -->
    <li class="nav-item d-flex justify-content-center">
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </li>
</ul>
