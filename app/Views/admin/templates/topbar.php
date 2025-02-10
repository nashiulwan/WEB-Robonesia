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
  <div
    class="d-none d-sm-inline-block form-inline mr-auto ml-md-6 my-2 my-md-0" ">
    <div class="input-group">   
  <h1 class="d-none d-lg-inline text-gray-800" style="font-size:18px; margin-bottom:-2px">
    <?= $greeting ?>
  </h1>
    </div>
  </div>
  <!-- Nav Item - User Information -->
  <ul class="navbar-nav ml-auto"> <!-- Menambahkan ml-auto di sini -->
    <li class="nav-item dropdown no-arrow">

      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-800 " style="font-size:16px; margin-bottom:-2px"><?= user()->fullname; ?></span>
        <img class="img-profile rounded-circle" style="width:45px; height:45px; margin-top:-10px;  margin-bottom:-10px; margin-left:5px"" src="<?= base_url(); ?>/uploads/<?= user()->user_image; ?>">
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