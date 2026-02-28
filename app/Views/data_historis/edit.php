// app/Views/data_historis/edit.php
<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>
Edit Data Historis
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Form Edit Data Ekspor</h5>
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

        <form action="/data-historis/update/<?= $data_historis['id_data'] ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="POST"> <div class="mb-3">
                <label for="id_produk" class="form-label">Produk</label>
                <select name="id_produk" id="id_produk" class="form-select">
                    <option value="">Pilih Produk...</option>
                    <?php foreach($produk as $p): ?>
                        <option value="<?= $p['id_produk'] ?>" <?= ($p['id_produk'] == $data_historis['id_produk']) ? 'selected' : '' ?>>
                            <?= esc($p['nama_produk']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tahun" class="form-label">Tahun</label>
                    <input type="number" name="tahun" id="tahun" class="form-control" value="<?= esc($data_historis['tahun']) ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="bulan" class="form-label">Bulan</label>
                    <input type="number" name="bulan" id="bulan" class="form-control" value="<?= esc($data_historis['bulan']) ?>">
                </div>
            </div>
            <div class="mb-3">
                <label for="jumlah_ekspor" class="form-label">Jumlah Ekspor</label>
                <input type="text" name="jumlah_ekspor" id="jumlah_ekspor" class="form-control" value="<?= esc($data_historis['jumlah_ekspor']) ?>">
            </div>

            <a href="/data-historis" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update Data</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>