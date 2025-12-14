<?= $this->extend('admin/dashboard') ?>

<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold">Atur Kuesioner</h2>
        <p class="text-muted">Pilih Periode untuk mengatur pertanyaan yang akan muncul bagi mahasiswa.</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($periodes as $p): ?>
                        <tr>
                            <td><?= $p['keterangan'] ?></td>
                            <td>
                                <span class="badge bg-<?= $p['status_periode'] == 'Aktif' ? 'success' : 'secondary' ?>">
                                    <?= $p['status_periode'] ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/atur-kuesioner/edit/' . $p['id_periode']) ?>" class="btn btn-primary btn-sm">
                                    <i class="bi bi-gear-fill me-1"></i> Atur Pertanyaan
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
