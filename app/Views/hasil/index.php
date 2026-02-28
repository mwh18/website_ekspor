<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>Hasil Peramalan<?= $this->endSection() ?>

<?= $this->section('page_title') ?><?= esc($page_title ?? 'Hasil Peramalan') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
// --- [LOGIKA PHP ANDA - TIDAK DIUBAH] ---
// Cek apakah ada hasil yang valid dari session
$hasil = session()->get('hasil_peramalan');
$hasResult = isset($hasil) && !empty($hasil) && isset($hasil['prediksi']);
$produkName = ($hasResult && isset($hasil['produk']['nama_produk'])) ? $hasil['produk']['nama_produk'] : 'Tidak Diketahui';

if ($hasResult) {
    $data_historis    = $hasil['data_historis'];
    $prediksi         = $hasil['prediksi'];
    $mape             = $hasil['mape'] ?? null;
    $mae              = $hasil['mae'] ?? null;
    $periode_prediksi = count($prediksi);
    $data_terakhir    = end($data_historis);

    // Persiapan data untuk Chart.js
    $labels = [];
    $dataAsli = [];
    foreach ($data_historis as $data) {
        $labels[] = date('M Y', strtotime($data['tahun'] . '-' . $data['bulan'] . '-01'));
        $dataAsli[] = (float)$data['jumlah_ekspor'];
    }
    
    $dataPred = array_fill(0, count($dataAsli) - 1, null);
    $dataPred[] = end($dataAsli);
    
    $last_date = new DateTime($data_terakhir['tahun'] . '-' . $data_terakhir['bulan'] . '-01');
    for ($i = 0; $i < count($prediksi); $i++) {
        $last_date->modify('+1 month');
        $labels[] = $last_date->format('M Y');
        $dataPred[] = isset($prediksi[$i]) ? (float)$prediksi[$i] : null;
    }

    // Persiapan data untuk tabel prediksi
    $tableBody = [];
    $curDate = new DateTime($data_terakhir['tahun'] . '-' . $data_terakhir['bulan'] . '-01');
    foreach($prediksi as $index => $val) {
        $curDate->modify('+1 month');
        $tableBody[] = [
            (string)($index + 1),
            $curDate->format('F Y'),
            number_format((float)$val, 2, ',', '.')
        ];
    }
}

// Fungsi untuk interpretasi MAPE
function getMapeInterpretation($mape) {
    if ($mape === null) return ['badge' => 'secondary', 'text' => 'Tidak tersedia.'];
    if ($mape < 10) return ['badge' => 'success', 'text' => 'Akurasi Sangat Baik'];
    if ($mape <= 20) return ['badge' => 'primary', 'text' => 'Akurasi Baik'];
    if ($mape <= 50) return ['badge' => 'warning', 'text' => 'Akurasi Cukup'];
    return ['badge' => 'danger', 'text' => 'Akurasi Rendah'];
}

$mapeInfo = getMapeInterpretation($mape ?? null);
?>

<!-- [BAGIAN TAMPILAN BARU - MODERN & INTERAKTIF] -->
<style>
    .metric-card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .metric-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    .metric-icon {
        font-size: 2rem;
        padding: 1rem;
        border-radius: 50%;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
    }
    .main-content-card {
        border-radius: 0.75rem;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }
    .no-result-card {
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="<?= site_url('peramalan') ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> &nbsp;Lakukan Peramalan Baru
    </a>
    <?php if ($hasResult): ?>
    <button class="btn btn-primary" id="btnPdf">
        <i class="fas fa-file-pdf"></i> &nbsp;Unduh Laporan PDF
    </button>
    <?php endif; ?>
</div>

<?php if ($hasResult): ?>
    
    <!-- Bagian Metrik / Ringkasan -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card metric-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="metric-icon bg-info mr-3"><i class="fas fa-box"></i></div>
                    <div>
                        <h6 class="card-subtitle text-muted">Komoditas</h6>
                        <h5 class="card-title mb-0 font-weight-bold"><?= esc($produkName) ?></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card metric-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="metric-icon bg-success mr-3"><i class="fas fa-bullseye"></i></div>
                    <div>
                        <h6 class="card-subtitle text-muted">MAPE</h6>
                        <h5 class="card-title mb-0 font-weight-bold"><?= isset($mape) ? number_format($mape, 2, ',', '.') . '%' : 'N/A' ?></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card metric-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="metric-icon bg-warning mr-3"><i class="fas fa-calculator"></i></div>
                    <div>
                        <h6 class="card-subtitle text-muted">MAE</h6>
                        <h5 class="card-title mb-0 font-weight-bold"><?= isset($mae) ? number_format($mae, 2, ',', '.') : 'N/A' ?></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card metric-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="metric-icon bg-<?= $mapeInfo['badge'] ?> mr-3"><i class="fas fa-check-circle"></i></div>
                    <div>
                        <h6 class="card-subtitle text-muted">Interpretasi</h6>
                        <h5 class="card-title mb-0 font-weight-bold"><?= $mapeInfo['text'] ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Grafik dan Tabel -->
    <div class="card main-content-card">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><i class="fas fa-chart-line"></i> &nbsp;Visualisasi Data Peramalan</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div style="height: 450px;">
                        <canvas id="predictionChart"></canvas>
                    </div>
                </div>
                <div class="col-lg-12">
                    <h5 class="mb-3">Tabel Rincian Prediksi</h5>
                    <div class="table-responsive" style="max-height: 400px;">
                        <table class="table table-striped table-hover table-bordered mb-0">
                            <thead class="thead-dark" style="position: sticky; top: 0;">
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th>Periode Prediksi</th>
                                    <th class="text-right">Jumlah Prediksi (Ton)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tableBody as $row): ?>
                                <tr>
                                    <td><?= $row[0] ?></td>
                                    <td><?= $row[1] ?></td>
                                    <td class="text-right font-weight-bold"><?= $row[2] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>
    <!-- Tampilan jika TIDAK ADA hasil -->
    <div class="card main-content-card no-result-card">
        <div class="card-body text-center py-5">
            <i class="fas fa-info-circle fa-4x text-primary mb-3"></i>
            <h4 class="card-title">Belum Ada Hasil Peramalan</h4>
            <p class="card-text text-muted">
                Hasil peramalan akan ditampilkan di sini setelah Anda memproses data.
            </p>
            <a href="<?= site_url('peramalan') ?>" class="btn btn-primary mt-3">
                <i class="fas fa-calculator"></i> &nbsp;Mulai Lakukan Peramalan
            </a>
        </div>
    </div>
<?php endif; ?>

<?php if ($hasResult): ?>
<!-- [LOGIKA JAVASCRIPT BARU - LEBIH INTERAKTIF] -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@2.0.1"></script> <!-- Plugin untuk zoom & pan -->
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jspdf-autotable@3.8.2/dist/jspdf.plugin.autotable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const labels = <?= json_encode($labels ?? []) ?>;
        const dataAsli = <?= json_encode($dataAsli ?? []) ?>;
        const dataPred = <?= json_encode($dataPred ?? []) ?>;

        const ctx = document.getElementById('predictionChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    { 
                        label: 'Data Historis (Ton)', 
                        data: dataAsli, 
                        borderColor: 'rgba(54, 162, 235, 1)', 
                        backgroundColor: 'rgba(54, 162, 235, 0.1)', 
                        borderWidth: 2.5, 
                        tension: 0.4, 
                        fill: true,
                        pointRadius: 2,
                        pointHoverRadius: 5
                    },
                    { 
                        label: 'Data Prediksi (Ton)', 
                        data: dataPred, 
                        borderColor: 'rgba(255, 99, 132, 1)', 
                        backgroundColor: 'rgba(255, 99, 132, 0.1)', 
                        borderWidth: 2.5, 
                        borderDash: [5, 5], 
                        tension: 0.4, 
                        fill: true,
                        pointRadius: 2,
                        pointHoverRadius: 5
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                plugins: {
                    legend: { 
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8
                        }
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 12 },
                        padding: 10,
                        cornerRadius: 5,
                        displayColors: true,
                        boxPadding: 4,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', { maximumFractionDigits: 2 }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    },
                    zoom: { // Opsi untuk plugin zoom
                        pan: {
                            enabled: true,
                            mode: 'x', // Pan hanya pada sumbu X (waktu)
                        },
                        zoom: {
                            wheel: {
                                enabled: true, // Zoom dengan scroll mouse
                            },
                            pinch: {
                                enabled: true // Zoom dengan cubit di perangkat sentuh
                            },
                            mode: 'x',
                        }
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: false, // Mulai dari nilai terdekat
                        title: { display: true, text: 'Jumlah Ekspor (Ton)' },
                        grid: {
                            color: '#e9ecef'
                        }
                    },
                    x: { 
                        title: { display: true, text: 'Periode' },
                        grid: { 
                            display: false 
                        } 
                    }
                }
            }
        });

        // --- [LOGIKA PDF ANDA - TIDAK DIUBAH] ---
        document.getElementById('btnPdf').addEventListener('click', () => {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({ orientation: 'p', unit: 'pt', format: 'a4' });
            const margin = 40;
            const pageW = doc.internal.pageSize.getWidth();
            const contentW = pageW - margin * 2;
            let finalY = 0;

            doc.setFont('helvetica', 'bold');
            doc.setFontSize(16);
            doc.text('Laporan Hasil Peramalan', margin, 50);
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(10);
            doc.text('Nama Komoditas: <?= addslashes($produkName) ?>', margin, 66);
            doc.text('Tanggal Dibuat: ' + new Date().toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric'}), margin, 80);

            doc.autoTable({
                startY: 100,
                head: [['Item Evaluasi', 'Nilai']],
                body: [
                    ['Periode Prediksi', '<?= $periode_prediksi ?> Bulan'],
                    ['Mean Absolute Percentage Error (MAPE)', '<?= isset($mape) ? number_format($mape, 2, ",", ".") . "%" : "N/A" ?>'],
                    ['Mean Absolute Error (MAE)', '<?= isset($mae) ? number_format($mae, 2, ",", ".") : "N/A" ?>']
                ],
                theme: 'grid',
                headStyles: { fillColor: [22, 163, 74] }
            });
            finalY = doc.lastAutoTable.finalY + 20;

            const canvas = document.getElementById('predictionChart');
            const imgData = canvas.toDataURL('image/png', 1.0);
            const imgHeight = (canvas.height * contentW) / canvas.width;
            doc.addImage(imgData, 'PNG', margin, finalY, contentW, imgHeight);
            finalY += imgHeight + 20;

            doc.autoTable({
                startY: finalY,
                head: [['No', 'Periode Prediksi', 'Jumlah Ekspor (Prediksi)']],
                body: <?= json_encode($tableBody ?? []) ?>,
                theme: 'striped',
                headStyles: { fillColor: [0, 123, 255] }
            });

            const safeName = '<?= preg_replace("/[^A-Za-z0-9_-]/", "_", $produkName) ?>';
            doc.save(`Laporan_Peramalan_${safeName}.pdf`);
        });
    });
</script>
<?php endif; ?>
<?= $this->endSection() ?>
