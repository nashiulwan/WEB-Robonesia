<style>
    .header__tentang {
  padding: 0 8rem;
  display: flex;
  align-items: center;
  flex-direction: column;
  justify-content: center;
  overflow: hidden;
}

.tentang__container {
  display: flex;
  flex-wrap: wrap;
  flex-direction: row;
  justify-content: center;
  max-width: 100%;
  gap: 2rem;
}

.tentang__container section {
  flex: 1 1 40%;
  gap: 1rem;
  text-align: center;
  box-sizing: border-box; /* Untuk memastikan padding tidak melebihi lebar elemen */
}

.tentang__container section p {
  text-align: justify;
  line-height: 2;
  margin-bottom: 2rem;
}

.tentang__container section p span {
  font-weight: 400;
  font-family: var(--header-font);
  font-size: 1.5rem;
  margin-right: 0.5rem;
}

.tentang__container img {
  min-width: 50%;
  height: 50vh;
  object-fit: cover;
  margin-bottom: 2rem;
  width: 100%;
}

/*.header__tentang h1 {*/
/*  margin-bottom: 1rem;*/
/*  font-size: 3rem;*/
/*  font-weight: 400;*/
/*  font-family: var(--header-font);*/
/*  color: var(--text-dark);*/
/*  line-height: 5rem;*/
/*  text-align: center;*/
/*}*/
/* DESKRIPSI DAN GAMBAR END */

/* VISI MISI */
.tentang__visi-misi {
  margin: 0 5rem;
  border: 2px solid var(--text-dark);
  margin-bottom: 3rem;
  padding: 3rem 5rem;
  align-items: center;
  justify-content: center;
  text-align: center;
}

.tentang__visi-misi ul {
  list-style-type: none;
  padding-left: 0;
}

  /*.header__tentang h1 {*/
  /*  font-size: 2rem;*/
  /*}*/

  .header__tentang p {
    font-size: 1rem;
  }

/* VISI MISI END */

/* SEJARAH */
.sejarah__container {
  margin: 8rem 0;
  padding: 0 8rem;
  display: flex;
  align-items: center;
  flex-direction: column;
  justify-content: center;
  /* max-width: 80%; */
}

.sejarah__container img {
  max-width: 30%;
  margin: 2rem 0;
}

.sejarah__container p {
  text-align: justify;
  line-height: 2;
  margin-bottom: 2rem;
}

@media screen and (max-width: 800px) {
    .header__tentang{
        padding: 0 2rem;

    }
    .tentang__container {
    flex-direction: column; /* Ubah dari row ke column */
    align-items: center;
    padding: 0; /* Hilangkan padding */
  }

  .tentang__container section {
    flex: none;
    width: 100%; /* Gunakan seluruh lebar */
    padding: 0; /* Hilangkan padding */
  }

  .tentang__container img {
    min-width: 100%;
    height: auto; /* Agar gambar menyesuaikan proporsi */
  }
  .sejarah__container {
    padding: 0 2rem;
  }
}
  
  @media screen and (max-width: 480px) {
    .tentang__visi-misi {
      margin: 0 2rem;
      padding: 1rem;
    }
}

</style>

<!-- Header -->
<header class="header__tentang" style="margin-top: 6rem;">
  <h1 data-aos="fade-up" data-aos-duration="1000">Tentang Kami</h1>
  <div class="tentang__container">
    <section>
      <p data-aos="fade-right"><span data-aos="fade-right" data-aos-delay="500">Tentang Robonesia</span>
        Robonesia adalah Lembaga yang konsen dalam dunia pendidikan khususnya robotika. Basis pembelajarannya berupa ekstrakurikuler Robotik di sekolah-sekolah, kelas robotik online, dan privat robotik. Goals robonesia Menjadi Perusahaan pembelajaran teknologi dan robotik terbesar di Indonesia, sehingga dengan bonus demografi penduduknya menjadi salah satu negara dengan sumber daya manusia teknologi yang handal.
      </p>
      <img src="/image/about.jpg" alt="Tentang Kami" class="header__tentang__img" data-aos="fade-right" data-aos-duration="1000">
    </section>
    <section>
      <img src="/image/about2.jpg" alt="Tentang Kami" class="header__tentang__img" data-aos="fade-left" data-aos-duration="1000">
      <p data-aos="fade-left"><span data-aos="fade-right" data-aos-delay="500">Program Pembelajaran yang Terjangkau dan Berkualitas</span>
        Kami memahami bahwa banyak anak-anak yang kesulitan mengakses materi, guru, alat, dan kompetisi dalam bidang teknologi dan robotika. Oleh karena itu, Robonesia hadir untuk menyediakan platform pembelajaran yang memudahkan anak-anak dalam mempelajari robotik dan teknologi. Melalui program ekstrakurikuler robotik di sekolah dan kelas robotik online, kami menawarkan kesempatan untuk anak-anak berbakat mengikuti kompetisi tingkat Sekolah Dasar hingga Sekolah Menengah Atas, sehingga dapat membawa nama baik sekolah dan mengharumkan bangsa di kancah internasional.
      </p>
    </section>
    <section>
      <img src="/image/about3.jpg" alt="Tentang Kami" class="header__tentang__img" data-aos="fade-up" data-aos-duration="1000">
      <p data-aos="fade-up" data-aos-duration="1000"><span>Mari Bergabung dan Wujudkan Masa Depan Bersama
        </span>
        Kami percaya bahwa dengan pendidikan robotik, anak-anak tidak hanya akan menguasai keterampilan teknis, tetapi juga mengembangkan kreativitas, kerja sama tim, dan kemampuan pemecahan masalah. Kami ingin membantu sekolah-sekolah yang ingin menyediakan materi berkualitas, peralatan robotik, dan guru yang kompeten di bidang teknologi. Bergabung dengan kami berarti ikut serta dalam membangun masa depan anak-anak dengan keterampilan teknologi yang dibutuhkan untuk menghadapi tantangan global.
      </p>
    </section>
  </div>
</header>

<!-- Main Content -->
<main>
  <!-- Visi & Misi -->
  <section class="tentang__visi-misi">
    <h1 data-aos="fade-up" data-aos-duration="1000">VISI</h1>
    <p data-aos="fade-up" data-aos-duration="1000">Learning Robotic for better education</p>
    <h1 class="misi-tittle" data-aos="fade-up" data-aos-duration="1000">MISI</h1>
    <ul>
      <li data-aos="fade-up" data-aos-duration="1000">Menumbuhkan integritas dalam diri anak anak dengan mengarahkan potensi anak melalui pembelajaran berbasis projek
      </li>
      <li data-aos="fade-up" data-aos-duration="1000">Melatih anak-anak agar memiliki keterampilan dalam teknologi dan sains</li>
      <li data-aos="fade-up" data-aos-duration="1000">Menyediakan alat pelatihan yang sesuai dengan tumbuh kembang anak</li>
    </ul>
  </section>

  <!-- Sejarah -->
  <section class="sejarah__container">
    <h1 data-aos="fade-up" data-aos-duration="1000">Sejarah Kami</h1>
    <img src="/image/logo.png" alt="Sejarah Kami" class="sejarah__img" data-aos="fade-up" data-aos-duration="1000">
    <p data-aos="fade-up" data-aos-duration="1000">
      Robonesia, sebelumnya dikenal sebagai Robonesia.id, didirikan pada tahun 2016 di Komp. Bumi Panyileukan, Jl. Indah Raya, Bandung. Nama "Robonesia," yang merupakan singkatan dari "Rumah Robot Indonesia," mencerminkan harapan untuk menjadi pusat pengembangan karya robotik yang bermanfaat bagi masyarakat Indonesia. Perusahaan ini lahir dari ide kreatif beberapa mahasiswa di Bandung yang melihat peluang besar dalam dunia robotika dan pendidikan teknologi. <br><br>

      Pada masa awal, Robonesia memulai dengan menawarkan layanan les privat robotik, mengajarkan dasar-dasar komputer, elektronika, dan fisika kepada anak-anak hingga remaja. Program ini bertujuan untuk mengembangkan kreativitas, meningkatkan keterampilan motorik halus, serta membangun imajinasi siswa hingga mereka mampu menciptakan proyek-proyek berbasis teknologi yang aplikatif dan bernilai jual. Materi pembelajaran yang ditawarkan meliputi pembuatan proyek DIY, pembelajaran animasi dengan Scratch, perancangan Lego, serta pengenalan coding dasar menggunakan Arduino. <br><br>

      Seiring waktu, Robonesia semakin berkembang dengan menjangkau lebih banyak siswa dan memperluas kerja sama dengan berbagai institusi pendidikan. Tidak hanya fokus pada pendidikan, Robonesia juga aktif dalam berbagai ajang kompetisi robotik tingkat nasional dan internasional, yang membantu mengukuhkan reputasinya sebagai lembaga pendidikan robotik yang unggul. Selain itu, Robonesia mulai memperluas usahanya ke penjualan produk robot edukasi untuk mendukung pembelajaran siswa di berbagai wilayah. <br><br>

      Saat ini, Robonesia terus berupaya memperluas jangkauan layanan dan pasar dengan tujuan menghadirkan pendidikan robotik berkualitas tinggi yang dapat diakses oleh masyarakat luas, termasuk di wilayah Medan.
    </p>
  </section>
</main>