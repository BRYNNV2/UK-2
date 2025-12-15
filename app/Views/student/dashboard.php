<?= $this->extend('student/layout') ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="mb-4">
    <h4 class="mb-0">Dashboard Mahasiswa</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item active">Home</li>
        </ol>
    </nav>
</div>

<!-- Welcome Hero Card -->
<div class="card mb-4" style="background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%); color: white; border: none;">
    <div class="card-body p-4">
        <div class="d-flex align-items-center">
            <div class="flex-grow-1">
                <h3 class="mb-2">Selamat Datang, <?= $mahasiswa['nama_mahasiswa'] ?? user()->username ?>!</h3>
                <p class="mb-2 opacity-90">
                    <i class="bi bi-mortarboard me-1"></i>
                    NIM: <strong><?= $mahasiswa['nim'] ?? '-' ?></strong>
                </p>
                <p class="mb-0 opacity-75">Portal Sistem Kuesioner Evaluasi Program Studi</p>
            </div>
            <div>
                <i class="bi bi-person-circle" style="font-size: 5rem; opacity: 0.2;"></i>
            </div>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>
        <?= session()->getFlashdata('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Status Cards -->
<div class="row g-3 mb-4">
    <!-- Kuesioner Status -->
    <div class="col-md-6">
        <div class="card h-100 border-0" style="background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%);">
            <div class="card-body text-white p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="mb-1 opacity-75 text-uppercase" style="font-size: 12px; letter-spacing: 0.5px;">Status Kuesioner</p>
                        <h4 class="mb-0 fw-bold">
                            <?php if ($activePeriode): ?>
                                <?= $hasSubmitted ? 'Sudah Mengisi' : 'Belum Mengisi' ?>
                            <?php else: ?>
                                Tidak Ada Periode Aktif
                            <?php endif; ?>
                        </h4>
                    </div>
                    <div class="p-3 rounded" style="background: rgba(255,255,255,0.2);">
                        <i class="bi <?= $hasSubmitted ? 'bi-check-circle' : 'bi-pencil-square' ?> fs-2"></i>
                    </div>
                </div>
                <?php if ($activePeriode): ?>
                    <div class="mt-3 pt-3 border-top border-white-50">
                        <small class="opacity-75">
                            <i class="bi bi-calendar-event me-1"></i>
                            Periode: <?= $activePeriode['keterangan'] ?>
                        </small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- NIM Card -->
    <div class="col-md-6">
        <div class="card h-100 border-0" style="background: linear-gradient(135deg, #64b5f6 0%, #90caf9 100%);">
            <div class="card-body text-white p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="mb-1 opacity-75 text-uppercase" style="font-size: 12px; letter-spacing: 0.5px;">Nomor Induk</p>
                        <h4 class="mb-0 fw-bold"><?= $mahasiswa['nim'] ?? '-' ?></h4>
                    </div>
                    <div class="p-3 rounded" style="background: rgba(255,255,255,0.2);">
                        <i class="bi bi-person-vcard fs-2"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top border-white-50">
                    <small class="opacity-75">
                        <i class="bi bi-building me-1"></i>
                        Mahasiswa Aktif
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Kuesioner Section -->
<div class="card">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">
            <i class="bi bi-clipboard-data text-primary me-2"></i>
            Kuesioner Tersedia
        </h5>
    </div>
    <?php if ($activePeriode): ?>
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-2">Kuesioner Periode <?= $activePeriode['keterangan'] ?></h5>
                    <p class="text-muted mb-0">
                        Status: 
                        <span class="badge bg-success">
                            <i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i>
                            Aktif
                        </span>
                    </p>
                </div>
                <div>
                    <?php if ($hasSubmitted): ?>
                        <button class="btn btn-secondary btn-lg" disabled>
                            <i class="bi bi-check-circle me-2"></i>
                            Sudah Mengisi
                        </button>
                    <?php else: ?>
                        <a href="<?= base_url('student/kuesioner') ?>" class="btn btn-success btn-lg">
                            <i class="bi bi-pencil-square me-2"></i>
                            Isi Sekarang
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="card-body text-center py-5">
            <i class="bi bi-calendar-x" style="font-size: 4rem; color: #dee2e6;"></i>
            <p class="text-muted mt-3 mb-0">Belum ada kuesioner aktif untuk saat ini.</p>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
