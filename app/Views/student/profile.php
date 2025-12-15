<?= $this->extend('student/layout') ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="mb-4">
    <h4 class="mb-0">Profil Mahasiswa</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item"><a href="<?= base_url('student') ?>">Home</a></li>
            <li class="breadcrumb-item active">Profil</li>
        </ol>
    </nav>
</div>

<div class="card">
    <!-- Profile Header -->
    <div class="card-header text-white text-center py-4" style="background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);">
        <div class="profile-avatar mx-auto mb-3" style="width: 100px; height: 100px; border-radius: 50%; background: white; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-person-circle" style="font-size: 50px; color: #1976d2;"></i>
        </div>
        <h3 class="mb-1"><?= $mahasiswa['nama_mahasiswa'] ?? user()->username ?></h3>
        <p class="mb-0 opacity-75"><?= $mahasiswa['nim'] ?? '-' ?></p>
    </div>

    <!-- Profile Details -->
    <div class="card-body p-4">
        <h5 class="mb-4">
            <i class="bi bi-info-circle text-primary me-2"></i>
            Informasi Profil
        </h5>
        
        <div class="row mb-3">
            <div class="col-md-4">
                <span class="text-muted">Nama Lengkap</span>
            </div>
            <div class="col-md-8">
                <strong><?= $mahasiswa['nama_mahasiswa'] ?? '-' ?></strong>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <span class="text-muted">NIM</span>
            </div>
            <div class="col-md-8">
                <strong><?= $mahasiswa['nim'] ?? '-' ?></strong>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <span class="text-muted">Program Studi</span>
            </div>
            <div class="col-md-8">
                <strong><?= $prodi['nama_prodi'] ?? '-' ?></strong>
                <?php if (isset($prodi['jenjang'])): ?>
                    <span class="badge bg-primary ms-2"><?= $prodi['jenjang'] ?></span>
                <?php endif; ?>
            </div>
        </div>

        <hr class="my-4">

        <h5 class="mb-4">
            <i class="bi bi-shield-lock text-primary me-2"></i>
            Informasi Akun
        </h5>

        <div class="row mb-3">
            <div class="col-md-4">
                <span class="text-muted">Username</span>
            </div>
            <div class="col-md-8">
                <strong><?= user()->username ?></strong>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <span class="text-muted">Email</span>
            </div>
            <div class="col-md-8">
                <strong><?= user()->email ?? '-' ?></strong>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <span class="text-muted">Status Akun</span>
            </div>
            <div class="col-md-8">
                <span class="badge bg-success">
                    <i class="bi bi-check-circle me-1"></i>
                    Aktif
                </span>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
