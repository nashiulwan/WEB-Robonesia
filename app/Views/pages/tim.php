
  <style>
    /* Container utama tim */
    .myteam-container {
      display: flex;
      flex-direction: column;
    }

    /* Bagian atas (detail anggota tim) */
    .myteam-top {
      padding-top: 6rem;
      padding-bottom: 1rem;
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background-color: var(--white);
    }
    .myteam-top section h1 {
      text-align: center;
      margin: 1rem 0;
      font-size: 24px;
      line-height: 1rem;
    }
    .myteam-top section img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 1rem;
    }
    .myteam-top section h2 {
      text-align: center;
      margin: 1rem;
      font-size: 18px;
      color: var(--text-light);
      line-height: 1rem;
    }
    .myteam-social-icon {
      display: flex;
      justify-content: center;
      gap: 1rem;
      margin-top: 1rem;
    }
    .myteam-social-icon a {
      text-decoration: none;
      color: #fff;
      width: 30px;
      height: 30px;
      display: flex;
      justify-content: center;
      align-items: center;
      border-radius: 50%;
      background-color: #333;
      font-size: 14px;
    }

    /* Bagian slider (bawah) */
    .myteam-bottom {
      position: relative;
      overflow: hidden;
      padding: 20px 0;
      background-color: #ddd;
      min-height: 150px;
      height: 150px;
    }
    .myteam-slider-container {
      width: 530px; 
      padding-top: 5px;
            padding-left: 5px;
                  padding-right: 5px;


      height: 120px;
      margin: 0 auto;
      overflow: hidden;
    }
    @media(max-width:660px) {
      .myteam-slider-container {
        width: 320px;
        margin: 0 auto;
        overflow: hidden;
      }
    }
    
    .myteam-slider-wrapper {
      display: flex;
      transition: transform 0.3s ease-in-out;
      gap: 5px;
      transform: translateX(0px);
      justify-content: flex-start;
    }
    .myteam-slide {
      flex: 0 0 auto;
      cursor: pointer;
      /*transition: transform 0.3s;*/
    }
    .myteam-slide:hover {
      /*transform: scale(1.05);*/
    }
    .myteam-slider-wrapper img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
    }


    /* Tombol panah slider */
    .myteam-arrow {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      font-size: 2.5rem;
      cursor: pointer;
      color: #333;
      border-radius: 50%;
      padding: 5px;
      z-index: 10;
      display: none; /* disembunyikan secara default */
    }
    #myteam-arrow-left {
      left: 10px;
    }
    #myteam-arrow-right {
      right: 10px;
    }
    
    /* Sembunyikan scrollbar */
    .myteam-slider-wrapper::-webkit-scrollbar {
      display: none;
    }
    .myteam-slider-wrapper {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
    
    @media(max-width:440px) {
      .myteam-slider-container {
        width: 260px;
        margin: 0 auto;
        overflow: hidden;
      }
      .myteam-bottom {
        min-height: 125px;
        height: 125px;
      }
      .myteam-slider-wrapper img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
      }
      
      #myteam-arrow-left {
      left: 5px;
    }
    #myteam-arrow-right {
      right: 5px;
    }
    }
  </style>
  <!-- Pastikan variabel $tim sudah berisi data tim -->
  <div class="myteam-container">
    <?php if (!empty($tim)) : ?>
      <!-- Bagian atas: Detail anggota tim -->
      <div class="myteam-top" id="myteam-top">
        <h1 id="myteam-title" data-aos="fade-up" data-aos-duration="1000">TIM KAMI</h1>
        <?php $firstTim = $tim[0]; ?>
        <section>
          <img src="<?= esc("/uploads/tim/" . $firstTim['foto']) ?>" alt="Foto <?= esc($firstTim['nama']) ?>" id="myteam-photo" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
        </section>
        <section>
          <h1 id="myteam-name" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400"><?= esc($firstTim['nama']) ?></h1>
          <h2 id="myteam-role" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600"><?= esc($firstTim['peran']) ?></h2>
          <div class="myteam-social-icon" id="myteam-social" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">
            <a href="<?= !empty($firstTim['facebook']) ? esc($firstTim['facebook']) : 'javascript:void(0)' ?>"
               target="<?= !empty($firstTim['facebook']) ? '_blank' : '' ?>"
               id="myteam-icon1"
               <?= empty($firstTim['facebook']) ? 'style="pointer-events: none; opacity: 0.5;"' : '' ?>>
              <i class="ri-facebook-fill"></i>
            </a>
            <a href="<?= !empty($firstTim['whatsapp']) ? 'https://wa.me/' . esc($firstTim['whatsapp']) : 'javascript:void(0)' ?>"
               target="<?= !empty($firstTim['whatsapp']) ? '_blank' : '' ?>"
               id="myteam-icon2"
               <?= empty($firstTim['whatsapp']) ? 'style="pointer-events: none; opacity: 0.5;"' : '' ?>>
              <i class="ri-whatsapp-fill"></i>
            </a>
            <a href="<?= !empty($firstTim['twitter']) ? esc($firstTim['twitter']) : 'javascript:void(0)' ?>"
               target="<?= !empty($firstTim['twitter']) ? '_blank' : '' ?>"
               id="myteam-icon3"
               <?= empty($firstTim['twitter']) ? 'style="pointer-events: none; opacity: 0.5;"' : '' ?>>
              <i class="ri-twitter-x-fill"></i>
            </a>
            <a href="<?= !empty($firstTim['instagram']) ? esc($firstTim['instagram']) : 'javascript:void(0)' ?>"
               target="<?= !empty($firstTim['instagram']) ? '_blank' : '' ?>"
               id="myteam-icon4"
               <?= empty($firstTim['instagram']) ? 'style="pointer-events: none; opacity: 0.5;"' : '' ?>>
              <i class="ri-instagram-fill"></i>
            </a>
          </div>
        </section>
      </div>

      <!-- Bagian bawah: Slider anggota tim -->
      <div class="myteam-bottom" id="myteam-bottom">
        <i class="myteam-arrow ri-arrow-left-s-line" id="myteam-arrow-left"></i>
        <i class="myteam-arrow ri-arrow-right-s-line" id="myteam-arrow-right"></i>
        <div class="myteam-slider-container">
          <div class="myteam-slider-wrapper">
            <?php foreach ($tim as $index => $member) : ?>
              <div class="myteam-slide">
                <img src="<?= esc("/uploads/tim/" . $member['foto']) ?>"
                     alt="Foto <?= esc($member['nama']) ?>"
                     class="myteam-photo-item"
                     data-index="<?= $index ?>">
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php else : ?>
      <p>Tidak ada anggota tim yang tersedia.</p>
    <?php endif; ?>
  </div>
<script>
  window.onload = function() {
    const sliderContainer = document.querySelector('.myteam-slider-container');
    const sliderWrapper = document.querySelector('.myteam-slider-wrapper');
    const slides = document.querySelectorAll('.myteam-slide');
    const arrowLeft = document.getElementById('myteam-arrow-left');
    const arrowRight = document.getElementById('myteam-arrow-right');
    const teamMembers = <?= json_encode($tim) ?>;
    
    // Atur jumlah slide yang terlihat dan indeks tengah default
    let visibleCount, centerIndex;
    if (window.innerWidth > 660) {
      visibleCount = 5;
      centerIndex = 2;
    } else {
      visibleCount = 3;
      centerIndex = 1;
    }
    
    // Flag untuk menentukan apakah logika centering aktif berdasarkan kondisi jumlah anggota
    let disableCenterLogic = (window.innerWidth > 660 && teamMembers.length <= 5);
    if (disableCenterLogic) {
      sliderWrapper.style.justifyContent = "flex-start";
    } else {
      // Re-order slide agar slide tengah berada di posisi center
      for (let i = 0; i < centerIndex; i++) {
        sliderWrapper.insertBefore(sliderWrapper.lastElementChild, sliderWrapper.firstElementChild);
      }
    }
    
    // Pastikan tombol panah selalu terlihat
    arrowLeft.style.display = "block";
    arrowRight.style.display = "block";
    
    // Fungsi untuk update social media
    function updateSocialIcons(idx) {
      const member = teamMembers[idx];

      // Facebook
      const iconFb = document.getElementById('myteam-icon1');
      if (member.facebook) {
        iconFb.href = member.facebook;
        iconFb.target = '_blank';
        iconFb.style.pointerEvents = "auto";
        iconFb.style.opacity = "1";
      } else {
        iconFb.href = "javascript:void(0)";
        iconFb.target = "";
        iconFb.style.pointerEvents = "none";
        iconFb.style.opacity = "0.5";
      }
      
      // WhatsApp
      const iconWa = document.getElementById('myteam-icon2');
      if (member.whatsapp) {
        iconWa.href = 'https://wa.me/' + member.whatsapp;
        iconWa.target = '_blank';
        iconWa.style.pointerEvents = "auto";
        iconWa.style.opacity = "1";
      } else {
        iconWa.href = "javascript:void(0)";
        iconWa.target = "";
        iconWa.style.pointerEvents = "none";
        iconWa.style.opacity = "0.5";
      }
      
      // Twitter
      const iconTw = document.getElementById('myteam-icon3');
      if (member.twitter) {
        iconTw.href = member.twitter;
        iconTw.target = '_blank';
        iconTw.style.pointerEvents = "auto";
        iconTw.style.opacity = "1";
      } else {
        iconTw.href = "javascript:void(0)";
        iconTw.target = "";
        iconTw.style.pointerEvents = "none";
        iconTw.style.opacity = "0.5";
      }
      
      // Instagram
      const iconIg = document.getElementById('myteam-icon4');
      if (member.instagram) {
        iconIg.href = member.instagram;
        iconIg.target = '_blank';
        iconIg.style.pointerEvents = "auto";
        iconIg.style.opacity = "1";
      } else {
        iconIg.href = "javascript:void(0)";
        iconIg.target = "";
        iconIg.style.pointerEvents = "none";
        iconIg.style.opacity = "0.5";
      }
    }
    
    // Fungsi untuk update tampilan utama berdasarkan slide yang berada di tengah
    function updateMainByCenter() {
      const centerSlide = sliderWrapper.children[centerIndex];
      if (centerSlide) {
        const img = centerSlide.querySelector('img');
        const idx = img.dataset.index;
        document.getElementById('myteam-photo').src = img.src;
        document.getElementById('myteam-name').textContent = teamMembers[idx].nama;
        document.getElementById('myteam-role').textContent = teamMembers[idx].peran;
        console.log("Anggota tengah:", teamMembers[idx]);
        
        // Update social media agar sesuai dengan anggota yang sedang tampil
        updateSocialIcons(idx);
      }
    }
    
    // Update tampilan awal
    if (!disableCenterLogic) {
      updateMainByCenter();
    } else {
      const firstSlide = sliderWrapper.children[0];
      const img = firstSlide.querySelector('img');
      const idx = img.dataset.index;
      document.getElementById('myteam-photo').src = img.src;
      document.getElementById('myteam-name').textContent = teamMembers[idx].nama;
      document.getElementById('myteam-role').textContent = teamMembers[idx].peran;
      // Update social media untuk anggota pertama
      updateSocialIcons(idx);
      console.log("Anggota pertama:", teamMembers[idx]);
    }
    
    // Hitung lebar tiap slide (asumsikan tiap slide memiliki lebar tetap dan gap 5px)
    const slideWidth = slides[0].offsetWidth + 5;
    
    // --- Navigasi dengan tombol panah (infinite cycling) ---
    if (!disableCenterLogic) {
      arrowRight.addEventListener('click', () => {
        sliderWrapper.style.transition = "transform 0.3s ease-in-out";
        sliderWrapper.style.transform = `translateX(-${slideWidth}px)`;
        
        sliderWrapper.addEventListener('transitionend', function handler() {
          sliderWrapper.style.transition = "none";
          sliderWrapper.appendChild(sliderWrapper.firstElementChild);
          sliderWrapper.style.transform = "translateX(0)";
          sliderWrapper.removeEventListener('transitionend', handler);
          updateMainByCenter();
        });
      });
  
      arrowLeft.addEventListener('click', () => {
        sliderWrapper.style.transition = "none";
        sliderWrapper.insertBefore(sliderWrapper.lastElementChild, sliderWrapper.firstElementChild);
        sliderWrapper.style.transform = `translateX(-${slideWidth}px)`;
        // Force reflow
        sliderWrapper.offsetHeight;
        sliderWrapper.style.transition = "transform 0.3s ease-in-out";
        sliderWrapper.style.transform = "translateX(0)";
        sliderWrapper.addEventListener('transitionend', function handler() {
          sliderWrapper.removeEventListener('transitionend', handler);
          updateMainByCenter();
        });
      });
      
      // Saat slide diklik, gunakan logika center
      document.querySelectorAll('.myteam-photo-item').forEach(img => {
        img.addEventListener('click', function() {
          const clickedSlide = this.parentElement;
          // Hitung selisih indeks slide yang diklik dengan slide tengah
          const slideArray = Array.from(sliderWrapper.children);
          const currentIndex = slideArray.indexOf(clickedSlide);
          const diff = currentIndex - centerIndex;
          if (diff !== 0) {
            sliderWrapper.style.transition = "transform 0.3s ease-in-out";
            sliderWrapper.style.transform = diff > 0 
              ? `translateX(-${diff * slideWidth}px)`
              : `translateX(${Math.abs(diff) * slideWidth}px)`;
            sliderWrapper.addEventListener('transitionend', function handler() {
              sliderWrapper.style.transition = "none";
              if (diff > 0) {
                for (let i = 0; i < diff; i++) {
                  sliderWrapper.appendChild(sliderWrapper.firstElementChild);
                }
              } else {
                for (let i = 0; i < Math.abs(diff); i++) {
                  sliderWrapper.insertBefore(sliderWrapper.lastElementChild, sliderWrapper.firstElementChild);
                }
              }
              sliderWrapper.style.transform = "translateX(0)";
              sliderWrapper.removeEventListener('transitionend', handler);
              updateMainByCenter();
            });
          } else {
            updateMainByCenter();
          }
        });
      });
    }
    
  // --- Fitur drag/swipe hanya untuk layar di bawah 440px ---
if (window.innerWidth < 440) {
  let isDragging = false;
  let startX = 0, currentX = 0;
  let dragReordered = false; // flag tambahan untuk reordering saat drag
  
  function handleDragEnd() {
    // Hitung total pergeseran
    const diff = currentX - startX;
    // Hitung berapa banyak slide yang harus digeser (bulatkan ke bilangan terdekat)
    const steps = Math.round(diff / slideWidth);
    
    // Lakukan transisi berdasarkan steps
    if (steps !== 0 && !disableCenterLogic) {
      sliderWrapper.style.transition = "transform 0.001s ease-in-out";
      sliderWrapper.style.transform = `translateX(${steps * slideWidth}px)`;
      
      sliderWrapper.addEventListener('transitionend', function handler() {
        sliderWrapper.style.transition = "none";
        if (steps > 0) {
          // Geser ke kanan: pindahkan slide terakhir ke depan sebanyak steps
          for (let i = 0; i < steps; i++) {
            sliderWrapper.insertBefore(sliderWrapper.lastElementChild, sliderWrapper.firstElementChild);
          }
        } else if (steps < 0) {
          // Geser ke kiri: pindahkan slide pertama ke akhir sebanyak abs(steps)
          for (let i = 0; i < Math.abs(steps); i++) {
            sliderWrapper.appendChild(sliderWrapper.firstElementChild);
          }
        }
        sliderWrapper.style.transform = "translateX(0)";
        sliderWrapper.removeEventListener('transitionend', handler);
        updateMainByCenter();
        dragReordered = false; // reset flag
      });
    } else {
      sliderWrapper.style.transition = "transform 0.3s ease-in-out";
      sliderWrapper.style.transform = "translateX(0)";
      updateMainByCenter();
      dragReordered = false;
    }
  }
  
  // Mouse events
  sliderWrapper.addEventListener('mousedown', (e) => {
    isDragging = true;
    startX = e.pageX;
    sliderWrapper.style.transition = "none";
    dragReordered = false;
  });
  document.addEventListener('mousemove', (e) => {
    if (!isDragging) return;
    currentX = e.pageX;
    let diff = currentX - startX;
    // Jika geser ke kiri (diff negatif) dan belum dilakukan reordering, lakukan sekarang
    if (diff < 0 && !dragReordered) {
      sliderWrapper.insertBefore(sliderWrapper.lastElementChild, sliderWrapper.firstElementChild);
      diff += slideWidth; // tambahkan offset agar pergeseran tetap mulus
      dragReordered = true;
    }
    sliderWrapper.style.transform = `translateX(${diff}px)`;
  });
  document.addEventListener('mouseup', (e) => {
    if (!isDragging) return;
    isDragging = false;
    currentX = e.pageX;
    handleDragEnd();
  });
  
  // Touch events
  sliderWrapper.addEventListener('touchstart', (e) => {
    isDragging = true;
    startX = e.touches[0].pageX;
    sliderWrapper.style.transition = "none";
    dragReordered = false;
  });
  sliderWrapper.addEventListener('touchmove', (e) => {
    if (!isDragging) return;
    currentX = e.touches[0].pageX;
    let diff = currentX - startX;
    if (diff < 0 && !dragReordered) {
      sliderWrapper.insertBefore(sliderWrapper.lastElementChild, sliderWrapper.firstElementChild);
      diff += slideWidth;
      dragReordered = true;
    }
    sliderWrapper.style.transform = `translateX(${diff}px)`;
  });
  sliderWrapper.addEventListener('touchend', () => {
    if (!isDragging) return;
    isDragging = false;
    handleDragEnd();
  });
}

    
    // --- Fitur navigasi dengan tombol keyboard untuk layar di atas 660px ---
    document.addEventListener('keydown', (e) => {
      if (window.innerWidth > 660) {
        if (e.key === "ArrowRight") {
          arrowRight.click();
        } else if (e.key === "ArrowLeft") {
          arrowLeft.click();
        }
      }
    });
  };
</script>



