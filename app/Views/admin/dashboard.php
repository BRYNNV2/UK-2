<!DOCTYPE html>
<html lang="en">
<?php helper('auth'); ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - UK2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background-color: #343a40; }
        .sidebar .list-group-item {
            background-color: transparent; border: none; color: #c2c7d0; padding: 12px 20px;
        }
        .sidebar .list-group-item:hover { background-color: #494e53; color: #fff; }
        .sidebar .list-group-item.active { background-color: #007bff; color: #fff; }
        .sidebar .section-header {
            color: #d0d4db; font-size: 0.75rem; text-transform: uppercase; font-weight: bold; padding: 15px 20px 5px; opacity: 0.5;
        }
        .main-content { padding: 30px; }
        .card { border: none; box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2); }
        .navbar-brand { font-weight: bold; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary">
        <div class="container-fluid">
            <!-- Toggle Button -->
            <button class="btn btn-dark me-2 border-0" id="sidebarToggle"><i class="bi bi-list fs-5"></i></button>
            
            <a class="navbar-brand" href="#"><i class="bi bi-shield-lock me-2"></i>UK2 ADMIN</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="<?= base_url('admin-logout') ?>"><i class="bi bi-box-arrow-right me-1"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 p-0 sidebar collapse d-md-block" id="sidebarMenu">
                <div class="list-group list-group-flush pt-2">
                    <a href="<?= base_url('admin') ?>" class="list-group-item list-group-item-action <?= uri_string() == 'admin' ? 'active' : '' ?>">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                    
                    <?php if (in_groups('admin')) : ?>
                        <div class="section-header">Pengguna</div>
                        <a href="<?= base_url('admin/users') ?>" class="list-group-item list-group-item-action <?= str_contains(uri_string(), 'users') ? 'active' : '' ?>">
                            <i class="bi bi-people me-2"></i> Kelola User
                        </a>
    
                        <div class="section-header">Akademik</div>
                        <a href="<?= base_url('admin/fakultas') ?>" class="list-group-item list-group-item-action <?= str_contains(uri_string(), 'fakultas') ? 'active' : '' ?>">
                            <i class="bi bi-building me-2"></i> Fakultas
                        </a>
                        <a href="<?= base_url('admin/jurusan') ?>" class="list-group-item list-group-item-action <?= str_contains(uri_string(), 'jurusan') ? 'active' : '' ?>">
                            <i class="bi bi-diagram-3 me-2"></i> Jurusan
                        </a>
                        <a href="<?= base_url('admin/prodi') ?>" class="list-group-item list-group-item-action <?= str_contains(uri_string(), 'prodi') ? 'active' : '' ?>">
                            <i class="bi bi-mortarboard me-2"></i> Program Studi
                        </a>
    
                        <div class="section-header">Mahasiswa</div>
                        <a href="<?= base_url('admin/mahasiswa') ?>" class="list-group-item list-group-item-action <?= str_contains(uri_string(), 'mahasiswa') ? 'active' : '' ?>">
                            <i class="bi bi-person-vcard me-2"></i> Data Mahasiswa
                        </a>
    
                    <?php endif; ?>
                    

                    <?php if (in_groups(['kaprodi'])) : ?>
                        <div class="section-header">Kuesioner</div>
                        <a href="<?= base_url('admin/periode') ?>" class="list-group-item list-group-item-action <?= str_contains(uri_string(), 'periode') ? 'active' : '' ?>">
                            <i class="bi bi-calendar-event me-2"></i> Atur Periode
                        </a>
                        <a href="<?= base_url('admin/pertanyaan') ?>" class="list-group-item list-group-item-action <?= str_contains(uri_string(), 'pertanyaan') ? 'active' : '' ?>">
                            <i class="bi bi-question-circle me-2"></i> Bank Pertanyaan
                        </a>
                        <a href="<?= base_url('admin/atur-kuesioner') ?>" class="list-group-item list-group-item-action <?= str_contains(uri_string(), 'atur-kuesioner') ? 'active' : '' ?>">
                             <i class="bi bi-list-check me-2"></i> Atur Kuesioner
                        </a>
                    <?php endif; ?>

                    <?php if (in_groups(['pimpinan', 'kaprodi'])) : ?>
                        <div class="section-header">Laporan</div>
                        <a href="<?= base_url('admin/laporan') ?>" class="list-group-item list-group-item-action <?= str_contains(uri_string(), 'laporan') ? 'active' : '' ?>">
                            <i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan Hasil
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Content -->
            <div class="col-md-10 main-content bg-light" id="mainContent">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function(e) {
            e.preventDefault();
            var sidebar = document.getElementById('sidebarMenu');
            var content = document.getElementById('mainContent');
            
            sidebar.classList.toggle('d-none');
            
            if (sidebar.classList.contains('d-none')) {
                content.classList.remove('col-md-10');
                content.classList.add('col-12');
            } else {
                content.classList.remove('col-12');
                content.classList.add('col-md-10');
            }
        });
    </script>
</body>
</html>
