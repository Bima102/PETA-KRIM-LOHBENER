<?php
$submit = [
    'name'  => 'submit',
    'id'    => 'submit',
    'value' => 'Update',
    'class' => 'btn btn-warning px-4 fw-bold shadow-sm',
    'type'  => 'submit'
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

            <?php if (session()->getFlashdata('msg')) : ?>
                <div class="alert alert-success m-4 text-dark fw-bold shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2 text-success"></i><?= session()->getFlashdata('msg'); ?>
                </div>
            <?php endif; ?>

            <div class="card-body p-4">
                <form action="/wilayah/wilayahUpdate/<?= $wilayah->id; ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="gambarLama" value="<?= $wilayah->gambar; ?>">

                    <!-- Kecamatan -->
                    <div class="form-group mb-3">
                        <?= form_label('<i class="fas fa-map-marker-alt me-1"></i> Kecamatan', 'kecamatan'); ?>
                        <select id="kecamatan" class="form-control fw-bold p-2 rounded-3" name="kecamatan" required>
                            <option value="" disabled hidden>Pilih Kecamatan</option>
                            <?php foreach ($kecamatan as $row) : ?>
                                <option value="<?= $row->kecamatan_id; ?>" <?= $row->kecamatan_id == $wilayah->kecamatan_id ? 'selected' : '' ?>>
                                    <?= $row->nama; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Kelurahan -->
                    <div class="form-group mb-3">
                        <?= form_label('<i class="fas fa-map-pin me-1"></i> Kelurahan', 'kelurahan'); ?>
                        <select id="kelurahan" class="form-control fw-bold p-2 rounded-3" name="kelurahan" required>
                            <option value="" disabled hidden>Pilih Kelurahan</option>
                            <?php foreach ($kelurahan as $row) : ?>
                                <option value="<?= $row->kelurahan_id; ?>" <?= $row->kelurahan_id == $wilayah->kelurahan_id ? 'selected' : '' ?>>
                                    <?= $row->nama; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Nama Jalan -->
                    <div class="form-group mb-3">
                        <?= form_label('<i class="fas fa-road me-1"></i> Nama Jalan/Daerah', 'nama_daerah'); ?>
                        <input type="text" class="form-control fw-bold p-2 rounded-3" name="nama_daerah" id="nama_daerah"
                               placeholder="Contoh: Jl. Merdeka / RT 01 RW 02"
                               value="<?= old('nama_daerah', $wilayah->nama_daerah); ?>" required>
                    </div>

                    <!-- Koordinat -->
                    <div class="row mb-3">
                        <div class="col">
                            <?= form_label('<i class="fas fa-location-arrow me-1"></i> Latitude', 'latitude'); ?>
                            <input type="text" class="form-control fw-bold p-2 rounded-3" name="latitude" id="latitude"
                                   placeholder="Contoh: -7.123456"
                                   value="<?= old('latitude', $wilayah->latitude); ?>" required>
                        </div>
                        <div class="col">
                            <?= form_label('<i class="fas fa-location-arrow me-1"></i> Longitude', 'longitude'); ?>
                            <input type="text" class="form-control fw-bold p-2 rounded-3" name="longitude" id="longitude"
                                   placeholder="Contoh: 109.123456"
                                   value="<?= old('longitude', $wilayah->longitude); ?>" required>
                        </div>
                    </div>

                    <!-- Jenis Kejahatan -->
                    <div class="form-group mb-3">
                        <?= form_label('<i class="fas fa-info-circle me-1"></i> Jenis Kejahatan', 'jenis_kejahatan'); ?>
                        <select name="jenis_kejahatan" id="jenis_kejahatan" class="form-control fw-bold p-2 rounded-3" required>
                            <option value="" disabled hidden>Pilih Jenis Kejahatan</option>
                            <option value="curanmor" <?= old('jenis_kejahatan') == 'curanmor' ? 'selected' : '' ?>>Curanmor</option>
                            <option value="perampokan" <?= old('jenis_kejahatan') == 'perampokan' ? 'selected' : '' ?>>Perampokan</option>
                            <option value="begal" <?= old('jenis_kejahatan') == 'begal' ? 'selected' : '' ?>>Begal</option>
                            <option value="tawuran" <?= old('jenis_kejahatan') == 'tawuran' ? 'selected' : '' ?>>Tawuran</option>
                        </select>
                    </div>

                    <!-- Upload Gambar -->
                    <div class="form-group mb-4">
                        <?= form_label('<i class="fas fa-image me-1"></i> Upload Gambar Wilayah', 'gambar'); ?>
                        <input type="file" class="form-control fw-bold p-2 rounded-3" id="gambar" name="gambar">
                        <div class="mt-3">
                            <img src="/img/<?= $wilayah->gambar; ?>" width="200" alt="Gambar Sebelumnya" class="img-thumbnail shadow">
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
