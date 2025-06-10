<?= $this->extend('templates/header'); ?>

<?= $this->section('head'); ?>
    <!-- Memuat CSS Mapbox GL JS untuk gaya peta -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.7.0/mapbox-gl.css" rel="stylesheet">
    <!-- Memuat JavaScript Mapbox GL JS untuk fungsi peta -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.7.0/mapbox-gl.js"></script>

    <style>
        /* Mengatur tinggi dan margin halaman agar peta mengisi layar */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        /* Mengatur ukuran elemen peta */
        #maps {
            height: calc(100vh - 70px); /* Tinggi peta disesuaikan dengan tinggi layar dikurangi header */
            width: 100%; /* Lebar peta penuh */
        }

        /* Gaya untuk kotak legenda */
        .info.legend {
            background: white; /* Latar belakang putih */
            padding: 10px; /* Jarak dalam 10px */
            line-height: 24px; /* Jarak antar baris */
            color: #333; /* Warna teks abu-abu gelap */
            border-radius: 6px; /* Sudut membulat */
            box-shadow: 0 0 15px rgba(0,0,0,0.2); /* Bayangan kotak */
            font-size: 13px; /* Ukuran font */
        }

        /* Gaya untuk judul legenda */
        .info.legend h4 {
            margin: 0 0 8px; /* Margin bawah 8px */
            font-size: 14px; /* Ukuran font judul */
            font-weight: bold; /* Tebal untuk judul */
        }

        /* Gaya untuk ikon legenda */
        .legend-icon {
            background-size: 18px 30px; /* Ukuran ikon legenda */
            display: inline-block; /* Menampilkan sebagai inline-block */
            width: 18px; /* Lebar ikon */
            height: 30px; /* Tinggi ikon */
            background-repeat: no-repeat; /* Ikon tidak diulang */
            background-position: center; /* Posisi ikon di tengah */
        }
    </style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
    <!-- Elemen div untuk menampilkan peta -->
    <div id="maps"></div>

    <script>
        // Mengatur token akses Mapbox dari variabel lingkungan PHP
        mapboxgl.accessToken = '<?php echo env('MAPBOX_TOKEN'); ?>';

        // Fungsi initMap: Menginisialisasi peta dan menambahkan marker serta legenda
        function initMap() {
            // Membuat instance peta Mapbox
            const map = new mapboxgl.Map({
                container: 'maps', // ID elemen HTML untuk peta
                style: 'mapbox://styles/mapbox/streets-v12', // Gaya peta (streets)
                center: [108.270018, -6.403131], // Koordinat pusat (Lohbener, Indramayu)
                zoom: 13 // Tingkat zoom awal
            });

            // Menambahkan kontrol navigasi (zoom dan rotasi)
            map.addControl(new mapboxgl.NavigationControl());

            // Mengambil data wilayah dari PHP, hanya status 'diterima'
            const dataWilayah = <?= json_encode($dataWilayah); ?>.filter(item => item.status === 'diterima');

            // Debugging: Mencatat data wilayah ke konsol untuk memeriksa isi
            console.log('Data Wilayah:', dataWilayah);

            // Menambahkan marker untuk setiap titik rawan kejahatan
            dataWilayah.forEach(row => {
                // Mengonversi longitude dan latitude ke angka
                const lng = parseFloat(row.longitude);
                const lat = parseFloat(row.latitude);

                // Memeriksa apakah koordinat valid
                if (isNaN(lng) || isNaN(lat)) {
                    // Mencatat peringatan jika koordinat tidak valid
                    console.warn(`Koordinat tidak valid untuk ${row.nama_daerah}: lng=${lng}, lat=${lat}`);
                    return; // Lewati iterasi jika koordinat tidak valid
                }

                // Menentukan ikon marker berdasarkan jenis kejahatan
                let markerIcon = '<?= base_url(); ?>/assets/img/marker-icon-blue.png'; // Default biru
                const jenis = row.jenis_kejahatan.toLowerCase();

                if (jenis === 'curanmor') {
                    markerIcon = '<?= base_url(); ?>/assets/img/marker-icon-red.png'; // Ikon merah untuk curanmor
                } else if (jenis === 'perampokan') {
                    markerIcon = '<?= base_url(); ?>/assets/img/marker-icon-yellow.png'; // Ikon kuning untuk perampokan
                } else if (jenis === 'tawuran') {
                    markerIcon = '<?= base_url(); ?>/assets/img/marker-icon-green.png'; // Ikon hijau untuk tawuran
                } else if (jenis === 'begal') {
                    markerIcon = '<?= base_url(); ?>/assets/img/marker-icon-blue.png'; // Ikon biru untuk begal
                }

                // Membuat marker dengan ikon kustom
                const marker = new mapboxgl.Marker({
                    element: createMarkerElement(markerIcon) // Elemen marker kustom
                })
                    .setLngLat([lng, lat]) // Menetapkan posisi marker
                    .setPopup(new mapboxgl.Popup().setHTML(`
                        <div style="width: 180px; font-size: 13px;">
                            <!-- Gambar kejadian dengan fallback jika gagal dimuat -->
                            <img src="<?= base_url(); ?>/img/${row.gambar}" 
                                 style="width: 100%; height: 135px; object-fit: cover; border-radius: 6px;"
                                 onerror="this.src='<?= base_url(); ?>/assets/img/default-image.jpg';">
                            <!-- Judul popup dengan jenis kejahatan -->
                            <h5 style="text-align: center; margin-top: 5px; font-size: 14px;">
                                Hati-hati daerah rawan: ${row.jenis_kejahatan}
                            </h5>
                            <!-- Informasi kelurahan dan lokasi kejadian -->
                            <p>
                                <b>Kelurahan</b>: ${row.kelnama}<br>
                                <b>Jalan/Tempat Kejadian</b>: ${row.nama_daerah}
                            </p>
                        </div>
                    `))
                    .addTo(map); // Menambahkan marker ke peta
            });

            // Menambahkan legenda saat peta selesai dimuat
            map.on('load', () => {
                // Membuat elemen div untuk legenda
                const legendDiv = document.createElement('div');
                legendDiv.className = 'info legend';
                legendDiv.innerHTML = `
                    <h4>Keterangan</h4>
                    <!-- Ikon dan keterangan untuk jenis kejahatan -->
                    <i class="legend-icon" style="background-image: url('<?= base_url(); ?>/assets/img/marker-icon-red.png');"></i> Curanmor<br>
                    <i class="legend-icon" style="background-image: url('<?= base_url(); ?>/assets/img/marker-icon-yellow.png');"></i> Perampokan<br>
                    <i class="legend-icon" style="background-image: url('<?= base_url(); ?>/assets/img/marker-icon-green.png');"></i> Tawuran<br>
                    <i class="legend-icon" style="background-image: url('<?= base_url(); ?>/assets/img/marker-icon-blue.png');"></i> Begal / Lainnya<br>
                `;

                // Membuat kontrol kustom untuk legenda
                const legendControl = new mapboxgl.Control({ element: legendDiv });
                // Menambahkan legenda ke peta di posisi kanan bawah
                map.addControl(legendControl, 'bottom-right');
            });
        }

        // Fungsi createMarkerElement: Membuat elemen HTML untuk ikon marker kustom
        function createMarkerElement(iconUrl) {
            // Membuat elemen div untuk marker
            const el = document.createElement('div');
            // Mengatur gambar latar belakang marker
            el.style.backgroundImage = `url(${iconUrl})`;
            // Mengatur lebar marker
            el.style.width = '25px';
            // Mengatur tinggi marker
            el.style.height = '41px';
            // Mengatur ukuran gambar agar sesuai dengan elemen
            el.style.backgroundSize = '100%';
            // Mengembalikan elemen marker
            return el;
        }

        // Memulai inisialisasi peta saat halaman dimuat
        window.onload = initMap;
    </script>
<?= $this->endSection(); ?>