<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    
    :root {
        --primary-color: #0d6efd;
        --success-color: #198754;
        --background-light: #f8f9fa;
        --text-dark: #212529;
        --text-muted: #6c757d;
        --border-radius: 1rem; /* 16px */
        --box-shadow: 0 8px 25px rgba(0, 0, 0, 0.07);
    }

    .content-wrapper {
        font-family: 'Inter', sans-serif;
        background-color: var(--background-light);
    }

   
    .welcome-banner {
        background: linear-gradient(110deg, #0d6efd 0%, #0056b3 100%);
        color: #fff;
        padding: 3rem;
        border-radius: var(--border-radius);
        margin-bottom: 2.5rem;
        position: relative;
        overflow: hidden;
    }
    .welcome-banner::before {
        content: '\f080'; 
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        font-size: 12rem;
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%) rotate(-15deg);
        opacity: 0.1;
    }
    .welcome-banner h1 {
        font-weight: 700;
        font-size: 2.5rem;
    }
    .welcome-banner p {
        font-size: 1.15rem;
        max-width: 600px;
        opacity: 0.9;
    }

    
    .guide-card {
        background-color: #fff;
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        height: 100%;
    }
    .guide-card h2 {
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: var(--text-dark);
        display: flex;
        align-items: center;
    }
    .guide-card h2 i {
        color: var(--primary-color);
        margin-right: 0.75rem;
    }
    .guide-card .step {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1.25rem;
    }
    .guide-card .step-number {
        background-color: var(--background-light);
        color: var(--primary-color);
        font-weight: 700;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-right: 1rem;
    }
    .guide-card .step-text {
        color: var(--text-muted);
    }
    .guide-card .step-text strong {
        color: var(--text-dark);
        font-weight: 600;
    }

    
    .action-card {
        background-color: #fff;
        padding: 2rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        color: var(--text-dark);
        box-shadow: var(--box-shadow);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .action-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        color: #fff;
    }
    .action-card .icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        width: 70px;
        height: 70px;
        border-radius: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        transition: transform 0.3s ease;
    }
    .action-card:hover .icon {
        transform: scale(1.1);
    }
    .action-card.card-peramalan .icon { background-color: var(--primary-color); }
    .action-card.card-hasil .icon { background-color: var(--success-color); }
    
    .action-card h3 {
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }
    .action-card p {
        margin-bottom: 0;
        color: var(--text-muted);
        transition: color 0.3s ease;
    }
    .action-card:hover p {
        color: rgba(255,255,255,0.85);
    }
    .action-card .arrow {
        position: absolute;
        bottom: 1.5rem;
        right: 1.5rem;
        font-size: 1.5rem;
        opacity: 0;
        transform: translateX(-15px);
        transition: all 0.3s ease;
    }
    .action-card:hover .arrow {
        opacity: 1;
        transform: translateX(0);
    }
    .action-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        transition: opacity 0.4s ease;
        z-index: -1;
        opacity: 0;
    }
    .action-card.card-peramalan::before { background: var(--primary-color); }
    .action-card.card-hasil::before { background: var(--success-color); }
    .action-card:hover::before {
        opacity: 1;
    }
</style>

<div class="container-fluid px-0">
    <div class="row">
        <div class="col-12">
          
            <div class="welcome-banner">
                <h1>Selamat Datang, <?= esc(session()->get('username')) ?>!</h1>
                <p>Platform Analisis Prediktif untuk membuka wawasan masa depan data ekspor Anda.</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-7 d-flex">
            <div class="guide-card">
                <h2><i class="fas fa-rocket"></i>Mulai dalam 3 Langkah Mudah</h2>
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-text">
                        <strong>Mulai Analisis</strong>
                        <br>Pilih menu "Lakukan Peramalan" untuk memulai proses prediksi data Anda.
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-text">
                        <strong>Tentukan Parameter</strong>
                        <br>Pilih komoditas dan periode waktu yang ingin Anda proyeksikan ke masa depan.
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-text">
                        <strong>Dapatkan Wawasan</strong>
                        <br>Lihat hasil peramalan yang disajikan dalam bentuk grafik dan tabel yang mudah dipahami.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="row g-4 h-100">
                <div class="col-12 d-flex">
                    <a href="<?= site_url('peramalan') ?>" class="action-card card-peramalan w-100">
                        <div class="icon"><i class="fas fa-calculator"></i></div>
                        <div>
                            <h3>Lakukan Peramalan</h3>
                            <p>Mulai analisis prediktif baru.</p>
                        </div>
                        <div class="arrow"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
                <div class="col-12 d-flex">
                    <a href="<?= site_url('hasil-peramalan') ?>" class="action-card card-hasil w-100">
                        <div class="icon"><i class="fas fa-chart-pie"></i></div>
                        <div>
                            <h3>Lihat Hasil Terakhir</h3>
                            <p>Akses laporan peramalan terakhir Anda.</p>
                        </div>
                        <div class="arrow"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
