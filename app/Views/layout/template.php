<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> | Prediksi Ekspor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #0d6efd;
            --dark-color: #212529;
            --body-bg: #f4f7fc;
            --card-bg: #ffffff;
        }
        body { font-family: 'Poppins', sans-serif; background-color: var(--body-bg); }
        .wrapper { display: flex; }
        .sidebar { width: var(--sidebar-width); min-height: 100vh; background-color: var(--dark-color); color: #adb5bd; position: fixed; transition: all 0.3s ease; z-index: 1030;}
        .sidebar-header { padding: 20px; text-align: center; font-size: 1.5rem; font-weight: 600; color: #fff; border-bottom: 1px solid #343a40; }
        .sidebar-nav { padding: 15px 0; }
        .sidebar-nav .nav-link { color: #adb5bd; padding: 12px 20px; display: flex; align-items: center; transition: all 0.2s ease; }
        .sidebar-nav .nav-link i { width: 30px; font-size: 1.1rem; }
        .sidebar-nav .nav-link.active, .sidebar-nav .nav-link:hover { background-color: var(--primary-color); color: #fff; border-radius: 0 50px 50px 0; margin-right: 15px; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); transition: all 0.3s ease; }
        .header { background-color: var(--card-bg); padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #dee2e6; }
        .header .user-avatar { width: 40px; height: 40px; border-radius: 50%; background-color: var(--primary-color); color: #fff; display: inline-flex; justify-content: center; align-items: center; font-weight: 600; }
        .header .dropdown-toggle::after { display: none; }
        #sidebar-toggle { display: none; }
        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { width: 100%; margin-left: 0; }
            #sidebar-toggle { display: inline-block; }
        }
    </style>
</head>
<body>

<div class="wrapper">
    <?= $this->include('layout/sidebar') ?>

    <div class="main-content">
        <?= $this->include('layout/header') ?>

        <main class="container-fluid p-4">
            <?= $this->renderSection('content') ?>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebar-toggle').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('active');
    });
</script>
</body>
</html>