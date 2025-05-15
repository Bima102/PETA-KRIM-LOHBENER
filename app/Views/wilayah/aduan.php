<?php
// Hapus atribut 'readonly' dari kolom nama_daerah
$nama_daerah = ['name' => 'nama_daerah', 'id' => 'nama_daerah', 'class' => 'form-control fw-bold', 'placeholder' => 'Nama Daerah / Jalan'];
$lat = ['name' => 'latitude', 'id' => 'latitude', 'class' => 'form-control fw-bold', 'placeholder' => 'Contoh: -6.123456', 'readonly' => true];
$long = ['name' => 'longitude', 'id' => 'longitude', 'class' => 'form-control fw-bold', 'placeholder' => 'Contoh: 108.123456', 'readonly' => true];
?>

<div class="container mt-5">
  <!-- ====== FORM ADUAN ====== -->
  <div class="card shadow rounded-4 p-4">
    <h4 class="fw-bold mb-4">Form Pengaduan Masyarakat</h4>
    <form action="/wilayah/aduanSave" method="POST" enctype="multipart/form-data">
      <!-- PETA OPENSTREETMAP -->
      <div class="form-group mb-3">
        <label class="fw-bold">Pilih Lokasi di Peta</label>
        <div id="map" style="height: 400px; width: 100%;"></div>
      </div>

      <!-- KECAMATAN (Auto) -->
      <div class="form-group mb-3">
        <label class="fw-bold">Kecamatan</label>
        <input type="text" class="form-control fw-bold" name="kecamatan_display" id="kecamatan_display" value="Lohbener" readonly>
        <input type="hidden" name="kecamatan" id="kecamatan" value="101">
      </div>

      <!-- KELURAHAN (Auto) -->
      <div class="form-group mb-3">
        <label class="fw-bold">Kelurahan</label>
        <select name="kelurahan" id="kelurahan" class="form-control fw-bold" required>
          <option value="" disabled selected>-- Pilih Kelurahan --</option>
          <?php foreach ($kelurahan as $row): ?>
            <option value="<?= $row->kelurahan_id ?>"><?= $row->nama ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- NAMA DAERAH (Auto, tetapi bisa diedit manual) -->
      <div class="form-group mb-3">
        <label class="fw-bold">Nama Daerah / Jalan</label>
        <?= form_input($nama_daerah); ?>
      </div>

      <!-- KOORDINAT (Auto) -->
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="fw-bold">Latitude</label>
          <?= form_input($lat); ?>
        </div>
        <div class="col-md-6">
          <label class="fw-bold">Longitude</label>
          <?= form_input($long); ?>
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
        <li><strong>Lokasi di Peta:</strong> Klik pada peta untuk memilih lokasi kejadian. Data seperti kecamatan, kelurahan, nama daerah/jalan, latitude, dan longitude akan terisi otomatis.</li>
        <li><strong>Nama Daerah / Jalan:</strong> Jika data otomatis tidak sesuai, Anda dapat mengeditnya secara manual.</li>
        <li><strong>Jenis Kejahatan:</strong> Pilih kategori yang sesuai.</li>
        <li><strong>Gambar Wilayah:</strong> Opsional. Jika ada bukti visual, unggah untuk membantu proses verifikasi.</li>
      </ul>
    </div>
  </div>
</div>

<!-- Tambahkan Leaflet dan Nominatim -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  let map;
  let marker;

  function initMap() {
    // Inisialisasi peta dengan koordinat default (Lohbener, Indramayu)
    const defaultLocation = [-6.402907, 108.270021];
    map = L.map('map').setView(defaultLocation, 13);

    // Tambahkan tile layer dari OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Tambahkan marker default
    marker = L.marker(defaultLocation, { draggable: true }).addTo(map);
    marker.on('dragend', onMarkerDragEnd);

    // Event listener ketika peta diklik
    map.on('click', onMapClick);

    // Isi data awal
    onMapClick({ latlng: L.latLng(defaultLocation) });
  }

  function onMapClick(e) {
    marker.setLatLng(e.latlng);
    updateFormFields(e.latlng.lat, e.latlng.lng);
    reverseGeocode(e.latlng.lat, e.latlng.lng);
  }

  function onMarkerDragEnd(e) {
    const latlng = marker.getLatLng();
    updateFormFields(latlng.lat, latlng.lng);
    reverseGeocode(latlng.lat, latlng.lng);
  }

  function updateFormFields(lat, lng) {
    document.getElementById('latitude').value = lat.toFixed(6);
    document.getElementById('longitude').value = lng.toFixed(6);
  }

  function reverseGeocode(lat, lng) {
    const url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`;

    fetch(url)
      .then(response => response.json())
      .then(data => {
        if (data && data.address) {
          let streetName = data.address.road || data.address.pedestrian || '';
          let village = data.address.suburb || data.address.village || data.address.suburb || '';
          let streetNumber = data.address.house_number || '';

          // Tentukan nama daerah/jalan
          if (streetNumber && streetName) {
            document.getElementById('nama_daerah').value = `${streetName} No.${streetNumber}`;
          } else if (streetName) {
            document.getElementById('nama_daerah').value = streetName;
          } else {
            document.getElementById('nama_daerah').value = 'Tidak diketahui';
          }

          // Isi field kecamatan (tetap Lohbener)
          document.getElementById('kecamatan_display').value = 'Lohbener';

          // Tentukan kelurahan
          const kelurahanSelect = document.getElementById('kelurahan');
          let kelurahanFound = false;
          village = village || data.address.city || data.address.town || '';
          if (village) {
            for (let option of kelurahanSelect.options) {
              if (option.text.toLowerCase().includes(village.toLowerCase())) {
                kelurahanSelect.value = option.value;
                kelurahanFound = true;
                break;
              }
            }
            if (!kelurahanFound) {
              kelurahanSelect.value = '';
              alert(`Kelurahan "${village}" tidak ditemukan dalam daftar. Silakan pilih secara manual.`);
            }
          } else {
            kelurahanSelect.value = '';
            alert('Kelurahan tidak terdeteksi. Silakan pilih secara manual.');
          }
        } else {
          alert('Gagal mendapatkan informasi lokasi dari Nominatim.');
          document.getElementById('nama_daerah').value = '';
          document.getElementById('kelurahan').value = '';
        }
      })
      .catch(error => {
        console.error('Error fetching geocode:', error);
        alert('Terjadi kesalahan saat mengambil data lokasi. Pastikan koneksi internet stabil.');
        document.getElementById('nama_daerah').value = '';
        document.getElementById('kelurahan').value = '';
      });
  }

  // Inisialisasi peta saat halaman dimuat
  window.onload = initMap;
</script>