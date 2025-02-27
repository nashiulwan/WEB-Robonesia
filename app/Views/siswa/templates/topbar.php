<?php
date_default_timezone_set('Asia/Jakarta');
$hour = date('H');

if ($hour >= 5 && $hour < 12) {
    $greeting = "Selamat pagi, " . user()->fullname . "!"; 
} elseif ($hour >= 12 && $hour < 15) {
    $greeting = "Selamat siang, " . user()->fullname . "!"; 
} elseif ($hour >= 15 && $hour < 18) {
    $greeting = "Selamat sore, " . user()->fullname . "!"; 
} else {
    $greeting = "Selamat malam, " . user()->fullname . "!";
}
?>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-6 my-2 my-md-0">
        <div class="input-group">   
            <h1 class="d-none d-lg-inline text-gray-800" style="font-size:18px; margin-bottom:-2px; margin-left: 1rem;">
                <?= $greeting ?>
            </h1>
        </div>
    </div>

    <!-- Navbar Items -->
    <ul class="navbar-nav ml-auto">
        
        <!-- Nav Item - Notifikasi -->
        

        <!-- Nav Item - Notifikasi -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="notifikasiDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Jika ada notifikasi, tampilkan badge -->
                <?php if (isset($jumlah_notifikasi) && $jumlah_notifikasi > 0) : ?>
                    <span class="badge badge-danger badge-counter"><?= $jumlah_notifikasi ?></span>
                <?php endif; ?>
            </a>
            <!-- Dropdown - Notifikasi -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="notifikasiDropdown">
                <h6 class="dropdown-header">
                    Pusat Notifikasi
                </h6>
                <?php if (!empty($notifikasi)) : ?>
                    <?php foreach ($notifikasi as $notif) : ?>
                        <a class="dropdown-item d-flex align-items-center" href="<?= base_url('siswa/markAsRead/' . $notif['id']); ?>">
                            <div>
                                <div class="small text-gray-500"><?= date('d M Y H:i', strtotime($notif['created_at'])); ?></div>
                                <span class="font-weight-bold"><?= esc($notif['judul']); ?></span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else : ?>
                    <a class="dropdown-item text-center small text-gray-500" href="#">Tidak ada notifikasi baru</a>
                <?php endif; ?>
                <a class="dropdown-item text-center small text-gray-500" href="<?= base_url('siswa/notifikasi'); ?>">Lihat semua notifikasi</a>
            </div>
        </li>


        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-800" style="font-size:16px;"><?= user()->fullname; ?></span>
                <img class="img-profile rounded-circle" style="width:40px; height:40px; margin-top:-10px; margin-bottom:-10px; margin-left:5px" src="<?= base_url(); ?>/uploads/<?= user()->user_image; ?>">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= base_url('/logout'); ?>" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>
</nav>
