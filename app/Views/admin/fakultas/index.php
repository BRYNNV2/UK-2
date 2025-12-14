<?= $this->extend('admin/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Fakultas</h2>
        <a href="<?= base_url('admin/fakultas/create') ?>" class="btn btn-primary">Tambah Fakultas</a>
    </div>

    <?php if (session()->getFlashdata('message')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Fakultas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($fakultas as $item) : ?>
                    <tr>
                        <td><?= $item['id_fakultas'] ?></td>
                        <td><?= $item['nama_fakultas'] ?></td>
                        <td>
                            <a href="<?= base_url('admin/fakultas/edit/'.$item['id_fakultas']) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?= base_url('admin/fakultas/delete/'.$item['id_fakultas']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
