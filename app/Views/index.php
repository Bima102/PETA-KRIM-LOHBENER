<!-- Bagian Hero Section -->
<div class="jumbotron hero">
    <!-- Kontainer untuk konten hero -->
    <div class="container">
        <!-- Baris dengan penyelarasan tengah dan padding vertikal -->
        <div class="row justify-content-center py-5">
            <!-- Kolom untuk konten hero, maksimum lebar 10/12 di layar medium -->
            <div class="col-md-10">
                <!-- Baris dalam untuk penyelarasan tengah -->
                <div class="row justify-content-center">
                    <!-- Kolom untuk teks hero, maksimum lebar 8/12 -->
                    <div class="col-md-8">
                        <!-- Judul utama aplikasi dengan animasi AOS -->
                        <h1 class="text-white text-center fw-bold mb-4 shadow-text" data-aos="fade-up">
                            PETA-KRIM LOHBENER
                        </h1>
                        <!-- Deskripsi aplikasi dengan animasi AOS -->
                        <p class="text-white text-center mb-4 lead shadow-text" data-aos="fade-up" data-aos-delay="100">
                            Website ini menampilkan peta lokasi<br>
                            dan informasi kasus kriminalitas yang terjadi di wilayah tersebut.<br>
                            Tujuannya adalah membantu masyarakat lebih waspada<br>
                            dan berhati-hati.
                        </p>
                        <!-- Tombol untuk menjelajahi fitur dengan animasi AOS -->
                        <p class="text-center" data-aos="fade-up" data-aos-delay="200">
                            <a class="btn btn-warning btn-lg shadow-sm fw-semibold px-4" href="#features" role="button">JELAJAHI</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bagian Edukasi Kriminalitas -->
<section class="py-5 bg-white" id="edukasi">
    <!-- Kontainer utama dengan margin atas -->
    <div class="container mt-5">
        <!-- Ikon dan teks "Edukasi" dengan animasi AOS -->
        <h2 class="text-center mb-2" data-aos="fade-up">
            <i class="bi bi-book-half text-primary me-2"></i>Edukasi
        </h2>
        <!-- Judul utama untuk jenis kejahatan dengan animasi AOS -->
        <h2 class="text-center text-dark mb-4 fw-bold" data-aos="fade-up" data-aos-delay="100">
            Jenis-Jenis Kejahatan
        </h2>

        <!-- Baris dengan auto-scroll untuk kartu kejahatan -->
        <div class="row g-4 auto-scroll" id="crimeCarousel">
            <!-- Kartu Pencurian Biasa (CUBIS) -->
            <div class="col-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <!-- Kartu dengan bayangan dan sudut membulat -->
                <div class="card crime-card h-100 shadow-sm border-0 rounded-4 transition hover-shadow position-relative">
                    <!-- Gambar untuk CUBIS -->
                    <img src="<?= base_url(); ?>/assets/img/pencuri.jpg" class="card-img-top rounded-top-4" alt="Pencurian Biasa (CUBIS)">
                    <!-- Badan kartu dengan konten -->
                    <div class="card-body">
                        <!-- Judul kartu dengan ikon -->
                        <h5 class="card-title">
                            <i class="bi bi-bag-dash-fill text-danger me-2"></i>Pencurian Biasa (CUBIS)
                        </h5>
                        <!-- Deskripsi singkat CUBIS -->
                        <p class="card-text small">
                            Tindakan mengambil barang milik orang lain dengan maksud untuk memilikinya secara melawan hukum. Contoh kejahatan CUBIS: mencopet, mencuri barang di pasar, atau mencuri HP di tempat umum.
                        </p>
                        <!-- Tombol untuk menampilkan ringkasan -->
                        <a class="btn btn-secondary btn-sm mb-2" data-bs-toggle="collapse" href="#detailCubis" role="button" aria-expanded="false" aria-controls="detailCubis">
                            Baca Ringkasan
                        </a>
                        <!-- Konten ringkasan yang dapat dibuka/tutup -->
                        <div class="collapse" id="detailCubis">
                            <p class="mt-2 small text-muted">
                                Sebagaimana diatur dalam Pasal 362 KUHP, CUBIS mencakup unsur tindakan mengambil barang orang lain, dengan niat memiliki secara melawan hukum tanpa unsur kekerasan atau pemberatan.
                            </p>
                        </div>
                        <!-- Tautan ke artikel lengkap -->
                        <a href="https://www.hukumonline.com/klinik/a/ini-bunyi-pasal-362-kuhp-tentang-pencurian-lt65802c0e6e0f9/" class="btn btn-dark btn-sm" target="_blank">Selengkapnya</a>
                    </div>
                </div>
            </div>

            <!-- Kartu Pencurian Kendaraan Bermotor (CURANMOR) -->
            <div class="col-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <!-- Kartu dengan bayangan dan sudut membulat -->
                <div class="card crime-card h-100 shadow-sm border-0 rounded-4 transition hover-shadow position-relative">
                    <!-- Gambar untuk CURANMOR -->
                    <img src="<?= base_url(); ?>/assets/img/malingmotor.jpg" class="card-img-top rounded-top-4" alt="Pencurian Kendaraan Bermotor">
                    <!-- Badan kartu dengan konten -->
                    <div class="card-body">
                        <!-- Judul kartu dengan ikon -->
                        <h5 class="card-title">
                            <i class="bi bi-car-front-fill text-warning me-2"></i>CURANMOR
                        </h5>
                        <!-- Deskripsi singkat CURANMOR -->
                        <p class="card-text small">
                            Pencurian kendaraan bermotor secara melawan hukum dengan tujuan memiliki atau menjual kembali. Contoh: mencuri motor di parkiran, membobol mobil, dan menyikat motor ojek online saat lengah.
                        </p>
                        <!-- Tombol untuk menampilkan ringkasan -->
                        <a class="btn btn-secondary btn-sm mb-2" data-bs-toggle="collapse" href="#detailCuranmor" role="button" aria-expanded="false" aria-controls="detailCuranmor">
                            Baca Ringkasan
                        </a>
                        <!-- Konten ringkasan yang dapat dibuka/tutup -->
                        <div class="collapse" id="detailCuranmor">
                            <p class="mt-2 small text-muted">
                                Biasanya dilakukan dengan merusak kunci kontak, memecahkan kaca kendaraan, atau menggunakan kunci palsu. Pelaku bisa dijerat Pasal 363 KUHP jika terdapat pemberatan seperti dilakukan malam hari.
                            </p>
                        </div>
                        <!-- Tautan ke artikel lengkap -->
                        <a href="https://www.hukumonline.com/klinik/a/pencurian-yang-dilakukan-dengan-kunci-duplikat-lt5d25a7019f837/" class="btn btn-dark btn-sm" target="_blank">Selengkapnya</a>
                    </div>
                </div>
            </div>

            <!-- Kartu Pencurian dengan Kekerasan (CURAS) -->
            <div class="col-4 mb-4" data-aos="fade-up" data-aos-delay="400">
                <!-- Kartu dengan bayangan dan sudut membulat -->
                <div class="card crime-card h-100 shadow-sm border-0 rounded-4 transition hover-shadow position-relative">
                    <!-- Gambar untuk CURAS -->
                    <img src="<?= base_url(); ?>/assets/img/begal.jpg" class="card-img-top rounded-top-4" alt="CURAS">
                    <!-- Badan kartu dengan konten -->
                    <div class="card-body">
                        <!-- Judul kartu dengan ikon -->
                        <h5 class="card-title">
                            <i class="bi bi-exclamation-octagon-fill text-danger me-2"></i>CURAS
                        </h5>
                        <!-- Deskripsi singkat CURAS -->
                        <p class="card-text small">
                            Pencurian yang disertai kekerasan atau ancaman kekerasan terhadap korban. Contoh CURAS: begal motor, penjambretan dengan kekerasan, dan perampokan rumah dengan senjata tajam.
                        </p>
                        <!-- Tombol untuk menampilkan ringkasan -->
                        <a class="btn btn-secondary btn-sm mb-2" data-bs-toggle="collapse" href="#detailCuras" role="button" aria-expanded="false" aria-controls="detailCuras">
                            Baca Ringkasan
                        </a>
                        <!-- Konten ringkasan yang dapat dibuka/tutup -->
                        <div class="collapse" id="detailCuras">
                            <p class="mt-2 small text-muted">
                                CURAS diatur dalam Pasal 365 KUHP. Pelaku menggunakan kekerasan agar korban menyerahkan harta bendanya, bahkan bisa menyebabkan luka berat atau kematian korban.
                            </p>
                        </div>
                        <!-- Tautan ke artikel lengkap -->
                        <a href="https://www.hukumonline.com/klinik/a/simak-begini-bunyi-dan-unsur-unsur-pasal-365-kuhp-lt65cb50141d1a0/" class="btn btn-dark btn-sm" target="_blank">Selengkapnya</a>
                    </div>
                </div>
            </div>

            <!-- Kartu Pencurian dengan Pemberatan (CURAT) -->
            <div class="col-4 mb-4" data-aos="fade-up" data-aos-delay="500">
                <!-- Kartu dengan bayangan dan sudut membulat -->
                <div class="card crime-card h-100 shadow-sm border-0 rounded-4 transition hover-shadow position-relative">
                    <!-- Gambar untuk CURAT -->
                    <img src="<?= base_url(); ?>/assets/img/Pencurianp.jpg" class="card-img-top rounded-top-4" alt="CURAT">
                    <!-- Badan kartu dengan konten -->
                    <div class="card-body">
                        <!-- Judul kartu dengan ikon -->
                        <h5 class="card-title">
                            <i class="bi bi-door-closed-fill text-primary me-2"></i>CURAT
                        </h5>
                        <!-- Deskripsi singkat CURAT -->
                        <p class="card-text small">
                            Pencurian dengan pemberatan, seperti membongkar rumah saat pemilik tidak ada. Contoh: membobol rumah kosong, mencuri di kantor malam hari, dan mencuri di toko swalayan dengan alat khusus.
                        </p>
                        <!-- Tombol untuk menampilkan ringkasan -->
                        <a class="btn btn-secondary btn-sm mb-2" data-bs-toggle="collapse" href="#detailCurat" role="button" aria-expanded="false" aria-controls="detailCurat">
                            Baca Ringkasan
                        </a>
                        <!-- Konten ringkasan yang dapat dibuka/tutup -->
                        <div class="collapse" id="detailCurat">
                            <p class="mt-2 small text-muted">
                                Pasal 363 KUHP menjelaskan CURAT dilakukan dengan kondisi tertentu, seperti dilakukan malam hari, oleh dua orang atau lebih, dengan cara merusak, memanjat, atau menggunakan alat khusus.
                            </p>
                        </div>
                        <!-- Tautan ke artikel lengkap -->
                        <a href="https://www.hukumonline.com/klinik/a/bunyi-pasal-363-kuhp-tentang-pencurian-dengan-pemberatan-lt6593d9f864498/" class="btn btn-dark btn-sm" target="_blank">Selengkapnya</a>
                    </div>
                </div>
            </div>

            <!-- Kartu Pembunuhan -->
            <div class="col-4 mb-4" data-aos="fade-up" data-aos-delay="600">
                <!-- Kartu dengan bayangan dan sudut membulat -->
                <div class="card crime-card h-100 shadow-sm border-0 rounded-4 transition hover-shadow position-relative">
                    <!-- Gambar untuk Pembunuhan -->
                    <img src="<?= base_url(); ?>/assets/img/pembunuhan.png" class="card-img-top rounded-top-4" alt="Pembunuhan">
                    <!-- Badan kartu dengan konten -->
                    <div class="card-body">
                        <!-- Judul kartu dengan ikon -->
                        <h5 class="card-title">
                            <i class="bi bi-skull-crossbones text-dark me-2"></i>Pembunuhan
                        </h5>
                        <!-- Deskripsi singkat Pembunuhan -->
                        <p class="card-text small">
                            Tindakan menghilangkan nyawa orang lain secara sengaja dan melawan hukum, baik dengan perencanaan atau spontan.
                        </p>
                        <!-- Tombol untuk menampilkan ringkasan -->
                        <a class="btn btn-secondary btn-sm mb-2" data-bs-toggle="collapse" href="#detailPembunuhan" role="button" aria-expanded="false" aria-controls="detailPembunuhan">
                            Baca Ringkasan
                        </a>
                        <!-- Konten ringkasan yang dapat dibuka/tutup -->
                        <div class="collapse" id="detailPembunuhan">
                            <p class="mt-2 small text-muted">
                                Termasuk pembunuhan berencana (Pasal 340 KUHP), pembunuhan karena emosi sesaat, dan pembunuhan karena pembelaan diri yang berlebihan.
                            </p>
                        </div>
                        <!-- Tautan ke artikel lengkap -->
                        <a href="https://www.hukumonline.com/klinik/a/pasal-340-kuhp-pembunuhan-berencana-dan-unsurnya-lt656d9e0860c6a/" class="btn btn-dark btn-sm" target="_blank">Selengkapnya</a>
                    </div>
                </div>
            </div>

            <!-- Kartu Tawuran -->
            <div class="col-4 mb-4" data-aos="fade-up" data-aos-delay="700">
                <!-- Kartu dengan bayangan dan sudut membulat -->
                <div class="card crime-card h-100 shadow-sm border-0 rounded-4 transition hover-shadow position-relative">
                    <!-- Gambar untuk Tawuran -->
                    <img src="<?= base_url(); ?>/assets/img/tawuran-remaja.png" class="card-img-top rounded-top-4" alt="Tawuran">
                    <!-- Badan kartu dengan konten -->
                    <div class="card-body">
                        <!-- Judul kartu dengan ikon -->
                        <h5 class="card-title">
                            <i class="bi bi-people-fill text-info me-2"></i>Tawuran
                        </h5>
                        <!-- Deskripsi singkat Tawuran -->
                        <p class="card-text small">
                            Tawuran adalah perkelahian massal yang melibatkan dua kelompok atau lebih, umumnya pelajar, yang kerap menggunakan senjata tajam seperti celurit dan golok. Aksi ini sangat berbahaya karena dapat mengakibatkan luka berat, kerusakan fasilitas umum, bahkan kematian.
                        </p>
                        <!-- Tombol untuk menampilkan ringkasan -->
                        <a class="btn btn-secondary btn-sm mb-2" data-bs-toggle="collapse" href="#detailTawuran" role="button" aria-expanded="false" aria-controls="detailTawuran">
                            Baca Ringkasan
                        </a>
                        <!-- Konten ringkasan yang dapat dibuka/tutup -->
                        <div class="collapse" id="detailTawuran">
                            <p class="mt-2 small text-muted">
                                Tawuran antar pelajar sering kali terjadi karena perselisihan antarsekolah, geng remaja, atau provokasi melalui media sosial. Selain meresahkan masyarakat, pelaku tawuran dapat dijerat dengan beberapa pasal KUHP, di antaranya:
                            </p>
                            <!-- Daftar pasal terkait tawuran -->
                            <ul class="small ps-3">
                                <li><strong>Pasal 170 KUHP:</strong> Kekerasan secara bersama-sama terhadap orang atau barang, ancaman hukuman hingga 12 tahun penjara jika menyebabkan kematian.</li>
                                <li><strong>Pasal 358 KUHP:</strong> Perkelahian bersama-sama, pidana penjara hingga 2 tahun 8 bulan.</li>
                                <li><strong>Pasal 351 KUHP:</strong> Penganiayaan, termasuk yang menyebabkan luka berat atau kematian.</li>
                            </ul>
                        </div>
                        <!-- Tautan ke artikel lengkap -->
                        <a href="https://www.hukumonline.com/berita/a/tindak-pidana-tawuran-pelajar-lt62875710f12c8/" class="btn btn-dark btn-sm" target="_blank">Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian Langkah Pencegahan Kriminalitas -->
        <div class="container my-5">
            <!-- Judul untuk langkah pencegahan dengan animasi AOS -->
            <h2 class="text-center fw-bold mb-5" data-aos="fade-up">
                <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                Langkah Pencegahan Kriminalitas
            </h2>

            <!-- Baris dengan auto-scroll untuk kartu pencegahan -->
            <div class="row g-4 auto-scroll" id="preventionCarousel">
                <!-- Kartu Lapor Polisi -->
                <div class="col-4" data-aos="fade-up" data-aos-delay="200">
                    <!-- Kartu dengan bayangan dan tinggi penuh -->
                    <div class="card shadow border-0 h-100">
                        <!-- Header kartu dengan ikon -->
                        <div class="card-header bg-primary text-white fw-bold">
                            <i class="bi bi-shield-lock-fill me-2"></i>Lapor Polisi
                        </div>
                        <!-- Badan kartu dengan konten -->
                        <div class="card-body">
                            <p><i class="bi bi-telephone-fill text-primary me-2"></i>Segera laporkan kejadian mencurigakan atau tindak kejahatan untuk penanganan cepat oleh pihak berwajib.</p>
                        </div>
                    </div>
                </div>

                <!-- Kartu Ronda Malam -->
                <div class="col-4" data-aos="fade-up" data-aos-delay="300">
                    <!-- Kartu dengan bayangan dan tinggi penuh -->
                    <div class="card shadow border-0 h-100">
                        <!-- Header kartu dengan ikon -->
                        <div class="card-header bg-success text-white fw-bold">
                            <i class="bi bi-people-fill me-2"></i>Ronda Malam
                        </div>
                        <!-- Badan kartu dengan konten -->
                        <div class="card-body">
                            <p><i class="bi bi-eye-fill text-success me-2"></i>Kegiatan ronda malam membangun rasa aman dan solidaritas antarwarga untuk mencegah aksi kriminalitas.</p>
                        </div>
                    </div>
                </div>

                <!-- Kartu Pasang CCTV -->
                <div class="col-4" data-aos="fade-up" data-aos-delay="400">
                    <!-- Kartu dengan bayangan dan tinggi penuh -->
                    <div class="card shadow border-0 h-100">
                        <!-- Header kartu dengan ikon -->
                        <div class="card-header bg-warning text-dark fw-bold">
                            <i class="bi bi-camera-video-fill me-2"></i>Pasang CCTV
                        </div>
                        <!-- Badan kartu dengan konten -->
                        <div class="card-body">
                            <p><i class="bi bi-camera-fill text-warning me-2"></i>Tempatkan CCTV di area rawan guna merekam kejadian sebagai alat bantu penyelidikan dan pencegahan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Memuat CSS AOS untuk animasi saat scroll -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<!-- Bagian CSS Kustom -->
<style>
    /* Mengatur baris agar tidak wrap dan mendukung scroll horizontal */
    .row.auto-scroll {
        flex-wrap: nowrap !important; /* Mencegah pembungkusan kartu */
        overflow-x: auto !important; /* Mengaktifkan scroll horizontal */
        scroll-behavior: smooth; /* Scroll mulus */
    }

    /* Mengatur lebar kolom kartu */
    .col-4 {
        flex: 0 0 33.333333% !important; /* Lebar kolom 1/3 */
        max-width: 33.333333% !important; /* Maksimum lebar kolom */
        min-width: 250px; /* Lebar minimum untuk mencegah kartu terlalu sempit */
    }

    /* Menyembunyikan scrollbar untuk tampilan lebih bersih */
    .row.auto-scroll::-webkit-scrollbar {
        display: none; /* Sembunyikan scrollbar di Chrome/Safari */
    }

    /* Menyembunyikan scrollbar untuk browser lain */
    .row.auto-scroll {
        -ms-overflow-style: none; /* Sembunyikan scrollbar di IE/Edge */
        scrollbar-width: none; /* Sembunyikan scrollbar di Firefox */
    }
</style>

<!-- Memuat JavaScript AOS dan Auto Scroll -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Menunggu DOM selesai dimuat sebelum menjalankan script
    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi AOS untuk animasi saat scroll
        AOS.init({
            duration: 800, // Durasi animasi dalam milidetik
            once: true // Animasi hanya terjadi sekali saat scroll
        });

        // Daftar carousel yang akan di-scroll otomatis
        const carousels = [
            { id: 'crimeCarousel', interval: 3000 }, // Scroll setiap 3 detik untuk jenis kejahatan
            { id: 'preventionCarousel', interval: 3000 } // Scroll setiap 3 detik untuk pencegahan
        ];

        // Iterasi melalui setiap carousel
        carousels.forEach(carousel => {
            // Mengambil elemen carousel berdasarkan ID
            const container = document.getElementById(carousel.id);
            // Inisialisasi posisi scroll
            let scrollPosition = 0;
            // Menghitung lebar kartu (termasuk jarak antar kartu)
            const cardWidth = container.querySelector('.col-4').offsetWidth + 16; // Gutter g-4 = 16px
            // Menghitung batas maksimum scroll
            const maxScroll = container.scrollWidth - container.clientWidth;

            // Fungsi untuk menggulir carousel secara otomatis
            function autoScroll() {
                // Menambah posisi scroll sebesar lebar kartu
                scrollPosition += cardWidth;
                // Reset ke awal jika mencapai batas maksimum
                if (scrollPosition >= maxScroll) {
                    scrollPosition = 0;
                }
                // Menggulir carousel dengan animasi mulus
                container.scrollTo({
                    left: scrollPosition,
                    behavior: 'smooth'
                });
            }

            // Mengatur interval scroll berdasarkan waktu yang ditentukan
            setInterval(autoScroll, carousel.interval);
        });
    });
</script>