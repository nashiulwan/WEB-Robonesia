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

        <!-- Nav Item - Dashboard Siswa -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('siswa/dashboard'); ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Nav Item - Sertifikat yang Diperoleh -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('siswa/sertifikat'); ?>">
                <i class="fas fa-fw fa-award"></i>
                <span>Sertifikat yang Diperoleh</span>
            </a>
        </li>

        <!-- Nav Item - Pengumuman -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengumuman" aria-expanded="true" aria-controls="collapsePengumuman">
                <i class="fas fa-fw fa-bullhorn"></i>
                <span>Pengumuman</span>
            </a>
            <div id="collapsePengumuman" class="collapse" aria-labelledby="headingPengumuman" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= base_url('siswa/pengumuman/sekolah'); ?>">Informasi Sekolah</a>
                    <a class="collapse-item" href="<?= base_url('siswa/pengumuman/event'); ?>">Event dan Lomba</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Daftar Prestasi -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('siswa/prestasi'); ?>">
                <i class="fas fa-fw fa-trophy"></i>
                <span>Daftar Prestasi Siswa</span>
            </a>
        </li>

        <!-- Nav Item - Galeri Kegiatan -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('siswa/galeri'); ?>">
                <i class="fas fa-fw fa-photo-video"></i>
                <span>Galeri Kegiatan</span>
            </a>
        </li>

        <!-- Nav Item - Project yang Selesai -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('siswa/project'); ?>">
                <i class="fas fa-fw fa-tasks"></i>
                <span>Project yang Selesai</span>
            </a>
        </li>

        <!-- Nav Item - Sertifikat Level dan Pencapaian -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('siswa/level'); ?>">
                <i class="fas fa-fw fa-medal"></i>
                <span>Sertifikat Level & Pencapaian</span>
            </a>
        </li>

        <!-- Nav Item - Nilai -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('siswa/nilai'); ?>">
                <i class="fas fa-fw fa-graduation-cap"></i>
                <span>Nilai</span>
            </a>
        </li>

        <!-- Nav Item - Jadwal Event/Lomba -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('siswa/jadwal'); ?>">
                <i class="fas fa-fw fa-calendar-alt"></i>
                <span>Jadwal Event/Lomba</span>
            </a>
        </li>

        <!-- Nav Item - Hubungi Guru -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('siswa/hubungi_guru'); ?>">
                <i class="fas fa-fw fa-comments"></i>
                <span>Hubungi Guru</span>
            </a>
        </li>

        <!-- Nav Item - Notifikasi -->
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