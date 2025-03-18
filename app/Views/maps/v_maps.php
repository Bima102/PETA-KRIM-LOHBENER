<?= $this->section('head'); ?>
<script src="<?= base_url(); ?>/leaflet/leaflet.js"></script>
<link rel="stylesheet" href="<?= base_url(); ?>/leaflet/leaflet.css">
<!-- Plugin Control Search -->
<script src="<?= base_url(); ?>/leaflet-search/src/leaflet-search.js"></script>

<style>
    /* Pastikan seluruh halaman penuh */
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    
    /* Pastikan peta memenuhi seluruh viewport */
    #maps {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>

<div id="maps"></div>

<script>
    // Inisialisasi peta dengan koordinat awal
    let map = L.map('maps').setView({
        lon: 108.270018,
        lat: -6.403131
    }, 13);

    // Tambahkan layer peta dari OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© <a href="https://openstreetmap.org/copyright" target="_blank"> OpenStreetMap'
    }).addTo(map);

    // Tambahkan marker berdasarkan data wilayah dari PHP
    <?php foreach ($dataWilayah as $row) : ?>
        L.marker({
            lon: <?= $row->longitude; ?>,
            lat: <?= $row->latitude; ?>
        }).bindPopup(`
            <br>
            <img src="<?= base_url(); ?>/img/<?= $row->gambar; ?>" width="200">
            <br>
            <h5><center>Rawan <?= $row->deskripsi; ?></center></h5>
            <b>Daerah</b>: <?= $row->nama_daerah; ?> <br>
            <b>Kecamatan</b>: <?= $row->kecnama; ?> <br>
            <b>Kelurahan</b>: <?= $row->kelnama; ?>
        `).addTo(map);
    <?php endforeach; ?>
</script>
