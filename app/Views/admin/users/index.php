<?= $this->extend('admin/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Kelola User</h2>
        <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary">Tambah User</a>
    </div>

    <?php if (session()->getFlashdata('message')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama User</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                    <tr id="user-row-<?= $user['id'] ?>">
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['nama_user'] ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td>
                            <span class="badge bg-info"><?= $user['role_name'] ?></span>
                        </td>
                        <td>
                            <?php if ($user['active']) : ?>
                                <span class="badge bg-success">Aktif</span>
                            <?php else : ?>
                                <span class="badge bg-secondary">Non-Aktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/users/edit/'.$user['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="<?= $user['id'] ?>" data-name="<?= $user['nama_user'] ?>">Hapus</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all delete buttons
    const deleteButtons = document.querySelectorAll('.btn-delete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const userId = this.getAttribute('data-id');
            const userName = this.getAttribute('data-name');
            
            // Confirm deletion
            if (!confirm(`Yakin ingin menghapus user "${userName}"?`)) {
                return;
            }
            
            // Disable button
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Hapus...';
            
            // Send AJAX request
            fetch('<?= base_url('admin/users/delete/') ?>' + userId, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove row with fade effect
                    const row = document.getElementById('user-row-' + userId);
                    row.style.transition = 'opacity 0.3s';
                    row.style.opacity = '0';
                    
                    setTimeout(() => {
                        row.remove();
                        
                        // Show success notification
                        showNotification('success', data.message);
                    }, 300);
                } else {
                    // Show error and re-enable button
                    showNotification('error', data.message);
                    this.disabled = false;
                    this.innerHTML = 'Hapus';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Terjadi kesalahan saat menghapus user');
                this.disabled = false;
                this.innerHTML = 'Hapus';
            });
        });
    });
    
    // Notification function
    function showNotification(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const notification = document.createElement('div');
        notification.className = `alert ${alertClass} alert-dismissible fade show`;
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // Insert notification
        const container = document.querySelector('.container');
        container.insertBefore(notification, container.firstChild);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
});
</script>
<?= $this->endSection() ?>
