<?= $this->extend('admin/dashboard') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1">Laporan Hasil Kuesioner</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/laporan') ?>">Laporan</a></li>
                    <li class="breadcrumb-item active">Hasil</li>
                </ol>
            </nav>
        </div>
        <div class="no-print">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="bi bi-printer me-1"></i> Cetak
            </button>
            <a href="<?= base_url('admin/laporan') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>

<!-- Report Card -->
<div class="card">
    <!-- Header Laporan -->
    <div class="card-header text-white text-center py-4" style="background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);">
        <h4 class="mb-2">Laporan Hasil Kuesioner</h4>
        <h5 class="fw-bold mb-1"><?= $prodi['nama_prodi'] ?></h5>
        <p class="mb-0 opacity-90">Periode: <?= $periode['keterangan'] ?></p>
    </div>

    <!-- Tabel Data -->
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead style="background: #f8f9fa;">
                    <tr class="text-center">
                        <th style="width: 5%;">No</th>
                        <th style="width: 40%;">Pertanyaan</th>
                        <th style="width: 40%;">Statistik Jawaban</th>
                        <th style="width: 15%;">Total Responden</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($questions)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                                <p class="mt-2 mb-0">Tidak ada data pertanyaan untuk periode ini.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($questions as $i => $q): ?>
                        <tr>
                            <td class="text-center fw-bold"><?= $i + 1 ?></td>
                            <td><?= $q['pertanyaan'] ?></td>
                            <td>
                                <div class="list-group list-group-flush">
                                    <?php foreach ($q['options'] as $opt): ?>
                                        <div class="list-group-item bg-transparent border-0 d-flex justify-content-between align-items-center py-2">
                                            <span><?= $opt['deskripsi_pilihan'] ?></span>
                                            <span class="badge bg-primary rounded-pill"><?= $opt['count'] ?> responden</span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <h5 class="mb-0 text-primary"><?= $q['total_responden'] ?></h5>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-3 border-top text-end no-print">
            <small class="text-muted">
                <i class="bi bi-calendar me-1"></i>
                Laporan dicetak pada: <?= date('d F Y, H:i') ?> WIB
            </small>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    .sidebar, .top-header {
        display: none !important;
    }
    .main-content {
        margin: 0 !important;
        padding: 20px !important;
    }
    .card {
        border: 1px solid #dee2e6 !important;
        box-shadow: none !important;
    }
}
</style>

<?= $this->endSection() ?>
