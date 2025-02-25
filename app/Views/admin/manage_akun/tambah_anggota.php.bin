<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<style>
  /* Styling untuk tabel */
  .table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(78, 115, 223, 0.1) !important;
  }

  .table-striped tbody tr:nth-of-type(even) {
    background-color: white !important;
  }
</style>

<div class="container-fluid my-4">
  <h1 class="h3 mb-4 text-gray-800">Tambah Anggota ke Kelas: <?= esc($class['nama_kelas']) ?></h1>

  <!-- Pencarian User -->
  <div class="mb-3">
    <input type="text" id="searchUserInput" class="form-control" placeholder="Cari siswa berdasarkan nama, username, atau email">
  </div>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="width: 5%;">No</th>
        <th style="width: 25%;">Nama Lengkap</th>
        <th style="width: 20%;">Username</th>
        <th style="width: 25%;">Email</th>
        <th style="width: 25%;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; ?>
      <?php if (!empty($users)) : ?>
        <?php foreach ($users as $user) : ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= esc($user['fullname']); ?></td>
            <td><?= esc($user['username']); ?></td>
            <td><?= esc($user['email']); ?></td>
            <td>
              <!-- Form untuk menambahkan user ke kelas -->
              <form action="<?= base_url('admin/manage_kelas/tambah_anggota_proses/' . esc($class['id'])); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id_user" value="<?= esc($user['id']); ?>">
                <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else : ?>
        <tr>
          <td colspan="5" class="text-center">Tidak ada siswa ditemukan</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<script>
  $(document).ready(function() {
    $("#searchUserInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("table tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
      });
    });
  });
</script>

<?= $this->endSection() ?>