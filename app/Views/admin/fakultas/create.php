<?= $this->extend('admin/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Tambah Fakultas</h2>
    <div class="card mt-3">
        <div class="card-body">
            <form action="<?= base_url('admin/fakultas/store') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label>Nama Fakultas</label>
                    <input type="text" name="nama_fakultas" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('admin/fakultas') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
