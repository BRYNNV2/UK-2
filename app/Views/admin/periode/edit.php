<?= $this->extend('admin/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Edit Periode</h2>
    <div class="card mt-3">
        <div class="card-body">
            <form action="<?= base_url('admin/periode/update/' . $periode['id_periode']) ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Semester</label>
                        <select name="semester" class="form-control" required>
                            <option value="Ganjil" <?= ($current_semester == 'Ganjil') ? 'selected' : '' ?>>Ganjil</option>
                            <option value="Genap" <?= ($current_semester == 'Genap') ? 'selected' : '' ?>>Genap</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Tahun Ajaran</label>
                        <select name="tahun" class="form-control" required>
                            <?php 
                            $startYear = date('Y') - 3;
                            for ($i = 0; $i < 6; $i++) : 
                                $y1 = $startYear + $i;
                                $y2 = $y1 + 1;
                                $val = "$y1/$y2";
                            ?>
                                <option value="<?= $val ?>" <?= ($val == $current_tahun) ? 'selected' : '' ?>><?= $val ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status_periode" class="form-control" required>
                        <option value="Tidak Aktif" <?= ($periode['status_periode'] == 'Tidak Aktif') ? 'selected' : '' ?>>Tidak Aktif</option>
                        <option value="Aktif" <?= ($periode['status_periode'] == 'Aktif') ? 'selected' : '' ?>>Aktif</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="<?= base_url('admin/periode') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
