<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahasiswa Dashboard - UK2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f6f9; }
        .hero-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="bi bi-mortarboard me-2"></i>UK2 MAHASISWA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-danger" href="<?= base_url('admin-logout') ?>">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card hero-card shadow mb-4">
            <div class="card-body p-5">
                <h1 class="display-5 fw-bold">Halo, <?= $mahasiswa['nama_mahasiswa'] ?? user()->username ?>!</h1>
                <p class="fs-5">Selamat datang di Sistem Kuesioner Universitas.</p>
                <p>NIM: <strong><?= $mahasiswa['nim'] ?? '-' ?></strong></p>
                <?php if ($activePeriode && !$hasSubmitted): ?>
                    <a href="<?= base_url('student/kuesioner') ?>" class="btn btn-light btn-lg mt-3"><i class="bi bi-pencil-square me-2"></i>Isi Kuesioner</a>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if (session()->getFlashdata('message')) : ?>
            <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
        <?php endif; ?>
        
        <div class="row" id="kuesioner">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Daftar Kuesioner Tersedia</h5>
                    </div>
                    <?php if ($activePeriode): ?>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-3">
                                <div>
                                    <h5 class="mb-1">Kuesioner Periode <?= $activePeriode['keterangan'] ?></h5>
                                    <p class="text-muted mb-0">Status: <span class="badge bg-success">Aktif</span></p>
                                </div>
                                <div>
                                    <?php if ($hasSubmitted): ?>
                                        <button class="btn btn-secondary" disabled>Sudah Mengisi</button>
                                    <?php else: ?>
                                        <a href="<?= base_url('student/kuesioner') ?>" class="btn btn-primary">Isi Sekarang</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="card-body text-center py-5">
                            <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" alt="Empty" style="max-width: 200px; opacity: 0.5;">
                            <p class="text-muted mt-3">Belum ada kuesioner aktif untuk saat ini.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
