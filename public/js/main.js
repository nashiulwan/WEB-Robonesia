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
// ==================================================
document.addEventListener('DOMContentLoaded', function () {
  fetch('/api/tim')
      .then(response => response.json())
      .then(data => {
          populateTeam(data);
      })
      .catch(error => console.error('Error fetching team data:', error));
});

let teamMembers = [];

function populateTeam(data) {
  teamMembers = data;
  updateTopSection(teamMembers[0]); // Tampilkan anggota pertama

  const bottomPhotosContainer = document.getElementById('timContainerBottom');
  bottomPhotosContainer.innerHTML = ''; // Hapus isi sebelumnya

  teamMembers.forEach((member, index) => {
      const img = document.createElement('img');
      img.src = 'uploads/tim/' + member.foto;
      img.alt = `Foto ${member.nama}`;
      img.addEventListener('click', () => updateTopSection(teamMembers[index]));
      bottomPhotosContainer.appendChild(img);
  });
}

function updateTopSection(member) {
  document.getElementById('timPhoto').src = 'uploads/tim/' + member.foto;
  document.getElementById('timTopName').textContent = member.nama;
  document.getElementById('timTopRole').textContent = member.peran;

  const socialIcons = document.getElementById('timSocialIcon');
  socialIcons.children[0].href = member.facebook;
  socialIcons.children[1].href = member.whatsapp;
  socialIcons.children[2].href = member.twitter;
  socialIcons.children[3].href = member.instagram;
}

// ==================================================




// GALERI HALAMAN AWAL
//
const totalPhotos = 14;
const gallery = document.querySelector('.galleryimage');
const bulletsContainer = document.querySelector('.bullets');

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