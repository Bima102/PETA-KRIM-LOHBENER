<div class="container mt-5 mb-5"> <!-- Menambahkan margin bawah -->
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
                <label for="kecamatan" class="form-label">Kecamatan</label>
                <input type="text" class="form-control" name="kecamatan" value="<?= old('kecamatan') ?>" required>
            </div>
            <div class="mb-3">
                <label for="kelurahan" class="form-label">Kelurahan</label>
                <input type="text" class="form-control" name="kelurahan" value="<?= old('kelurahan') ?>" required>
            </div>
            <div class="mb-3">
                <label for="daerah" class="form-label">Daerah/Jalan</label>
                <input type="text" class="form-control" name="daerah" value="<?= old('daerah') ?>" required>
            </div>
            <div class="mb-3">
                <label for="pelapor" class="form-label">Pelapor</label>
                <input type="text" class="form-control" name="pelapor" id="pelapor" value="<?= esc($pelapor) ?>" readonly>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Kirim Aduan</button>
            </div>
        </form>
    </div>
</div>
