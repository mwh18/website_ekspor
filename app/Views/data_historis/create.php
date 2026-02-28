<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>
Tambah Data Historis
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Form Tambah Data Ekspor</h5>
    </div>
    <div class="card-body">
        <?php if(session('validation')): ?>
            <div class="alert alert-danger">
                <ul>
                <?php foreach(session('validation')->getErrors() as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
        <?php endif ?>

        <form action="/data-historis/store" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="id_produk" class="form-label">Produk</label>
                <select name="id_produk" id="id_produk" class="form-select">
                    <option value="">Pilih Produk...</option>
                    <?php foreach($produk as $p): ?>
                        <option value="<?= $p['id_produk'] ?>"><?= esc($p['nama_produk']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tahun" class="form-label">Tahun</label>
                    <input type="number" name="tahun" id="tahun" class="form-control" placeholder="Contoh: 2024">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="bulan" class="form-label">Bulan</label>
                    <input type="number" name="bulan" id="bulan" class="form-control" placeholder="Angka 1-12">
                </div>
            </div>
            <div class="mb-3">
                <label for="jumlah_ekspor" class="form-label">Jumlah Ekspor</label>
                <input type="text" name="jumlah_ekspor" id="jumlah_ekspor" class="form-control" placeholder="Contoh: 150.75">
            </div>

            <a href="/data-historis" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Data</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>