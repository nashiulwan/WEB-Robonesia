<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<!-- Custom CSS untuk menghilangkan efek fokus pada button filter -->

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 text-gray-800"><?= esc($title) ?></h1>
    </div>

    <!-- Nav tabs untuk memilih antara daftar prestasi dan daftar akun -->
    <ul class="nav nav-tabs mb-3" id="prestasiTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="daftar-prestasi-tab" data-bs-toggle="tab" data-bs-target="#daftar-prestasi" type="button" role="tab" aria-controls="daftar-prestasi" aria-selected="true">
                Daftar Prestasi
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="daftar-akun-tab" data-bs-toggle="tab" data-bs-target="#daftar-akun" type="button" role="tab" aria-controls="daftar-akun" aria-selected="false">
                Daftar Akun
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="daftar-prestasi" role="tabpanel" aria-labelledby="daftar-prestasi-tab">
            <div class="mb-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center flex-grow-1 me-3" style="min-width: 0; ">
                    <input type="text" id="searchInputPrestasi" class="form-control flex-grow-1" placeholder="Cari prestasi" style="min-width: 0; max-width:30rem; margin-right:1rem">
                    <i class="fas fa-search text-muted ms-2" id="iconSearchPrestasi" style="margin-right:1rem"></i>
                </div>
                <!-- Tombol di sebelah kanan -->
                <a href="<?= base_url('admin/manage_prestasi/tambah'); ?>" class="btn btn-primary" id="tambahPrestasiBtn">Tambah Prestasi</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead style="color: black; background-color:#2222">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 30%;">Nama Kegiatan</th>
                            <th style="width: 12%;">Jenis</th>
                            <th style="width: 15%;">Tingkat</th>
                            <th style="width: 10%;">Tahun</th>
                            <th style="width: 14%;">Pencapaian</th>
                            <th style="width: 14%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php if (!empty($prestasis)): ?>
                            <?php foreach ($prestasis as $prestasi): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= esc($prestasi['nama_kegiatan']); ?></td>
                                    <td><?= esc($prestasi['jenis']); ?></td>
                                    <td><?= esc($prestasi['tingkat']); ?></td>
                                    <td><?= esc($prestasi['tahun']); ?></td>
                                    <td><?= esc($prestasi['pencapaian']); ?></td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2" style="justify-content: space-between;">
                                            <a href="<?= base_url('admin/prestasi/detail/' . esc($prestasi['id'])); ?>" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('admin/prestasi/edit/' . esc($prestasi['id'])); ?>" class="btn btn-warning btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px;">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <form action="<?= base_url('admin/prestasi/delete/' . esc($prestasi['id'])); ?>" method="post">
                                                <?= csrf_field(); ?>
                                                <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px" onclick="return confirm('Apakah Anda yakin ingin menghapus prestasi ini?');">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Belum ada prestasi untuk user ini.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab Daftar Akun -->
        <div class="tab-pane fade" id="daftar-akun" role="tabpanel" aria-labelledby="daftar-akun-tab">
            <!-- Sama seperti view sebelumnya, tampilkan tabel daftar akun -->
            <div class="mb-3 d-flex align-items-center justify-content-between">
                <div class="flex-grow-1 me-3" style="margin-right:1rem">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari akun berdasarkan username, nama, atau email">
                </div>
                <i class="fas fa-search text-muted" style="margin-right:1rem"></i>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead style="color: black; background-color:#2222">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 20%;">Nama Pengguna</th>
                            <th style="width: 28%;">Email</th>
                            <th style="width: 30%;">Nama Lengkap</th>
                            <th style="width: 5%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider" style="color: black;">
                        <?php $no = 1; ?>
                        <?php if (!empty($users)) : ?>
                            <?php foreach ($users as $row) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= esc($row['username']); ?></td>
                                    <td><?= esc($row['email']); ?></td>
                                    <td><?= esc($row['fullname']); ?></td>
                                    <td>
                                        <!-- Tautan untuk menambahkan prestasi ke akun tertentu -->
                                        <a href="<?= base_url('admin/prestasi/prestasi_detail/' . $row['id']); ?>" class="btn btn-primary btn-sm"><i class="fas fa-trophy"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data akun</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Pastikan jQuery dan Bootstrap JS sudah dimuat -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Fitur pencarian untuk tabel akun
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("table tbody tr").each(function() {
            var username = $(this).find("td:nth-child(2)").text().toLowerCase();
            var email = $(this).find("td:nth-child(3)").text().toLowerCase();
            var fullname = $(this).find("td:nth-child(4)").text().toLowerCase();

            if (username.includes(value) || email.includes(value) || fullname.includes(value)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    $("#searchInputPrestasi").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("table tbody tr").each(function() {
            var nama_kegiatan = $(this).find("td:nth-child(2)").text().toLowerCase();
            var jenis = $(this).find("td:nth-child(3)").text().toLowerCase();
            var tingkat = $(this).find("td:nth-child(4)").text().toLowerCase();
            var tahun = $(this).find("td:nth-child(4)").text().toLowerCase();

            if (nama_kegiatan.includes(value) || jenis.includes(value) || tingkat.includes(value) || tahun.includes(value)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
</script>

<?= $this->endSection() ?>