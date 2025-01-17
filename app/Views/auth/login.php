<?= $this->extend('auth/templates/index'); ?>
<?= $this->section('content'); ?>
<div class="container">

  <!-- Outer Row -->
  <div class="row justify-content-center">

    <div class="col-md-5">

      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg">
              <div class="p-5">
                <div class="text-center">
                  <h2 class="mb-4" style="color:black"> Robonesia | Login</h2>
                </div>
                <?= view('Myth\Auth\Views\_message_block') ?>
                <form class="user" action="<?= url_to('login') ?>" method="post">
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
                        name="login" placeholder="<?= lang('Auth.emailOrUsername') ?>">
                      <div class="invalid-feedback">
                        <?= session('errors.login') ?>
                      </div>
                    </div>
                  <?php endif; ?>
                  <div class="form-group">

                    <input type="password" name="password" class="form-control form-control-user  <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>">
                    <div class="invalid-feedback">
                      <?= session('errors.password') ?>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary btn-user btn-block"><?= lang('Auth.loginAction') ?></button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>
<?= $this->endSection(); ?>