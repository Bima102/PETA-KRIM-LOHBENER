<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $title; ?></title>

    <!-- Bootstrap & Assets -->
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="<?= base_url(); ?>/assets/css/style.css" rel="stylesheet" />

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js & plugin Datalabels -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <!-- Custom chart script (dipanggil terakhir agar Chart dan plugin sudah siap) -->
    <script>
        // Pastikan plugin datalabels diregistrasi sebelum digunakan
        Chart.register(ChartDataLabels);
    </script>
    <script src="<?= base_url(); ?>/assets/js/chart.js"></script>

    <!-- Section tambahan dari tiap view -->
    <?= $this->renderSection('head'); ?>

    <style>
        .nav-link.active {
            font-weight: bold;
            color: #ffc107 !important;
        }
    </style>
</head>

<body>
    <?php
        $uri = service('uri');
        $segment1 = $uri->getSegment(1, ''); // Tambahkan default kosong
    ?>

    <!-- ====== NAVBAR ====== -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
        <div class="container">
            <a class="navbar-brand fs-6 d-flex align-items-center" href="#">
                <img src="<?= base_url('assets/img/polisi.png'); ?>" alt="Logo Polisi" width="40" height="40" class="me-2">
                PETA-KRIM LOHBENER
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">

                    <?php if (session()->get('isLoggedIn')) : ?>
                        <?php $role = session()->get('role'); ?>

                        <?php if ($role == 'admin') : ?>
                            <li class="nav-item"><a class="nav-link <?= ($segment1 == 'dashboard') ? 'active' : ''; ?>" href="/dashboard">Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link <?= ($segment1 == 'wilayah') ? 'active' : ''; ?>" href="/wilayah">Data Wilayah</a></li>
                            <li class="nav-item"><a class="nav-link <?= ($segment1 == 'maps') ? 'active' : ''; ?>" href="/maps">Peta</a></li>
                        <?php elseif ($role == 'user') : ?>
                            <li class="nav-item"><a class="nav-link <?= ($segment1 == 'halaman_utama') ? 'active' : ''; ?>" href="/halaman_utama">Halaman Utama</a></li>
                            <li class="nav-item"><a class="nav-link <?= ($segment1 == 'statistik') ? 'active' : ''; ?>" href="/statistik">Statistik Kejahatan</a></li>
                            <li class="nav-item"><a class="nav-link <?= ($segment1 == 'maps_user') ? 'active' : ''; ?>" href="/maps_user">Peta</a></li>
                            <li class="nav-item"><a class="nav-link <?= ($segment1 == 'wilayah') ? 'active fw-bold text-primary' : ''; ?>" href="<?= base_url('/wilayah/aduan') ?>">Lapor</a></li>
                        <?php endif; ?>
                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-warning text-dark fw-bold" href="/logout">Keluar</a>
                        </li>

                    <?php else : ?>
                        <li class="nav-item"><a class="nav-link <?= ($segment1 == 'halaman_utama') ? 'active' : ''; ?>" href="/halaman_utama">Halaman Utama</a></li>
                        <li class="nav-item"><a class="nav-link <?= ($segment1 == 'statistik') ? 'active' : ''; ?>" href="/statistik">Statistik Kejahatan</a></li>
                        <li class="nav-item"><a class="nav-link <?= ($segment1 == 'maps_user') ? 'active' : ''; ?>" href="/maps_user">Peta</a></li>
                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-warning text-dark fw-bold" href="/login">Masuk</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>

    <!-- ====== CONTENT SECTION ====== -->
    <?= $this->renderSection('content'); ?>
</body>

</html>
