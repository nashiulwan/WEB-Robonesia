<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('admin/dashboard'); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="/image/logo-robonesia.png" alt="logo">
        </div>
        <div class="sidebar-brand-text mx-3">Robonesia</div>
    </a>

    <?php if (in_groups('admin')) : ?>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/dashboard'); ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Nav Item - Profil -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/profil'); ?>">
                <i class="fas fa-fw fa-user"></i>
                <span>Profil</span>
            </a>
        </li>

        <!-- Nav Item - Manage_akun -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseManage_akun" aria-expanded="true" aria-controls="collapseArtikel">
                <i class="fas fa-fw fa-users"></i>
                <span>Kelola Akun</span>
            </a>
            <div id="collapseManage_akun" class="collapse" aria-labelledby="headingManage_akun" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= base_url('admin/manage_akun'); ?>">Daftar Akun</a>
                    <a class="collapse-item" href="<?= base_url('admin/manage_akun/tambah'); ?>">Tambahkan Akun</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Artikel -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseArtikel" aria-expanded="true" aria-controls="collapseArtikel">
                <i class="fas fa-fw fa-newspaper"></i>
                <span>Artikel</span>
            </a>
            <div id="collapseArtikel" class="collapse" aria-labelledby="headingArtikel" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= base_url('admin/artikel'); ?>">Semua Artikel</a>
                    <a class="collapse-item" href="<?= base_url('admin/artikel/tambah'); ?>">Tambahkan Artikel</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Manage_Kelas -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseManage_kelas" aria-expanded="true" aria-controls="collapseManage_kelas">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Manajemen Kelas</span>
            </a>
            <div id="collapseManage_kelas" class="collapse" aria-labelledby="headingManage_kelas" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= base_url('admin/manage_kelas'); ?>">Daftar Kelas</a>
                    <a class="collapse-item" href="<?= base_url('admin/manage_kelas/tambah'); ?>">Tambah Kelas</a>
                    <a class="collapse-item" href="<?= base_url('admin/manage_kelas/kelola_anggota'); ?>">Kelola Anggota</a>
                </div>
            </div>
        </li>
        
        <!-- Nav Item - Prestasi dan Sertifikat -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePrestasiSertifikat" aria-expanded="true" aria-controls="collapsePrestasiSertifikat">
                <i class="fas fa-trophy"></i>
                <span>Prestasi & Sertifikat</span>
            </a>
            <div id="collapsePrestasiSertifikat" class="collapse" aria-labelledby="headingPrestasiSertifikat" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= base_url('admin/prestasi'); ?>">Prestasi</a>
                    <a class="collapse-item" href="<?= base_url('admin/grade_level'); ?>">Grade/Level</a>
                    <a class="collapse-item" href="<?= base_url('admin/sertifikat'); ?>">Sertfikat</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Analytics -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/analytics'); ?>">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Analytics</span>
            </a>
        </li>

        <!-- Nav Item - Pengaturan -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengaturan" aria-expanded="true" aria-controls="collapsePengaturan">
                <i class="fas fa-fw fa-cogs"></i>
                <span>Pengaturan</span>
            </a>
            <div id="collapsePengaturan" class="collapse" aria-labelledby="headingPengaturan" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= base_url('admin/pengaturan/kontak') ?>">Kontak</a>
                    <a class="collapse-item" href="<?= base_url('admin/pengaturan/mitra') ?>">Mitra</a>
                    <a class="collapse-item" href="<?= base_url('admin/pengaturan/tim') ?>">Tim</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

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