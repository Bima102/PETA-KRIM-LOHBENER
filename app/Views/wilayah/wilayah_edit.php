<?php
$submit = [
    'name'  => 'submit',
    'id'    => 'submit',
    'value' => 'Update',
    'class' => 'btn btn-warning px-4 fw-bold shadow-sm',
    'type'  => 'submit'
];

$nama_daerah = [
    'type'        => 'text',
    'name'        => 'nama_daerah',
    'id'          => 'nama_daerah',
    'class'       => 'form-control fw-bold p-2 rounded-3',
    'placeholder' => 'Contoh: Jl. Merdeka / RT 01 RW 02',
    'value'       => old('nama_daerah', esc($wilayah->nama_daerah)),
    'required'    => true
];

$latitude = [
    'type'        => 'text',
    'name'        => 'latitude',
    'id'          => 'latitude',
    'class'       => 'form-control fw-bold p-2 rounded-3',
    'placeholder' => 'Contoh: -7.123456',
    'value'       => old('latitude', esc($wilayah->latitude)),
    'required'    => true
];

$longitude = [
    'type'        => 'text',
    'name'        => 'longitude',
    'id'          => 'longitude',
    'class'       => 'form-control fw-bold p-2 rounded-3',
    'placeholder' => 'Contoh: 109.123456',
    'value'       => old('longitude', esc($wilayah->longitude)),
    'required'    => true
];

$nama_pelapor = [
    'type'        => 'text',
    'name'        => 'nama_pelapor',
    'id'          => 'nama_pelapor',
    'class'       => 'form-control fw-bold p-2 rounded-3',
    'placeholder' => 'Masukkan nama pelapor',
    'value'       => old('nama_pelapor', esc($wilayah->nama_pelapor)),
    'required'    => true
];

$no_hp = [
    'type'        => 'text',
    'name'        => 'no_hp',
    'id'          => 'no_hp',
    'class'       => 'form-control fw-bold p-2 rounded-3',
    'placeholder' => 'Masukkan nomor telepon (contoh: 081234567890)',
    'value'       => old('no_hp', esc($wilayah->no_hp)),
    'required'    => true
];

$deskripsi = [
    'type'        => 'textarea',
    'name'        => 'deskripsi',
    'id'          => 'deskripsi',
    'class'       => 'form-control fw-bold p-2 rounded-3',
    'placeholder' => 'Masukkan kronologi kejadian',
    'value'       => old('deskripsi', esc($wilayah->deskripsi)),
    'required'    => true
];
?>

<div class="row justify-content-center mt-4 mb-5">
    <div class="col-md-10">
        <div class="card shadow-lg border-0 rounded-4" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
            <div class="card-header bg-dark text-warning d-flex align-items-center rounded-top">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-edit me-2"></i> Formulir Edit Data Wilayah
                </h5>
            </div>

            <?php if (session()->getFlashdata('msg')) : ?>
                <div class="alert alert-success m-4 text-dark fw-bold shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2 text-success"></i>
                    <?= esc(session()->getFlashdata('msg')); ?>
                </div>
            <?php endif; ?>

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

                    <div class="form-group mb-3">
                        <?= form_label('<i class="fas fa-road me-1"></i> Detail patokan Tempat/Jalan/Gang Kejadian', 'nama_daerah'); ?>
                        <?= form_input($nama_daerah); ?>
                    </div>

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

                    <div class="form-group mb-3">
                        <?= form_label('<i class="fas fa-info-circle me-1"></i> Jenis Kejahatan', 'jenis_kejahatan'); ?>
                        <select name="jenis_kejahatan" id="jenis_kejahatan" class="form-control fw-bold p-2 rounded-3" required onchange="toggleCustomInput()">
                            <option value="" disabled <?= !old('jenis_kejahatan', $wilayah->jenis_kejahatan) ? 'selected' : '' ?>>-- Pilih Jenis Kejahatan --</option>
                            <option value="curanmor" <?= old('jenis_kejahatan', $wilayah->jenis_kejahatan) == 'curanmor' ? 'selected' : '' ?>>Curanmor</option>
                            <option value="perampokan" <?= old('jenis_kejahatan', $wilayah->jenis_kejahatan) == 'perampokan' ? 'selected' : '' ?>>Perampokan</option>
                            <option value="begal" <?= old('jenis_kejahatan', $wilayah->jenis_kejahatan) == 'begal' ? 'selected' : '' ?>>Begal</option>
                            <option value="tawuran" <?= old('jenis_kejahatan', $wilayah->jenis_kejahatan) == 'tawuran' ? 'selected' : '' ?>>Tawuran</option>
                            <option value="lainnya" <?= old('jenis_kejahatan', $wilayah->jenis_kejahatan) == 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                        <div id="custom_kejahatan_div" class="form-group mt-2" style="display: <?= old('jenis_kejahatan', $wilayah->jenis_kejahatan) == 'lainnya' ? 'block' : 'none' ?>;">
                            <?= form_label('Jenis Kejahatan Lainnya', 'custom_kejahatan'); ?>
                            <input type="text" name="custom_kejahatan" id="custom_kejahatan" class="form-control fw-bold p-2 rounded-3" value="<?= old('custom_kejahatan', ($wilayah->jenis_kejahatan == 'lainnya' && strpos($wilayah->jenis_kejahatan, 'lainnya') === false) ? '' : str_replace('lainnya', '', $wilayah->jenis_kejahatan)) ?>" placeholder="Masukkan jenis kejahatan lainnya">
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <?= form_label('<i class="fas fa-user me-1"></i> Nama Pelapor', 'nama_pelapor'); ?>
                        <?= form_input($nama_pelapor); ?>
                    </div>

                    <div class="form-group mb-3">
                        <?= form_label('<i class="fas fa-phone me-1"></i> Nomor Telepon', 'no_hp'); ?>
                        <?= form_input($no_hp); ?>
                        <small class="form-text text-muted">Masukkan nomor telepon aktif (contoh: 081234567890)</small>
                    </div>

                    <div class="form-group mb-3">
                        <?= form_label('<i class="fas fa-clipboard-list me-1"></i> Kronologi Kejadian', 'deskripsi'); ?>
                        <?= form_textarea($deskripsi); ?>
                    </div>

                    <div class="form-group mb-4">
                        <?= form_label('<i class="fas fa-image me-1"></i> Upload Gambar Wilayah', 'gambar'); ?>
                        <input type="file" class="form-control fw-bold p-2 rounded-3" id="gambar" name="gambar">
                        <small class="form-text text-muted">Opsional. Unggah gambar untuk memperbarui (ukuran maksimal 1MB, format JPG/PNG)</small>
                        <?php if ($wilayah->gambar && file_exists('img/' . $wilayah->gambar)): ?>
                            <div class="mt-2">
                                <img src="/img/<?= esc($wilayah->gambar); ?>" alt="Gambar Saat Ini" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal" onclick="window.location.href='/wilayah'">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </button>
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
            customInput.value = '';
        }
    }

    // Panggil fungsi saat halaman dimuat untuk menangani nilai awal
    document.addEventListener('DOMContentLoaded', function() {
        toggleCustomInput();
    });
</script>