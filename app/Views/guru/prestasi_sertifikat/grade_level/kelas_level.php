<?= $this->extend('guru/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><?= esc($title) ?></h1>

  <!-- Form Edit Kelas (termasuk level/sub level dan data gambar) -->
  <form action="<?= base_url('guru/grade_level/update_level/' . $kelas['id']) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <!-- Field Level -->
    <div class="form-group">
      <label for="level">Level</label>
      <select name="level" id="level" class="form-control">
        <option value="Basic" <?= ($kelas['level'] == 'Basic') ? 'selected' : '' ?>>Basic</option>
        <option value="Intermediate" <?= ($kelas['level'] == 'Intermediate') ? 'selected' : '' ?>>Intermediate</option>
        <option value="Advance" <?= ($kelas['level'] == 'Advance') ? 'selected' : '' ?>>Advanced</option>
        <option value="Lainnya" <?= ($kelas['level'] == 'Lainnya') ? 'selected' : '' ?>>Lainnya</option>
      </select>
    </div>
    <div class="form-group" id="subLevelContainer" style="display: <?= ($kelas['level'] == 'Lainnya') ? 'block' : 'none'; ?>;">
      <input type="text" name="level_lainnya" id="level_lainnya" class="form-control" placeholder="Masukkan level lain" value="<?= isset($kelas['level_lainnya']) ? $kelas['level_lainnya'] : '' ?>">
    </div>
    <!-- Field Sub Level -->
    <div class="form-group">
      <label for="sub_level">Sub Level</label>
      <input type="text" name="sub_level" id="sub_level" class="form-control" placeholder="Masukkan sub-level" value="<?= $kelas['sub_level'] ?>">
    </div>

    <button type="submit" class="btn btn-primary" style="width:7rem">Simpan</button>
    <a href="<?= base_url('guru/grade_level') ?>" class="btn btn-warning" style="width:7rem">Kembali</a>
  </form>
</div>

<script>
  // Menampilkan input "Level Lainnya" jika opsi "Lainnya" dipilih
  document.getElementById('level').addEventListener('change', function() {
    const subLevelContainer = document.getElementById('subLevelContainer');
    if (this.value === 'Lainnya') {
      subLevelContainer.style.display = 'block';
    } else {
      subLevelContainer.style.display = 'none';
      document.getElementById('level_lainnya').value = '';
    }
  });
</script>
<?= $this->endSection() ?>