<?php
$submit = [
    'name'  => 'submit',
    'id'    => 'submit',
    'value' => 'Update',
    'class' => 'btn btn-primary',
    'type'  => 'submit'
];
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <a href="<?= base_url('/wilayah'); ?>" class="btn btn-primary mb-3 mt-3">Kembali</a>
                <h4 class="card-title">Edit Data Wilayah</h4>
                <p class="card-category">Formulir Edit Data Wilayah</p>
            </div>

            <?php if (session()->getFlashdata('msg')) : ?>
                <div class="alert alert-success text-dark" role="alert">
                    <?= session()->getFlashdata('msg'); ?>
                </div>
            <?php endif; ?>

            <div class="card-body">
                <form action="/wilayah/wilayahUpdate/<?= $wilayah->id; ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="gambarLama" value="<?= $wilayah->gambar; ?>">

                    <div class="form-group">
                        <?= form_label('Kecamatan', 'kecamatan'); ?>
                        <select id="kecamatan" class="form-control fw-bold p-2" name="kecamatan" required>
                            <option value="" disabled hidden>Pilih Kecamatan</option>
                            <?php foreach ($kecamatan as $row) : ?>
                                <option value="<?= $row->kecamatan_id; ?>" <?= $row->kecamatan_id == $wilayah->kecamatan_id ? 'selected' : '' ?>>
                                    <?= $row->nama; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <?= form_label('Kelurahan', 'kelurahan'); ?>
                        <select id="kelurahan" class="form-control fw-bold p-2" name="kelurahan" required>
                            <option value="" disabled hidden>Pilih Kelurahan</option>
                            <?php foreach ($kelurahan as $row) : ?>
                                <option value="<?= $row->kelurahan_id; ?>" <?= $row->kelurahan_id == $wilayah->kelurahan_id ? 'selected' : '' ?>>
                                    <?= $row->nama; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <?= form_label('Nama Jalan/Daerah', 'nama_daerah'); ?>
                        <input type="text" class="form-control fw-bold p-2" name="nama_daerah" id="nama_daerah"
                               placeholder="Contoh: Jl. Merdeka / RT 01 RW 02"
                               value="<?= old('nama_daerah', $wilayah->nama_daerah); ?>" required>

                        <div class="row">
                            <div class="col">
                                <?= form_label('Latitude', 'latitude'); ?>
                                <input type="text" class="form-control fw-bold p-2" name="latitude" id="latitude"
                                       placeholder="Contoh: -7.123456"
                                       value="<?= old('latitude', $wilayah->latitude); ?>" required>
                            </div>
                            <div class="col">
                                <?= form_label('Longitude', 'longitude'); ?>
                                <input type="text" class="form-control fw-bold p-2" name="longitude" id="longitude"
                                       placeholder="Contoh: 109.123456"
                                       value="<?= old('longitude', $wilayah->longitude); ?>" required>
                            </div>
                        </div>

                        <?= form_label('Deskripsi', 'deskripsi'); ?>
                        <input type="text" class="form-control fw-bold p-2" name="deskripsi" id="deskripsi"
                               placeholder="Contoh: Pembunuhan / Begal / Pencurian"
                               value="<?= old('deskripsi', $wilayah->deskripsi); ?>" required>

                        <?= form_label('Gambar', 'gambar'); ?>
                        <input type="file" class="form-control fw-bold p-2" id="gambar" name="gambar">
                        <div class="mt-3">
                            <img src="/img/<?= $wilayah->gambar; ?>" width="200" alt="Gambar Sebelumnya" class="img-thumbnail">
                        </div>
                    </div>

                    <div class="mt-4">
                        <?= form_submit($submit); ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
