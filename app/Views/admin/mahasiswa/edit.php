<?= $this->extend('admin/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Edit Mahasiswa</h2>
    <div class="card mt-3">
        <div class="card-body">
            <form action="<?= base_url('admin/mahasiswa/update/' . $mahasiswa['nim']) ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label>NIM</label>
                    <input type="text" name="nim" class="form-control" value="<?= $mahasiswa['nim'] ?>" required>
                </div>

                <div class="mb-3">
                    <label>Nama Mahasiswa</label>
                    <input type="text" name="nama_mahasiswa" class="form-control" value="<?= $mahasiswa['nama_mahasiswa'] ?>" required>
                </div>

                <div class="mb-3">
                    <label>Program Studi</label>
                    <select name="id_prodi" class="form-control" required>
                        <option value="">-- Pilih Prodi --</option>
                        <?php foreach ($prodi as $p) : ?>
                            <option value="<?= $p['id_prodi'] ?>" <?= ($p['id_prodi'] == $mahasiswa['id_prodi']) ? 'selected' : '' ?>>
                                <?= $p['nama_prodi'] ?> (<?= $p['jenjang'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="<?= base_url('admin/mahasiswa') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
