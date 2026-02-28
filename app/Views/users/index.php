<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>
Kelola Pengguna
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<?= $page_title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .table thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        border-bottom-width: 1px;
    }
    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 4px 25px rgba(0,0,0,0.05);
    }
    .btn-action {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
    }
</style>

<div class="card">
    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-0">Manajemen Akses Pengguna</h5>
                <p class="card-subtitle text-muted mt-1">Kelola siapa saja yang dapat mengakses sistem.</p>
            </div>
            <a href="/users/new" class="btn btn-primary fw-bold">
                <i class="fas fa-plus me-2"></i> Tambah Pengguna
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th class="text-center" style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Belum ada pengguna.</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach($users as $user): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <div class="fw-bold"><?= esc($user['username']) ?></div>
                            </td>
                            <td>
                                <span class="badge fs-6 fw-normal text-capitalize bg-<?= ($user['role'] == 'admin') ? 'primary' : 'secondary' ?>">
                                    <i class="fas fa-<?= ($user['role'] == 'admin') ? 'user-shield' : 'user' ?> me-1"></i>
                                    <?= esc($user['role']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php if ($user['id'] != session()->get('user_id')): ?>
                                    <button type="button" class="btn btn-danger btn-action" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $user['id'] ?>" data-username="<?= esc($user['username']) ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                <?php else: ?>
                                    <span class="text-muted fst-italic">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus pengguna <strong id="usernameToDelete"></strong>? Tindakan ini tidak dapat diurungkan.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <a id="deleteLink" href="#" class="btn btn-danger">Ya, Hapus</a>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var userId = button.getAttribute('data-id');
        var username = button.getAttribute('data-username');
        
        var modalUsername = deleteModal.querySelector('#usernameToDelete');
        var deleteLink = deleteModal.querySelector('#deleteLink');
        
        modalUsername.textContent = username;
        deleteLink.href = '/users/delete/' + userId;
    });
});
</script>
<?= $this->endSection() ?>
