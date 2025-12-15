<?= $this->extend('admin/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Tambah Mahasiswa</h2>
    <div class="card mt-3">
        <div class="card-body">
            <form action="<?= base_url('admin/mahasiswa/store') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="alert alert-info">
                    <strong>Pilihan:</strong>
                    <ul class="mb-0">
                        <li>Jika sudah ada akun user mahasiswa di menu "Kelola User", pilih dari dropdown di bawah</li>
                        <li>Jika belum ada, kosongkan dropdown dan sistem akan otomatis membuatkan akun baru</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <label>Link ke User yang Sudah Ada (Opsional)</label>
                    <select name="existing_user_id" id="existing_user_id" class="form-control">
                        <option value="">-- Buat Akun Baru --</option>
                        <?php foreach ($available_users as $user) : ?>
                            <option value="<?= $user['id'] ?>">
                                <?= $user['username'] ?> (<?= $user['email'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted">Jika dipilih, NIM dan Password akan menggunakan username user tersebut</small>
                </div>

                <div class="mb-3">
                    <label>NIM</label>
                    <input type="text" name="nim" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Nama Mahasiswa</label>
                    <input type="text" name="nama_mahasiswa" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Program Studi</label>
                    <select name="id_prodi" class="form-control" required>
                        <option value="">-- Pilih Prodi --</option>
                        <?php foreach ($prodi as $p) : ?>
                            <option value="<?= $p['id_prodi'] ?>"><?= $p['nama_prodi'] ?> (<?= $p['jenjang'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('admin/mahasiswa') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
