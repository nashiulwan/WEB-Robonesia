new Swiper('.testimoni-card-wrapper', {
    loop: true,
    spaceBetween: 30,

    // Pagination Bullet
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
      dynamicBullets: true,
    },
  
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },

    breakpoints: {
      0: {
        slidesPerView: 1
      },
      768: {
        slidesPerView: 2
      },
      1024: {
        slidesPerView: 3
      },
    }
  });
  // Fungsi untuk mengecek scroll dan menambahkan kelas shifted
  window.addEventListener("scroll", function() {
    const floatingButtons = document.querySelector('.floating-buttons');
    if (window.scrollY > 500) {
      floatingButtons.classList.add('shifted');
    } else {
      floatingButtons.classList.remove('shifted');
    }
  });
  