<?= $this->extend('auth/templates/index'); ?>
<?= $this->section('content'); ?>
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
</style>
<section>
  <div class="login__container">
    <div class="row">
      <div class="col-md-7 ">
        <div class="loginheader">
          <div class="loginheader__content">
            <h1>Sistem Akademik <span>ROBONESIA</span>
              <br>Pengelolaan Pembelajaran Robotik
            </h1>
            <p style="color: black; padding-right: 4rem;">
              Sistem Akademik Robonesia memudahkan pengelolaan pembelajaran robotik, membantu memantau kemajuan, dan mendukung pencapaian hasil belajar secara optimal.
            </p>
          </div>
          <img class="background-img" src="/image/akad_login.png" alt="">
        </div>
      </div>


      <!-- Kolom Kanan: Form Login -->
      <div class="col-md-5">
        <div class="card o-hidden border-0 shadow-lg my-4">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg">
                <div class="p-5">
                  <div class="text-center">
                    <h2 class="mb-4" style="color:black">Masuk</h2>
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
                    <div class="form-group">
                      <label type="text" class="form-control form-control-user" <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                        name="login" placeholder="<?= lang('Auth.emailOrUsername') ?>">
                        <div class="invalid-feedback">
                          <?= session('errors.login') ?>
                        </div>
                        <div class="invalid-feedback">
                          <?= session('errors.user_role') ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block"><?= lang('Auth.loginAction') ?></button>
                    <hr>
                    <div class="text-center">
                      <a class="small" href="forgot-password.html">Lupa kata sandi?</a>
                    </div>
                    <div class="text-center">
                      <a class="small" href="https://wa.me/082118032898">Hubungi admin?</a>
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