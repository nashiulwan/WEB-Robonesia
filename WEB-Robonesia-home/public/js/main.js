//SCROLLED NAVBAR
const navLinks = document.getElementById("nav-links");

navLinks.addEventListener("click", (e) => {
  menuBtnIcon.setAttribute("class", "ri-menu-line");
});

const navbar = document.querySelector('.nav__container');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });


// BTN NAIK KEATAS
// Ambil elemen tombol
const scrollToTopButton = document.getElementById("scrollToTop");

// Tampilkan tombol jika halaman di-scroll ke bawah
window.addEventListener("scroll", () => {
  if (window.scrollY > 300) { // Tampilkan jika scroll melebihi 300px
    scrollToTopButton.style.display = "flex";
  } else {
    scrollToTopButton.style.display = "none";
  }
});

// Fungsi untuk scroll ke atas
function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: "smooth" // Animasi smooth
  });
}



// HALAMAN TIM
// ======================================
// Data Anggota Tim
// script.js

// Data Anggota Tim
const teamMembers = [
  {
      photo: '/image/tim1.jpg',
      name: 'Anggota 1',
      role: 'Peran 1',
      social: {
          facebook: 'https://facebook.com/anggota1',
          whatsapp: 'https://wa.me/1234567890',
          twitter: 'https://twitter.com/anggota1',
          instagram: 'https://instagram.com/anggota1'
      }
  },
  {
      photo: '/image/tim2.jpg',
      name: 'Anggota 2',
      role: 'Peran 2',
      social: {
          facebook: 'https://facebook.com/anggota2',
          whatsapp: 'https://wa.me/0987654321',
          twitter: 'https://twitter.com/anggota2',
          instagram: 'https://instagram.com/anggota2'
      }
  },
  {
      photo: '/image/tim3.jpg',
      name: 'Anggota 3',
      role: 'Peran 3',
      social: {
          facebook: 'https://facebook.com/anggota3',
          whatsapp: 'https://wa.me/1122334455',
          twitter: 'https://twitter.com/anggota3',
          instagram: 'https://instagram.com/anggota3'
      }
  },
  {
      photo: '/image/tim4.jpg',
      name: 'Anggota 4',
      role: 'Peran 4',
      social: {
          facebook: 'https://facebook.com/anggota4',
          whatsapp: 'https://wa.me/5544332211',
          twitter: 'https://twitter.com/anggota4',
          instagram: 'https://instagram.com/anggota4'
      }
  }
];

// Fungsi untuk Mengganti Foto dan Informasi di Bagian Atas
function updateTopSection(member) {
  // Ganti foto
  const topPhoto = document.getElementById('timPhoto');
  topPhoto.src = member.photo;

  // Ganti nama
  const topName = document.getElementById('timTopName');
  topName.textContent = member.name;

  // Ganti peran
  const topRole = document.getElementById('timTopRole');
  topRole.textContent = member.role;

  // Ganti tautan sosial
  const socialIcons = document.getElementById('timSocialIcon');
  socialIcons.children[0].href = member.social.facebook;
  socialIcons.children[1].href = member.social.whatsapp;
  socialIcons.children[2].href = member.social.twitter;
  socialIcons.children[3].href = member.social.instagram;
}

// Tambahkan Event Listener pada Foto di Bagian Bawah
document.addEventListener('DOMContentLoaded', () => {
  //FUNGSI GANTI TOP SECTION DARI GAMBAR
  const bottomPhotos = document.querySelectorAll('.tim__container__bottom img');
  bottomPhotos.forEach((img, index) => {
      img.addEventListener('click', () => {
          updateTopSection(teamMembers[index]);
      });
  });

  const arrowLeft = document.getElementById('arrowLeft');
  const arrowRight = document.getElementById('arrowRight');

  arrowLeft.addEventListener('click', () => {
    navigateTeam('left');
  });

  arrowRight.addEventListener('click', () => {
    navigateTeam('right');
  });

});

let timSaatIni = 0;

function navigateTeam(direction) {

  const totalMembers = teamMembers.length;

  if (direction === 'left') {
    timSaatIni = (timSaatIni - 1 + totalMembers) % totalMembers;
  } else if (direction === 'right') {
    timSaatIni = (timSaatIni + 1) % totalMembers;
  }

  updateTopSection(teamMembers[timSaatIni]);
  console.log("tim saat ini: " + timSaatIni);
}




// GALERI HALAMAN AWAL
//
const totalPhotos = 14;
const gallery = document.querySelector('.galleryimage');
const textContainer = document.querySelector('.text-container');
const bulletsContainer = document.querySelector('.bullets');

// Array deskripsi untuk setiap foto
const photoDescriptions = [
  "Foto ketika A", "Foto ketika B", "Foto ketika C", "Foto ketika D",
  "Foto ketika E", "Foto ketika F", "Foto ketika G", "Foto ketika H",
  "Foto ketika I", "Foto ketika J", "Foto ketika K", "Foto ketika L",
  "Foto ketika M", "Foto ketika N"
];

let currentIndex = 0;

// Muat foto ke dalam galeri
for (let i = 1; i <= totalPhotos; i++) {
  const photoDiv = document.createElement('div');
  photoDiv.classList.add('photo');
  if (i === 1) photoDiv.classList.add('active');

  const img = document.createElement('img');
  img.src = `/image/galeri_dok${i}.jpg`;
  img.alt = `Foto ${i}`;

  photoDiv.appendChild(img);
  gallery.appendChild(photoDiv);

  // Tambahkan bullet untuk setiap foto
  const bullet = document.createElement('div');
  bullet.classList.add('bullet');
  if (i === 1) bullet.classList.add('active');
  bulletsContainer.appendChild(bullet);
}

const photos = document.querySelectorAll('.photo');
const bullets = document.querySelectorAll('.bullet');

function updateGallery() {
  photos.forEach((photo, index) => {
    photo.classList.remove('active', 'left', 'right');

    if (index === currentIndex) {
      photo.classList.add('active'); // Tengah
    } else if (index === (currentIndex - 1 + totalPhotos) % totalPhotos) {
      photo.classList.add('left'); // Kiri
    } else if (index === (currentIndex + 1) % totalPhotos) {
      photo.classList.add('right'); // Kanan
    }
  });

  bullets.forEach((bullet, index) => {
    bullet.classList.remove('active');
    if (index === currentIndex) bullet.classList.add('active');
  });

  // Perbarui teks di text-container berdasarkan deskripsi
  textContainer.textContent = photoDescriptions[currentIndex];
}

function nextPhoto() {
  currentIndex = (currentIndex + 1) % totalPhotos;
  updateGallery();
}

function previousPhoto() {
  currentIndex = (currentIndex - 1 + totalPhotos) % totalPhotos;
  updateGallery();
}

// Perbarui galeri setiap 3 detik
setInterval(nextPhoto, 3000);

// Panggil updateGallery untuk inisialisasi awal
updateGallery();



