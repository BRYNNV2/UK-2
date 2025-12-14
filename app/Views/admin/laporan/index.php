<?= $this->extend('admin/dashboard') ?>

<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold">Laporan Hasil Kuesioner</h2>
        <p class="text-muted">Pilih Periode dan Program Studi untuk melihat hasil survei.</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('admin/laporan/result') ?>" method="get" target="_blank">
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label class="form-label fw-bold">Periode Kuesioner</label>
                    <select name="id_periode" class="form-select" required>
                        <option value="">-- Pilih Periode --</option>
                        <?php foreach ($periodes as $p): ?>
                            <option value="<?= $p['id_periode'] ?>"><?= $p['keterangan'] ?> (<?= $p['status_periode'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-5 mb-3">
                    <label class="form-label fw-bold">Program Studi</label>
                    <?php if (isset($isKaprodi) && $isKaprodi && isset($assignedProdi)): ?>
                        <input type="text" class="form-control" value="<?= $assignedProdi['nama_prodi'] ?>" readonly>
                        <input type="hidden" name="id_prodi" value="<?= $assignedProdi['id_prodi'] ?>">
                    <?php else: ?>
                        <select name="id_prodi" class="form-select" required>
                            <option value="">-- Pilih Prodi --</option>
                            <?php foreach ($prodis as $prof): ?>
                                <option value="<?= $prof['id_prodi'] ?>"><?= $prof['nama_prodi'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </div>
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-printer me-2"></i>Lihat Laporan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
