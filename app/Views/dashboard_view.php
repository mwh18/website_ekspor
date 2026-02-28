<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .stat-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .stat-card .icon {
        font-size: 2rem;
        width: 60px;
        height: 60px;
        border-radius: 12px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stat-card h3 {
        font-weight: 700;
    }
    .quick-access-card {
        border-radius: 12px;
        transition: all 0.3s ease;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .quick-access-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        background-color: var(--primary-color);
        color: #fff;
    }
    .quick-access-card:hover .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
    }
    .quick-access-card .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        background-color: rgba(13, 110, 253, 0.1);
        color: var(--primary-color);
        transition: all 0.3s ease;
    }
    .quick-access-card:hover .icon-circle {
        background-color: #fff;
    }
</style>


<div class="card bg-primary text-white mb-4">
    <div class="card-body p-4">
        <h4 class="card-title fw-bold">Selamat Datang Kembali, <?= esc(session()->get('username')) ?>!</h4>
        <p class="card-text mb-0">Anda berada di Dashboard Sistem Prediksi Ekspor. Mari mulai analisis data Anda.</p>
    </div>
</div>


<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card p-3 bg-white">
            <div class="d-flex align-items-center">
                <div class="icon bg-success me-3">
                    <i class="fas fa-box"></i>
                </div>
                <div>
                    <h3 class="mb-0"><?= $totalProduk ?></h3>
                    <p class="text-muted mb-0">Produk Dikelola</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card p-3 bg-white">
            <div class="d-flex align-items-center">
                <div class="icon bg-warning me-3">
                    <i class="fas fa-database"></i>
                </div>
                <div>
                    <h3 class="mb-0"><?= $totalData ?></h3>
                    <p class="text-muted mb-0">Total Data Historis</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card p-3 bg-white">
            <div class="d-flex align-items-center">
                <div class="icon bg-info me-3">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div>
                    <h3 class="mb-0 fs-5"><?= $periodeTerakhir ?></h3>
                    <p class="text-muted mb-0">Periode Data Terakhir</p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row g-4">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Tren Nilai Ekspor (12 Bulan Terakhir)</h5>
            </div>
            <div class="card-body">
                <div style="height: 300px;">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="d-flex flex-column h-100">
            <h5 class="mb-3">Akses Cepat</h5>
            <a href="/peramalan" class="text-decoration-none text-dark">
                <div class="quick-access-card p-3 mb-3 flex-grow-1">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle me-3">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Lakukan Peramalan</h6>
                            <p class="text-muted small mb-0">Mulai prediksi baru</p>
                        </div>
                    </div>
                </div>
            </a>
            <a href="/hasil-peramalan" class="text-decoration-none text-dark <?= !session()->has('hasil_prediksi') ? 'disabled' : '' ?>">
                <div class="quick-access-card p-3 flex-grow-1">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle me-3">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Lihat Hasil Terakhir</h6>
                            <p class="text-muted small mb-0">Tampilkan hasil prediksi</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('trendChart').getContext('2d');
    const trendChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= $chartLabels ?>,
            datasets: [{
                label: 'Total Nilai Ekspor',
                data: <?= $chartValues ?>,
                borderColor: 'rgba(13, 110, 253, 1)',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: false
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
<?= $this->endSection() ?>