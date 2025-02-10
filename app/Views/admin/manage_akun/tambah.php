<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<style>
    .custom_file::-webkit-file-upload-button {
        margin-top: -10px;
        margin-left: -5px;
    }
</style>
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Tambah Akun</h1>

    <!-- Menampilkan pesan error validasi -->
    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Menampilkan pesan error umum -->
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Form Tambah Akun -->
    <form action="<?= base_url('admin/manage_akun/simpan') ?>" method="post" enctype="multipart/form-data" autocomplete="off">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="email">Alamat Email</label>
            <input type="email" name="email" id="email" class="form-control <?= (session()->getFlashdata('errors') && array_key_exists('email', session()->getFlashdata('errors'))) ? 'is-invalid' : '' ?>" value="<?= old('email') ?>" placeholder="Masukkan alamat email" autocomplete="off">
            <?php if (session()->getFlashdata('errors') && array_key_exists('email', session()->getFlashdata('errors'))) : ?>
                <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors')['email'] ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="username">Nama Pengguna</label>
            <input type="text" name="username" id="username" class="form-control <?= (session()->getFlashdata('errors') && array_key_exists('username', session()->getFlashdata('errors'))) ? 'is-invalid' : '' ?>" value="<?= old('username') ?>" placeholder="Masukkan nama pengguna" required autocomplete="off">
            <?php if (session()->getFlashdata('errors') && array_key_exists('username', session()->getFlashdata('errors'))) : ?>
                <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors')['username'] ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="fullname">Nama Lengkap</label>
            <input type="text" name="fullname" id="fullname" class="form-control <?= (session()->getFlashdata('errors') && array_key_exists('fullname', session()->getFlashdata('errors'))) ? 'is-invalid' : '' ?>" value="<?= old('fullname') ?>" placeholder="Masukkan nama lengkap" autocomplete="off">
            <?php if (session()->getFlashdata('errors') && array_key_exists('fullname', session()->getFlashdata('errors'))) : ?>
                <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors')['fullname'] ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="user_image" class="form-label">Unggah Foto Profil</label>
            <input type="file" class="form-control <?= (session()->getFlashdata('errors') && array_key_exists('user_image', session()->getFlashdata('errors'))) ? 'is-invalid' : '' ?> custom_file" id="user_image" name="user_image" accept="image/*">
            <?php if (session()->getFlashdata('errors') && array_key_exists('user_image', session()->getFlashdata('errors'))) : ?>
                <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors')['user_image'] ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password">Kata Sandi</label>
            <input type="password" name="password" id="password" class="form-control <?= (session()->getFlashdata('errors') && array_key_exists('password', session()->getFlashdata('errors'))) ? 'is-invalid' : '' ?>" placeholder="Masukkan kata sandi" required autocomplete="new-password">
            <?php if (session()->getFlashdata('errors') && array_key_exists('password', session()->getFlashdata('errors'))) : ?>
                <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors')['password'] ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="confirm_password">Konfirmasi Kata Sandi</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control <?= (session()->getFlashdata('errors') && array_key_exists('confirm_password', session()->getFlashdata('errors'))) ? 'is-invalid' : '' ?>" placeholder="Masukkan kata sandi" required autocomplete="new-password">
            <?php if (session()->getFlashdata('errors') && array_key_exists('confirm_password', session()->getFlashdata('errors'))) : ?>
                <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors')['confirm_password'] ?>
                </div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Tambah Akun</button>
    </form>
</div>


<?= $this->endSection() ?>