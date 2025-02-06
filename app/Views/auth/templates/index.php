<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Robonesia | Login</title>
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
  <link rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
    crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Remix Icon -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />

  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="<?= base_url(); ?>/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>/css/styles.css" rel="stylesheet">
  <link href="<?= base_url(); ?>/css/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <style>
    .login__container {
      width: var(--max-width);
      margin: auto;
      padding-block: 2rem;
      padding-inline: 3rem;
      gap: 2rem;
      min-height: 80vh;
      grid-template-columns: 1.5fr 2fr;
    }
  
    .loginheader {
      position: relative;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      position: relative;
      height: 100%;
      margin-bottom: -2rem;
    }
  
    .loginheader__content {
      position: relative;
      z-index: 2;
    }
  
    .background-img {
      position: relative;
      z-index: 1;
      max-width: 70%;
      margin-top: -10rem;
      margin-right: 80px;
      opacity: 0.9;
      -webkit-mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 30%, rgba(0, 0, 0, 1) 100%);
      mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 30%, rgba(0, 0, 0, 1) 100%);
    }
  
    .loginheader__content h1 {
      margin-bottom: 1rem;
      font-size: 3rem;
      font-weight: 400;
      font-family: var(--header-font);
      color: var(--text-dark);
      line-height: 4rem;
    }
  
    .loginheader__content h1 span {
      color: var(--color-yellow);
    }
  
    .loginheader__content p {
      margin-bottom: 2rem;
      columns: var(--text-light);
      line-height: 1.75rem;
    }
  
    .loginheader__content form {
      margin-bottom: 4rem;
      padding: 1.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-direction: column;
      gap: 1rem 0;
      border-radius: calc(1rem + 10px);
      box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.1);
    }
  
    .loginheader__content .input__row {
      width: 100%;
      display: flex;
      align-items: center;
      gap: 1rem;
      flex: 1;
    }
  
    .loginheader__content .input__group {
      flex: 1;
    }
  
    .loginheader__content .input__group h5 {
      margin-bottom: 5px;
      font-size: 0.9rem;
      font-weight: 500;
      color: var(--text-light);
    }
  
    .loginheader__content .input__group>div {
      display: flex;
      align-items: center;
      gap: 10px;
    }
  
    .loginheader__content input {
      width: 100%;
      outline: none;
      border: none;
      font-size: 1rem;
      background-color: transparent;
    }
  
    .loginheader__content input::placeholder {
      font-weight: 600;
      color: var(--text-dark);
    }
  
    .loginheader__content .input__group span {
      font-size: 1.1rem;
      font-weight: 600;
      color: var(--color-yellow);
    }
  
    .loginheader__content button {
      width: 100%;
      padding: 1rem 2rem;
      outline: none;
      border: none;
      font-size: 1rem;
      white-space: nowrap;
      color: var(--white);
      background-color: var(--color-yellow);
      border-radius: 10px;
      transition: 0.3s;
      cursor: pointer;
    }
  
    .loginheader__content button:hover {
      background-color: var(--color-blue);
    }
  
    .loginheader__content .bar {
      font-size: 0.9rem;
      color: var(--text-light);
      text-align: center;
    }
  
    .loginheader__image {
      grid-area: 1/2/2/3;
    }
  
    .loginheader__content :is(h1, p, .bar) {
      text-align: left;
    }
  
    .akad__login__callus {
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 2;
    }
  
    .input__group {
      display: flex;
      align-items: center;
    }
  
    .input__group span {
      display: flex;
      align-items: center;
      gap: 10px;
    }
  
    .button__row {
      display: flex;
      gap: 10px;
    }
  
    .captcha-container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
    }
  
    .captcha-container img {
      width: 40%;
      /* Setengah dari total luas kontainer */
      height: auto;
    }
  
    .captcha-container input {
      width: 100%;
      flex: 1;
    }
  
    .input-group-append {
      cursor: pointer;
    }
  
    .input-group-eye {
      position: relative;
      /* Membuat kontainer menjadi referensi posisi untuk ikon */
    }
  
    .form-control-eye {
      padding-right: 35px;
      /* Memberikan ruang untuk ikon di sebelah kanan input */
    }
  
    .pw-eye {
      position: absolute;
      right: 15px;
      z-index: 999;
      top: 50%;
      transform: translateY(-60%);
      font-size: 1.2rem;
      color: #333;
      cursor: pointer;
    }

  
    .input-group:not(.has-validation)>.dropdown-toggle:nth-last-child(n+3),
    .input-group:not(.has-validation)>.form-floating:not(:last-child)>.form-control,
    .input-group:not(.has-validation)>.form-floating:not(:last-child)>.form-select,
    .input-group:not(.has-validation)>:not(:last-child):not(.dropdown-toggle):not(.dropdown-menu):not(.form-floating) {
      border-radius: 50px;
    }

    @media (max-width: 766px) {
      .login__container {
        display: flex;
        flex-direction: column;
        justify-content: center; 
        align-items: center;
        gap: 1rem;
        min-height: 100vh;
      }
      
      .loginheader__content h1 {
        padding-top:1rem;
        margin: 0 auto !important;
        text-align: center !important;
      }
    
      .loginheader__content h1 .sub_judul {
        display: none;
      }
    
      .loginheader__content p {
        display: none;
      }
    
      .background-img {
        display: none;
      }
    }
  </style>
</head>

<body class="" style="background-color: white;">

  <?= $this->renderSection('content'); ?>

  <!-- Bootstrap core JavaScript -->
  <script src="<?= base_url(); ?>/jquery/jquery.min.js"></script>
  <script src="<?= base_url(); ?>/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript -->
  <script src="<?= base_url(); ?>/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages -->
  <script src="<?= base_url(); ?>/js/sb-admin-2.min.js"></script>
  <script>
    document.getElementById("togglePassword").addEventListener("click", function() {
      // Ambil elemen input password dan ikon mata
      var passwordField = document.getElementById("password");
      var eyeIcon = document.getElementById("togglePassword");

      // Cek apakah password ditampilkan atau tidak
      if (passwordField.type === "password") {
        // Jika password disembunyikan, tampilkan password
        passwordField.type = "text";
        // Ganti ikon menjadi eye terbuka
        eyeIcon.classList.remove("bi-eye");
        eyeIcon.classList.add("bi-eye-slash");
      } else {
        // Jika password ditampilkan, sembunyikan password
        passwordField.type = "password";
        // Ganti ikon menjadi eye tertutup
        eyeIcon.classList.remove("bi-eye-slash");
        eyeIcon.classList.add("bi-eye");
      }
    });
    document.getElementById('myForm').addEventListener('submit', function(event) {
      var inputs = document.querySelectorAll('input[required]'); // Semua input yang memiliki atribut required
  
      let formIsValid = true;
  
      inputs.forEach(function(input) {
        if (!input.value) {
          let errorMessage = '';
          switch (input.name) {
            case 'username':
              errorMessage = 'Harap isi nama pengguna Anda.';
              break;
            case 'password':
              errorMessage = 'Harap isi kata sandi Anda.';
              break;
            case 'captcha_answer':
              errorMessage = 'Harap isi jawaban captcha Anda.';
              break;
            default:
              errorMessage = 'Harap isi kolom ini.';
          }
  
          // Menampilkan pesan kustom
          input.setCustomValidity(errorMessage);
          formIsValid = false; // Menandakan form tidak valid
        } else {
          // Menghapus pesan kustom jika input valid
          input.setCustomValidity('');
        }
      });
  
      if (!formIsValid) {
        event.preventDefault(); // Mencegah form dikirim jika ada input yang invalid
      }
    });document.getElementById('myForm').addEventListener('submit', function(event) {
      var inputs = document.querySelectorAll('input[required]'); // Semua input yang memiliki atribut required
  
      let formIsValid = true;
  
      inputs.forEach(function(input) {
        if (!input.value) {
          let errorMessage = '';
          switch (input.name) {
            case 'username':
              errorMessage = 'Harap isi nama pengguna Anda.';
              break;
            case 'password':
              errorMessage = 'Harap isi kata sandi Anda.';
              break;
            case 'captcha_answer':
              errorMessage = 'Harap isi jawaban captcha Anda.';
              break;
            default:
              errorMessage = 'Harap isi kolom ini.';
          }
  
          // Menampilkan pesan kustom
          input.setCustomValidity(errorMessage);
          formIsValid = false; // Menandakan form tidak valid
        } else {
          // Menghapus pesan kustom jika input valid
          input.setCustomValidity('');
        }
      });
  
      if (!formIsValid) {
        event.preventDefault();
      }
    });
  </script>
</body>

</html>