<!-- TIM -->
<div class="tim__container">
  <?php if (!empty($tim)) : ?>
    <!-- Section Top -->
    <div class="tim__container__top" id="timContainerTop">
      <h1 id="timTopTitle">TIM KAMI</h1>
      
      <!-- Tampilkan anggota pertama sebagai default -->
      <?php $firstTim = $tim[0]; ?>
      <section>
        <img src="<?= esc("/uploads/tim/" . $firstTim['foto']) ?>" alt="Foto <?= esc($firstTim['nama']) ?>" id="timPhoto">
      </section>
      <section>
        <h1 id="timTopName"><?= esc($firstTim['nama']) ?></h1>
        <h2 id="timTopRole"><?= esc($firstTim['peran']) ?></h2>
        <div class="tim__social__icon" id="timSocialIcon">
          <a href="<?= esc($firstTim['facebook']) ?>" target="_blank" id="icon1"><i class="ri-facebook-fill"></i></a>
          <a href="https://wa.me/<?= esc($firstTim['whatsapp']) ?>" target="_blank" id="icon2"><i class="ri-whatsapp-fill"></i></a>
          <a href="<?= esc($firstTim['twitter']) ?>" target="_blank" id="icon3"><i class="ri-twitter-x-fill"></i></a>
          <a href="<?= esc($firstTim['instagram']) ?>" target="_blank" id="icon4"><i class="ri-instagram-fill"></i></a>
        </div>
      </section>
    </div>

    <!-- Section Bottom -->
    <div class="tim__container__bottom" id="timContainerBottom">
      <i class="tim_arrow ri-arrow-left-s-line arrow" id="arrowLeft"></i>
      <i class="tim_arrow ri-arrow-right-s-line arrow" id="arrowRight"></i> 

      <!-- Looping untuk menampilkan semua anggota tim -->
      <?php foreach ($tim as $member) : ?>
        <img src="<?= esc("/uploads/tim/" . $member['foto']) ?>" alt="Foto <?= esc($member['nama']) ?>" class="timPhoto">
      <?php endforeach; ?>
    </div>
  <?php else : ?>
    <p>Tidak ada anggota tim yang tersedia.</p>
  <?php endif; ?>
</div>
