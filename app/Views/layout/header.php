<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="/css/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=arrow_forward" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
  <link rel="stylesheet" href="/css/styles.css" />
  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <title><?= $title; ?></title>
</head>

<body>
  <!-- BTN NAIK KEATAS -->
  <button id="scrollToTop" class="scroll-to-top" onclick="scrollToTop()"><i class="ri-arrow-up-s-line"></i></button>


  <nav>
      <div class="nav__container">
        <!-- Logo -->
        <div class="nav__logo">
          <a href="/beranda"><img src="/image/logo.png" alt="Robonesia Logo"></a>
        </div>
        <!-- Sidebar toggle button -->
        <input type="checkbox" id="sidebar-active">
        <label for="sidebar-active" class="open-sidebar-button">
          <i class="ri-menu-line"></i>
        </label>
        <!-- Link Container -->
        <div class="link-container">
            <ul class="nav__links" id="nav-links">
            <li class="nav-beranda"><a href="/beranda">Beranda</a></li>
            <li><a href="/pages/tentang">Tentang</a></li>
            <li><a href="/pages/blog">Blog</a></li>
            <li><a href="/pages/galeri">Galeri</a></li>
            <li><a href="/pages/tim">Tim</a></li>
            <li><a href="/pages/partner">Mitra</a></li>
            <li><a href="/pages/hubungi">Hubungi</a></li>
          </ul>
        </div>
      </div>
    </nav>