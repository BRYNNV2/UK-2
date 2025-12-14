<?= $this->extend('admin/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Edit Pertanyaan</h2>
    <div class="card mt-3">
        <div class="card-body">
            <form action="<?= base_url('admin/pertanyaan/update/' . $pertanyaan['id_pertanyaan']) ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label>Isi Pertanyaan</label>
                    <textarea name="pertanyaan" class="form-control" rows="3" required><?= $pertanyaan['pertanyaan'] ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Untuk Program Studi</label>
                    <select name="id_prodi" class="form-control" required>
                        <option value="">-- Pilih Prodi --</option>
                        <?php foreach ($prodi as $p) : ?>
                            <option value="<?= $p['id_prodi'] ?>" <?= ($p['id_prodi'] == $pertanyaan['id_prodi']) ? 'selected' : '' ?>>
                                <?= $p['nama_prodi'] ?> (<?= $p['jenjang'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="<?= base_url('admin/pertanyaan') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
