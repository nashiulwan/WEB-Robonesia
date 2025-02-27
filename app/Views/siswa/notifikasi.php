<?= $this->extend('siswa/layout'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <h3 class="mt-4">Semua Notifikasi</h3>
    <ul class="list-group mt-3">
        <?php if (!empty($notifikasi)) : ?>
            <?php foreach ($notifikasi as $notif) : ?>
                <li class="list-group-item <?= $notif['status'] === 'unread' ? 'bg-light' : ''; ?>">
                    <div class="d-flex justify-content-between">
                        <span><?= esc($notif['judul']); ?></span>
                        <span class="text-muted small"><?= date('d M Y H:i', strtotime($notif['created_at'])); ?></span>
                    </div>
                    <div>
                        <a href="<?= base_url('siswa/markAsRead/' . $notif['id']); ?>" class="btn btn-sm btn-primary">Tandai Dibaca</a>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php else : ?>
            <li class="list-group-item text-center">Tidak ada notifikasi</li>
        <?php endif; ?>
    </ul>
</div>
<?= $this->endSection(); ?>
