<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi | Prediksi Ekspor</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #0d6efd;
            --primary-dark-hover: #0a58ca;
            --secondary-color: #6c757d;
            --bg-color: #f4f7fc;
            --card-bg: #ffffff;
            --text-color: #34495E;
            --font-family: 'Poppins', sans-serif;
        }
        body {
            font-family: var(--font-family);
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            min-height: 600px;
            background-color: var(--card-bg);
            border-radius: 15px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .login-image-section {
            flex: 1;
            background: linear-gradient(rgba(13, 110, 253, 0.7), rgba(44, 62, 80, 0.7)), url(https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=2070) no-repeat center center;
            background-size: cover;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 50px;
        }
        .login-image-section h1 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .login-image-section p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        .login-form-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }
        .login-box {
            width: 100%;
            max-width: 380px;
        }
        .login-box .logo {
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        .login-box .logo i {
            margin-right: 12px;
        }
        .form-control {
            height: 50px;
            border-radius: 8px;
        }
        .btn-primary {
            padding: 12px;
            font-weight: 600;
        }
        @media (max-width: 992px) {
            .login-image-section {
                display: none;
            }
            .login-container {
                max-width: 450px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-image-section">
        <h1>Mulai Perjalanan Data Anda</h1>
        <p>Daftar untuk mengakses alat peramalan canggih dan ubah data historis menjadi wawasan masa depan.</p>
    </div>

    <div class="login-form-section">
        <div class="login-box">
            <div class="logo">
                <i class="fa-solid fa-user-plus"></i><span>Daftar Akun</span>
            </div>
            <div class="text-center mb-4">
                <h4>Buat Akun Baru</h4>
                <p class="text-muted">Isi data di bawah untuk memulai.</p>
            </div>

            <?php if(session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger pb-0">
                    <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <?= form_open('/register/process') ?>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?= old('username') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="mb-4">
                    <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Daftar Sekarang</button>
            <?= form_close() ?>

            <div class="text-center mt-4">
                <small>Sudah punya akun? <a href="/login">Login di sini</a></small>
            </div>
        </div>
    </div>
</div>

</body>
</html>