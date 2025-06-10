<?= $this->extend('templates/header'); ?>

<?= $this->section('head'); ?>
    <!-- Mapbox GL JS dan CSS -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.7.0/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.7.0/mapbox-gl.js"></script>

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #maps {
            height: calc(100vh - 70px);
            width: 100%;
        }

        .info.legend {
            background: white;
            padding: 10px;
            line-height: 24px;
            color: #333;
            border-radius: 6px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            font-size: 13px;
        }

        .info.legend h4 {
            margin: 0 0 8px;
            font-size: 14px;
            font-weight: bold;
        }

        .legend-icon {
            background-size: 18px 30px;
            display: inline-block;
            width: 18px;
            height: 30px;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
    <div id="maps"></div>

    <script>
        // Inisialisasi Mapbox dengan access token dari PHP
        mapboxgl.accessToken = '<?php echo env('MAPBOX_TOKEN'); ?>';

        // Inisialisasi peta
        function initMap() {
            const map = new mapboxgl.Map({
                container: 'maps',
                style: 'mapbox://styles/mapbox/streets-v12',
                center: [108.270018, -6.403131], // Koordinat Lohbener
                zoom: 13
            });

            // Tambahkan kontrol navigasi (zoom dan rotasi)
            map.addControl(new mapboxgl.NavigationControl());

            // Data wilayah hanya yang status 'diterima'
            const dataWilayah = <?= json_encode($dataWilayah); ?>.filter(item => item.status === 'diterima');

            // Debugging: Log data untuk memeriksa isi
            console.log('Data Wilayah:', dataWilayah);

            // Tambahkan marker untuk setiap titik rawan yang diterima
            dataWilayah.forEach(row => {
                // Pastikan koordinat valid
                const lng = parseFloat(row.longitude);
                const lat = parseFloat(row.latitude);
                if (isNaN(lng) || isNaN(lat)) {
                    console.warn(`Koordinat tidak valid untuk ${row.nama_daerah}: lng=${lng}, lat=${lat}`);
                    return; // Lewati jika koordinat tidak valid
                }

                let markerIcon = '<?= base_url(); ?>/assets/img/marker-icon-blue.png'; // Default biru untuk "Lainnya"
                const jenis = row.jenis_kejahatan.toLowerCase();

                if (jenis === 'curanmor') {
                    markerIcon = '<?= base_url(); ?>/assets/img/marker-icon-red.png';
                } else if (jenis === 'perampokan') {
                    markerIcon = '<?= base_url(); ?>/assets/img/marker-icon-yellow.png';
                } else if (jenis === 'tawuran') {
                    markerIcon = '<?= base_url(); ?>/assets/img/marker-icon-green.png';
                } else if (jenis === 'begal') {
                    markerIcon = '<?= base_url(); ?>/assets/img/marker-icon-blue.png';
                }

                const marker = new mapboxgl.Marker({
                    element: createMarkerElement(markerIcon)
                })
                    .setLngLat([lng, lat])
                    .setPopup(new mapboxgl.Popup().setHTML(`
                        <div style="width: 180px; font-size: 13px;">
                            <img src="<?= base_url(); ?>/img/${row.gambar}" 
                                 style="width: 100%; height: 135px; object-fit: cover; border-radius: 6px;"
                                 onerror="this.src='<?= base_url(); ?>/assets/img/default-image.jpg';">
                            <h5 style="text-align: center; margin-top: 5px; font-size: 14px;">
                                Hati-hati daerah rawan: ${row.jenis_kejahatan}
                            </h5>
                            <p>
                                <b>Kelurahan</b>: ${row.kelnama}<br>
                                <b>Jalan/Tempat Kejadian</b>: ${row.nama_daerah}
                            </p>
                        </div>
                    `))
                    .addTo(map);
            });

            // Tambahkan legenda
            map.on('load', () => {
                const legendDiv = document.createElement('div');
                legendDiv.className = 'info legend';
                legendDiv.innerHTML = `
                    <h4>Keterangan</h4>
                    <i class="legend-icon" style="background-image: url('<?= base_url(); ?>/assets/img/marker-icon-red.png');"></i> Curanmor<br>
                    <i class="legend-icon" style="background-image: url('<?= base_url(); ?>/assets/img/marker-icon-yellow.png');"></i> Perampokan<br>
                    <i class="legend-icon" style="background-image: url('<?= base_url(); ?>/assets/img/marker-icon-green.png');"></i> Tawuran<br>
                    <i class="legend-icon" style="background-image: url('<?= base_url(); ?>/assets/img/marker-icon-blue.png');"></i> Begal / Lainnya<br>
                `;

                const legendControl = new mapboxgl.Control({ element: legendDiv });
                map.addControl(legendControl, 'bottom-right');
            });
        }

        // Fungsi untuk membuat elemen marker kustom
        function createMarkerElement(iconUrl) {
            const el = document.createElement('div');
            el.style.backgroundImage = `url(${iconUrl})`;
            el.style.width = '25px';
            el.style.height = '41px';
            el.style.backgroundSize = '100%';
            return el;
        }

        // Inisialisasi peta saat halaman dimuat
        window.onload = initMap;
    </script>
<?= $this->endSection(); ?>