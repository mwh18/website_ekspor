<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>
Tambah Pengguna
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 4px 25px rgba(0,0,0,0.05);
    }
    .form-label {
        font-weight: 600;
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white py-3">
                 <h5 class="card-title mb-0">Formulir Pengguna Baru</h5>
                 <p class="card-subtitle text-muted mt-1">Isi detail di bawah untuk menambahkan pengguna baru ke sistem.</p>
            </div>
            <div class="card-body p-4">
                <?php if(session('validation')): ?>
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Terjadi Kesalahan!</h4>
                        <ul class="mb-0">
                        <?php foreach(session('validation')->getErrors() as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif ?>

                <form action="/users/store" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control form-control-lg" value="<?= old('username') ?>" placeholder="Contoh: budi_setiawan" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control form-control-lg" required>
                        <div class="form-text">Minimal 6 karakter.</div>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role Akses</label>
                        <select name="role" id="role" class="form-select form-select-lg" required>
                            <option value="" disabled selected>-- Pilih Role --</option>
                            <option value="admin" <?= (old('role') == 'admin') ? 'selected' : '' ?>>Admin</option>
                            <option value="user" <?= (old('role') == 'user') ? 'selected' : '' ?>>User</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="/users" class="btn btn-light me-2">Batal</a>
                        <button type="submit" class="btn btn-primary fw-bold">
                            <i class="fas fa-save me-2"></i>Simpan Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
