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
    </style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
    <div id="maps"></div>

    <script>
        // Inisialisasi peta
        let map = L.map('maps').setView([-6.403131, 108.270018], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© <a href="https://openstreetmap.org/copyright" target="_blank">OpenStreetMap</a>'
        }).addTo(map);

        // Definisikan semua icon
        const defaultIcon = L.icon({
            iconUrl: '<?= base_url(); ?>/leaflet/images/marker-icon.png',
            shadowUrl: '<?= base_url(); ?>/leaflet/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        const redIcon = L.icon({
            iconUrl: '<?= base_url(); ?>/leaflet/images/marker-icon-red.png',
            shadowUrl: '<?= base_url(); ?>/leaflet/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        const yellowIcon = L.icon({
            iconUrl: '<?= base_url(); ?>/leaflet/images/marker-icon-yellow.png',
            shadowUrl: '<?= base_url(); ?>/leaflet/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        const greenIcon = L.icon({
            iconUrl: '<?= base_url(); ?>/leaflet/images/marker-icon-green.png',
            shadowUrl: '<?= base_url(); ?>/leaflet/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        // Kirim data PHP ke JS sebagai objek JSON
        const dataWilayah = <?= json_encode($dataWilayah); ?>;

        // Loop data marker
        dataWilayah.forEach(row => {
            let icon = defaultIcon;

            // Tentukan icon berdasarkan jenis kejahatan
            switch (row.jenis_kejahatan.toLowerCase()) {
                case 'curanmor':
                    icon = redIcon;
                    break;
                case 'perampokan':
                    icon = yellowIcon;
                    break;
                case 'tawuran':
                    icon = greenIcon;
                    break;
                // begal dan lainnya pakai default (biru)
            }

            L.marker([parseFloat(row.latitude), parseFloat(row.longitude)], { icon: icon })
                .bindPopup(`
                    <div style="width: 180px; font-size: 13px;">
                        <img 
                            src="<?= base_url(); ?>/img/${row.gambar}" 
                            style="width: 100%; height: 135px; object-fit: cover; border-radius: 6px;"
                        >
                        <h5 style="text-align: center; margin-top: 5px; font-size: 14px;">
                            Hati-hati daerah rawan: ${row.jenis_kejahatan}
                        </h5>
                        <p>
                            <b>Kecamatan</b>: ${row.kecnama}<br>
                            <b>Kelurahan</b>: ${row.kelnama}<br>
                            <b>Daerah/Jalan</b>: ${row.nama_daerah}
                        </p>
                    </div>
                `).addTo(map);
        });

                // Tambahkan legend (keterangan warna)
                const legend = L.control({ position: 'bottomright' });

                legend.onAdd = function (map) {
                    const div = L.DomUtil.create('div', 'info legend');
                    div.innerHTML += "<h4>Keterangan</h4>";
                    div.innerHTML += '<i style="background: url(<?= base_url(); ?>/leaflet/images/marker-icon-red.png) no-repeat center center; background-size: 18px 30px; display: inline-block; width: 18px; height: 30px;"></i> Curanmor<br>';
                    div.innerHTML += '<i style="background: url(<?= base_url(); ?>/leaflet/images/marker-icon-yellow.png) no-repeat center center; background-size: 18px 30px; display: inline-block; width: 18px; height: 30px;"></i> Perampokan<br>';
                    div.innerHTML += '<i style="background: url(<?= base_url(); ?>/leaflet/images/marker-icon-green.png) no-repeat center center; background-size: 18px 30px; display: inline-block; width: 18px; height: 30px;"></i> Tawuran<br>';
                    div.innerHTML += '<i style="background: url(<?= base_url(); ?>/leaflet/images/marker-icon.png) no-repeat center center; background-size: 18px 30px; display: inline-block; width: 18px; height: 30px;"></i> Begal<br>';
                    return div;
                };

                legend.addTo(map);
    </script>
<?= $this->endSection(); ?>
