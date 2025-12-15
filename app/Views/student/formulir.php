<?= $this->extend('student/layout') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="mb-4">
    <h4 class="mb-1">Isi Kuesioner</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item"><a href="<?= base_url('student') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Kuesioner <?= $periode['keterangan'] ?></li>
        </ol>
    </nav>
</div>

<!-- Info Card -->
<div class="card mb-4" style="border-left: 4px solid #1976d2;">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h5 class="mb-2">
                    <i class="bi bi-clipboard-check text-primary me-2"></i>
                    Kuesioner Periode <?= $periode['keterangan'] ?>
                </h5>
                <p class="mb-0 text-muted">
                    <i class="bi bi-person-circle me-1"></i>
                    Mahasiswa: <strong><?= $mahasiswa['nama_mahasiswa'] ?></strong> (<?= $mahasiswa['nim'] ?>)
                </p>
            </div>
            <div class="col-md-4 text-end">
                <span class="badge bg-primary" style="font-size: 14px;">
                    <i class="bi bi-list-check me-1"></i>
                    <?= count($questions) ?> Pertanyaan
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Questionnaire Form -->
<form action="<?= base_url('student/submit') ?>" method="post" id="questionnaireForm">
    <?= csrf_field() ?>

    <?php if (empty($questions)): ?>
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox" style="font-size: 4rem; opacity: 0.3; color: #1976d2;"></i>
                <h5 class="mt-3 mb-2">Belum Ada Pertanyaan</h5>
                <p class="text-muted">Belum ada pertanyaan untuk Program Studi Anda.</p>
                <a href="<?= base_url('student') ?>" class="btn btn-primary mt-2">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Questions -->
        <?php foreach ($questions as $index => $q): ?>
            <div class="card mb-3">
                <div class="card-header bg-white">
                    <div class="d-flex align-items-start">
                        <span class="badge bg-primary me-3" style="font-size: 16px; min-width: 40px;">
                            <?= $index + 1 ?>
                        </span>
                        <h6 class="mb-0 flex-grow-1"><?= $q['pertanyaan'] ?></h6>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($q['options'])): ?>
                        <p class="text-muted mb-0">
                            <i class="bi bi-exclamation-circle me-1"></i>
                            Belum ada pilihan jawaban untuk pertanyaan ini.
                        </p>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($q['options'] as $opt): ?>
                                <label class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                        <input 
                                            class="form-check-input me-3" 
                                            type="radio" 
                                            name="answer[<?= $q['id_pertanyaan'] ?>]" 
                                            value="<?= $opt['id_pilihan_jawaban'] ?>"
                                            <?= (isset($q['existing_answer_option_id']) && $q['existing_answer_option_id'] == $opt['id_pilihan_jawaban']) ? 'checked' : '' ?>
                                            required
                                            style="width: 20px; height: 20px;"
                                        >
                                        <span><?= $opt['deskripsi_pilihan'] ?></span>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Submit Button -->
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="mb-0 text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Pastikan semua pertanyaan sudah dijawab sebelum submit.
                        </p>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="<?= base_url('student') ?>" class="btn btn-secondary me-2">
                            <i class="bi bi-x-circle me-1"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="bi bi-check-circle me-1"></i>
                            Submit Jawaban
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('questionnaireForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Submitting...';
            
            // Create FormData and submit via fetch
            const formData = new FormData(form);
            
            fetch('<?= base_url('student/submit') ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.ok || response.redirected) {
                    // Redirect to dashboard on success
                    window.location.href = '<?= base_url('student') ?>';
                } else {
                    throw new Error('Submit failed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan jawaban. Silakan coba lagi.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i> Submit Jawaban';
            });
        });
    }
});
</script>

<?= $this->endSection() ?>
