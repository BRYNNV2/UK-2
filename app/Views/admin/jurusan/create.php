<?= $this->extend('admin/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Tambah Jurusan</h2>
    <div class="card mt-3">
        <div class="card-body">
            <form action="<?= base_url('admin/jurusan/store') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label>Nama Jurusan</label>
                    <input type="text" name="nama_jurusan" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Fakultas</label>
                    <select name="id_fakultas" class="form-control" required>
                        <option value="">-- Pilih Fakultas --</option>
                        <?php foreach ($fakultas as $fk) : ?>
                            <option value="<?= $fk['id_fakultas'] ?>"><?= $fk['nama_fakultas'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('admin/jurusan') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
