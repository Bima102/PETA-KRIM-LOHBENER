<?php
// Mendefinisikan URL API untuk mengambil berita dari CNBC Indonesia
$apiUrl = 'https://berita-indo-api-next.vercel.app/api/cnn-news/nasional';

// Inisialisasi array kosong untuk menyimpan data berita
$newsDataArr = [];

// Mengambil data dari API menggunakan file_get_contents
$response = @file_get_contents($apiUrl);

// Memeriksa apakah pengambilan data berhasil
if ($response !== false) {
    // Mengonversi respons JSON menjadi array asosiatif
    $resJson = json_decode($response, true);

    // Memeriksa apakah data berita tersedia dalam respons
    if (isset($resJson['data'])) {
        // Mengambil hanya 8 berita pertama dari data
        $newsDataArr = array_slice($resJson['data'], 0, 8);
    }
}
?>

<!-- Bagian Footer Content Start -->
<!-- Kontainer untuk judul berita di tengah -->
<div class="text-center mb-4">
    <!-- Judul bagian berita dengan ikon dan gaya tebal -->
    <h3 class="fw-bold"><i class="bi bi-newspaper me-2 text-primary"></i>Berita & Update Terkini</h3>
</div>

<!-- Bagian News Grid -->
<!-- Kontainer utama untuk grid berita -->
<div id="newsdetails" class="container py-4">
    <!-- Baris dengan auto-scroll untuk kartu berita -->
    <div class="row g-3 auto-scroll" id="newsCarousel">
        <?php if (!empty($newsDataArr)) : ?>
            <!-- Loop melalui data berita untuk membuat kartu -->
            <?php foreach ($newsDataArr as $news) : ?>
                <!-- Kolom untuk setiap kartu berita -->
                <div class="col-4">
                    <!-- Kartu berita dengan bayangan dan tinggi penuh -->
                    <div class="card h-100 shadow-sm">
                        <?php
                        // Mengambil URL gambar dari array image (default ke placeholder jika tidak ada)
                        $imageUrl = isset($news['image']) && is_array($news['image']) && isset($news['image']['large'])
                            ? $news['image']['large']
                            : 'https://via.placeholder.com/300x150.png?text=Gambar+Tidak+Tersedia';
                        ?>
                        <!-- Gambar berita di bagian atas kartu -->
                        <img src="<?= htmlspecialchars($imageUrl) ?>" class="card-img-top" alt="News Image" style="height: 150px; object-fit: cover;">
                        <!-- Badan kartu dengan konten berita -->
                        <div class="card-body d-flex flex-column p-3">
                            <!-- Judul berita dengan sanitasi untuk keamanan -->
                            <h5 class="card-title mb-2"><?= htmlspecialchars(is_string($news['title'] ?? '') ? $news['title'] : '') ?></h5>
                            <!-- Cuplikan konten berita dengan sanitasi -->
                            <p class="card-text text-muted mb-3"><?= htmlspecialchars(is_string($news['contentSnippet'] ?? '') ? $news['contentSnippet'] : '') ?></p>
                            <!-- Tombol untuk menuju link berita lengkap -->
                            <a href="<?= htmlspecialchars(is_string($news['link'] ?? '') ? $news['link'] : '#') ?>" target="_blank" class="btn btn-dark btn-sm mt-auto">Selanjutnya</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <!-- Pesan jika data berita tidak ditemukan -->
            <h4 class="text-center">Data tidak ditemukan</h4>
        <?php endif; ?>
    </div>
</div>

<!-- Bagian Optional Custom Styling -->
<style>
    /* Mengatur latar belakang halaman */
    body {
        background-color: #f0f0f0;
    }

    /* Mengatur latar belakang kontainer berita */
    #newsdetails {
        background-color: #f0f0f0;
    }

    /* Gaya untuk kartu berita */
    #newsdetails .card {
        border-radius: 10px; /* Sudut membulat lebih kecil */
        background-color: #ffffff; /* Latar belakang putih */
        transition: transform 0.3s ease; /* Efek transisi saat hover */
    }

    /* Efek hover untuk kartu berita */
    #newsdetails .card:hover {
        transform: translateY(-5px); /* Mengangkat kartu saat hover */
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1); /* Bayangan lebih dalam */
    }

    /* Margin atas untuk judul berita */
    h3.fw-bold {
        margin-top: 2rem;
    }

    /* Mengatur baris agar tidak wrap dan mendukung scroll horizontal */
    .row.auto-scroll {
        flex-wrap: nowrap !important; /* Mencegah pembungkusan kartu */
        overflow-x: auto !important; /* Mengaktifkan scroll horizontal */
        scroll-behavior: smooth; /* Scroll mulus */
    }

    /* Mengatur lebar kolom kartu */
    .col-4 {
        flex: 0 0 33.333333% !important; /* Lebar kolom 1/3 di desktop */
        max-width: 33.333333% !important; /* Maksimum lebar kolom */
        min-width: 220px; /* Lebar minimum lebih kecil untuk mobile */
    }

    /* Menyembunyikan scrollbar untuk tampilan lebih bersih */
    .row.auto-scroll::-webkit-scrollbar {
        display: none; /* Sembunyikan scrollbar di Chrome/Safari */
    }

    .row.auto-scroll {
        -ms-overflow-style: none; /* Sembunyikan scrollbar di IE/Edge */
        scrollbar-width: none; /* Sembunyikan scrollbar di Firefox */
    }

    /* Media query untuk layar kecil (mobile) */
    @media (max-width: 768px) {
        .col-4 {
            flex: 0 0 75% !important; /* Lebar kartu lebih besar di mobile */
            max-width: 75% !important; /* Maksimum lebar kartu */
            min-width: 180px; /* Lebar minimum lebih kecil untuk mobile */
        }
        .card-img-top {
            height: 120px !important; /* Tinggi gambar lebih kecil di mobile */
        }
        .card-body {
            padding: 2px !important; /* Padding lebih kecil di mobile */
        }
        .card-title {
            font-size: 0.9rem; /* Ukuran font judul lebih kecil */
            margin-bottom: 0.5rem; /* Jarak lebih kecil */
        }
        .card-text {
            font-size: 0.8rem; /* Ukuran font teks lebih kecil */
            margin-bottom: 0.5rem; /* Jarak lebih kecil */
        }
        .btn-sm {
            font-size: 0.75rem; /* Ukuran font tombol lebih kecil */
            padding: 0.3rem 0.6rem; /* Padding tombol lebih kecil */
        }
        .g-3 {
            gap: 0.75rem !important; /* Jarak antar kartu lebih kecil di mobile */
        }
    }

    /* Media query untuk layar sangat kecil */
    @media (max-width: 576px) {
        .col-4 {
            min-width: 160px; /* Lebar minimum lebih kecil untuk layar sangat kecil */
        }
        .card-img-top {
            height: 100px !important; /* Tinggi gambar lebih kecil lagi */
        }
        .card-title {
            font-size: 0.85rem; /* Ukuran font judul lebih kecil lagi */
        }
        .card-text {
            font-size: 0.75rem; /* Ukuran font teks lebih kecil lagi */
        }
    }
</style>

<!-- Bagian JavaScript untuk Auto Scroll -->
<script>
    // Menunggu DOM selesai dimuat sebelum menjalankan script
    document.addEventListener('DOMContentLoaded', function () {
        // Mengambil elemen carousel berita
        const carousel = document.getElementById('newsCarousel');

        // Inisialisasi posisi scroll
        let scrollPosition = 0;

        // Menghitung lebar kartu berdasarkan lebar layar
        const cardWidth = window.innerWidth <= 768
            ? carousel.querySelector('.col-4').offsetWidth + 12 // Gutter g-3 = 12px di mobile
            : carousel.querySelector('.col-4').offsetWidth + 16; // Gutter g-3 = 16px di desktop

        // Menghitung batas maksimum scroll
        const maxScroll = carousel.scrollWidth - carousel.clientWidth;

        // Fungsi untuk menggulir carousel secara otomatis
        function autoScroll() {
            // Menambah posisi scroll sebesar lebar kartu
            scrollPosition += cardWidth;

            // Reset ke awal jika mencapai batas maksimum
            if (scrollPosition >= maxScroll) {
                scrollPosition = 0;
            }

            // Menggulir carousel dengan animasi mulus
            carousel.scrollTo({
                left: scrollPosition,
                behavior: 'smooth'
            });
        }

        // Mengatur interval scroll setiap 3 detik
        setInterval(autoScroll, 3000);
    });
</script>

<!-- Memuat Bootstrap JS untuk fungsi interaktif -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>