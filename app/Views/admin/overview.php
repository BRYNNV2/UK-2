<?= $this->extend('admin/dashboard') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">Selamat Datang</div>
    <div class="card-body">
        <p>Halo, <strong><?= user()->username ?></strong>!</p>
        <p>Anda login sebagai <strong><?= user()->role ?? 'Admin' ?></strong>.</p>
        <hr>
        <?php if (in_groups('admin')) : ?>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title text-uppercase mb-1 opacity-75">Total User</h6>
                                <h2 class="display-6 fw-bold mb-0"><?= $count_users ?? 0 ?></h2>
                            </div>
                            <i class="bi bi-people fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title text-uppercase mb-1 opacity-75">Total Prodi</h6>
                                <h2 class="display-6 fw-bold mb-0"><?= $count_prodi ?? 0 ?></h2>
                            </div>
                            <i class="bi bi-mortarboard fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-info mb-3 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title text-uppercase mb-1 opacity-75">Mahasiswa</h6>
                                <h2 class="display-6 fw-bold mb-0"><?= $count_mhs ?? 0 ?></h2>
                            </div>
                            <i class="bi bi-person-vcard fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php else : ?>
            <div class="alert alert-info">
                <h4 class="alert-heading">Selamat Datang!</h4>
                <p>Silakan gunakan menu di samping untuk mengakses fitur yang tersedia untuk peran Anda.</p>
                <?php if (in_groups(['pimpinan', 'kaprodi'])) : ?>
                    <hr>
                    <a href="<?= base_url('admin/laporan') ?>" class="btn btn-primary">Lihat Laporan Hasil Kuesioner</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
