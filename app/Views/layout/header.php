<header class="header">
    <div>
        <button class="btn btn-outline-secondary" id="sidebar-toggle"><i class="fas fa-bars"></i></button>
        <h4 class="d-inline-block align-middle ms-3 mb-0"><?= $this->renderSection('page_title') ?></h4>
    </div>
    <div class="user-profile d-flex align-items-center">
        <div class="user-avatar me-2">
            <?= strtoupper(substr(session()->get('username') ?? 'U', 0, 1)) ?>
        </div>
        <div class="d-none d-sm-block">
            <div class="fw-bold"><?= esc(session()->get('username') ?? 'Pengguna') ?></div>
            
            <?php if (session()->get('role') == 'admin'): ?>
                <span class="badge bg-primary fw-light">Admin</span>
            <?php else: ?>
                <span class="badge bg-secondary fw-light">User</span>
            <?php endif; ?>
        </div>
    </div>
</header>
