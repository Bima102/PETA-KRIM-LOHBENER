<?php
// Mendefinisikan URL API NewsData.io untuk berita terbaru dari Indonesia
$apiUrl = 'https://newsdata.io/api/1/news?country=id&language=id&apikey=pub_3c11f131081f449d861ef84ab2779d9b&category=top'; // Menyimpan URL API dengan parameter untuk mengambil berita dari Indonesia dalam bahasa Indonesia, kategori top, menggunakan API key yang diberikan

// Inisialisasi array kosong untuk menyimpan data berita
$newsDataArr = []; // Membuat array kosong untuk menyimpan data berita yang akan diambil dari API
$errorMessage = ''; // Membuat variabel untuk menyimpan pesan error jika terjadi masalah

// Mengambil data dari API menggunakan file_get_contents dengan penanganan error
$response = @file_get_contents($apiUrl); // Mengambil data dari URL API, menggunakan @ untuk menekan pesan error bawaan PHP

if ($response !== false) { // Memeriksa apakah pengambilan data berhasil (tidak menghasilkan false)
    // Mengonversi respons JSON menjadi array asosiatif
    $resJson = json_decode($response, true); // Mengubah string JSON dari API menjadi array PHP yang dapat digunakan, dengan true untuk format array asosiatif

    if ($resJson === null) { // Memeriksa apakah JSON tidak valid (gagal dikonversi)
        $errorMessage = 'Respons JSON tidak valid.'; // Menetapkan pesan error jika JSON tidak valid
    } elseif (isset($resJson['error'])) { // Memeriksa apakah ada error dari API
        $errorMessage = 'API Error: ' . $resJson['error']; // Menetapkan pesan error dari respons API
    } elseif (isset($resJson['results'])) { // Memeriksa apakah ada data berita dalam respons
        // Mengambil data berita dari kunci 'results'
        $newsDataArr = array_slice($resJson['results'], 0, 8); // Mengambil 8 berita pertama dari hasil API menggunakan array_slice
    } else { // Jika tidak ada kondisi di atas yang terpenuhi
        $errorMessage = 'Tidak ada data berita dalam respons.'; // Menetapkan pesan error jika tidak ada data berita
    }
} else { // Jika pengambilan data gagal
    // Log error jika API gagal
    error_log('Gagal mengambil data dari NewsData.io API'); // Mencatat error ke log server untuk debugging
    $errorMessage = 'Gagal mengambil data dari API. Coba lagi nanti.'; // Menetapkan pesan error untuk ditampilkan kepada pengguna
}
?>

<!-- Bagian Footer Content Start -->
<div class="text-center mb-4">
    <h3 class="fw-bold"><i class="bi bi-newspaper me-2 text-primary"></i>Berita & Update Terkini Indonesia</h3> <!-- Menampilkan judul bagian berita dengan ikon koran dan teks berwarna primer, diratakan ke tengah dengan margin bawah -->
</div>

<!-- Bagian News Grid -->
<div id="newsdetails" class="container py-4">
    <div class="row g-3 auto-scroll" id="newsCarousel">
        <?php if (!empty($newsDataArr)) : ?> <!-- Memeriksa apakah array berita tidak kosong -->
            <?php foreach ($newsDataArr as $news) : ?> <!-- Melakukan perulangan untuk setiap berita dalam array -->
                <div class="col-4">
                    <div class="card h-100 shadow-sm">
                        <?php
                        // Mengambil URL gambar (default ke placeholder jika tidak ada)
                        $imageUrl = isset($news['image_url']) && !empty($news['image_url']) // Memeriksa apakah ada URL gambar yang valid
                            ? $news['image_url'] // Menggunakan URL gambar dari API jika ada
                            : 'https://via.placeholder.com/300x150.png?text=Gambar+Tidak+Tersedia'; // Menggunakan placeholder jika tidak ada gambar
                        ?>
                        <img src="<?= htmlspecialchars($imageUrl) ?>" class="card-img-top" alt="Berita Indonesia" style="height: 150px; object-fit: cover;"> <!-- Menampilkan gambar berita dengan sanitasi untuk keamanan, ukuran tetap 150px dengan penyesuaian objek -->
                        <div class="card-body d-flex flex-column p-3">
                            <!-- Judul berita dengan sanitasi -->
                            <h5 class="card-title mb-2"><?= htmlspecialchars($news['title'] ?? 'Judul Tidak Tersedia') ?></h5> <!-- Menampilkan judul berita dengan sanitasi, fallback ke "Judul Tidak Tersedia" jika tidak ada -->
                            <!-- Deskripsi singkat berita -->
                            <p class="card-text text-muted mb-3"><?= htmlspecialchars($news['description'] ?? $news['content'] ?? 'Deskripsi Tidak Tersedia') ?></p> <!-- Menampilkan deskripsi atau konten berita dengan sanitasi, fallback ke "Deskripsi Tidak Tersedia" jika tidak ada -->
                            <!-- Tombol menuju artikel lengkap -->
                            <a href="<?= htmlspecialchars($news['link'] ?? '#') ?>" target="_blank" class="btn btn-dark btn-sm mt-auto">Selanjutnya</a> <!-- Menampilkan tombol link ke artikel lengkap dengan sanitasi, terbuka di tab baru, posisi bawah otomatis -->
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?> <!-- Jika array berita kosong -->
            <h4 class="text-center">Data berita Indonesia tidak ditemukan. <?= htmlspecialchars($errorMessage ?: 'Coba lagi nanti.') ?></h4> <!-- Menampilkan pesan error atau pesan default jika tidak ada data berita -->
        <?php endif; ?>
    </div>
</div>

<!-- Bagian CSS Kustom -->
<style>
    body { // Mengatur latar belakang halaman
        background-color: #f0f0f0; // Memberikan warna abu-abu muda sebagai latar belakang
    }

    #newsdetails { // Mengatur kontainer berita
        background-color: #f0f0f0; // Memberikan warna latar belakang yang sama dengan body
    }

    #newsdetails .card { // Mengatur gaya kartu berita
        border-radius: 10px; // Memberikan sudut melengkung pada kartu
        background-color: #ffffff; // Memberikan latar belakang putih pada kartu
        transition: transform 0.3s ease; // Menambahkan animasi transisi saat hover
    }

    #newsdetails .card:hover { // Mengatur efek saat kursor di atas kartu
        transform: translateY(-5px); // Menggeser kartu ke atas 5px saat hover
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1); // Menambahkan bayangan saat hover
    }

    h3.fw-bold { // Mengatur gaya judul
        margin-top: 2rem; // Memberikan margin atas 2rem
    }

    .row.auto-scroll { // Mengatur baris dengan scroll otomatis
        flex-wrap: nowrap !important; // Mencegah pembungkus fleksibel
        overflow-x: auto !important; // Mengaktifkan scroll horizontal
        scroll-behavior: smooth; // Membuat scroll bergerak mulus
    }

    .col-4 { // Mengatur kolom kartu
        flex: 0 0 33.333333% !important; // Menentukan lebar kolom 33.33% tanpa menyusut atau berkembang
        max-width: 33.333333% !important; // Membatasi lebar maksimum kolom
        min-width: 220px; // Menentukan lebar minimum kolom
    }

    .row.auto-scroll::-webkit-scrollbar { // Menyembunyikan scrollbar di browser berbasis WebKit
        display: none; // Menghilangkan scrollbar
    }

    .row.auto-scroll { // Menyembunyikan scrollbar di browser lain
        -ms-overflow-style: none; // Untuk Internet Explorer dan Edge
        scrollbar-width: none; // Untuk Firefox
    }

    @media (max-width: 768px) { // Aturan gaya untuk layar dengan lebar maksimum 768px
        .col-4 { // Mengatur ulang kolom untuk layar kecil
            flex: 0 0 75% !important; // Mengubah lebar kolom menjadi 75%
            max-width: 75% !important; // Membatasi lebar maksimum
            min-width: 180px; // Mengurangi lebar minimum
        }
        .card-img-top { // Mengatur ulang gambar kartu
            height: 120px !important; // Mengurangi tinggi gambar
        }
        .card-body { // Mengatur ulang badan kartu
            padding: 2px !important; // Mengurangi padding
        }
        .card-title { // Mengatur ulang judul kartu
            font-size: 0.9rem; // Mengurangi ukuran font
            margin-bottom: 0.5rem; // Mengurangi margin bawah
        }
        .card-text { // Mengatur ulang teks kartu
            font-size: 0.8rem; // Mengurangi ukuran font
            margin-bottom: 0.5rem; // Mengurangi margin bawah
        }
        .btn-sm { // Mengatur ulang tombol kecil
            font-size: 0.75rem; // Mengurangi ukuran font
            padding: 0.3rem 0.6rem; // Mengurangi padding
        }
        .g-3 { // Mengatur ulang jarak antar kolom
            gap: 0.75rem !important; // Mengurangi jarak
        }
    }

    @media (max-width: 576px) { // Aturan gaya untuk layar dengan lebar maksimum 576px
        .col-4 { // Mengatur ulang kolom untuk layar sangat kecil
            min-width: 160px; // Mengurangi lebar minimum lebih jauh
        }
        .card-img-top { // Mengatur ulang gambar kartu
            height: 100px !important; // Mengurangi tinggi gambar lebih jauh
        }
        .card-title { // Mengatur ulang judul kartu
            font-size: 0.85rem; // Menyesuaikan ukuran font
        }
        .card-text { // Mengatur ulang teks kartu
            font-size: 0.75rem; // Menyesuaikan ukuran font
        }
    }
</style>

<!-- Bagian JavaScript untuk Auto Scroll -->
<script>
    document.addEventListener('DOMContentLoaded', function () { // Menambahkan event listener saat halaman selesai dimuat
        const carousel = document.getElementById('newsCarousel'); // Mendapatkan elemen carousel berdasarkan ID
        let scrollPosition = 0; // Inisialisasi posisi scroll
        const cardWidth = window.innerWidth <= 768 // Menentukan lebar kartu berdasarkan ukuran layar
            ? carousel.querySelector('.col-4').offsetWidth + 12 // Lebar kartu + jarak untuk layar <= 768px
            : carousel.querySelector('.col-4').offsetWidth + 16; // Lebar kartu + jarak untuk layar > 768px
        const maxScroll = carousel.scrollWidth - carousel.clientWidth; // Menghitung jarak scroll maksimum

        function autoScroll() { // Fungsi untuk scroll otomatis
            scrollPosition += cardWidth; // Meningkatkan posisi scroll sebesar lebar kartu
            if (scrollPosition >= maxScroll) { // Memeriksa apakah scroll mencapai akhir
                scrollPosition = 0; // Kembali ke posisi awal jika mencapai akhir
            }
            carousel.scrollTo({ // Melakukan scroll ke posisi baru
                left: scrollPosition, // Posisi horizontal
                behavior: 'smooth' // Efek scroll mulus
            });
        }

        setInterval(autoScroll, 3000); // Menjalankan fungsi autoScroll setiap 3000ms (3 detik)
    });
</script>

<!-- Memuat Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script> <!-- Memuat pustaka JavaScript Bootstrap untuk fungsionalitas tambahan seperti tooltip atau modal -->