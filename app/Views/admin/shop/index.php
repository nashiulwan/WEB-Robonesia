<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<?php
function convertOembedToIframe($content)
{
    return str_replace('[embed]', '<iframe>', str_replace('[/embed]', '</iframe>', $content));
}
?>
<style>
    .text-ellipsis {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: normal;
        border: none;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 text-gray-800"><?= esc($title) ?></h1>
        <a href="<?= base_url('admin/shop/tambah'); ?>" class="btn btn-primary">Tambah Produk</a>
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
            <input type="text" id="searchInput" class="form-control" placeholder="Cari produk">
        </div>
        <i class="fas fa-search text-muted" style="margin-right:1rem"></i>
    </div>



    <!-- TABEL -->
    <?php $no = 1; ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table" style="color: black; background-color:#2222">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Gambar Produk</th>
                    <th style="width: 20%;">Nama Produk</th>
                    <th style="width: 15%;">Harga Produk</th>
                    <th style="width: 25%;">Deskripsi</th>
                    <th style="width: 10%;">Aksi</th>
                </tr>
            </thead>
            <tbody class="table-group-divider" style="color: black;">
                <?php if (!empty($shop)) : ?>
                    <?php foreach ($shop as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="text-break">
                                <img src="<?= base_url('uploads/shop/' . esc($row['gambar_produk'])); ?>" alt="Gambar Produk" class="img-fluid" width="100">
                            </td>
                            <td>
                                <div class="text-ellipsis"><?= esc($row['nama_produk']); ?> </div>
                            </td>
                            <td>
                                <div class="text-ellipsis"><?= esc($row['harga']); ?></div>
                            </td>
                            <td >
                                <div class="text-ellipsis"> <?= convertOembedToIframe(html_entity_decode($row['deskripsi_produk'])) ?></div>
                            </td>

                            <td>
                                <div class="d-flex flex-wrap gap-2" style="justify-content: space-between;">
                                    <a href="<?= base_url('admin/shop/edit/' . esc($row['id'])); ?>" class="btn btn-warning btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; margin: 2px;">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="<?= base_url('admin/shop/delete/' . esc($row['id'])); ?>" method="post">
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

</div>

<!-- Pastikan jQuery dan Bootstrap JS telah dimuat -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Fitur pencarian: filter baris tabel berdasarkan username, email, atau fullname
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("table tbody tr").each(function() {
                var nama_produk = $(this).find("td:nth-child(3)").text().toLowerCase();
                var harga_produk = $(this).find("td:nth-child(4)").text().toLowerCase();

                if (nama_produk.includes(value) || harga_produk.includes(value)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

    });
</script>

<?= $this->endSection() ?>