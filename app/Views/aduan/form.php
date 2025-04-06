<div class="container mt-5 mb-5">
    <h2 class="text-center">Form Aduan Masyarakat</h2>

    <!-- Tampilkan Pesan Sukses Jika Ada -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Tampilkan Error Validasi Jika Ada -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-center">
        <form action="/aduan/submit" method="post" class="p-5 shadow-lg bg-white rounded form-container" style="max-width: 800px; width: 100%;">
            <div class="mb-3">
                <label for="jenis_kejahatan" class="form-label">Jenis Kejahatan</label>
                <input type="text" class="form-control" name="jenis_kejahatan" value="<?= old('jenis_kejahatan') ?>" required>
            </div>
            <div class="mb-3">
                <label for="kelurahan" class="form-label">Kelurahan</label>
                <input type="text" class="form-control" name="kelurahan" value="<?= old('kelurahan') ?>" required>
            </div>
            <div class="mb-3">
                <label for="daerah" class="form-label">Daerah / Jalan</label>
                <input type="text" class="form-control" name="daerah" value="<?= old('daerah') ?>" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="latitude" class="form-label">Latitude</label>
                    <input type="text" class="form-control" name="latitude" value="<?= old('latitude') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="longitude" class="form-label">Longitude</label>
                    <input type="text" class="form-control" name="longitude" value="<?= old('longitude') ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="pelapor" class="form-label">Pelapor</label>
                <input type="text" class="form-control" name="pelapor" value="<?= esc($pelapor) ?>" readonly>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Kirim Aduan</button>
            </div>
        </form>
    </div>

    <!-- Panduan Pengambilan Titik Lokasi -->
    <div class="mt-5">
        <h5><i class="bi bi-info-circle"></i> Panduan Mengambil Titik Lokasi (Latitude & Longitude)</h5>
        <div class="alert alert-info">
            <strong>Langkah-langkah mengambil titik lokasi dari Google Maps (via HP):</strong>
            <ol class="mt-2">
                <li>Buka aplikasi <strong>Google Maps</strong> di handphone Anda.</li>
                <li>Arahkan ke lokasi kejadian atau geser peta hingga titik sesuai.</li>
                <li>Tekan dan tahan titik pada peta hingga muncul <strong>pin merah</strong>.</li>
                <li>Bagian bawah akan menampilkan informasi lokasi, ketuk bagian tersebut.</li>
                <li>Koordinat akan muncul dalam format <code>-7.123456, 110.123456</code>.</li>
                <li>Salin angka pertama ke kolom <strong>Latitude</strong> dan angka kedua ke kolom <strong>Longitude</strong>.</li>
            </ol>
            <p><strong>Contoh:</strong> Koordinat <code>-7.001234, 110.123456</code></p>
            <ul>
                <li>Latitude: <code>-7.001234</code></li>
                <li>Longitude: <code>110.123456</code></li>
            </ul>
            <div class="alert alert-warning mt-3">
                ⚠️ Pastikan titik lokasi yang Anda pilih benar-benar tempat kejadian untuk mempercepat proses penanganan.
            </div>
        </div>
    </div>
</div>
