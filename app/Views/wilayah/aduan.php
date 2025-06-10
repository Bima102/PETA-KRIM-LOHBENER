<?php
// Definisi input form untuk nama daerah
$nama_daerah = [
    'name' => 'nama_daerah',
    'id' => 'nama_daerah',
    'class' => 'form-control fw-bold',
    'placeholder' => 'Detail patokan Tempat/Jalan/Gang Kejadian'
];

// Definisi input form untuk latitude
$lat = [
    'name' => 'latitude',
    'id' => 'latitude',
    'class' => 'form-control fw-bold',
    'placeholder' => 'Contoh: -6.123456'
];

// Definisi input form untuk longitude
$long = [
    'name' => 'longitude',
    'id' => 'longitude',
    'class' => 'form-control fw-bold',
    'placeholder' => 'Contoh: 108.123456'
];
?>

<!-- Kontainer utama untuk form pengaduan dengan margin atas -->
<div class="container mt-5">
    <!-- Bagian Form Pengaduan Masyarakat -->
    <div class="card shadow rounded-4 p-4">
        <!-- Judul form pengaduan -->
        <h4 class="fw-bold mb-4">Form Pengaduan Masyarakat</h4>
        
        <!-- Form untuk mengirim data pengaduan -->
        <form action="/wilayah/aduanSave" method="POST" enctype="multipart/form-data">
            <!-- Bagian peta Mapbox untuk memilih lokasi -->
            <div class="form-group mb-3">
                <label class="fw-bold">Pilih Lokasi di Peta</label>
                <!-- Div untuk menampilkan peta dengan tinggi 400px -->
                <div id="map" style="height: 400px; width: 100%;"></div>
            </div>

            <!-- Dropdown untuk memilih kelurahan -->
            <div class="form-group mb-3">
                <label class="fw-bold">Kelurahan</label>
                <select name="kelurahan" id="kelurahan" class="form-control fw-bold" required>
                    <option value="" disabled selected>-- Pilih Kelurahan --</option>
                    <?php
                    // Daftar kelurahan yang tersedia
                    $kelurahan_list = [
                        'Bojongslawi', 'Kiajaran Kulon', 'KiajaranWetan', 'Langut',
                        'Lanjan', 'Larangan', 'Legok', 'Lohbener', 'Pamayahan',
                        'Rambatan Kulon', 'Sindangkerta', 'Waru'
                    ];
                    // Loop untuk menampilkan setiap kelurahan sebagai opsi
                    foreach ($kelurahan_list as $kel) {
                        echo "<option value='$kel'>$kel</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Input untuk detail patokan tempat kejadian -->
            <div class="form-group mb-3">
                <label class="fw-bold">Detail patokan Tempat/Jalan/Gang Kejadian</label>
                <!-- Fungsi form_input untuk membuat input teks -->
                <?= form_input($nama_daerah); ?>
            </div>

            <!-- Input untuk koordinat latitude dan longitude -->
            <div class="row mb-3">
                <!-- Kolom untuk latitude -->
                <div class="col-md-6">
                    <label class="fw-bold">Latitude</label>
                    <?= form_input($lat); ?>
                </div>
                <!-- Kolom untuk longitude -->
                <div class="col-md-6">
                    <label class="fw-bold">Longitude</label>
                    <?= form_input($long); ?>
                </div>
            </div>

            <!-- Dropdown untuk memilih jenis kejahatan -->
            <div class="form-group mb-3">
                <label class="fw-bold">Jenis Kejahatan</label>
                <select name="jenis_kejahatan" id="jenis_kejahatan" class="form-control fw-bold" required onchange="toggleCustomInput()">
                    <option value="" disabled selected>-- Pilih Jenis Kejahatan --</option>
                    <option value="curanmor">Curanmor</option>
                    <option value="perampokan">Perampokan</option>
                    <option value="begal">Begal</option>
                    <option value="tawuran">Tawuran</option>
                    <option value="lainnya">Lainnya</option>
                </select>
                <!-- Input tambahan untuk jenis kejahatan lainnya, disembunyikan secara default -->
                <div id="custom_kejahatan_div" class="form-group mt-2" style="display: none;">
                    <label class="fw-bold">Jenis Kejahatan Lainnya</label>
                    <input type="text" name="custom_kejahatan" id="custom_kejahatan" class="form-control fw-bold" placeholder="Masukkan jenis kejahatan lainnya">
                </div>
            </div>

            <!-- Input untuk mengunggah gambar -->
            <div class="form-group mb-3">
                <label class="fw-bold">Gambar</label>
                <input type="file" class="form-control" name="gambar">
            </div>

            <!-- Tombol untuk mengirim form -->
            <button type="submit" class="btn btn-primary fw-bold">Kirim Pengaduan</button>
        </form>
    </div>

    <!-- Bagian Panduan Pengisian Form -->
    <div class="mt-5">
        <!-- Judul panduan dengan ikon -->
        <h5><i class="bi bi-info-circle-fill text-primary"></i> Panduan Mengisi Form & Mengambil Titik Lokasi</h5>
        <!-- Informasi panduan dalam alert -->
        <div class="alert alert-info">
            <p><strong>Pastikan Anda mengisi data dengan benar agar laporan cepat diproses.</strong></p>
            <ul>
                <li><strong>Lokasi di Peta:</strong> Klik pada peta untuk memilih lokasi kejadian. Data seperti kelurahan, latitude, dan longitude akan terisi otomatis.</li>
                <li><strong>Detail patokan Tempat/Jalan/Gang Kejadian:</strong> Masukkan Detail patokan Tempat/Jalan/Gang Kejadian secara manual sesuai kejadian.</li>
                <li><strong>Jenis Kejahatan:</strong> Pilih kategori yang sesuai. Jika tidak ada kategori yang sesuai, pilih 'Lainnya' dan isi manual.</li>
                <li><strong>Gambar Wilayah:</strong> Opsional. Jika ada bukti visual, unggah untuk membantu proses verifikasi.</li>
            </ul>
        </div>
    </div>
</div>

<!-- Memuat CSS Mapbox GL JS -->
<link href="https://api.mapbox.com/mapbox-gl-js/v3.7.0/mapbox-gl.css" rel="stylesheet">
<!-- Memuat JavaScript Mapbox GL JS -->
<script src="https://api.mapbox.com/mapbox-gl-js/v3.7.0/mapbox-gl.js"></script>

<script>
    // Inisialisasi token Mapbox dari variabel lingkungan PHP
    mapboxgl.accessToken = '<?php echo env('MAPBOX_TOKEN'); ?>';
    let map; // Variabel untuk menyimpan objek peta
    let marker; // Variabel untuk menyimpan objek marker

    // Fungsi untuk menginisialisasi peta
    function initMap() {
        // Koordinat default (Lohbener, Indramayu)
        const defaultLocation = [108.270021, -6.402907];
        // Membuat peta dengan Mapbox
        map = new mapboxgl.Map({
            container: 'map', // ID elemen untuk menampilkan peta
            style: 'mapbox://styles/mapbox/streets-v12', // Gaya peta
            center: defaultLocation, // Koordinat pusat peta
            zoom: 13 // Tingkat zoom awal
        });

        // Menambahkan kontrol navigasi (zoom dan rotasi)
        map.addControl(new mapboxgl.NavigationControl());

        // Mendeteksi lokasi pengguna saat halaman dimuat
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    // Mendapatkan koordinat pengguna
                    const userLocation = [position.coords.longitude, position.coords.latitude];
                    // Mengatur pusat peta ke lokasi pengguna
                    map.setCenter(userLocation);
                    // Menempatkan marker di lokasi pengguna
                    placeMarker(userLocation[0], userLocation[1]);
                    // Memperbarui kolom form dengan koordinat
                    updateFormFields(userLocation[1], userLocation[0]);
                    // Mengambil informasi kelurahan dari koordinat
                    reverseGeocode(userLocation[1], userLocation[0]);
                },
                (error) => {
                    // Menangani kesalahan deteksi lokasi
                    console.error('Error getting user location:', error);
                    alert('Gagal mendeteksi lokasi Anda. Menggunakan lokasi default.');
                }
            );
        } else {
            // Menangani browser yang tidak mendukung geolokasi
            alert('Browser Anda tidak mendukung geolokasi.');
        }

        // Menangani klik pada peta untuk menempatkan marker
        map.on('click', (e) => {
            const lng = e.lngLat.lng;
            const lat = e.lngLat.lat;
            // Menempatkan marker di lokasi yang diklik
            placeMarker(lng, lat);
            // Memperbarui kolom form dengan koordinat
            updateFormFields(lat, lng);
            // Mengambil informasi kelurahan dari koordinat
            reverseGeocode(lat, lng);
        });
    }

    // Fungsi untuk menempatkan marker pada peta
    function placeMarker(lng, lat) {
        // Menghapus marker sebelumnya jika ada
        if (marker) {
            marker.remove();
        }
        // Membuat marker baru yang dapat diseret
        marker = new mapboxgl.Marker({ draggable: true })
            .setLngLat([lng, lat])
            .addTo(map);

        // Menangani event saat marker diseret
        marker.on('dragend', () => {
            const lngLat = marker.getLngLat();
            // Memperbarui kolom form dengan koordinat baru
            updateFormFields(lngLat.lat, lngLat.lng);
            // Mengambil informasi kelurahan dari koordinat baru
            reverseGeocode(lngLat.lat, lngLat.lng);
        });
    }

    // Fungsi untuk memperbarui kolom latitude dan longitude pada form
    function updateFormFields(lat, lng) {
        document.getElementById('latitude').value = lat.toFixed(6);
        document.getElementById('longitude').value = lng.toFixed(6);
    }

    // Fungsi untuk mendapatkan informasi kelurahan dari koordinat (reverse geocoding)
    function reverseGeocode(lat, lng) {
        // URL untuk mengambil data dari API Mapbox
        const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=<?php echo env('MAPBOX_TOKEN'); ?>&language=id&types=address,poi,place,neighborhood,locality,postcode`;

        // Mengambil data dari API
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.features && data.features.length > 0) {
                    // Mencari nama kelurahan dari data
                    let kelurahanName = '';
                    const kelurahanFeature = data.features.find(feature => 
                        feature.place_type.includes('locality') || feature.place_type.includes('neighborhood')
                    );

                    if (kelurahanFeature) {
                        kelurahanName = kelurahanFeature.text || '';
                    } else {
                        // Mengambil nama tempat dari fitur pertama jika tidak ada locality/neighborhood
                        const feature = data.features[0];
                        kelurahanName = feature.place_name.split(',')[0].trim();
                    }

                    // Daftar kelurahan yang valid
                    const validKelurahan = [
                        'Bojongslawi', 'Kiajaran Kulon', 'KiajaranWetan', 'Langut',
                        'Lanjan', 'Larangan', 'Legok', 'Lohbener', 'Pamayahan',
                        'Rambatan Kulon', 'Sindangkerta', 'Waru'
                    ];
                    const kelurahanSelect = document.getElementById('kelurahan');
                    let kelurahanFound = false;

                    // Memeriksa apakah kelurahan valid
                    if (kelurahanName) {
                        for (let option of kelurahanSelect.options) {
                            if (option.text.toLowerCase() === kelurahanName.toLowerCase() && validKelurahan.includes(kelurahanName)) {
                                kelurahanSelect.value = option.value;
                                kelurahanFound = true;
                                break;
                            }
                        }
                    }

                    // Menampilkan peringatan jika kelurahan tidak valid
                    if (!kelurahanFound) {
                        kelurahanSelect.value = '';
                        alert(`Kelurahan "${kelurahanName}" tidak terdaftar. Pilih kelurahan di Wilayah Pengawasan Polsek Lohbener.`);
                    }

                    // Mengosongkan kolom nama_daerah untuk diisi manual
                    document.getElementById('nama_daerah').value = '';
                } else {
                    // Menampilkan peringatan jika data lokasi tidak ditemukan
                    document.getElementById('kelurahan').value = '';
                    alert('Gagal mendapatkan informasi lokasi dari Mapbox.');
                }
            })
            .catch(error => {
                // Menangani kesalahan saat mengambil data
                console.error('Error fetching geocode:', error);
                alert('Terjadi kesalahan saat mengambil data lokasi. Pastikan koneksi internet stabil.');
                document.getElementById('kelurahan').value = '';
            });
    }

    // Fungsi untuk menampilkan/menyembunyikan input jenis kejahatan lainnya
    function toggleCustomInput() {
        const jenisKejahatan = document.getElementById('jenis_kejahatan').value;
        const customDiv = document.getElementById('custom_kejahatan_div');
        const customInput = document.getElementById('custom_kejahatan');
        if (jenisKejahatan === 'lainnya') {
            // Menampilkan input tambahan jika memilih 'Lainnya'
            customDiv.style.display = 'block';
            customInput.required = true;
        } else {
            // Menyembunyikan input tambahan untuk opsi lain
            customDiv.style.display = 'none';
            customInput.required = false;
            customInput.value = ''; // Mengosongkan input
        }
    }

    // Memanggil fungsi inisialisasi peta saat halaman dimuat
    window.onload = initMap;
</script>