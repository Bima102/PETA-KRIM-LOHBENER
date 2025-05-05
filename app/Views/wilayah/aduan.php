<?php
$nama_daerah = ['name' => 'nama_daerah', 'class' => 'form-control fw-bold', 'placeholder' => 'Nama Daerah / Jalan'];
$lat = ['name' => 'latitude', 'class' => 'form-control fw-bold', 'placeholder' => 'Contoh: -6.123456'];
$long = ['name' => 'longitude', 'class' => 'form-control fw-bold', 'placeholder' => 'Contoh: 108.123456'];
?>

<div class="container mt-5">

  <!-- ====== FORM ADUAN ====== -->
  <div class="card shadow rounded-4 p-4">
    <h4 class="fw-bold mb-4">Form Pengaduan Masyarakat</h4>
    <form action="/wilayah/aduanSave" method="POST" enctype="multipart/form-data">

      <!-- KECAMATAN (Auto) -->
      <div class="form-group mb-3">
        <label class="fw-bold">Kecamatan</label>
        <input type="text" class="form-control fw-bold" name="kecamatan_display" value="Lohbener" readonly>
        <input type="hidden" name="kecamatan" value="101">
      </div>

      <!-- KELURAHAN -->
      <div class="form-group mb-3">
        <label class="fw-bold">Kelurahan</label>
        <select name="kelurahan" class="form-control fw-bold" required>
          <option disabled selected>-- Pilih Kelurahan --</option>
          <?php foreach ($kelurahan as $row): ?>
            <option value="<?= $row->kelurahan_id ?>"><?= $row->nama ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- NAMA DAERAH -->
      <div class="form-group mb-3">
        <label class="fw-bold">Nama Daerah / Jalan</label>
        <?= form_input($nama_daerah); ?>
      </div>

      <!-- KOORDINAT -->
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="fw-bold">Latitude</label>
          <?= form_input(array_merge($lat, ['required' => 'required'])); ?>
        </div>
        <div class="col-md-6">
          <label class="fw-bold">Longitude</label>
          <?= form_input(array_merge($long, ['required' => 'required'])); ?>
        </div>
      </div>


      <!-- JENIS KEJAHATAN -->
      <div class="form-group mb-3">
        <label class="fw-bold">Jenis Kejahatan</label>
        <select name="jenis_kejahatan" class="form-control fw-bold" required>
          <option disabled selected>-- Pilih Jenis Kejahatan --</option>
          <option value="curanmor">Curanmor</option>
          <option value="perampokan">Perampokan</option>
          <option value="begal">Begal</option>
          <option value="tawuran">Tawuran</option>
        </select>
      </div>

      <!-- GAMBAR -->
      <div class="form-group mb-3">
        <label class="fw-bold">Gambar</label>
        <input type="file" class="form-control" name="gambar">
      </div>

      <!-- SUBMIT -->
      <button type="submit" class="btn btn-primary fw-bold">Kirim Pengaduan</button>
    </form>
  </div>

  <!-- ====== PANDUAN PENGISIAN ====== -->
  <div class="mt-5">
    <h5><i class="bi bi-info-circle-fill text-primary"></i> Panduan Mengisi Form & Mengambil Titik Lokasi</h5>
    <div class="alert alert-info">

      <p><strong>Pastikan Anda mengisi data dengan benar agar laporan cepat diproses.</strong></p>
      <ul>
        <li><strong>Kelurahan:</strong> Pilih kelurahan tempat kejadian perkara.</li>
        <li><strong>Nama Daerah / Jalan:</strong> Masukkan nama jalan atau daerah kejadian.</li>
        <li><strong>Koordinat:</strong> Wajib diisi berdasarkan titik lokasi dari Google Maps.</li>
        <li><strong>Jenis Kejahatan:</strong> Pilih kategori yang sesuai.</li>
        <li><strong>Gambar Wilayah:</strong> Opsional. Jika ada bukti visual, unggah untuk membantu proses verifikasi.</li>
      </ul>

      <hr>

      <strong>Cara Mengambil Titik Lokasi dari Google Maps (via HP):</strong>
      <ol class="mt-2">
        <li>Buka aplikasi <strong>Google Maps</strong>.</li>
        <li>Arahkan ke lokasi kejadian atau geser peta ke titik kejadian.</li>
        <li>Tekan dan tahan titik tersebut hingga muncul <strong>pin merah</strong>.</li>
        <li>Ketuk informasi di bagian bawah layar.</li>
        <li>Catat angka koordinat seperti <code>-7.123456, 110.123456</code>.</li>
        <li>Masukkan:
          <ul>
            <li><strong>Latitude:</strong> -7.123456</li>
            <li><strong>Longitude:</strong> 110.123456</li>
          </ul>
        </li>
      </ol>

      <div class="alert alert-warning mt-3">
        ⚠️ <strong>Pastikan koordinat lokasi benar</strong> untuk mempercepat penanganan oleh petugas.
      </div>
    </div>
  </div>
</div>
