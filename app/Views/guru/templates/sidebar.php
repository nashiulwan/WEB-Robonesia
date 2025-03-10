<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('guru/dashboard'); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="/image/logo-robonesia.png" alt="logo">
        </div>
        <div class="sidebar-brand-text mx-3">Robonesia</div>
    </a>

    <?php if (in_groups('guru')) : ?>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('guru/dashboard'); ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Nav Item - Profil -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('guru/profil'); ?>">
                <i class="fas fa-fw fa-user"></i>
                <span>Profil</span>
            </a>
        </li>
        
        <!-- Nav Item - Manage_Kelas -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseManage_kelas" aria-expanded="true" aria-controls="collapseManage_kelas">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Manajemen Kelas</span>
            </a>
            <div id="collapseManage_kelas" class="collapse" aria-labelledby="headingManage_kelas" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= base_url('guru/manage_kelas'); ?>">Daftar Kelas</a>
                    <a class="collapse-item" href="<?= base_url('guru/manage_kelas/tambah'); ?>">Tambah Kelas</a>
                    <a class="collapse-item" href="<?= base_url('guru/manage_kelas/kelola_anggota'); ?>">Kelola Anggota</a>
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
                    <a class="collapse-item" href="<?= base_url('guru/prestasi'); ?>">Prestasi</a>
                    <a class="collapse-item" href="<?= base_url('guru/grade_level'); ?>">Grade/Level</a>
                    <a class="collapse-item" href="<?= base_url('guru/sertifikat'); ?>">Sertfikat</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Galeri Siswa -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('guru/galeri'); ?>">
                <i class="fas fa-images"></i>
                <span>Galeri Siswa</span>
            </a>
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