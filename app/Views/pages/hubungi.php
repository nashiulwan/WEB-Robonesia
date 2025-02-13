<!-- HUBUNGI PAGE CONTENT -->
<div class="kontak__container__top">
  <!-- Foto dokumentasi -->
  <img src="/image/kontak_kami.jpg" alt="Robonesia" class="full-image">
</div>

<!-- Kontainer untuk tabel dan peta -->
<div class="kontak__container__bottom">
  <h1 data-aos="fade-up" data-aos-duration="1000">KONTAK KAMI</h1>
  <!-- Tabel informasi kontak -->
  <table data-aos="fade-up" data-aos-duration="1000">
    <tr>
      <th>Informasi</th>
      <th>Detail</th>
    </tr>
    <tr>
      <td>Alamat</td>
      <td>
        <i class="ri-map-pin-line"></i>
        <?= esc($kontak['alamat']) ?>
      </td>
    </tr>
    <tr>
      <td>HP/Whatsapp</td>
      <td>
        <i class="ri-whatsapp-fill"></i>
        <a href="https://wa.me/<?= esc($kontak['no_hp']) ?>" target="_blank"><?= esc($kontak['no_hp']) ?></a>
      </td>
    </tr>
    <tr>
      <td>Email</td>
      <td>
        <i class="ri-mail-fill"></i>
        <a href="mailto:<?= esc($kontak['email']) ?>" target="_blank"><?= esc($kontak['email']) ?></a>
      </td>
    </tr>
    <tr>
      <td>Sosial Media</td>
      <td>
        <i class="ri-instagram-fill"></i>
        Instagram:
        <a href="<?= esc($kontak['instagram']) ?>" target="_blank">@Robonesia_medan</a>
        <br>
        <i class="ri-facebook-fill"></i>
        Facebook:
        <a href="<?= esc($kontak['facebook']) ?>" target="_blank">Robonesia Medan</a>
      </td>
    </tr>
  </table>

  <!-- Peta lokasi -->
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3981.834370097979!2d98.73926197422834!3d3.6252872963487994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x303133fbf0f76b0d%3A0x4926a9917e548920!2sKomplek%20Permata%20Jatian%20Indah!5e0!3m2!1sid!2sid!4v1738743396709!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"  data-aos="fade-up" data-aos-duration="1000"></iframe>

  <!-- Tombol buka di maps -->
  <a href="<?= esc($kontak['maps']) ?>" target="_blank" class="btn" id="btn_buka_di_map"  data-aos="fade-up" data-aos-duration="1000">Buka di Maps</a>

</div>
<!-- HUBUNGI END -->
