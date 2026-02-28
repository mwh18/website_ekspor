<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>
Lakukan Peramalan
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .forecast-card {
        max-width: 700px;
        margin: auto;
    }
    .forecast-icon {
        font-size: 3rem;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: rgba(13, 110, 253, 0.1);
        color: var(--bs-primary);
    }
</style>

<div class="card forecast-card">
    <div class="card-body p-4 p-md-5">
        <div class="text-center mb-4">
            <div class="forecast-icon d-inline-flex align-items-center justify-content-center mb-3">
                <i class="fas fa-rocket"></i>
            </div>
            <h4 class="card-title fw-bold">Mulai Prediksi Baru</h4>
            <p class="text-muted">Pilih komoditas dan tentukan periode untuk memulai peramalan.</p>
        </div>

        <!-- Menampilkan pesan error jika ada -->
        <?php if(session()->get('error')): ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div>
                    <?= session()->get('error') ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Perbaikan 1: Menggunakan site_url() untuk action form -->
        <form action="<?= site_url('peramalan/proses') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-4">
                <label for="id_produk" class="form-label fw-bold">Langkah 1: Pilih Komoditas</label>
                <select name="id_produk" id="id_produk" class="form-select form-select-lg" required>
                    <option value="">-- Pilih Produk untuk Diprediksi --</option>
                    <?php foreach($produk as $p): ?>
                        <option value="<?= $p['id_produk'] ?>"><?= esc($p['nama_produk']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-4">
                <label for="periode" class="form-label fw-bold">Langkah 2: Tentukan Periode Prediksi (Bulan)</label>
                <!-- Perbaikan 2: Mengubah name="jumlah_prediksi" menjadi name="periode" -->
                <input type="number" class="form-control form-control-lg" name="periode" id="periode" value="12" min="1" required>
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-calculator me-2"></i> Lakukan Prediksi Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
