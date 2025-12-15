<?= $this->extend('admin/dashboard') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="mb-4">
    <h4 class="mb-0">Dashboard Overview</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item active">Home</li>
        </ol>
    </nav>
</div>

<!-- Welcome Card -->
<div class="card mb-4" style="border-left: 4px solid #0d47a1;">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div class="flex-grow-1">
                <h5 class="mb-1">Selamat Datang, <strong><?= user()->username ?></strong>!</h5>
                <p class="text-muted mb-0">
                    <i class="bi bi-shield-check text-success me-1"></i>
                    Login sebagai <strong><?= user()->role ?? 'Admin' ?></strong>
                </p>
            </div>
            <div>
                <i class="bi bi-person-circle" style="font-size: 4rem; color: #0d47a1; opacity: 0.2;"></i>
            </div>
        </div>
</div>

<?php if (isset($is_kaprodi) && $is_kaprodi && isset($kaprodi_prodi)): ?>
    <!-- Kaprodi Dashboard -->
    <div class="row g-3 mb-4">
        <!-- Prodi Info Card -->
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);">
                <div class="card-body text-white p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-2"><i class="bi bi-building me-2"></i>Program Studi Anda</h4>
                            <h3 class="fw-bold mb-1"><?= $kaprodi_prodi['nama_prodi'] ?></h3>
                            <p class="mb-0 opacity-90">Ketua Program Studi</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <i class="bi bi-mortarboard" style="font-size: 5rem; opacity: 0.2;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <!-- Total Mahasiswa -->
        <div class="col-md-4">
            <div class="card h-100 border-0" style="background: linear-gradient(135deg, #42a5f5 0%, #64b5f6 100%);">
                <div class="card-body text-white p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="mb-1 opacity-75 text-uppercase" style="font-size: 12px; letter-spacing: 0.5px;">Mahasiswa Prodi</p>
                            <h2 class="mb-0 fw-bold"><?= $kaprodi_mhs_count ?? 0 ?></h2>
                        </div>
                        <div class="p-3 rounded" style="background: rgba(255,255,255,0.2);">
                            <i class="bi bi-people fs-2"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top border-white-50">
                        <small class="opacity-75">
                            <i class="bi bi-person-check me-1"></i>
                            Total mahasiswa aktif
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Periode Aktif -->
        <div class="col-md-4">
            <div class="card h-100 border-0" style="background: linear-gradient(135deg, #64b5f6 0%, #90caf9 100%);">
                <div class="card-body text-white p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="mb-1 opacity-75 text-uppercase" style="font-size: 12px; letter-spacing: 0.5px;">Periode Kuesioner</p>
                            <?php if (isset($active_periode) && $active_periode): ?>
                                <h5 class="mb-0 fw-bold"><?= $active_periode['keterangan'] ?></h5>
                            <?php else: ?>
                                <h6 class="mb-0">Tidak Ada</h6>
                            <?php endif; ?>
                        </div>
                        <div class="p-3 rounded" style="background: rgba(255,255,255,0.2);">
                            <i class="bi bi-calendar-event fs-2"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top border-white-50">
                        <small class="opacity-75">
                            <?php if (isset($active_periode) && $active_periode): ?>
                                <i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i>
                                Status: <strong>Aktif</strong>
                            <?php else: ?>
                                <i class="bi bi-x-circle me-1"></i>
                                Belum ada periode aktif
                            <?php endif; ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Responden -->
        <div class="col-md-4">
            <div class="card h-100 border-0" style="background: linear-gradient(135deg, #90caf9 0%, #bbdefb 100%);">
                <div class="card-body text-white p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="mb-1 opacity-75 text-uppercase" style="font-size: 12px; letter-spacing: 0.5px;">Responden</p>
                            <h2 class="mb-0 fw-bold"><?= $kaprodi_respondents ?? 0 ?></h2>
                        </div>
                        <div class="p-3 rounded" style="background: rgba(255,255,255,0.2);">
                            <i class="bi bi-check-circle fs-2"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top border-white-50">
                        <small class="opacity-75">
                            <i class="bi bi-clipboard-check me-1"></i>
                            Sudah mengisi kuesioner
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-3">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="bi bi-lightning-charge text-warning me-2"></i>
                        Menu Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="<?= base_url('admin/periode') ?>" class="btn btn-outline-primary w-100 py-3 text-start">
                                <i class="bi bi-calendar-event me-2 fs-5"></i>
                                <div>
                                    <div class="fw-bold">Kelola Periode</div>
                                    <small class="text-muted">Atur periode kuesioner</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="<?= base_url('admin/pertanyaan') ?>" class="btn btn-outline-success w-100 py-3 text-start">
                                <i class="bi bi-question-circle me-2 fs-5"></i>
                                <div>
                                    <div class="fw-bold">Bank Pertanyaan</div>
                                    <small class="text-muted">Kelola pertanyaan</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="<?= base_url('admin/atur-kuesioner') ?>" class="btn btn-outline-info w-100 py-3 text-start">
                                <i class="bi bi-list-check me-2 fs-5"></i>
                                <div>
                                    <div class="fw-bold">Atur Kuesioner</div>
                                    <small class="text-muted">Assign pertanyaan</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="<?= base_url('admin/laporan') ?>" class="btn btn-outline-danger w-100 py-3 text-start">
                                <i class="bi bi-file-earmark-bar-graph me-2 fs-5"></i>
                                <div>
                                    <div class="fw-bold">Lihat Laporan</div>
                                    <small class="text-muted">Hasil kuesioner</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="bi bi-info-circle text-info me-2"></i>
                        Informasi
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (isset($active_periode) && $active_periode): ?>
                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted d-block mb-1">Periode Aktif</small>
                            <strong><?= $active_periode['keterangan'] ?></strong>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted d-block mb-1">Total Mahasiswa</small>
                            <strong><?= $kaprodi_mhs_count ?? 0 ?> orang</strong>
                        </div>
                        <div>
                            <small class="text-muted d-block mb-1">Partisipasi</small>
                            <?php 
                            $participation = $kaprodi_mhs_count > 0 ? round(($kaprodi_respondents / $kaprodi_mhs_count) * 100) : 0;
                            ?>
                            <div class="d-flex align-items-center">
                                <div class="progress flex-grow-1 me-2" style="height: 20px;">
                                    <div class="progress-bar bg-primary" style="width: <?= $participation ?>%"><?= $participation ?>%</div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center py-4 mb-0">
                            <i class="bi bi-calendar-x d-block mb-2" style="font-size: 2rem; opacity: 0.3;"></i>
                            Belum ada periode aktif
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php elseif (isset($is_kaprodi) && !$is_kaprodi): ?>
    <!-- Admin Dashboard (keep existing) -->
    <!-- Statistics Cards -->
    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <!-- Total Users -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0" style="background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <p class="mb-1 opacity-75" style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Total Users</p>
                            <h2 class="mb-0 fw-bold"><?= $count_users ?? 0 ?></h2>
                        </div>
                        <div class="p-2 rounded" style="background: rgba(255,255,255,0.2);">
                            <i class="bi bi-people fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top border-white-50">
                        <small class="opacity-75">
                            <i class="bi bi-graph-up me-1"></i>
                            Registered accounts
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Mahasiswa -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0" style="background: linear-gradient(135deg, #42a5f5 0%, #64b5f6 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <p class="mb-1 opacity-75" style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Mahasiswa</p>
                            <h2 class="mb-0 fw-bold"><?= $count_mhs ?? 0 ?></h2>
                        </div>
                        <div class="p-2 rounded" style="background: rgba(255,255,255,0.2);">
                            <i class="bi bi-person-vcard fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top border-white-50">
                        <small class="opacity-75">
                            <i class="bi bi-mortarboard me-1"></i>
                            Active students
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Fakultas -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0" style="background: linear-gradient(135deg, #64b5f6 0%, #90caf9 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <p class="mb-1 opacity-75" style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Fakultas</p>
                            <h2 class="mb-0 fw-bold"><?= $count_fakultas ?? 0 ?></h2>
                        </div>
                        <div class="p-2 rounded" style="background: rgba(255,255,255,0.2);">
                            <i class="bi bi-building fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top border-white-50">
                        <small class="opacity-75">
                            <i class="bi bi-diagram-3 me-1"></i>
                            <?= $count_jurusan ?? 0 ?> Jurusan
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Prodi -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0" style="background: linear-gradient(135deg, #90caf9 0%, #bbdefb 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <p class="mb-1 opacity-75" style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Program Studi</p>
                            <h2 class="mb-0 fw-bold"><?= $count_prodi ?? 0 ?></h2>
                        </div>
                        <div class="p-2 rounded" style="background: rgba(255,255,255,0.2);">
                            <i class="bi bi-mortarboard fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top border-white-50">
                        <small class="opacity-75">
                            <i class="bi bi-check-circle me-1"></i>
                            Study programs
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-3">
        <!-- Quick Access Card -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="bi bi-lightning-charge text-warning me-2"></i>
                        Quick Access
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-primary w-100 py-3 text-start">
                                <i class="bi bi-people me-2"></i>
                                <div>
                                    <div class="fw-bold">Kelola User</div>
                                    <small class="text-muted">Manage accounts</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="<?= base_url('admin/mahasiswa') ?>" class="btn btn-outline-success w-100 py-3 text-start">
                                <i class="bi bi-person-vcard me-2"></i>
                                <div>
                                    <div class="fw-bold">Data Mahasiswa</div>
                                    <small class="text-muted">Student records</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="<?= base_url('admin/prodi') ?>" class="btn btn-outline-info w-100 py-3 text-start">
                                <i class="bi bi-mortarboard me-2"></i>
                                <div>
                                    <div class="fw-bold">Program Studi</div>
                                    <small class="text-muted">Study programs</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Info Card -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="bi bi-info-circle text-primary me-2"></i>
                        System Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-2 bg-primary bg-opacity-10 rounded me-3">
                            <i class="bi bi-calendar3 text-primary"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Today</small>
                            <strong><?= date('d F Y') ?></strong>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-2 bg-success bg-opacity-10 rounded me-3">
                            <i class="bi bi-clock text-success"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Time</small>
                            <strong><?= date('H:i:s') ?> WIB</strong>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="p-2 bg-info bg-opacity-10 rounded me-3">
                            <i class="bi bi-gear text-info"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Version</small>
                            <strong>v1.0.0</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php else : ?>
    <!-- For Kaprodi/Pimpinan -->
    <div class="card">
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <i class="bi bi-clipboard-data" style="font-size: 4rem; color: #0d47a1; opacity: 0.3;"></i>
            </div>
            <h4 class="mb-3">Selamat Datang!</h4>
            <p class="text-muted mb-4">Silakan gunakan menu di samping untuk mengakses fitur yang tersedia.</p>
            
            <?php if (in_groups(['pimpinan', 'kaprodi'])) : ?>
                <a href="<?= base_url('admin/laporan') ?>" class="btn btn-primary">
                    <i class="bi bi-file-earmark-bar-graph me-2"></i>
                    Lihat Laporan Hasil Kuesioner
                </a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<!-- Analytics Section for Admin -->
<?php if (isset($prodi_stats) && !empty($prodi_stats) && !$is_kaprodi): ?>
<div class="row g-3 mt-3">
    <!-- Response Rate Chart -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0">
                    <i class="bi bi-bar-chart-line text-primary me-2"></i>
                    Tingkat Partisipasi per Program Studi
                </h6>
                <small class="text-muted">Periode: <?= $active_periode['keterangan'] ?? '-' ?></small>
            </div>
            <div class="card-body">
                <canvas id="responseRateChart" height="80"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Responding Prodi -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header bg-white">
                <h6 class="mb-0">
                    <i class="bi bi-trophy text-warning me-2"></i>
                    Top Responding
                </h6>
            </div>
            <div class="card-body">
                <?php foreach ($prodi_stats as $index => $stat): ?>
                    <div class="mb-3 pb-3 <?= $index < count($prodi_stats) - 1 ? 'border-bottom' : '' ?>">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div>
                                <span class="badge bg-primary">#<?= $index + 1 ?></span>
                                <strong class="ms-2 small"><?= $stat['nama_prodi'] ?></strong>
                            </div>
                            <span class="badge bg-success"><?= $stat['response_rate'] ?>%</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar" style="width: <?= $stat['response_rate'] ?>%; background: linear-gradient(90deg, #42a5f5, #1976d2);"></div>
                        </div>
                        <small class="text-muted"><?= $stat['responded'] ?> / <?= $stat['total_mhs'] ?> mahasiswa</small>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('responseRateChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($prodi_stats, 'nama_prodi')) ?>,
                datasets: [{
                    label: 'Response Rate (%)',
                    data: <?= json_encode(array_column($prodi_stats, 'response_rate')) ?>,
                    backgroundColor: 'rgba(25, 118, 210, 0.8)',
                    borderColor: 'rgb(25, 118, 210)',
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Response Rate: ' + context.parsed.y + '%';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: { callback: function(value) { return value + '%'; } },
                        grid: { color: 'rgba(0, 0, 0, 0.05)' }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }
});
</script>
<?php endif; ?>

<?= $this->endSection() ?>
