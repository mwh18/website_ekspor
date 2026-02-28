<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>
Tentang Sistem - Prediksi Ekspor
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    
    :root {
        --primary-color: #0d6efd;
        --primary-light: #e0e7ff;
        --secondary-color: #10b981;
        --bg-light-gray: #f9fafb;
        --text-dark: #111827;
        --text-medium: #4b5563;
        --text-light: #6b7280;
        --border-color: #e5e7eb;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.07), 0 2px 4px -2px rgba(0, 0, 0, 0.07);
        --card-hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
    }

    .about-wrapper {
        font-family: 'Inter', sans-serif;
        background-color: var(--bg-light-gray);
        padding: 4rem 0;
    }

    .about-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
    }

    
    .hero-section {
        text-align: center;
        margin-bottom: 5rem;
    }

    .hero-section .badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 9999px;
        background-color: var(--primary-light);
        color: var(--primary-color);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }

    .hero-section h1 {
        font-size: 3.5rem;
        font-weight: 700;
        color: var(--text-dark);
        line-height: 1.2;
        margin-bottom: 1.5rem;
        background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-section p {
        font-size: 1.2rem;
        color: var(--text-medium);
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.7;
    }

    /* Grid Konten Utama */
    .main-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 2.5rem;
    }

    /* Layout untuk layar lebih besar */
    @media (min-width: 1024px) {
        .main-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    /* Styling Kartu Informasi */
    .info-card {
        background-color: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .info-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--card-hover-shadow);
    }

    .info-card .card-icon-wrapper {
        width: 64px;
        height: 64px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 2rem;
        font-size: 1.8rem;
    }
    
    .icon-purpose { background-color: #e0e7ff; color: #4f46e5; }
    .icon-method { background-color: #d1fae5; color: #059669; }
    .icon-tech { background-color: #fee2e2; color: #ef4444; }

    .info-card h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .info-card p, .info-card li {
        color: var(--text-light);
        line-height: 1.8;
        font-size: 1rem;
    }
    
    .info-card .tech-list {
        list-style: none;
        padding: 0;
        margin-top: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .info-card .tech-list li {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .info-card .tech-list i {
        font-size: 1.25rem;
        width: 24px;
        text-align: center;
        opacity: 0.7;
    }
    
    .tech-list .fa-php { color: #7A86B8; }
    .tech-list .fa-python { color: #306998; }
    .tech-list .fa-brain { color: #f59e0b; }
    .tech-list .fa-database { color: #00758f; }
    .tech-list .fa-bootstrap { color: #7952b3; }

</style>

<div class="about-wrapper">
    <div class="about-container">

        
        <header class="hero-section">
            <span class="badge">Platform Analitik Cerdas</span>
            
            <h1>Prediksi Cerdas untuk Ekspor Anda</h1>
            <p>Analisis data ekspor historis untuk menghasilkan perkiraan tren masa depan yang akurat dan dapat diandalkan.</p>
            
        </header>

        
        <div class="main-grid">
            
            
            <div class="info-card">
                <div class="card-icon-wrapper icon-purpose">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3>Tujuan Sistem</h3>
                <p>
                    Menyediakan alat yang mudah digunakan untuk meramal data ekspor, membantu siapa saja memahami pola data untuk membuat prediksi akurat bagi perencanaan di masa depan.
                </p>
            </div>

            
            <div class="info-card">
                <div class="card-icon-wrapper icon-method">
                    <i class="fas fa-wave-square"></i>
                </div>
                <h3>Metodologi Inti: ARIMA</h3>
                <p>
                    <strong>AutoRegressive Integrated Moving Average (ARIMA)</strong> adalah model statistik andal yang menjadi inti dari sistem ini. Kami menggunakan <code>auto_arima</code> untuk secara cerdas menemukan parameter model terbaik, memastikan peramalan yang optimal untuk setiap set data.
                </p>
            </div>

            
            <div class="info-card">
                <div class="card-icon-wrapper icon-tech">
                    <i class="fas fa-layer-group"></i>
                </div>
                <h3>Arsitektur Teknologi</h3>
                <ul class="tech-list">
                    <li><i class="fab fa-php"></i><div><strong>Backend Web:</strong> CodeIgniter 4</div></li>
                    <li><i class="fab fa-python"></i><div><strong>API Prediksi:</strong> Flask (Python)</div></li>
                    <li><i class="fas fa-brain"></i><div><strong>Machine Learning:</strong> Pmdarima & Pandas</div></li>
                    <li><i class="fas fa-database"></i><div><strong>Database:</strong> MySQL</div></li>
                    <li><i class="fab fa-bootstrap"></i><div><strong>Frontend:</strong> Bootstrap 5 & Chart.js</div></li>
                </ul>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection() ?>
