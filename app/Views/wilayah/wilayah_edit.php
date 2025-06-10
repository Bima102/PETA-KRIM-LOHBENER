<?php
// Konfigurasi tombol submit
$submit = [
    'name'  => 'submit',
    'id'    => 'submit',
    'value' => 'Update',
    'class' => 'btn btn-warning px-4 fw-bold shadow-sm',
    'type'  => 'submit'
];

// Konfigurasi input untuk mempermudah dan konsisten
$nama_daerah = [
    'type'        => 'text',
    'name'        => 'nama_daerah',
    'id'          => 'nama_daerah',
    'class'       => 'form-control fw-bold p-2 rounded-3',
    'placeholder' => 'Contoh: Jl. Merdeka / RT 01 RW 02',
    'value'       => old('nama_daerah', esc($wilayah->nama_daerah)), // Escape untuk keamanan
    'required'    => true
];

$latitude = [
    'type'        => 'text',
    'name'        => 'latitude',
    'id'          => 'latitude',
    'class'       => 'form-control fw-bold p-2 rounded-3',
    'placeholder' => 'Contoh: -7.123456',
    'value'       => old('latitude', esc($wilayah->latitude)), // Escape untuk keamanan
    'required'    => true
];

$longitude = [
    'type'        => 'text',
    'name'        => 'longitude',
    'id'          => 'longitude',
    'class'       => 'form-control fw-bold p-2 rounded-3',
    'placeholder' => 'Contoh: 109.123456',
    'value'       => old('longitude', esc($wilayah->longitude)), // Escape untuk keamanan
    'required'    => true
];
?>

<div class="row justify-content-center mt-4 mb-5">
    <div class="col-md-10">
        <div class="card shadow-lg border-0 rounded-4" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">

            <!-- Header -->
            <div class="card-header bg-dark text-warning d-flex align-items-center rounded-top">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-edit me-2"></i> Formulir Edit Data Wilayah
                </h5>
            </div>

            <!-- Notifikasi Sukses -->
            <?php if (session()->getFlashdata('msg')) : ?>
                <div class="alert alert-success m-4 text-dark fw-bold shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2 text-success"></i>
                    <?= esc(session()->getFlashdata('msg')); ?>
                </div>
            <?php endif; ?>

            <!-- Notifikasi Error Validasi -->
            <?php if (isset($validation) && $validation->getErrors()) : ?>
                <div class="alert alert-danger m-4 text-dark fw-bold shadow-sm" role="alert">
                    <i class="fas fa-exclamation-circle me-2 text-danger"></i>
                    <ul class="mb-0">
                        <?php foreach ($validation->getErrors() as $error) : ?>
                            <li><?= esc($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="card-body p-4">
                <form action="/wilayah/wilayahUpdate/<?= esc($wilayah->id); ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="gambarLama" value="<?= esc($wilayah->gambar); ?>">

                    <!-- Kelurahan -->
                    <div class="form-group mb-3">
                        <?= form_label('<i class="fas fa-map-pin me-1"></i> Kelurahan', 'kelurahan'); ?>
                        <select id="kelurahan" class="form-control fw-bold p-2 rounded-3" name="kelurahan" required>
                            <option value="" disabled hidden>Pilih Kelurahan</option>
                            <?php foreach ($kelurahan as $kel) : ?>
                                <option value="<?= esc($kel); ?>" <?= $kel == $wilayah->kelurahan ? 'selected' : ''; ?>>
                                    <?= esc($kel); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Nama Jalan -->
                    <div class="form-group mb-3">
                        <?= form_label('<i class="fas fa-road me-1"></i> Detail patokan Tempat/Jalan/Gang Kejadian', 'nama_daerah'); ?>
                        <?= form_input($nama_daerah); ?>
                    </div>

                    <!-- Koordinat -->
                    <div class="row mb-3">
                        <div class="col">
                            <?= form_label('<i class="fas fa-location-arrow me-1"></i> Latitude', 'latitude'); ?>
                            <?= form_input($latitude); ?>
                            <small class="form-text text-muted">Masukkan dalam format desimal, misalnya: -7.123456</small>
                        </div>
                        <div class="col">
                            <?= form_label('<i class="fas fa-location-arrow me-1"></i> Longitude', 'longitude'); ?>
                            <?= form_input($longitude); ?>
                            <small class="form-text text-muted">Masukkan dalam format desimal, misalnya: 109.123456</small>
                        </div>
                    </div>

                    <!-- Jenis Kejahatan -->
                    <div class="form-group mb-3">
                        <?= form_label('<i class="fas fa-info-circle me-1"></i> Jenis Kejahatan', 'jenis_kejahatan'); ?>
                        <select name="jenis_kejahatan" id="jenis_kejahatan" class="form-control fw-bold p-2 rounded-3" required onchange="toggleCustomInput()">
                            <option value="" disabled hidden>Pilih Jenis Kejahatan</option>
                            <option value="curanmor" <?= old('jenis_kejahatan', $wilayah->jenis_kejahatan) == 'curanmor' ? 'selected' : ''; ?>>Curanmor</option>
                            <option value="perampokan" <?= old('jenis_kejahatan', $wilayah->jenis_kejahatan) == 'perampokan' ? 'selected' : ''; ?>>Perampokan</option>
                            <option value="begal" <?= old('jenis_kejahatan', $wilayah->jenis_kejahatan) == 'begal' ? 'selected' : ''; ?>>Begal</option>
                            <option value="tawuran" <?= old('jenis_kejahatan', $wilayah->jenis_kejahatan) == 'tawuran' ? 'selected' : ''; ?>>Tawuran</option>
                            <option value="lainnya" <?= old('jenis_kejahatan', $wilayah->jenis_kejahatan) == 'lainnya' || (strpos($wilayah->jenis_kejahatan, 'lainnya') === false && !in_array($wilayah->jenis_kejahatan, ['curanmor', 'perampokan', 'begal', 'tawuran'])) ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                        <div id="custom_kejahatan_div" class="form-group mt-2" style="display: <?= (old('jenis_kejahatan', $wilayah->jenis_kejahatan) == 'lainnya' || (strpos($wilayah->jenis_kejahatan, 'lainnya') === false && !in_array($wilayah->jenis_kejahatan, ['curanmor', 'perampokan', 'begal', 'tawuran']))) ? 'block' : 'none'; ?>;">
                            <?= form_label('Jenis Kejahatan Lainnya', 'custom_kejahatan'); ?>
                            <input type="text" name="custom_kejahatan" id="custom_kejahatan" class="form-control fw-bold p-2 rounded-3" value="<?= old('custom_kejahatan', (strpos($wilayah->jenis_kejahatan, 'lainnya') === false && !in_array($wilayah->jenis_kejahatan, ['curanmor', 'perampokan', 'begal', 'tawuran'])) ? esc($wilayah->jenis_kejahatan) : ''); ?>" placeholder="Masukkan jenis kejahatan lainnya">
                        </div>
                    </div>

                    <!-- Upload Gambar -->
                    <div class="form-group mb-4">
                        <?= form_label('<i class="fas fa-image me-1"></i> Upload Gambar Wilayah', 'gambar'); ?>
                        <input type="file" class="form-control fw-bold p-2 rounded-3" id="gambar" name="gambar" accept="image/jpeg,image/jpg,image/png">
                        <small class="form-text text-muted">Maksimal 1 MB, format: JPG, JPEG, atau PNG</small>
                        <div class="mt-3">
                            <img src="/img/<?= esc($wilayah->gambar); ?>" width="200" alt="Gambar Sebelumnya" class="img-thumbnail shadow">
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('/wilayah'); ?>" class="btn btn-secondary fw-bold px-4 shadow-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <?= form_submit($submit); ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleCustomInput() {
    const jenisKejahatan = document.getElementById('jenis_kejahatan').value;
    const customDiv = document.getElementById('custom_kejahatan_div');
    const customInput = document.getElementById('custom_kejahatan');
    if (jenisKejahatan === 'lainnya') {
        customDiv.style.display = 'block';
        customInput.required = true;
    } else {
        customDiv.style.display = 'none';
        customInput.required = false;
        customInput.value = ''; // Kosongkan input jika bukan "Lainnya"
    }
}

// Panggil fungsi saat halaman dimuat untuk menyesuaikan tampilan berdasarkan nilai awal
document.addEventListener('DOMContentLoaded', function() {
    toggleCustomInput();
});
</script>