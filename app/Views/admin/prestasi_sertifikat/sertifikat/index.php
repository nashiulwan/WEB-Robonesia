<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 text-gray-800"><?= esc($title) ?></h1>
    </div>

    <ul class="nav nav-tabs mb-3" id="prestasiTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="daftar-sertifikat-tab" data-bs-toggle="tab" data-bs-target="#daftar-sertifikat" type="button" role="tab" aria-controls="daftar-sertifikat" aria-selected="true">
                Daftar Sertifikat
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="daftar-prestasi-tab" data-bs-toggle="tab" data-bs-target="#daftar-prestasi" type="button" role="tab" aria-controls="daftar-prestasi" aria-selected="true">
                Daftar Prestasi
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="daftar-akun-tab" data-bs-toggle="tab" data-bs-target="#daftar-akun" type="button" role="tab" aria-controls="daftar-akun" aria-selected="false">
                Daftar Akun
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="daftar-kelas-tab" data-bs-toggle="tab" data-bs-target="#daftar-kelas" type="button" role="tab" aria-controls="daftar-kelas" aria-selected="false">
                Daftar Kelas
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Daftar Sertifikat -->
        <div class="tab-pane fade show active" id="daftar-sertifikat" role="tabpanel" aria-labelledby="daftar-sertifikat-tab">
            <div class="mb-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center flex-grow-1 me-3" style="min-width: 0; ">
                    <input type="text" id="searchInputSertifikat" class="form-control flex-grow-1" placeholder="Cari sertifikat" style="margin-right:1rem">
                    <i class="fas fa-search text-muted ms-2" id="iconSearchPrestasi" style="margin-right:1rem"></i>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead style="color: black; background-color:#2222">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 25%;">Nama File</th>
                            <th style="width: 30%;">Deskripsi</th>
                            <th style="width: 26%;">Penerima</th>
                            <th style="width: 14%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php if (!empty($sertifikats)): ?>
                            <?php foreach ($sertifikats as $sertifikat): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td>
                                        <?php
                                        // Decode data JSON menjadi array
                                        $files = json_decode($sertifikat['nama_file'], true);
                                        if (!empty($files)):
                                            $totalFiles = count($files);
                                            $displayCount = ($totalFiles > 3) ? 3 : $totalFiles;
                                            for ($i = 0; $i < $displayCount; $i++):
                                                $fileName = $files[$i];
                                                // Jika nama file terlalu panjang, potong agar tidak mengganggu lebar tabel
                                                if (strlen($fileName) > 25) {
                                                    $ext  = pathinfo($fileName, PATHINFO_EXTENSION);
                                                    $base = pathinfo($fileName, PATHINFO_FILENAME);

                                                    $base = substr($base, 0, 15) . '...' . substr($base, -3);
                                                    $fileName = $base . '.' . $ext;
                                                }
                                                echo esc($fileName) . '<br>';
                                            endfor;
                                            if ($totalFiles > 3):
                                                echo '... (total: ' . $totalFiles . ')';
                                            endif;
                                        endif;
                                        ?>
                                    </td>
                                    <td><?= esc($sertifikat['deskripsi']); ?></td>
                                    <td><?= esc($sertifikat['penerima']); ?></td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2" style="justify-content: space-between;">
                                            <a href="<?= base_url('admin/sertifikat/detail/' . esc($sertifikat['id'])); ?>" class="btn btn-primary btn-sm" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('admin/sertifikat/edit/' . esc($sertifikat['id'])); ?>" class="btn btn-warning btn-sm" title="Download">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <a href="<?= base_url('admin/sertifikat/delete/' . esc($sertifikat['id'])); ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?');">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Belum ada sertifikat.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Daftar Prestasi -->
        <div class="tab-pane fade" id="daftar-prestasi" role="tabpanel" aria-labelledby="daftar-prestasi-tab">
            <div class="mb-3 d-flex align-items-center justify-content-between">
                <input type="text" id="searchInputPrestasi" class="form-control flex-grow-1" placeholder="Cari prestasi" style="margin-right:1rem">
                <i class="fas fa-search text-muted ms-2" id="iconSearchPrestasi" style="margin-right:1rem"></i>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead style="color: black; background-color:#2222">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 35%;">Nama Kegiatan</th>
                            <th style="width: 10%;">Jenis</th>
                            <th style="width: 15%;">Tingkat</th>
                            <th style="width: 10%;">Tahun</th>
                            <th style="width: 20%;">Pencapaian</th>
                            <th style="width: 5%;">Aksi</th>
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
                                            <a href="<?= base_url('admin/sertifikat/prestasi/' . esc($prestasi['id'])); ?>" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px;">
                                                <i class="fas fa-award"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Belum ada prestasi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Daftar Akun -->
        <div class="tab-pane fade" id="daftar-akun" role="tabpanel" aria-labelledby="daftar-akun-tab">
            <div class="mb-3 d-flex align-items-center justify-content-between">
                <input type="text" id="searchInputAkun" class="form-control flex-grow-1" placeholder="Cari akun" style="margin-right:1rem">
                <i class="fas fa-search text-muted ms-2" id="iconSearchPrestasi" style="margin-right:1rem"></i>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead style="color: black; background-color:#2222">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 20%;">Nama Pengguna</th>
                            <th style="width: 20%;">Email</th>
                            <th style="width: 25%;">Nama Lengkap</th>
                            <th style="width: 25%;">Asal Sekolah</th>
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
                                    <td><?= esc($row['asal_sekolah']); ?></td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2" style="justify-content: space-between;">
                                            <a href="<?= base_url('admin/sertifikat/akun/' . esc($row['id'])); ?>" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px;">
                                                <i class="fas fa-award"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Akun tidak ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Daftar Kelas -->
        <div class="tab-pane fade" id="daftar-kelas" role="tabpanel" aria-labelledby="daftar-kelas-tab">
            <div class="mb-3 d-flex align-items-center justify-content-between">
                <input type="text" id="searchInputKelas" class="form-control flex-grow-1" placeholder="Cari kelas" style="margin-right:1rem">
                <i class="fas fa-search text-muted ms-2" id="iconSearchPrestasi" style="margin-right:1rem"></i>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead style="color: black; background-color:#2222">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 31%;">Nama Kelas</th>
                            <th style="width: 25%;">Level</th>
                            <th style="width: 25%;">Sub Level</th>
                            <th style="width: 5%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider" style="color: black;">
                        <?php $no = 1; ?>
                        <?php if (!empty($prestasis)): ?>

                            <?php foreach ($kelas as $row): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= esc($row['nama_kelas']); ?></td>
                                    <td><?= esc($row['level']); ?></td>
                                    <td><?= esc($row['sub_level']); ?></td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2" style="justify-content: space-between;">
                                            <a href="<?= base_url('admin/sertifikat/kelas/' . esc($row['id'])); ?>" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px;">
                                                <i class="fas fa-award"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Kelas tidak ditemukan</td>
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
    $("#searchInputAkun").on("keyup", function() {
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

    $("#searchInputKelas").on("keyup", function() {
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