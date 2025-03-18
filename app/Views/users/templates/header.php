<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="<?= base_url(); ?>/assets/css/style.css" rel="stylesheet" />
</head>

<body>
    <?php
    $uri = service('uri');
    ?>
    <div id="liveAlertPlaceholder"></div>
    <!-- ====== NAVBAR ====== -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
        <div class="container">
            <a class="navbar-brand fs-6 d-flex align-items-center" href="#">
                <img src="<?= base_url('img/polisi.png'); ?>" alt="Logo Polisi" width="40" height="40" class="me-2">
                PETA-KRIM INDRAMAYU 
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php if (session()->get('isLoggedIn')) : ?>
                        <?php $role = session()->get('role'); ?>
                        <?php if ($role == 'admin') : ?>
                            <li class="nav-item"><a class="nav-link" href="/dashboard">Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link" href="/laporan">Laporan</a></li>
                            <li class="nav-item"><a class="nav-link" href="/wilayah">Data Wilayah</a></li>
                            <li class="nav-item"><a class="nav-link" href="/maps">Peta</a></li>
                            <a class="btn btn-primary" href="/logout">Keluar</a>
                        <?php elseif ($role == 'user') : ?>
                            <li class="nav-item"><a class="nav-link" href="/halaman_utama">Halaman Utama</a></li>
                            <li class="nav-item"><a class="nav-link" href="/informasi">Informasi</a></li>
                            <li class="nav-item"><a class="nav-link" href="/maps_user">Peta</a></li>
                            <li class="nav-item"><a class="nav-link" href="/chat">LAPOR</a></li>
                            <a class="btn btn-primary" href="/logout">Keluar</a>
                        <?php endif; ?>
                    <?php else : ?>
                        <li class="nav-item"><a class="nav-link" href="/halaman_utama">Halaman Utama</a></li>
                        <li class="nav-item"><a class="nav-link" href="/informasi">Informasi</a></li>
                        <li class="nav-item"><a class="nav-link" href="/maps_user">Peta</a></li>
                        <li class="nav-item"><a class="nav-link" href="/chat">Laporan</a></li>
                        <a class="btn btn-primary" href="/login">Masuk</a>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>
