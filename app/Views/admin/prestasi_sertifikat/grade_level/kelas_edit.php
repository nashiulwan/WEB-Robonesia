<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800">Edit Kelas</h1>

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

  <?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
      <?= session()->getFlashdata('success'); ?>
    </div>
  <?php endif; ?>

  <!-- Menampilkan pesan error umum -->
  <?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger">
      <?= session()->getFlashdata('error') ?>
    </div>
  <?php endif; ?>

  <form action="<?= base_url('admin/grade_level/update/' . $kelas['id']) ?>" method="post" autocomplete="off">
    <?= csrf_field() ?>

    <div class="form-group">
      <label for="nama_kelas">Level</label>

    </div>

    <div class="form-group">
      <label for="status">Proyek dikerjakan</label>

    </div>


    <button type="submit" class="btn btn-primary" style="min-width:7rem">Simpan</button>
    <a href="<?= base_url('admin/grade_level') ?>" class="btn btn-warning" style="margin-left:10px; width:7rem">Kembali</a>
  </form>
</div>

<?= $this->endSection() ?>