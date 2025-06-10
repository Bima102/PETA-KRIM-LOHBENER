<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Menentukan pengkodean karakter UTF-8 -->
    <meta charset="utf-8" />
    <!-- Mengatur viewport untuk responsivitas di perangkat mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Menampilkan judul halaman dari variabel PHP -->
    <title><?= $title; ?></title>

    <!-- Bagian Bootstrap & Assets -->
    <!-- Memuat CSS Bootstrap 5 untuk gaya responsif -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Memuat Font Awesome untuk ikon tambahan -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Memuat Bootstrap Icons untuk ikon berita dan lainnya -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Memuat CSS kustom dari assets lokal -->
    <link href="<?= base_url(); ?>/assets/css/style.css" rel="stylesheet" />
    <!-- Memuat font Anton dari Google Fonts untuk gaya teks -->
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">

    <!-- Memuat jQuery untuk fungsi JavaScript tambahan -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Memuat Bootstrap JS untuk komponen interaktif -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Memuat Chart.js untuk membuat grafik -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Memuat plugin Datalabels untuk Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <!-- Bagian JavaScript untuk registrasi plugin Chart.js -->
    <script>
        // Mendaftarkan plugin ChartDataLabels sebelum digunakan
        Chart.register(ChartDataLabels);
    </script>
    <!-- Memuat script kustom untuk grafik dari assets lokal -->
    <script src="<?= base_url(); ?>/assets/js/chart.js"></script>

    <!-- Menyisipkan section tambahan dari view lain (misalnya CSS/JS spesifik) -->
    <?= $this->renderSection('head'); ?>

    <!-- Bagian CSS kustom untuk header -->
    <style>
        /* Mengatur gaya untuk tautan navigasi aktif */
        .nav-link.active {
            font-weight: bold; /* Tebal untuk menandakan aktif */
            color: #ffc107 !important; /* Warna kuning khas Bootstrap warning */
        }

        /* Mengatur gaya untuk logo di navbar */
        .navbar-brand img {
            width: 60px; /* Ukuran logo proporsional */
            height: 60px; /* Tinggi logo disesuaikan */
            object-fit: contain; /* Mencegah distorsi gambar */
            margin-right: 8px; /* Jarak antara logo dan teks */
        }

        /* Mengatur gaya untuk teks dan logo navbar */
        .navbar-brand {
            display: flex; /* Mengatur logo dan teks sejajar */
            align-items: center; /* Menyelaraskan secara vertikal */
            font-family: 'Anton', sans-serif; /* Menggunakan font Anton */
            font-size: 1.3rem; /* Ukuran font teks */
            letter-spacing: 1px; /* Jarak antar huruf */
            color: #ffc107 !important; /* Warna kuning untuk teks */
            padding: 0.1rem 0; /* Padding minimal untuk header kompak */
        }

        /* Mengatur padding navbar */
        .navbar {
            padding: 0.5rem 1rem; /* Padding navbar yang ramping */
        }

        /* Responsivitas untuk layar kecil */
        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1rem; /* Ukuran teks lebih kecil di layar kecil */
            }
            .navbar-brand img {
                width: 40px; /* Ukuran logo lebih kecil di layar kecil */
                height: 40px; /* Tinggi logo disesuaikan */
            }
            .navbar {
                padding: 0.3rem 0.8rem; /* Padding navbar lebih kecil */
            }
        }
    </style>
</head>

<body>
    <!-- Mengambil URI saat ini untuk menentukan segmen aktif -->
    <?php
        $uri = service('uri');
        $segment1 = $uri->getSegment(1, ''); // Mengambil segmen pertama URI, default kosong
    ?>

    <!-- Bagian Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <!-- Kontainer untuk navbar -->
        <div class="container">
            <!-- Logo dan teks navbar -->
            <a class="navbar-brand" href="#">
                <img src="<?= base_url('assets/img/log.png'); ?>" alt="Logo Polisi" class="logo-img">
                PETA-KRIM LOHBENER
            </a>
            <!-- Tombol toggle untuk navbar responsif -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Daftar menu navigasi -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    <!-- Memeriksa apakah pengguna sudah login -->
                    <?php if (session()->get('isLoggedIn')) : ?>
                        <!-- Mengambil peran pengguna dari session -->
                        <?php $role = session()->get('role'); ?>

                        <!-- Menu untuk admin -->
                        <?php if ($role == 'admin') : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= ($segment1 == 'dashboard') ? 'active' : ''; ?>" href="/dashboard">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= ($segment1 == 'statistik') ? 'active' : ''; ?>" href="/statistik">Statistik Kejahatan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= ($segment1 == 'wilayah') ? 'active' : ''; ?>" href="/wilayah">Data Wilayah</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= ($segment1 == 'maps') ? 'active' : ''; ?>" href="/maps">Peta</a>
                            </li>
                        <!-- Menu untuk pengguna biasa -->
                        <?php elseif ($role == 'user') : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= ($segment1 == 'halaman_utama') ? 'active' : ''; ?>" href="/halaman_utama">Halaman Utama</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= ($segment1 == 'statistik') ? 'active' : ''; ?>" href="/statistik">Statistik Kejahatan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= ($segment1 == 'maps_user') ? 'active' : ''; ?>" href="/maps_user">Peta</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= ($segment1 == 'wilayah') ? 'active fw-bold text-primary' : ''; ?>" href="<?= base_url('/wilayah/aduan'); ?>">Lapor</a>
                            </li>
                        <?php endif; ?>
                        <!-- Tombol logout untuk pengguna yang sudah login -->
                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-warning text-dark fw-bold" href="/logout">Keluar</a>
                        </li>
                    <!-- Menu untuk pengguna yang belum login -->
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($segment1 == 'halaman_utama') ? 'active' : ''; ?>" href="/halaman_utama">Halaman Utama</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($segment1 == 'statistik') ? 'active' : ''; ?>" href="/statistik">Statistik Kejahatan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($segment1 == 'maps_user') ? 'active' : ''; ?>" href="/maps_user">Peta</a>
                        </li>
                        <!-- Tombol login untuk pengguna yang belum login -->
                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-warning text-dark fw-bold" href="/login">Masuk</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Menampilkan pesan error dari session flashdata -->
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="container mt-3">
            <!-- Alert untuk menampilkan pesan error -->
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Bagian konten utama dari view lain -->
    <?= $this->renderSection('content'); ?>
</body>
</html>