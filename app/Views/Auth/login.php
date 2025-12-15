<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UK2 Academic System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-blue: #2c5aa0;
            --light-gray: #f5f5f5;
            --pattern-color: #ffd700;
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            background: url('<?= base_url('assets/login-bg.png') ?>') no-repeat center center;
            background-size: cover;
            overflow: hidden;
            position: relative;
        }
        
        /* Overlay untuk memastikan form tetap terbaca */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.1);
            z-index: 0;
        }

        /* Hide SVG pattern karena sudah ada di background image */
        .pattern-left {
            display: none;
        }

        /* Login Container */
        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            position: relative;
            z-index: 10;
            padding: 20px;
        }
        
        .login-box {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 420px;
            padding: 40px 35px;
        }
        
        /* Logo and Header */
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .university-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 15px;
            background: var(--primary-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .university-logo i {
            font-size: 40px;
            color: white;
        }
        
        .login-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        
        .login-subtitle {
            font-size: 14px;
            color: #666;
        }
        
        /* Form Styles */
        .form-label-group {
            position: relative;
            margin-bottom: 20px;
        }
        
        .form-label-group .form-control {
            height: 50px;
            padding: 15px 15px 15px 45px;
            border: 1.5px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .form-label-group .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1);
        }
        
        .form-label-group .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 18px;
        }
        
        .form-label-group label {
            position: absolute;
            left: 45px;
            top: 16px;
            color: #999;
            font-size: 14px;
            pointer-events: none;
            transition: all 0.2s;
        }
        
        .form-label-group .form-control:focus + label,
        .form-label-group .form-control:not(:placeholder-shown) + label {
            top: -8px;
            left: 12px;
            font-size: 11px;
            background: white;
            padding: 0 5px;
            color: var(--primary-blue);
        }
        
        /* Login Button */
        .btn-login {
            width: 100%;
            height: 50px;
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            border: none;
            border-radius: 6px;
            color: #333;
            font-weight: 600;
            font-size: 15px;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.4);
        }
        
        /* Forgot Password */
        .forgot-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: var(--primary-blue);
            text-decoration: none;
            font-size: 13px;
        }
        
        .forgot-link:hover {
            text-decoration: underline;
        }
        
        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            font-size: 12px;
            color: #999;
        }
        
        /* Responsive */
        @media (max-width: 576px) {
            .login-box {
                padding: 30px 25px;
            }
            .pattern-left {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Arabic Calligraphy Decoration -->
    <div class="pattern-left">
        <svg viewBox="0 0 400 600" xmlns="http://www.w3.org/2000/svg">
            <!-- Large flowing Arabic-style shapes -->
            <path d="M120,100 Q180,140 120,180 Q60,140 120,100 Z" fill="currentColor" opacity="0.9"/>
            <path d="M80,230 Q140,270 80,310 Q20,270 80,230 Z" fill="currentColor" opacity="0.85"/>
            <path d="M180,240 Q240,280 180,320 Q120,280 180,240 Z" fill="currentColor" opacity="0.8"/>
            
            <!-- Curved calligraphic strokes -->
            <path d="M50,120 C80,150 120,180 150,200 C120,220 80,250 50,280" stroke="currentColor" stroke-width="8" fill="none" opacity="0.7"/>
            <path d="M160,350 C190,380 230,410 260,430 C230,450 190,480 160,510" stroke="currentColor" stroke-width="10" fill="none" opacity="0.75"/>
            
            <!-- Decorative circles -->
            <circle cx="120" cy="60" r="12" fill="currentColor" opacity="0.9"/>
            <circle cx="80" cy="190" r="10" fill="currentColor" opacity="0.8"/>
            <circle cx="180" cy="200" r="10" fill="currentColor" opacity="0.8"/>
            <circle cx="120" cy="340" r="14" fill="currentColor" opacity="0.85"/>
            <circle cx="160" cy="530" r="16" fill="currentColor" opacity="0.7"/>
            
            <!-- Arabic-style ornamental shapes -->
            <ellipse cx="150" cy="150" rx="30" ry="50" fill="currentColor" opacity="0.4" transform="rotate(20 150 150)"/>
            <ellipse cx="100" cy="400" rx="25" ry="60" fill="currentColor" opacity="0.35" transform="rotate(-15 100 400)"/>
        </svg>
    </div>

    <!-- Login Form -->
    <div class="login-wrapper">
        <div class="login-box">
            <div class="login-header">
                <div class="university-logo">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <h4 class="login-title">Single Sign On</h4>
                <p class="login-subtitle">UK2 Academic System</p>
            </div>

            <?= view('Myth\Auth\Views\_message_block') ?>

            <form action="<?= route_to('login') ?>" method="post">
                <?= csrf_field() ?>

                <!-- User ID / Email -->
                <div class="form-label-group">
                    <i class="bi bi-person input-icon"></i>
                    <?php if ($config->validFields === ['email']): ?>
                        <input type="email" class="form-control" name="login" placeholder=" " required>
                        <label><?=lang('Auth.email')?></label>
                    <?php else: ?>
                        <input type="text" class="form-control" name="login" placeholder=" " required>
                        <label>Masukkan User ID</label>
                    <?php endif; ?>
                </div>

                <!-- Password -->
                <div class="form-label-group">
                    <i class="bi bi-lock input-icon"></i>
                    <input type="password" class="form-control" name="password" placeholder=" " required>
                    <label>Masukkan Password</label>
                </div>

                <!-- Remember Me -->
                <?php if ($config->allowRemembering): ?>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember" style="font-size: 13px; color: #666;">
                        <?=lang('Auth.rememberMe')?>
                    </label>
                </div>
                <?php endif; ?>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-login">Masuk</button>

                <!-- Forgot Password -->
                <?php if ($config->activeResetter): ?>
                <a href="<?= route_to('forgot') ?>" class="forgot-link">Lupa Password?</a>
                <?php endif; ?>
            </form>

            <!-- Footer -->
            <div class="login-footer">
                Copyright © SPTIK UK2 <?= date('Y') ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
