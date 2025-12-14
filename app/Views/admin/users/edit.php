<?= $this->extend('admin/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Edit User</h2>
    <div class="card mt-3">
        <div class="card-body">
            <form action="<?= base_url('admin/users/update/'.$user->id) ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_user" class="form-control" value="<?= $user->nama_user ?>" required>
                </div>

                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="<?= $user->username ?>" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?= $user->email ?>" required>
                </div>

                <div class="mb-3">
                    <label>Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" class="form-control" minlength="8">
                </div>

                <div class="mb-3">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        <?php foreach ($groups as $group) : ?>
                            <option value="<?= $group['id'] ?>" <?= ($group['id'] == $current_group_id) ? 'selected' : '' ?>>
                                <?= $group['description'] ?> (<?= $group['name'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
