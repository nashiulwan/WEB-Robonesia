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
                <i class="fas fa-fw fa-user"></i>
                <span>Kelola Akun</span>
            </a>
            <div id="collapseManage_akun" class="collapse" aria-labelledby="headingManage_akun" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= base_url('admin/manage_akun'); ?>">Semua Artikel</a>
                    <a class="collapse-item" href="<?= base_url('admin/manage_akun'); ?>">Tambahkan Akun</a>
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

        <!-- Nav Item - Pengguna -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/pengguna'); ?>">
                <i class="fas fa-fw fa-users"></i>
                <span>Pengguna</span>
            </a>
        </li>

        <!-- Nav Item - Analytics -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/analytics'); ?>">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Analytics</span>
            </a>
        </li>

        <!-- Nav Item - SEO -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/seo'); ?>">
                <i class="fas fa-fw fa-search"></i>
                <span>SEO</span>
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
                    <a class="collapse-item" href="<?= base_url('admin/pengaturan/galeri') ?>">Galeri</a>
                    <a class="collapse-item" href="<?= base_url('admin/pengaturan/mitra') ?>">Mitra</a>
                    <a class="collapse-item" href="<?= base_url('admin/pengaturan/tim') ?>">Tim</a>
                    <a class="collapse-item" href="<?= base_url('admin/pengaturan/prestasi') ?>">Prestasi</a>
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