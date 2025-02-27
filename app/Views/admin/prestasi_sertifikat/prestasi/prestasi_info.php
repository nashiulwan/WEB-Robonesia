<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<style>
  /* Tabel Data Detail: Baris pertama biru transparan 20%, kedua putih */

  .table-detail tbody tr:nth-of-type(odd) {
    background-color: rgba(78, 115, 223, 0.1) !important;
  }

  .table-detail tbody tr:nth-of-type(even) {
    background-color: white !important;
  }

  .table-account tbody tr:nth-of-type(odd) {
    background-color: white !important;
  }

  .table-account tbody tr:nth-of-type(even) {
    background-color: rgba(78, 115, 223, 0.1) !important;
  }
</style>

<div class="container-fluid my-4">
  <h1 class="h3 mb-4 text-gray-800"><?= esc($title) ?></h1>


  <div class="card shadow-sm">
    <div class="card-body table-responsive">

      <table class="table table-borderless table-striped table-detail" style="color: black;">
        <?php if ($prestasi['jenis'] === 'Individual' && !empty($anggota)): ?>
          <?php $individu = $anggota[0];
          ?>
          <tr>
            <th class="th-data-akun">Nama Lengkap</th>
            <td><?= esc($individu['fullname']) ?></td>
          </tr>
          <tr>
            <th>Asal Sekolah</th>
            <td><?= esc($individu['asal_sekolah'] ?? '-') ?></td>
          </tr>
          <tr>
            <th>Kelas</th>
            <td><?= esc($individu['kelas'] ?? '-') ?></td>
          </tr>
        <?php endif; ?>
        <tr>
          <th style="width:35%;">Nama Kegiatan</th>
          <td><?= esc($prestasi['nama_kegiatan']) ?></td>
        </tr>
        <tr>
          <th>Jenis Prestasi</th>
          <td><?= esc($prestasi['jenis']) ?></td>
        </tr>
        <tr>
          <th>Tingkat</th>
          <td><?= esc($prestasi['tingkat']) ?></td>
        </tr>
        <tr>
          <th>Tahun</th>
          <td><?= esc($prestasi['tahun']) ?></td>
        </tr>
        <tr>
          <th>Pencapaian</th>
          <td><?= esc($prestasi['pencapaian']) ?></td>
        </tr>
      </table>


      <!-- Jika prestasi berjenis Kelompok, tampilkan tabel Anggota -->
      <?php if ($prestasi['jenis'] === 'Kelompok' && !empty($anggota)): ?>
        <div class="table-responsive">
          <p style="padding-top: 1rem; padding-left: 12px; color:black;"><strong>Anggota Tim</strong></p>
          <table class="table table-borderless table-anggota" style="color: black; padding-left:6px">
            <thead style="color: black; background-color: rgba(78, 115, 223, 0.1)">
              <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Asal Sekolah</th>
                <th>Kelas</th>
              </tr>
            </thead>
            <tbody class="table-anggota">
              <?php $no = 1;
              foreach ($anggota as $member): ?>
                <tr>
                  <td style="width: 5%;"><?= $no++; ?></td>
                  <td style="width: 40%;"><?= esc($member['fullname']) ?></td>
                  <td style="width: 30%;"><?= esc($member['asal_sekolah'] ?? '-') ?></td>
                  <td style="width: 20%;"><?= esc($member['kelas'] ?? '-') ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>

    <a href="<?= base_url('admin/prestasi') ?>" class="btn btn-warning" style="margin-left:20px; margin-bottom:1rem;width:7rem">Kembali</a>
  </div>
  <?= $this->endSection() ?>