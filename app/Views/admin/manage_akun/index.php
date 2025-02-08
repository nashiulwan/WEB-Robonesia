<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<!-- Custom CSS untuk menghilangkan efek fokus pada button filter -->
<style>
    .btn-filter-role:focus,
    .btn-filter-role:active {
        background: none !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
    }

    /* Hilangkan caret default pada dropdown button */
    #filterRoleButton::after {
        display: none;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 text-gray-800"><?= esc($title) ?></h1>
        <a href="<?= base_url('admin/manage_akun/tambah'); ?>" class="btn btn-primary">Tambahkan Akun</a>
    </div>

    <!-- Tampilkan Flash Message -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <!-- Form Pencarian -->
    <div class="mb-3 d-flex align-items-center justify-content-between">
        <div class="flex-grow-1 me-3" style="margin-right:1rem">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari akun berdasarkan username, nama, atau email">
        </div>
        <i class="fas fa-search text-muted" style="margin-right:1rem"></i>
    </div>



    <!-- TABEL -->
    <?php $no = 1; ?>
    <table class="table table-bordered table-hover">
        <thead class="table" style="color: black; background-color:#2222">
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Nama pengguna</th>
                <th style="width: 28%;">Email</th>
                <th style="width: 30%;">Nama Lengkap</th>
                <th style="width: 12%;">
                    Hak Akses
                    <!-- Filter Hak Akses dengan button dropdown -->
                    <div class="dropdown d-inline">
                        <button class="btn btn-sm btn-secondary dropdown-toggle btn-filter-role" type="button" id="filterRoleButton" data-bs-toggle="dropdown" aria-expanded="false" style="width: 30px; height:30px; color:black; background-color:transparent; border:none; margin:-5px">
                            <i class="fas fa-bars" style="font-size: 1em; margin-right: 0.5rem;"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="filterRoleButton">
                            <li>
                                <a class="dropdown-item filter-option" href="#" data-role="all">
                                    <i class="fas fa-bars" style="font-size: 1em; margin-right: 0.5rem;"></i>
                                    Semua
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item filter-option" href="#" data-role="1">
                                    <i class="fab fa-black-tie" style="font-size: 1em; margin-right: 0.5rem;"></i>
                                    Admin
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item filter-option" href="#" data-role="3">
                                    <i class="fas fa-user-tie" style="font-size: 1em; margin-right: 0.5rem;"></i>
                                    Guru
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item filter-option" href="#" data-role="2">
                                    <i class="fas fa-user-graduate" style="font-size: 1em; margin-right: 0.5rem;"></i>
                                    Siswa
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item filter-option" href="#" data-role="0">
                                    <i class="fas fa-question-circle" style="font-size: 1em; margin-right: 0.5rem;"></i>
                                    Lainnya
                                </a>
                            </li>
                        </ul>
                    </div>
                </th>
                <th style="width: 10%;">Aksi</th>
            </tr>
        </thead>
        <tbody class="table-group-divider" style="color: black;">
            <?php if (!empty($users)) : ?>
                <?php foreach ($users as $row) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td class="text-break"><?= esc($row['username']); ?></td>
                        <td class="text-break"><?= esc($row['email']); ?></td>
                        <td class="text-break"><?= esc($row['fullname']); ?></td>
                        <td class="text-break">
                            <!-- Update role per baris via AJAX -->
                            <select class="form-select form-select-sm change-role" data-id="<?= $row['id']; ?>">
                                <option value="1" <?= ($row['role'] == '1') ? 'selected' : '' ?>>Admin</option>
                                <option value="3" <?= ($row['role'] == '3') ? 'selected' : '' ?>>Guru</option>
                                <option value="2" <?= ($row['role'] == '2') ? 'selected' : '' ?>>Siswa</option>
                                <option value="0" <?= (!in_array($row['role'], ['3', '1', '2'])) ? 'selected' : '' ?>>-</option>
                            </select>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-2" style="justify-content: space-between;">
                                <a href="<?= base_url('admin/manage-akun/edit/' . esc($row['id'])); ?>" class="btn btn-warning btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px;">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="<?= base_url('admin/manage_akun/delete/' . esc($row['id'])); ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="11" class="text-center">Tidak ada data ditemukan</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pastikan jQuery dan Bootstrap JS telah dimuat -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Update role user via AJAX (tetap sama)
        $(".change-role").on("change", function() {
            var userId = $(this).data("id");
            var newRole = $(this).val();
            var csrfToken = '<?= csrf_token() ?>';
            var csrfHash = '<?= csrf_hash() ?>';

            $.ajax({
                url: "<?= base_url('admin/manage_akun/updateRole'); ?>",
                type: "POST",
                data: {
                    id: userId,
                    role: newRole
                },
                headers: {
                    [csrfToken]: csrfHash
                },
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                    } else {
                        alert("Gagal mengubah role.");
                    }
                },
                error: function(xhr, status, error) {
                    alert("Terjadi kesalahan: " + error);
                }
            });
        });

        // Filter data berdasarkan role saat opsi dropdown diklik
        $(document).on('click', '.filter-option', function(e) {
            e.preventDefault();
            var selectedRole = $(this).data('role'); // "all", "1", "3", "2", atau "0"
            var newIcon = $(this).find('i').clone();
            $('#filterRoleButton').html(newIcon);

            $('tbody tr').each(function() {
                var rowRole = $(this).find('.change-role').val();
                if (selectedRole === 'all' || rowRole === String(selectedRole)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Fitur pencarian: filter baris tabel berdasarkan username, email, atau fullname
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

    });
</script>

<?= $this->endSection() ?>