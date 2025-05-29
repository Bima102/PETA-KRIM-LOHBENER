<?= $this->extend('templates/header'); ?>

<?= $this->section('head'); ?>
    <!-- Leaflet JS dan CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>/leaflet/leaflet.css">
    <script src="<?= base_url(); ?>/leaflet/leaflet.js"></script>

    <!-- Leaflet Search -->
    <link rel="stylesheet" href="<?= base_url(); ?>/leaflet-search/src/leaflet-search.css">
    <script src="<?= base_url(); ?>/leaflet-search/src/leaflet-search.js"></script>

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
        // Inisialisasi peta terfokus ke Lohbener
        const map = L.map('maps').setView([-6.403131, 108.270018], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© <a href="https://openstreet.org/copyright" target="_blank">OpenStreetMap</a>'
        }).addTo(map);

        // Definisi icon sesuai warna kejahatan
        const icons = {
            default: L.icon({
                iconUrl: '<?= base_url(); ?>/leaflet/images/marker-icon.png',
                shadowUrl: '<?= base_url(); ?>/leaflet/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            }),
            red: L.icon({
                iconUrl: '<?= base_url(); ?>/leaflet/images/marker-icon-red.png',
                shadowUrl: '<?= base_url(); ?>/leaflet/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            }),
            yellow: L.icon({
                iconUrl: '<?= base_url(); ?>/leaflet/images/marker-icon-yellow.png',
                shadowUrl: '<?= base_url(); ?>/leaflet/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            }),
            green: L.icon({
                iconUrl: '<?= base_url(); ?>/leaflet/images/marker-icon-green.png',
                shadowUrl: '<?= base_url(); ?>/leaflet/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            })
        };

        // Data wilayah hanya yang status 'diterima'
        const dataWilayah = <?= json_encode($dataWilayah); ?>.filter(item => item.status === 'diterima');

        // Tambahkan marker untuk setiap titik rawan yang diterima
        dataWilayah.forEach(row => {
            let icon = icons.default;
            const jenis = row.jenis_kejahatan.toLowerCase();

            if (jenis === 'curanmor') icon = icons.red;
            else if (jenis === 'perampokan') icon = icons.yellow;
            else if (jenis === 'tawuran') icon = icons.green;

            const marker = L.marker(
                [parseFloat(row.latitude), parseFloat(row.longitude)],
                { icon: icon }
            ).addTo(map);

            marker.bindPopup(`
                <div style="width: 180px; font-size: 13px;">
                    <img src="<?= base_url(); ?>/img/${row.gambar}" 
                         style="width: 100%; height: 135px; object-fit: cover; border-radius: 6px;">
                    <h5 style="text-align: center; margin-top: 5px; font-size: 14px;">
                        Hati-hati daerah rawan: ${row.jenis_kejahatan}
                    </h5>
                    <p>
                        <b>Kelurahan</b>: ${row.kelnama}<br>
                        <b>Tempat/Jalan Kejadian</b>: ${row.nama_daerah}
                    </p>
                </div>
            `);
        });

        // Tambahkan legenda
        const legend = L.control({ position: 'bottomright' });
        legend.onAdd = function () {
            const div = L.DomUtil.create('div', 'info legend');
            div.innerHTML += "<h4>Keterangan</h4>";
            div.innerHTML += `<i class="legend-icon" style="background-image: url('<?= base_url(); ?>/leaflet/images/marker-icon-red.png');"></i> Curanmor<br>`;
            div.innerHTML += `<i class="legend-icon" style="background-image: url('<?= base_url(); ?>/leaflet/images/marker-icon-yellow.png');"></i> Perampokan<br>`;
            div.innerHTML += `<i class="legend-icon" style="background-image: url('<?= base_url(); ?>/leaflet/images/marker-icon-green.png');"></i> Tawuran<br>`;
            div.innerHTML += `<i class="legend-icon" style="background-image: url('<?= base_url(); ?>/leaflet/images/marker-icon.png');"></i> Begal / Lainnya<br>`;
            return div;
        };
        legend.addTo(map);
    </script>
<?= $this->endSection(); ?>