<?php

$uri = service('uri');

$userRole = session()->get('role'); 
?>
<nav class="sidebar">
    <div class="sidebar-header">
        <i class="fa-solid fa-chart-line"></i> Prediksi Ekspor
    </div>
    <ul class="nav flex-column sidebar-nav">
        <li class="nav-item">
            <a class="nav-link <?= ($uri->getSegment(1) == 'dashboard') ? 'active' : '' ?>" href="<?= site_url('dashboard') ?>">
                <i class="fas fa-home"></i>Dashboard
            </a>
        </li>
        
        <!-- Menu Khusus Admin -->
        <?php if (isset($userRole) && $userRole == 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link <?= ($uri->getSegment(1) == 'data-historis') ? 'active' : '' ?>" href="<?= site_url('data-historis') ?>">
                    <i class="fas fa-database"></i>Data Historis
                </a>
            </li>
        <?php endif; ?>

        <li class="nav-item">
            <a class="nav-link <?= ($uri->getSegment(1) == 'peramalan') ? 'active' : '' ?>" href="<?= site_url('peramalan') ?>">
                <i class="fas fa-calculator"></i>Lakukan Peramalan
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?= ($uri->getSegment(1) == 'hasil-peramalan' || $uri->getSegment(1) == 'hasil') ? 'active' : '' ?>" href="<?= site_url('hasil-peramalan') ?>">
                <i class="fas fa-chart-bar"></i>Hasil Peramalan
            </a>
        </li>

        <!-- Menu Khusus User -->
        <?php if (isset($userRole) && $userRole == 'user'): ?>
            <li class="nav-item">
                <a class="nav-link <?= ($uri->getSegment(1) == 'tentang') ? 'active' : '' ?>" href="<?= site_url('tentang') ?>">
                    <i class="fas fa-info-circle"></i>Tentang Sistem
                </a>
            </li>
        <?php endif; ?>
        
        
        <?php if (isset($userRole) && $userRole == 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link <?= ($uri->getSegment(1) == 'users') ? 'active' : '' ?>" href="<?= site_url('users') ?>">
                    <i class="fas fa-user-cog"></i>Kelola Pengguna
                </a>
            </li>
        <?php endif; ?>
        
        <li class="nav-item">
            <a class="nav-link" href="<?= site_url('logout') ?>">
                <i class="fas fa-sign-out-alt"></i>Logout
            </a>
        </li>
    </ul>
</nav>
