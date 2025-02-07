<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 text-gray-800"><?= esc($title) ?></h1>
        <a href="<?= base_url('admin/artikel/tambah'); ?>" class="btn btn-primary">Tambahkan Akun</a>
    </div>

    <!-- Tampilkan Flash Message -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <!-- TABEL ARTIKEL -->

    <?php $no = 1; ?>
    <table class="table table-bordered table-hover">
        <thead class="table" style="color: black; background-color:#2222">
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Nama pengguna</th>
                <th style="width: 30%;">Email</th>
                <th style="width: 30%;">Nama Lengkap</th>
                <th style="width: 10%;">Hak Akses</th>
                <th style="width: 10%">Aksi</th>
            </tr>
        </thead>
        <tbody class="table-group-divider" style="color: black;">
            <?php if (!empty($users)) : ?>
                <?php foreach ($users as $row) : ?>
                    <tr>
                        <td><?= $no++; ?></td> <!-- Nomor otomatis -->
                        <td class="text-break"><?= esc($row['username']); ?></td>
                        <td class="text-break"><?= esc($row['email']); ?></td>
                        <td class="text-break"><?= esc($row['fullname']); ?></td>
                        <td class="text-break">
                            <select class="form-select form-select-sm change-role" data-id="<?= $row['id']; ?>">
                                <option value="1" <?= ($row['role'] == '1') ? 'selected' : '' ?>>Admin</option>
                                <option value="3" <?= ($row['role'] == '3') ? 'selected' : '' ?>>Guru</option>
                                <option value="2" <?= ($row['role'] == '2') ? 'selected' : '' ?>>Siswa</option>
                                <option value="0" <?= (!in_array($row['role'], ['3', '1', '2'])) ? 'selected' : '' ?>>-</option>
                            </select>
                        </td>

                        <td>
                            <div class="d-flex flex-wrap gap-2" style="justify-content: space-between;">
                                <a href="<?= base_url('admin/manage-akun/edit/' . esc($row['id'])); ?>"
                                    class="btn btn-warning btn-sm  d-flex align-items-center justify-content-center"
                                    style="width: 32px; height: 32px; margin: 2px">
                                    <i class="fas fa-pen"></i> <!-- Ikon Hapus -->
                                </a>

                                <form action="<?= base_url('admin/manage_akun/delete/' . esc($row['id'])); ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <button type="submit"
                                        class="btn btn-danger btn-sm  d-flex align-items-center justify-content-center"
                                        style="width: 32px; height: 32px; margin: 2px"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">
                                        <i class="fas fa-trash-alt"></i> <!-- Ikon Hapus -->
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
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
                    [csrfToken]: csrfHash // Memasukkan CSRF ke dalam header
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
    });
</script>

<?= $this->endSection() ?>