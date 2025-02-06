  <!-- FOOTER -->
  <footer class="footer">
    <div class="footer-top section">
      <a href="#" class="logo">
        <img src="/image/logo-backup.png" alt="Robonesia">
      </a>
      <div class="container grid-list">
        <div class="footer-brand">
          <p class="footer-brand-text">
            Mari kita bangun generasi melalui inovasi teknologi dan pendidikan berbasis robotik untuk masa depan yang cerah.
          </p>
          <div class="wrapper">
            <span class="span">Telepon :</span>
            <a target="_blank" href="https://wa.me/<?= esc($kontak['no_hp']) ?>" class="footer-link"><?= esc($kontak['no_hp']) ?></a>
          </div>
          <div class="wrapper">
            <span class="span">Email :</span>
            <a target="_blank" href="mailto:<?= esc($kontak['email']) ?>" class="footer-link"><?= esc($kontak['email']) ?></a>
          </div>
          <div class="footer-list">
            <div class="social-list">
              <a target="_blank" href="<?= esc($kontak['facebook']) ?>" class="social-link">
                <i class="ri-facebook-fill"></i>
              </a>
              <a target="_blank" href="https://wa.me/<?= esc($kontak['no_hp']) ?>" class="social-link">
                <i class="ri-whatsapp-fill"></i>
              </a>
              <a target="_blank" href="<?= esc($kontak['instagram']) ?>" class="social-link">
                <i class="ri-instagram-fill"></i>
              </a>
              <a target="_blank" href="<?= esc($kontak['x']) ?>" class="social-link">
                <i class="ri-twitter-x-fill"></i>
              </a>
              <a target="_blank" href="<?= esc($kontak['tiktok']) ?>" class="social-link">
                <i class="ri-tiktok-fill"></i>
              </a>
              <a target="_blank" href="<?= esc($kontak['youtube']) ?>" class="social-link">
                <i class="ri-youtube-fill"></i>
              </a>
            </div>
          </div>
        </div>

        <ul class="footer-list">
          <li><a href="/beranda" class="footer-link">Beranda</a></li>
          <li><a href="/tentang" class="footer-link">Tentang</a></li>
          <li><a href="/blog" class="footer-link">Blog</a></li>
          <li><a href="/galeri" class="footer-link">Galeri</a></li>
          <li><a href="/tim" class="footer-link">Tim</a></li>
          <li><a href="/partner" class="footer-link">Mitra</a></li>
          <li><a href="/hubungi" class="footer-link">Hubungi</a></li>
        </ul>
        <ul class="footer-list">
          <li><a target="_blank" href="<?= esc($kontak['maps']) ?>" class="footer-link">Maps</a></li>
          <li><a target="_blank" href="/testimoni" class="footer-link">Testimoni</a></li>
          <li><a target="_blank" href="/program" class="footer-link">Program Belajar</a></li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="copyright__container">
        <p class="copyright">
          Copyright 2024 All Rights Reserved by <a href="#" class="copyright-link">Robonesia</a>
        </p>
      </div>
    </div>
  </footer>
  <!-- FOOTER END -->

  <!-- AOS -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="/js/script.js"></script>

  <script src="https://unpkg.com/scrollreveal"></script>
  <script src="/js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  </body>
</html>
