<?= $this->extend('admin/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Mahasiswa</h2>
        <a href="<?= base_url('admin/mahasiswa/create') ?>" class="btn btn-primary">Tambah Mahasiswa</a>
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
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Prodi</th>
                        <th>Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mahasiswa as $item) : ?>
                    <tr>
                        <td><?= $item['nim'] ?></td>
                        <td><?= $item['nama_mahasiswa'] ?></td>
                        <td><?= $item['nama_prodi'] ?? '-' ?></td>
                        <td><?= $item['nama_jurusan'] ?? '-' ?></td>
                        <td>
                            <a href="<?= base_url('admin/mahasiswa/edit/'.$item['nim']) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?= base_url('admin/mahasiswa/delete/'.$item['nim']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
