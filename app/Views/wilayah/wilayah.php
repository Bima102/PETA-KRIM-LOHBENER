<?php
$nama_daerah = [
  'name'        => 'nama_daerah',
  'id'          => 'nama_daerah',
  'class'       => 'form-control text-dark fw-bold',
  'value'       => old('nama_daerah'),
  'placeholder' => 'Nama Daerah / Jalan'
];

$lat = [
  'name'        => 'latitude',
  'id'          => 'latitude',
  'class'       => 'form-control text-dark fw-bold',
  'value'       => old('latitude'),
  'placeholder' => 'Contoh: -6.123456'
];

$long = [
  'name'        => 'longitude',
  'id'          => 'longitude',
  'class'       => 'form-control text-dark fw-bold',
  'value'       => old('longitude'),
  'placeholder' => 'Contoh: 108.123456'
];

$submit = [
  'name'  => 'submit',
  'id'    => 'submit',
  'value' => 'Simpan Data',
  'class' => 'btn btn-warning fw-bold px-4',
  'type'  => 'submit'
];
?>

<!-- Section Tabel & Modal -->
<div class="row mt-4">
  <div class="col-md-12">
    <div class="card shadow-sm border-0 rounded-4 px-3">
      <div class="card-header bg-white border-bottom rounded-top py-3 px-4 d-flex align-items-center">
        <h5 class="mb-0 fw-bold text-dark">
          <i class="fas fa-map-marked-alt me-2 text-primary"></i> Data Wilayah
        </h5>
      </div>

      <div class="card-body p-4">
        <?php if (session()->getFlashdata('msg')) : ?>
          <div class="alert alert-success shadow-sm fw-bold" role="alert">
            <i class="fas fa-check-circle me-2 text-success"></i>
            <?= session()->getFlashdata('msg'); ?>
          </div>
        <?php endif; ?>

        <!-- Tombol Tambah -->
        <div class="d-flex justify-content-center mb-4">
          <button type="button" class="btn btn-primary fw-bold shadow-sm px-4 py-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fas fa-plus me-1"></i> Tambah Data
          </button>
        </div>

        <!-- Tabel -->
        <div class="table-responsive px-2">
          <table class="table table-hover align-middle text-nowrap table-borderless shadow-sm rounded-4 overflow-hidden">
            <thead class="bg-dark text-white text-center">
              <tr class="fw-bold">
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Kecamatan</th>
                <th style="width: 25%;">Kelurahan</th>
                <th>Nama Daerah / Jalan</th>
                <th style="width: 15%;">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white text-center">
              <?php if (empty($content)) : ?>
                <tr>
                  <td colspan="5" class="text-center text-muted py-4">
                    <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                    Belum ada data wilayah.
                  </td>
                </tr>
              <?php else : ?>
                <?php foreach ($content as $row => $value) : ?>
                  <tr class="border-bottom border-light">
                    <td class="fw-semibold"><?= $row + 1; ?></td>
                    <td><?= $value->kecnama; ?></td>
                    <td><?= $value->kelnama; ?></td>
                    <td><?= $value->nama_daerah; ?></td>
                    <td>
                      <a href="/detailWilayah/<?= $value->id; ?>" class="btn btn-sm btn-primary fw-bold px-3">
                        <i class="fas fa-info-circle me-1"></i> Detail
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header bg-dark text-white rounded-top">
        <h5 class="modal-title fw-bold">
          <i class="fas fa-plus-circle me-2"></i> Tambah Data Wilayah
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4">
        <form action="/wilayah_data_save" method="POST" enctype="multipart/form-data">

          <!-- Kecamatan -->
          <div class="form-group mb-3">
            <?= form_label('Kecamatan', 'kecamatan'); ?>
            <input type="text" class="form-control fw-bold p-2 rounded-3" name="kecamatan_display" value="Lohbener" readonly>
            <input type="hidden" name="kecamatan" value="101">
          </div>

          <!-- Kelurahan -->
          <div class="form-group mb-3">
            <?= form_label('Kelurahan', 'kelurahan'); ?>
            <select name="kelurahan" id="kelurahan" class="form-control fw-bold p-2 rounded-3" required>
              <option value="" disabled selected>-- Pilih Kelurahan --</option>
              <?php foreach ($kelurahan as $row) : ?>
                <option value="<?= $row->kelurahan_id; ?>"><?= $row->nama; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Nama Daerah -->
          <div class="form-group mb-3">
            <?= form_label('Nama Daerah / Jalan', 'nama_daerah'); ?>
            <?= form_input($nama_daerah); ?>
          </div>

          <!-- Koordinat -->
          <div class="row mb-3">
            <div class="col-md-6">
              <?= form_label('Latitude', 'latitude'); ?>
              <?= form_input($lat); ?>
            </div>
            <div class="col-md-6">
              <?= form_label('Longitude', 'longitude'); ?>
              <?= form_input($long); ?>
            </div>
          </div>

          <!-- Jenis Kejahatan -->
          <div class="form-group mb-3">
            <?= form_label('Jenis Kejahatan', 'jenis_kejahatan'); ?>
            <select name="jenis_kejahatan" id="jenis_kejahatan" class="form-control fw-bold p-2 rounded-3" required>
              <option value="" disabled selected>-- Pilih Jenis Kejahatan --</option>
              <option value="curanmor" <?= old('jenis_kejahatan') == 'curanmor' ? 'selected' : '' ?>>Curanmor</option>
              <option value="perampokan" <?= old('jenis_kejahatan') == 'perampokan' ? 'selected' : '' ?>>Perampokan</option>
              <option value="begal" <?= old('jenis_kejahatan') == 'begal' ? 'selected' : '' ?>>Begal</option>
              <option value="tawuran" <?= old('jenis_kejahatan') == 'tawuran' ? 'selected' : '' ?>>Tawuran</option>
            </select>
          </div>

          <!-- Upload Gambar -->
          <div class="form-group mb-4">
            <?= form_label('Upload Gambar Wilayah', 'gambar'); ?>
            <input type="file" class="form-control text-dark fw-bold p-2" id="gambar" name="gambar">
          </div>

          <!-- Tombol -->
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              <i class="fas fa-times-circle me-1"></i> Tutup
            </button>
            <?= form_submit($submit); ?>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
