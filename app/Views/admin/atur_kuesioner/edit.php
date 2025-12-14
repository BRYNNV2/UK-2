<?= $this->extend('admin/dashboard') ?>

<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold">Atur Pertanyaan: <?= $periode['keterangan'] ?></h2>
        <p class="text-muted">Program Studi: <strong><?= $prodi['nama_prodi'] ?></strong></p>
    </div>
</div>

<?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>

<form action="<?= base_url('admin/atur-kuesioner/save/' . $periode['id_periode']) ?>" method="post">
    <?= csrf_field() ?>
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Pilih Pertanyaan</h5>
            <small class="text-muted">Centang pertanyaan yang ingin ditampilkan pada kuesioner periode ini.</small>
        </div>
        <div class="card-body">
            <?php if(empty($questions)): ?>
                <div class="alert alert-warning">
                    Belum ada pertanyaan di Bank Pertanyaan Prodi Anda. 
                    <a href="<?= base_url('admin/pertanyaan/create') ?>">Tambah Pertanyaan Baru</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="50"><input type="checkbox" id="checkAll" class="form-check-input"></th>
                                <th>Pertanyaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($questions as $q): ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="questions[]" value="<?= $q['id_pertanyaan'] ?>" 
                                               class="form-check-input q-check" 
                                               <?= $q['selected'] ? 'checked' : '' ?>>
                                    </td>
                                    <td><?= $q['pertanyaan'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        <div class="card-footer bg-light d-flex justify-content-between">
            <a href="<?= base_url('admin/atur-kuesioner') ?>" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </div>
</form>

<script>
    document.getElementById('checkAll').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('.q-check');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    });
</script>
<?= $this->endSection() ?>
