<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>
Manajemen Data Historis
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- BAGIAN GRAFIK DENGAN DESAIN BARU -->
<div class="row g-4 mb-4">
    <!-- Grafik Pisang -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header bg-white border-0">
                <h5 class="card-title mb-0 fs-6">Tren Nilai Ekspor Pisang</h5>
            </div>
            <div class="card-body">
                <div style="height: 250px;">
                    <canvas id="pisangChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- Grafik Kopi -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header bg-white border-0">
                <h5 class="card-title mb-0 fs-6">Tren Nilai Ekspor Kopi</h5>
            </div>
            <div class="card-body">
                <div style="height: 250px;">
                    <canvas id="kopiChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- Grafik Kelapa -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header bg-white border-0">
                <h5 class="card-title mb-0 fs-6">Tren Nilai Ekspor Kelapa</h5>
            </div>
            <div class="card-body">
                <div style="height: 250px;">
                    <canvas id="kelapaChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- AKHIR BAGIAN GRAFIK -->


<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Tabel Rincian Data Ekspor</h5>
            <a href="/data-historis/new" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Data</a>
        </div>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Tahun</th>
                        <th>Bulan</th>
                        <th>Nilai Ekspor</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach($data_historis as $data): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($data['nama_produk']) ?></td>
                        <td><?= esc($data['tahun']) ?></td>
                        <td><?= esc($data['bulan']) ?></td>
                        <td><?= number_format($data['jumlah_ekspor'], 2, ',', '.') ?></td>
                        <td class="text-center">
                            <a href="/data-historis/edit/<?= $data['id_data'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <a href="/data-historis/delete/<?= $data['id_data'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Memuat Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Ambil data dari controller
    const chartData = <?= $chartData ?>;

    // Fungsi untuk membuat grafik dengan gaya simpel
    const createChart = (canvasId, label, data, color) => {
        const ctx = document.getElementById(canvasId).getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: `Nilai Ekspor ${label}`,
                    data: data.values,
                    borderColor: color,
                    borderWidth: 2, // Garis sedikit lebih tebal
                    fill: false, // Menghilangkan area warna di bawah garis
                    tension: 0.1, // Garis sedikit melengkung, tidak kaku
                    pointRadius: 2, // Menampilkan titik data
                    pointBackgroundColor: color
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: false,
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) return (value / 1000000) + ' Jt';
                                if (value >= 1000) return (value / 1000) + ' Rb';
                                return value;
                            }
                        }
                    },
                    x: {
                        ticks: {
                            maxTicksLimit: 8
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    };

    // Buat grafik untuk setiap produk
    if (chartData['Pisang']) {
        createChart('pisangChart', 'Pisang', chartData['Pisang'], 'rgba(54, 162, 235, 1)');
    }
    if (chartData['Kopi']) {
        createChart('kopiChart', 'Kopi', chartData['Kopi'], 'rgba(115, 99, 251, 1)');
    }
    if (chartData['Kelapa']) {
        createChart('kelapaChart', 'Kelapa', chartData['Kelapa'], 'rgba(45, 206, 137, 1)');
    }
</script>
<?= $this->endSection() ?>