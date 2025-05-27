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
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js & plugin Datalabels -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <!-- Custom chart script (dipanggil terakhir agar Chart dan plugin sudah siap) -->
    <script>
        // energetica plugin datalabels diregistrasi sebelum digunakan
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

        /* Styling untuk logo */
        .navbar-brand img {
            width: 60px; /* Kecilkan sedikit ukuran logo agar lebih proporsional */
            height: 60px;
            object-fit: contain; /* Pastikan gambar tidak terdistorsi */
            margin-right: 8px; /* Jarak antara logo dan teks */
        }

        .navbar-brand {
            display: flex;
            align-items: center; /* Pastikan logo dan teks sejajar vertikal */
            font-family: 'Anton', sans-serif;
            font-size: 1.3rem; /* Sesuaikan ukuran teks agar lebih seimbang */
            letter-spacing: 1px;
            color: #ffc107 !important;
            padding: 0.1rem 0; /* Kurangi padding vertikal untuk membuat header lebih kompak */
        }

        /* Styling untuk navbar */
        .navbar {
            padding: 0.5rem 1rem; /* Kurangi padding navbar agar header lebih ramping */
        }

        /* Responsiveness untuk layar kecil */
        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1rem; /* Kurangi ukuran teks di layar kecil */
            }
            .navbar-brand img {
                width: 40px; /* Kurangi ukuran logo di layar kecil */
                height: 40px;
            }
            .navbar {
                padding: 0.3rem 0.8rem; /* Sesuaikan padding navbar di layar kecil */
            }
        }
    </style>
</head>

<body>
    <?php
        $uri = service('uri');
        $segment1 = $uri->getSegment(1, ''); // Tambahkan default kosong
    ?>

    <!-- ====== NAVBAR ====== -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="<?= base_url('assets/img/logo_petakriminal.png'); ?>" alt="Logo Polisi" class="logo-img">
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
                            <li class="nav-item"><a class="nav-link <?= ($segment1 == 'statistik') ? 'active' : ''; ?>" href="/statistik">Statistik Kejahatan</a></li>
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