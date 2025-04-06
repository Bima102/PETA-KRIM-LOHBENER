<?php
$nama_daerah = [
  'name' => 'nama_daerah',
  'id'   => 'nama_daerah',
  'class' => 'form-control text-dark fw-bold',
  'value' => null,
  'placeholder' => 'Daerah/Jalan'
];

$lat = [
  'name' => 'latitude',
  'id'   => 'latitude',
  'class' => 'form-control text-dark fw-bold',
  'value' => null,
  'placeholder' => 'Latitude'
];

$long = [
  'name' => 'longitude',
  'id'   => 'longitude',
  'class' => 'form-control text-dark fw-bold',
  'value' => null,
  'placeholder' => 'Longitude'
];

$desk = [
  'name' => 'deskripsi',
  'id'   => 'deskripsi',
  'class' => 'form-control text-dark fw-bold',
  'value' => null,
  'placeholder' => 'Deskripsi'
];

$submit = [
  'name'  => 'submit',
  'id'    => 'submit',
  'value' => 'Submit',
  'class' => 'btn btn-primary',
  'type'  => 'submit'
];
?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title">Menu Data Wilayah</h4>
      </div>
      <div class="card-body">
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
          Tambah Data
        </button>

        <?php if (session()->getFlashdata('msg')) : ?>
          <div class="alert alert-success text-dark" role="alert">
            <?= session()->getFlashdata('msg'); ?>
          </div>
        <?php endif; ?>

        <!-- Modal Tambah Data -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Wilayah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="/wilayah_data_save" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <?= form_label('Kecamatan', 'kecamatan'); ?>
                    <select id="kecamatan" class="form-control text-dark fw-bold p-2 mb-3" name="kecamatan" required>
                      <option value="">-- Pilih Kecamatan --</option>
                      <?php foreach ($kecamatan as $row) : ?>
                        <option value="<?= $row->kecamatan_id; ?>"><?= $row->nama; ?></option>
                      <?php endforeach; ?>
                    </select>

                    <?= form_label('Kelurahan', 'kelurahan'); ?>
                    <select id="kelurahan" class="form-control text-dark fw-bold p-2 mb-3" name="kelurahan" required>
                      <option value="">-- Pilih Kelurahan --</option>
                      <?php foreach ($kelurahan as $row) : ?>
                        <option value="<?= $row->kelurahan_id; ?>"><?= $row->nama; ?></option>
                      <?php endforeach; ?>
                    </select>

                    <?= form_label('Nama Daerah/Jalan', 'nama_daerah'); ?>
                    <?= form_input($nama_daerah); ?><br>

                    <div class="row">
                      <div class="col-md-6">
                        <?= form_label('Latitude', 'latitude'); ?>
                        <?= form_input($lat); ?>
                      </div>
                      <div class="col-md-6">
                        <?= form_label('Longitude', 'longitude'); ?>
                        <?= form_input($long); ?>
                      </div>
                    </div><br>

                    <?= form_label('Deskripsi', 'deskripsi'); ?>
                    <?= form_input($desk); ?><br>

                    <?= form_label('Gambar', 'gambar'); ?>
                    <input type="file" class="form-control text-dark fw-bold p-2 mb-4" id="gambar" name="gambar">
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <?= form_submit($submit); ?>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Tabel Data -->
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark text-center">
              <tr>
                <th>No</th>
                <th>Kecamatan</th>
                <th>Kelurahan</th>
                <th>Daerah/Jalan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($content as $row => $value) : ?>
                <tr>
                  <td class="text-center"><?= $row + 1; ?></td>
                  <td><?= $value->kecnama; ?></td>
                  <td><?= $value->kelnama; ?></td>
                  <td><?= $value->nama_daerah; ?></td>
                  <td class="text-center">
                    <a href="/detailWilayah/<?= $value->id; ?>" class="btn btn-primary btn-sm">
                      <i class="fas fa-info-circle"></i> Detail
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>
