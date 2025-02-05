<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="container">
    <h2 class="my-4"><i class="fas fa-cog"></i> Pengaturan Kontak</h2>

    <!-- Bagian Tabel Data Kontak -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-table"></i> Data Kontak Terkini</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>No. HP</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Maps</th>
                        <th>Facebook</th>
                        <th>Instagram</th>
                        <th>X</th>
                        <th>Tiktok</th>
                        <th>Youtube</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($kontak)) : ?>
                        <tr>
                            <td><?= esc($kontak['no_hp']) ?></td>
                            <td><?= esc($kontak['email']) ?></td>
                            <td><?= esc(strlen($kontak['alamat']) > 50 ? substr($kontak['alamat'], 0, 50) . '...' : $kontak['alamat']) ?></td>
                            <td><a href="<?= esc($kontak['maps']) ?>" target="_blank">Lihat Maps</a></td>
                            <td><a href="<?= esc($kontak['facebook']) ?>" target="_blank">Facebook</a></td>
                            <td><a href="<?= esc($kontak['instagram']) ?>" target="_blank">Instagram</a></td>
                            <td><a href="<?= esc($kontak['x']) ?>" target="_blank">X</a></td>
                            <td><a href="<?= esc($kontak['tiktok']) ?>" target="_blank">Tiktok</a></td>
                            <td><a href="<?= esc($kontak['youtube']) ?>" target="_blank">Youtube</a></td>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td colspan="9" class="text-center">Data belum tersedia.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Form Input Kontak -->
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-edit"></i> Edit Kontak</h5>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/pengaturan/kontak/update') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-phone"></i> No. HP</label>
                            <input type="text" name="no_hp" class="form-control" value="<?= esc($kontak['no_hp'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" name="email" class="form-control" value="<?= esc($kontak['email'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-map-marker-alt"></i> Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" required><?= esc($kontak['alamat'] ?? '') ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-map"></i> Google Maps Embed Link</label>
                            <input type="url" name="maps" class="form-control" value="<?= esc($kontak['maps'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><i class="fab fa-facebook"></i> Facebook</label>
                            <input type="url" name="facebook" class="form-control" value="<?= esc($kontak['facebook'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fab fa-instagram"></i> Instagram</label>
                            <input type="url" name="instagram" class="form-control" value="<?= esc($kontak['instagram'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fab fa-twitter"></i> X</label>
                            <input type="url" name="x" class="form-control" value="<?= esc($kontak['x'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fab fa-tiktok"></i> Tiktok</label>
                            <input type="url" name="tiktok" class="form-control" value="<?= esc($kontak['tiktok'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fab fa-youtube"></i> Youtube</label>
                            <input type="url" name="youtube" class="form-control" value="<?= esc($kontak['youtube'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
            </form>
        </div>
    </div>
</div>


<?= $this->endSection() ?>
