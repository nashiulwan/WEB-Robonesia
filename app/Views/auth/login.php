<?= $this->extend('auth/templates/index'); ?>
<?= $this->section('content'); ?>
<?php

use Myth\Auth\Config\Auth; ?>
<?php $config = new Auth(); ?>

<section>
  <div class="login__container">
    <div class="row">
      <div class="col-md-7 ">
        <div class="loginheader">
          <div class="loginheader__content">
            <h1 class="loginheader__content">
              Sistem Akademik <span>ROBONESIA</span>
              <br><span class="sub_judul" style="color: #333;">Pengelolaan Pembelajaran Robotik</span>
            </h1>

            <p style="color: black; padding-right: 4rem;">
              Sistem Akademik Robonesia memudahkan pengelolaan pembelajaran robotik, membantu memantau kemajuan, dan mendukung pencapaian hasil belajar secara optimal.
            </p>
          </div>
          <img class="background-img" src="/image/akad_login.png" alt="">
        </div>
      </div>

      <div class="col-md-5">
        <div class="card o-hidden border-0 shadow-lg my-4">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg">
                <div class="p-5">
                  <div class="text-center" style="margin-top: -10px;">
                    <h2 class="mb-4" style="color:black">Masuk</h2>
                  </div>
                  <?= view('Myth\Auth\Views\_message_block') ?>
                  <form class="user" action="<?= url_to('auth/login') ?>" method="post">
                    <?= csrf_field() ?>

                    <?php if ($config->validFields === ['email']): ?>
                      <div class="form-group">
                        <input type="email" class="form-control form-control-user" <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                          name="login" placeholder="<?= lang('Auth.email') ?>">
                        <div class="invalid-feedback">
                          <?= session('errors.login') ?>
                        </div>
                      </div>
                    <?php else: ?>
                      <div class="form-group">
                        <input type="text" class="form-control form-control-user" <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                          name="login" placeholder="<?= lang('Auth.emailOrUsername') ?>" required>
                        <div class="invalid-feedback">
                          <?= session('errors.login') ?>
                        </div>
                      </div>
                    <?php endif; ?>
                    <div class="form-group">
                      <div class="input-group input-group-eye">
                        <input type="password" id="password" name="password" class="form-control form-control-eye form-control-user <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" required>
                        <i class="bi bi-eye pw-eye" id="togglePassword"></i>
                        <div class="invalid-feedback">
                          <?= session('errors.password') ?>
                        </div>
                      </div>
                    </div>


                    <div class="form-group captcha-container">
                      <img src="<?= $captcha_image; ?>" alt="Captcha">
                      <input type="text" name="captcha_answer" class="form-control form-control-user" autocomplete="off" placeholder="Jawaban" required>
                      <div class="invalid-feedback">
                        <?= session('errors.captcha_answer') ?>
                      </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-user btn-block"><?= lang('Auth.loginAction') ?></button>
                    <hr>
                    <div class="text-center">
                      <a class="small" target="_blank" href="https://wa.me/082118032898">Hubungi admin?</a>
                    </div>
                    <div class="text-center" style="margin-bottom: -10px;">
                      <a class="small" href="<?= url_to('/') ?>">Kembali ke beranda</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" style="position: absolute; bottom:0; left:0; z-index: -1">
    <path fill="#33cccc" fill-opacity="1" d="M0,224L48,229.3C96,235,192,245,288,245.3C384,245,480,235,576,224C672,213,768,203,864,181.3C960,160,1056,128,1152,101.3C1248,75,1344,53,1392,42.7L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
  </svg>
</section>

<?= $this->endSection(); ?>