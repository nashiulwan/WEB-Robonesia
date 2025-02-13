<?= $this->extend('admin/templates/dashboard'); ?>

<?= $this->section('page-content'); ?>
<div class="app-content">
          <div class="container-fluid">
            <div class="row">

              <!--BOX PENGUNJUNG-->
              <div class="col-lg-4 col-6">
                <div class="small-box text-bg-success">
                  <div class="inner">
                    <h3>X</h3>
                    <p>Pengunjung</p>
                  </div>
                  <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"></path>
                  </svg>
                  <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    Google Analytics <i class="bi bi-link-45deg"></i>
                  </a>
                </div>
              </div>

              <!--BOX PENGGUNA -->
              <div class="col-lg-4 col-6">
                <div class="small-box text-bg-warning">
                  <div class="inner">
                      <h3><?= $jumlahPengguna ?></h3>
                      <p>Jumlah Pengguna</p>
                  </div>
                  <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                      <path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"></path>
                  </svg>
                  <a href="/admin/pengguna" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                      Manajemen Akun <i class="bi bi-link-45deg"></i>
                  </a>
              </div>
              </div>

              <!--BOX ARTIKEL-->
              <div class="col-lg-4 col-6">
                <div class="small-box text-bg-danger">
                  <div class="inner">
                    <h3><?= $jumlahArtikel; ?></h3>
                    <p>Jumlah Artikel</p>
                  </div>
                  <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"></path>
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"></path>
                  </svg>
                  <a href="/admin/artikel" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    Manajemen Artikel <i class="bi bi-link-45deg"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        
<?= $this->endSection(); ?>