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
            height: calc(100vh - 70px); /* Atur sesuai tinggi navbar kamu */
            width: 100%;
        }
    </style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
    <div id="maps"></div>

    <script>
        let map = L.map('maps').setView([-6.403131, 108.270018], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© <a href="https://openstreetmap.org/copyright" target="_blank">OpenStreetMap</a>'
        }).addTo(map);

        <?php foreach ($dataWilayah as $row): ?>
            L.marker([<?= $row->latitude ?>, <?= $row->longitude ?>])
                .bindPopup(`
                    <div style="width: 180px; font-size: 13px;">
                        <img 
                            src="<?= base_url(); ?>/img/<?= esc($row->gambar); ?>" 
                            style="width: 100%; height: 135px; object-fit: cover; border-radius: 6px;"
                        >
                        <h5 style="text-align: center; margin-top: 5px; font-size: 14px;">
                            Hati-hati daerah rawan: <?= esc($row->jenis_kejahatan); ?>
                        </h5>
                        <p>
                            <b>Kecamatan</b>: <?= esc($row->kecnama); ?><br>
                            <b>Kelurahan</b>: <?= esc($row->kelnama); ?><br>
                            <b>Daerah/Jalan</b>: <?= esc($row->nama_daerah); ?>
                        </p>
                    </div>
                `).addTo(map);
        <?php endforeach; ?>
    </script>
<?= $this->endSection(); ?>
