<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<style>
  .table-detail tbody tr:nth-of-type(odd) {
    background-color: rgba(78, 115, 223, 0.1) !important;
  }

  .table-detail tbody tr:nth-of-type(even) {
    background-color: white !important;
  }

  .desc-container {
    max-height: 6em;
    overflow-y: auto;
    line-height: 1.5em;
  }
</style>

<div class="container-fluid my-4">
  <h1 class="h3 mb-4 text-gray-800"><?= esc($title) ?></h1>
  <table class="table table-borderless table-striped table-detail" style="color: black;">
    <tr>
      <th style="width:35%;">Nama Kelas</th>
      <td><?= esc($class['nama_kelas']) ?></td>
    </tr>
    <tr>
      <th>Kode Kelas</th>
      <td><?= esc($class['kode_kelas']) ?></td>
    </tr>
    <tr>
      <th>Jumlah Anggota</th>
      <td><?= esc($class['jumlah_anggota']) ?></td>
    </tr>
    <tr>
      <th>Grade/Level</th>
      <td><?= esc($class['level']) ?></td>
    </tr>
  </table>
  <div>

  <a href="<?= base_url('admin/grade_level') ?>" class="btn btn-warning" style="min-width:7rem">Kembali</a>
  </div>
</div>
<?= $this->endSection() ?>