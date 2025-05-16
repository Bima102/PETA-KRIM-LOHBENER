<?php
// Input form fields configuration
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
      <div class="card-header bg-white border-bottom rounded-top py-3 px-4 d-flex align-items-center justify-content-center">
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

        <!-- Validasi Laporan -->
        <hr class="my-5">
        <h5 class="fw-bold mb-3">
          <i class="fas fa-check-circle text-success me-2"></i> Validasi Laporan Masyarakat
        </h5>

        <div class="table-responsive">
          <table class="table table-bordered table-sm text-center align-middle">
            <thead class="bg-warning text-dark">
              <tr>
                <th>Kecamatan</th>
                <th>Kelurahan</th>
                <th>Daerah / Jalan</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Jenis Kejahatan</th>
                <th>Gambar</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pengaduan as $row): ?>
                <tr>
                  <td><?= $row->kecnama ?></td>
                  <td><?= $row->kelnama ?></td>
                  <td class="text-nowrap"><?= $row->nama_daerah ?></td>
                  <td class="text-nowrap">
                    <a href="https://www.google.com/maps?q=<?= $row->latitude ?>,<?= $row->longitude ?>" target="_blank">
                      <?= $row->latitude ?>
                    </a>
                  </td>
                  <td class="text-nowrap">
                    <a href="https://www.google.com/maps?q=<?= $row->latitude ?>,<?= $row->longitude ?>" target="_blank">
                      <?= $row->longitude ?>
                    </a>
                  </td>
                  <td class="text-nowrap"><?= ucfirst($row->jenis_kejahatan) ?></td>
                  <td><img src="/img/<?= $row->gambar ?>" width="60" class="rounded-3"></td>
                  <td>
                    <a href="/wilayah/aduanTerima/<?= $row->id ?>" class="btn btn-success btn-sm">Terima</a>
                    <a href="/wilayah/aduanTolak/<?= $row->id ?>" class="btn btn-danger btn-sm">Tolak</a>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>

        <!-- Tombol Tambah dan Cetak -->
        <div class="d-flex justify-content-center my-4 gap-3">
          <button type="button" class="btn btn-primary fw-bold shadow-sm px-4 py-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fas fa-plus me-1"></i> Tambah Data
          </button>
          <button type="button" class="btn btn-success fw-bold shadow-sm px-4 py-2" onclick="cetakLaporan()">
            <i class="fas fa-print me-1"></i> Cetak
          </button>
        </div>

        <!-- Tabel DATA WILAYAH -->
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

<!-- Skrip untuk cetak laporan -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
function cetakLaporan() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();

  // Header
  doc.setFontSize(14);
  doc.setFont("helvetica", "bold");
  doc.text('LAPORAN KEJAHATAN WILAYAH KEAMANAN POLSEK LOHBENER', 105, 15, { align: 'center' });
  doc.setFontSize(12);
  doc.setFont("helvetica", "normal");

  // Tabel Header
  doc.setFontSize(10);
  doc.setFont("helvetica", "bold");
  doc.setFillColor(255, 204, 0); // Warna kuning untuk header
  doc.rect(20, 54, 170, 8, 'F');
  doc.text('NO', 22, 60);
  doc.text('KELURAHAN', 35, 60);
  doc.text('NAMA DAERAH / JALAN', 75, 60);
  doc.text('JENIS KEJAHATAN', 140, 60);

  // Garis tabel header
  doc.setLineWidth(0.2);
  doc.line(20, 62, 190, 62);

  // Isi tabel
  const data = [
    <?php foreach ($content as $row => $value) : ?>
      {
        no: <?= $row + 1 ?>,
        kelurahan: '<?= $value->kelnama ?>',
        nama_daerah: '<?= $value->nama_daerah ?>',
        jenis_kejahatan: '<?= ucfirst($value->jenis_kejahatan) ?>'
      },
    <?php endforeach; ?>
  ];

  let y = 68;
  doc.setFont("helvetica", "normal");
  data.forEach((item, index) => {
    // Warna abu-abu terang untuk baris genap
    if (index % 2 === 0) {
      doc.setFillColor(240, 240, 240);
      doc.rect(20, y - 6, 170, 8, 'F');
    }
    doc.text(String(item.no), 22, y);
    doc.text(item.kelurahan, 35, y);
    doc.text(item.nama_daerah, 75, y);
    doc.text(item.jenis_kejahatan, 140, y);
    y += 8;
  });

  // Garis tabel
  for (let i = 68; i <= y - 8; i += 8) {
    doc.line(20, i, 190, i);
  }
  doc.line(20, 54, 20, y - 8);   // Kolom NO
  doc.line(30, 54, 30, y - 8);   // Kolom NO
  doc.line(65, 54, 65, y - 8);   // Kolom Kelurahan
  doc.line(130, 54, 130, y - 8); // Kolom Nama Daerah
  doc.line(190, 54, 190, y - 8); // Kolom Jenis Kejahatan

  // Footer
  doc.text('Indramayu, 16 Mei 2025', 150, y + 20);
  doc.text('Kepala Polsek Sektor Lohbener,', 150, y + 30);
  doc.text('NIP. 1234567890', 150, y + 50);

  // Simpan PDF
  doc.save('Laporan_Wilayah_Lohbener.pdf');
}
</script>