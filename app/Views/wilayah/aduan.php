<?php
// Form input definitions
$nama_daerah = ['name' => 'nama_daerah', 'id' => 'nama_daerah', 'class' => 'form-control fw-bold', 'placeholder' => 'Detail patokan Tempat/Jalan/Gang Kejadian'];
$lat = ['name' => 'latitude', 'id' => 'latitude', 'class' => 'form-control fw-bold', 'placeholder' => 'Contoh: -6.123456'];
$long = ['name' => 'longitude', 'id' => 'longitude', 'class' => 'form-control fw-bold', 'placeholder' => 'Contoh: 108.123456'];
?>

<div class="container mt-5">
  <!-- ====== FORM ADUAN ====== -->
  <div class="card shadow rounded-4 p-4">
    <h4 class="fw-bold mb-4">Form Pengaduan Masyarakat</h4>
    <form action="/wilayah/aduanSave" method="POST" enctype="multipart/form-data">
      <!-- PETA MAPBOX -->
      <div class="form-group mb-3">
        <label class="fw-bold">Pilih Lokasi di Peta</label>
        <div id="map" style="height: 400px; width: 100%;"></div>
      </div>

      <!-- KELURAHAN -->
      <div class="form-group mb-3">
        <label class="fw-bold">Kelurahan</label>
        <select name="kelurahan" id="kelurahan" class="form-control fw-bold" required>
          <option value="" disabled selected>-- Pilih Kelurahan --</option>
          <?php
          $kelurahan_list = ['Bojongslawi', 'Kiajaran Kulon', 'KiajaranWetan', 'Langut', 'Lanjan', 'Larangan', 'Legok', 'Lohbener', 'Pamayahan', 'Rambatan Kulon', 'Sindangkerta', 'Waru'];
          foreach ($kelurahan_list as $kel) {
            echo "<option value='$kel'>$kel</option>";
          }
          ?>
        </select>
      </div>

      <!-- NAMA DAERAH -->
      <div class="form-group mb-3">
        <label class="fw-bold">Detail patokan Tempat/Jalan/Gang Kejadian</label>
        <?= form_input($nama_daerah); ?>
      </div>

      <!-- KOORDINAT -->
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
        <li><strong>Lokasi di Peta:</strong> Klik pada peta untuk memilih lokasi kejadian. Data seperti kelurahan, latitude, dan longitude akan terisi otomatis.</li>
        <li><strong>Detail patokan Tempat/Jalan/Gang Kejadian:</strong> Masukkan Detail patokan Tempat/Jalan/Gang Kejadian secara manual sesuai kejadian.</li>
        <li><strong>Jenis Kejahatan:</strong> Pilih kategori yang sesuai.</li>
        <li><strong>Gambar Wilayah:</strong> Opsional. Jika ada bukti visual, unggah untuk membantu proses verifikasi.</li>
      </ul>
    </div>
  </div>
</div>

<!-- Tambahkan Mapbox GL JS -->
<link href="https://api.mapbox.com/mapbox-gl-js/v3.7.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v3.7.0/mapbox-gl.js"></script>

<script>
  // Inisialisasi Mapbox dengan access token
  mapboxgl.accessToken = 'pk.eyJ1IjoiYWJpbTEyIiwiYSI6ImNtYjZmaTBzYzAwOXQycXB0MGh3YTJzZWUifQ.IG31kSLXsRVUIdPfiF517g';
  let map;
  let marker;

  function initMap() {
    // Inisialisasi peta dengan koordinat default (Lohbener, Indramayu)
    const defaultLocation = [108.270021, -6.402907];
    map = new mapboxgl.Map({
      container: 'map',
      style: 'mapbox://styles/mapbox/streets-v12',
      center: defaultLocation,
      zoom: 13
    });

    // Tambahkan kontrol navigasi (zoom dan rotasi)
    map.addControl(new mapboxgl.NavigationControl());

    // Deteksi lokasi pengguna saat halaman dimuat
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const userLocation = [position.coords.longitude, position.coords.latitude];
          map.setCenter(userLocation);
          placeMarker(userLocation[0], userLocation[1]);
          updateFormFields(userLocation[1], userLocation[0]);
          reverseGeocode(userLocation[1], userLocation[0]);
        },
        (error) => {
          console.error('Error getting user location:', error);
          alert('Gagal mendeteksi lokasi Anda. Menggunakan lokasi default.');
        }
      );
    } else {
      alert('Browser Anda tidak mendukung geolokasi.');
    }

    // Event listener saat peta diklik
    map.on('click', (e) => {
      const lng = e.lngLat.lng;
      const lat = e.lngLat.lat;
      placeMarker(lng, lat);
      updateFormFields(lat, lng);
      reverseGeocode(lat, lng);
    });
  }

  function placeMarker(lng, lat) {
    // Hapus marker sebelumnya jika ada
    if (marker) {
      marker.remove();
    }
    // Tambahkan marker baru
    marker = new mapboxgl.Marker({ draggable: true })
      .setLngLat([lng, lat])
      .addTo(map);

    // Event listener saat marker diseret
    marker.on('dragend', () => {
      const lngLat = marker.getLngLat();
      updateFormFields(lngLat.lat, lngLat.lng);
      reverseGeocode(lngLat.lat, lngLat.lng);
    });
  }

  function updateFormFields(lat, lng) {
    document.getElementById('latitude').value = lat.toFixed(6);
    document.getElementById('longitude').value = lng.toFixed(6);
  }

  function reverseGeocode(lat, lng) {
    const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${mapboxgl.accessToken}&language=id&types=address,poi,place,neighborhood,locality,postcode`;

    fetch(url)
      .then(response => response.json())
      .then(data => {
        if (data.features && data.features.length > 0) {
          // Cari kelurahan dari features (locality atau neighborhood)
          let kelurahanName = '';
          const kelurahanFeature = data.features.find(feature => 
            feature.place_type.includes('locality') || feature.place_type.includes('neighborhood')
          );

          if (kelurahanFeature) {
            kelurahanName = kelurahanFeature.text || '';
          } else {
            // Jika tidak ada locality/neighborhood, ambil elemen pertama dari place_name
            const feature = data.features[0];
            kelurahanName = feature.place_name.split(',')[0].trim();
          }

          // Validasi kelurahan terhadap daftar yang diizinkan
          const validKelurahan = ['Bojongslawi', 'Kiajaran Kulon', 'KiajaranWetan', 'Langut', 'Lanjan', 'Larangan', 'Legok', 'Lohbener', 'Pamayahan', 'Rambatan Kulon', 'Sindangkerta', 'Waru'];
          const kelurahanSelect = document.getElementById('kelurahan');
          let kelurahanFound = false;

          if (kelurahanName) {
            for (let option of kelurahanSelect.options) {
              if (option.text.toLowerCase() === kelurahanName.toLowerCase() && validKelurahan.includes(kelurahanName)) {
                kelurahanSelect.value = option.value;
                kelurahanFound = true;
                break;
              }
            }
          }

          // Jika kelurahan tidak ditemukan atau tidak valid
          if (!kelurahanFound) {
            kelurahanSelect.value = '';
            alert(`Kelurahan "${kelurahanName}" tidak terdaftar. Pilih kelurahan di Wilayah Pengawasan Polsek Lohbener.`);
          }

          // Kosongkan kolom nama_daerah agar diisi manual
          document.getElementById('nama_daerah').value = '';
        } else {
          document.getElementById('kelurahan').value = '';
          alert('Gagal mendapatkan informasi lokasi dari Mapbox.');
        }
      })
      .catch(error => {
        console.error('Error fetching geocode:', error);
        alert('Terjadi kesalahan saat mengambil data lokasi. Pastikan koneksi internet stabil.');
        document.getElementById('kelurahan').value = '';
      });
  }

  // Inisialisasi peta saat halaman dimuat
  window.onload = initMap;
</script>