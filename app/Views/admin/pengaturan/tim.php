<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Anggota Tim</h1>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>


    <div class="card">
        <div class="card-body">
            <a href="<?= base_url('admin/pengaturan/tim/tambah') ?>" class="btn btn-primary mb-3">Tambah Anggota Tim</a>

            <!-- Form Pencarian -->
            <div class="mb-3 d-flex align-items-center justify-content-between">
                <div class="flex-grow-1 me-3" style="margin-right:1rem">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari anggota tim">
                </div>
                <i class="fas fa-search text-muted" style="margin-right:1rem"></i>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="timTable">
                    <thead>
                        <tr>
                            <th style="width: 10%" ;>Foto</th>
                            <th style="width: 30%" ;>Nama</th>
                            <th style="width: 30%" ;>Peran</th>
                            <th style="width: 25%" ;>Media Sosial</th>
                            <th style="width: 5%" ;>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tim as $t) : ?>
                            <tr>
                                <td><img src="<?= base_url('uploads/tim/' . esc($t['foto'])) ?>" alt="Foto" width="100" style="border-radius: 50%;"></td>
                                <td><?= esc($t['nama']) ?></td>
                                <td><?= esc($t['peran']) ?></td>
                                <td>
                                    <?php if ($t['facebook']) : ?>
                                        <a href="<?= esc($t['facebook']) ?>" target="_blank">Facebook</a><br>
                                    <?php endif; ?>
                                    <?php if ($t['whatsapp']) : ?>
                                        <a href="https://wa.me/<?= esc($t['whatsapp']) ?>" target="_blank">WhatsApp</a><br>
                                    <?php endif; ?>
                                    <?php if ($t['twitter']) : ?>
                                        <a href="<?= esc($t['twitter']) ?>" target="_blank">Twitter</a><br>
                                    <?php endif; ?>
                                    <?php if ($t['instagram']) : ?>
                                        <a href="<?= esc($t['instagram']) ?>" target="_blank">Instagram</a><br>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <!-- Button Edit -->
                                    <a href="<?= base_url('admin/pengaturan/tim/edit/' . $t['id']) ?>" class="btn btn-warning btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px;">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    <!-- Button Hapus -->
                                    <a href="<?= base_url('admin/pengaturan/tim/hapus/' . $t['id']) ?>" <?= csrf_field(); ?>
                                        <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">
                                        <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </a>
                                    <!-- 
                                    <a href="<?= base_url('admin/pengaturan/tim/edit/' . $t['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="<?= base_url('admin/pengaturan/tim/hapus/' . $t['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus anggota tim ini?')">Hapus</a> -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("searchInput");
        const table = document.getElementById("timTable");
        const rows = table.getElementsByTagName("tr");

        searchInput.addEventListener("keyup", function() {
            const searchText = searchInput.value.toLowerCase();
            for (let i = 1; i < rows.length; i++) { // Lewati header
                let rowData = rows[i].textContent.toLowerCase();
                rows[i].style.display = rowData.includes(searchText) ? "" : "none";
            }
        });
    })
</script>
<?= $this->endSection() ?>