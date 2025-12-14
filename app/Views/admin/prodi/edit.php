<?= $this->extend('admin/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Edit Program Studi</h2>
    <div class="card mt-3">
        <div class="card-body">
            <form action="<?= base_url('admin/prodi/update/' . $prodi['id_prodi']) ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label>Nama Prodi</label>
                    <input type="text" name="nama_prodi" class="form-control" value="<?= $prodi['nama_prodi'] ?>" required>
                </div>
                
                <div class="mb-3">
                    <label>Jenjang</label>
                    <select name="jenjang" class="form-control" required>
                        <option value="S1" <?= ($prodi['jenjang'] == 'S1') ? 'selected' : '' ?>>S1</option>
                        <option value="D3" <?= ($prodi['jenjang'] == 'D3') ? 'selected' : '' ?>>D3</option>
                        <option value="D4" <?= ($prodi['jenjang'] == 'D4') ? 'selected' : '' ?>>D4</option>
                        <option value="S2" <?= ($prodi['jenjang'] == 'S2') ? 'selected' : '' ?>>S2</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Jurusan</label>
                    <select name="id_jurusan" class="form-control" required>
                        <option value="">-- Pilih Jurusan --</option>
                        <?php foreach ($jurusan as $j) : ?>
                            <option value="<?= $j['id_jurusan'] ?>" <?= ($j['id_jurusan'] == $prodi['id_jurusan']) ? 'selected' : '' ?>>
                                <?= $j['nama_jurusan'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Kaprodi (User)</label>
                    <select name="id_kaprodi" class="form-control">
                        <option value="">-- Pilih Kaprodi (Optional) --</option>
                        <?php if(!empty($kaprodis)): ?>
                            <?php foreach ($kaprodis as $k) : ?>
                                <option value="<?= $k['id'] ?>" <?= (!empty($prodi['id_kaprodi']) && $prodi['id_kaprodi'] == $k['id']) ? 'selected' : '' ?>>
                                    <?= $k['nama_user'] ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="<?= base_url('admin/prodi') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
