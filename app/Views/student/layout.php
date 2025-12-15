<!DOCTYPE html>
<html lang="en">
<?php helper('auth'); ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahasiswa Dashboard - UK2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-blue: #1976d2;
            --dark-blue: #0d47a1;
            --light-blue: #e3f2fd;
            --sidebar-bg: #ffffff;
            --sidebar-hover: #f5f5f5;
            --sidebar-active: #1976d2;
            --header-bg: #0d47a1;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
        }

        /* Top Header */
        .top-header {
            background: linear-gradient(135deg, var(--header-bg) 0%, #1565c0 100%);
            height: 60px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            padding: 0 20px;
        }

        .top-header .system-title {
            color: white;
            font-size: 18px;
            font-weight: 600;
            margin-left: 15px;
            flex-grow: 1;
        }

        .top-header .user-info {
            color: white;
            font-size: 14px;
            margin-right: 20px;
        }

        .top-header .btn-logout {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            padding: 6px 15px;
            border-radius: 4px;
            font-size: 14px;
            transition: all 0.3s;
            text-decoration: none;
        }

        .top-header .btn-logout:hover {
            background: rgba(255,255,255,0.3);
        }

        /* Sidebar Toggle Button */
        .sidebar-toggle {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .sidebar-toggle:hover {
            background: rgba(255,255,255,0.3);
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 60px;
            left: 0;
            width: 250px;
            height: calc(100vh - 60px);
            background: var(--sidebar-bg);
            border-right: 1px solid #dee2e6;
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 999;
        }

        .sidebar.collapsed {
            left: -250px;
        }

        .sidebar-menu {
            padding: 15px 0;
        }

        .sidebar-menu .menu-section {
            color: #6c757d;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            padding: 15px 20px 8px;
            letter-spacing: 0.5px;
        }

        .sidebar-menu .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #495057;
            text-decoration: none;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .sidebar-menu .menu-item:hover {
            background: var(--sidebar-hover);
            color: #212529;
            border-left-color: #dee2e6;
        }

        .sidebar-menu .menu-item.active {
            background: linear-gradient(90deg, rgba(25,118,210,0.15) 0%, rgba(25,118,210,0.05) 100%);
            color: var(--primary-blue);
            font-weight: 600;
            border-left-color: var(--sidebar-active);
        }

        .sidebar-menu .menu-item i {
            width: 20px;
            margin-right: 12px;
            font-size: 16px;
        }

        /* Main Content */
        .main-content {
            margin-top: 60px;
            margin-left: 250px;
            padding: 30px;
            transition: all 0.3s ease;
            min-height: calc(100vh - 60px);
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }
            .sidebar.show {
                left: 0;
            }
            .main-content {
                margin-left: 0;
            }
        }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>
<body>
    <!-- Top Header -->
    <div class="top-header">
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="bi bi-list fs-5"></i>
        </button>
        <div class="system-title">
            <i class="bi bi-mortarboard-fill me-2"></i>
            Portal Mahasiswa - Sistem Kuesioner
        </div>
        <div class="user-info">
            <i class="bi bi-person-circle me-1"></i>
            <?= user()->username ?>
        </div>
        <a href="<?= base_url('admin-logout') ?>" class="btn-logout">
            <i class="bi bi-box-arrow-right me-1"></i> Logout
        </a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-menu">
            <!-- Dashboard -->
            <a href="<?= base_url('student') ?>" class="menu-item <?= uri_string() == 'student' ? 'active' : '' ?>">
                <i class="bi bi-house-door"></i>
                <span>Dashboard</span>
            </a>

            <!-- Kuesioner -->
            <?php if (isset($activePeriode) && $activePeriode && isset($hasSubmitted) && !$hasSubmitted): ?>
                <div class="menu-section">Kuesioner</div>
                <a href="<?= base_url('student/kuesioner') ?>" class="menu-item <?= str_contains(uri_string(), 'kuesioner') ? 'active' : '' ?>">
                    <i class="bi bi-pencil-square"></i>
                    <span>Isi Kuesioner</span>
                </a>
            <?php endif; ?>
            
            <!-- Profile -->
            <div class="menu-section">Akun</div>
            <a href="<?= base_url('student/profile') ?>" class="menu-item <?= str_contains(uri_string(), 'profile') ? 'active' : '' ?>">
                <i class="bi bi-person"></i>
                <span>Profil Saya</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <?= $this->renderSection('content') ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('sidebarToggle');

        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });

        // Mobile: Close sidebar when clicking outside
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickOnToggle = toggleBtn.contains(event.target);
                
                if (!isClickInsideSidebar && !isClickOnToggle && sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                }
            }
        });

        // Handle mobile toggle
        if (window.innerWidth <= 768) {
            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                sidebar.classList.toggle('show');
            });
        }
    </script>
</body>
</html>
