<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Kuesioner - UK2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
    </style>
</head>
<body>
    <div class="container mt-5 mb-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Kuesioner Periode <?= $periode['keterangan'] ?></h4>
                <p class="mb-0 small">Mahasiswa: <?= $mahasiswa['nama_mahasiswa'] ?> (<?= $mahasiswa['nim'] ?>)</p>
            </div>
            <div class="card-body">
                <form action="<?= base_url('student/submit') ?>" method="post">
                    <?= csrf_field() ?>

                    <?php if (empty($questions)): ?>
                        <div class="alert alert-info">Belum ada pertanyaan untuk Prodi Anda.</div>
                    <?php else: ?>
                        <?php foreach ($questions as $index => $q): ?>
                            <div class="mb-4 p-3 border rounded bg-light">
                                <label class="form-label fw-bold mb-3"><?= ($index + 1) ?>. <?= $q['pertanyaan'] ?></label>
                                
                                <?php foreach ($q['options'] as $opt): ?>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" 
                                               name="jawaban[<?= $q['id_pertanyaan'] ?>]" 
                                               value="<?= $opt['id_pilihan_jawaban'] ?>" 
                                               id="opt_<?= $opt['id_pilihan_jawaban'] ?>" 
                                               <?= (isset($q['existing_answer_option_id']) && $q['existing_answer_option_id'] == $opt['id_pilihan_jawaban']) ? 'checked' : '' ?>
                                               required>
                                        <label class="form-check-label" for="opt_<?= $opt['id_pilihan_jawaban'] ?>">
                                            <?= $opt['deskripsi_pilihan'] ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" onclick="return confirm('Apakah Anda yakin jawaban sudah benar? Data tidak bisa diubah setelah disimpan.')">Kirim Jawaban</button>
                            <a href="<?= base_url('student') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
