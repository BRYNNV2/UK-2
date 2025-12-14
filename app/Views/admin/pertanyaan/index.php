<?= $this->extend('admin/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Bank Pertanyaan</h2>
        <a href="<?= base_url('admin/pertanyaan/create') ?>" class="btn btn-primary">Tambah Pertanyaan</a>
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
                        <th width="5%">ID</th>
                        <th width="50%">Pertanyaan</th>
                        <th width="20%">Untuk Prodi</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pertanyaan as $item) : ?>
                    <tr>
                        <td><?= $item['id_pertanyaan'] ?></td>
                        <td><?= $item['pertanyaan'] ?></td>
                        <td><?= $item['nama_prodi'] ?></td>
                        <td>
                            <a href="<?= base_url('admin/pertanyaan/edit/'.$item['id_pertanyaan']) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?= base_url('admin/pertanyaan/delete/'.$item['id_pertanyaan']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
