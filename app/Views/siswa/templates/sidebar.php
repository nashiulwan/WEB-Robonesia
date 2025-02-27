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

        <!-- Nav Item - Profil -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('siswa/profil'); ?>">
                <i class="fas fa-fw fa-user"></i>
                <span>Profil</span>
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
                    <a class="collapse-item" href="<?= base_url('siswa/project-dan-nilai'); ?>">Project dan Nilai</a>
                    <a class="collapse-item" href="<?= base_url('siswa/sertifikat'); ?>">Sertifikat yang Diperoleh</a>
                    <a class="collapse-item" href="<?= base_url('siswa/prestasi'); ?>">Daftar Prestasi</a>
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
                </div>
            </div>
        </li>

        <!-- Menu Kegiatan & Proyek -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('siswa/galeri'); ?>">
                <i class="fas fa-fw fa-images"></i>
                <span>Galeri Kegiatan</span>
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
