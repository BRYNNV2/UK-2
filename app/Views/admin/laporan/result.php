<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Kuesioner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 20px; }
            .card { border: none !important; box-shadow: none !important; }
        }
    </style>
</head>
<body class="bg-light">

    <div class="container bg-white p-5 my-3 shadow-sm">
        <!-- HEADER LAPORAN -->
        <div class="text-center mb-5 border-bottom pb-4">
            <h3 class="fw-bold text-uppercase">Laporan Hasil Kuesioner</h3>
            <h4 class="fw-bold"><?= $prodi['nama_prodi'] ?></h4>
            <p class="fs-5 mb-0">Periode: <?= $periode['keterangan'] ?></p>
        </div>

        <div class="row mb-4">
            <div class="col-12 text-end no-print">
                <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer"></i> Cetak Laporan</button>
                <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 40%;">Pertanyaan</th>
                        <th style="width: 40%;">Statistik Jawaban</th>
                        <th style="width: 15%;">Total Responden</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($questions)): ?>
                        <tr><td colspan="4" class="text-center py-4">Tidak ada data pertanyaan.</td></tr>
                    <?php else: ?>
                        <?php foreach ($questions as $i => $q): ?>
                        <tr>
                            <td class="text-center"><?= $i + 1 ?></td>
                            <td><?= $q['pertanyaan'] ?></td>
                            <td>
                                <ul class="list-group list-group-flush small">
                                    <?php foreach ($q['options'] as $opt): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent py-1">
                                            <?= $opt['deskripsi_pilihan'] ?>
                                            <span class="badge bg-primary rounded-pill"><?= $opt['count'] ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                            <td class="text-center fw-bold fs-5"><?= $q['total_responden'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-5 pt-5 text-end no-print">
            <p class="mb-5">Dicetak pada: <?= date('d-m-Y H:i') ?></p>
        </div>
    </div>

</body>
</html>
