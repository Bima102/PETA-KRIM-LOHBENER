<?php
// Definisi input form untuk nama daerah
$nama_daerah = [
    'name' => 'nama_daerah',
    'id' => 'nama_daerah',
    'class' => 'form-control fw-bold',
    'placeholder' => 'Detail patokan Tempat/Jalan/Gang Kejadian',
    'required' => true // Tambahkan required untuk validasi sisi klien
];

// Definisi input form untuk latitude
$lat = [
    'name' => 'latitude',
    'id' => 'latitude',
    'class' => 'form-control fw-bold',
    'placeholder' => 'Contoh: -6.123456',
    'required' => true
];

// Definisi input form untuk longitude
$long = [
    'name' => 'longitude',
    'id' => 'longitude',
    'class' => 'form-control fw-bold',
    'placeholder' => 'Contoh: 108.123456',
    'required' => true
];
?>

<!-- Kontainer utama untuk form pengaduan dengan margin atas -->
<div class="container mt-5">
    <!-- Bagian Form Pengaduan Masyarakat -->
    <div class="card shadow rounded-4 p-4">
        <!-- Judul form pengaduan -->
        <h4 class="fw-bold mb-4">Form Pengaduan Masyarakat</h4>
        
        <!-- Menampilkan pesan error atau sukses jika ada -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('msg')): ?>
            <div class="alert alert-success">
                <?= esc(session()->getFlashdata('msg')); ?>
            </div>
        <?php endif; ?>

        <!-- Form untuk mengirim data pengaduan -->
        <form action="/wilayah/aduanSave" method="POST" enctype="multipart/form-data">
            <!-- Bagian peta Mapbox untuk memilih lokasi -->
            <div class="form-group mb-3">
                <label class="fw-bold">Pilih Lokasi di Peta</label>
                <div id="map" style="height: 400px; width: 100%;"></div>
            </div>

            <!-- Dropdown untuk memilih kelurahan -->
            <div class="form-group mb-3">
                <label class="fw-bold">Kelurahan</label>
                <select name="kelurahan" id="kelurahan" class="form-control fw-bold" required>
                    <option value="" disabled selected>-- Pilih Kelurahan --</option>
                    <?php
                    $kelurahan_list = [
                        'Bojongslawi', 'Kiajaran Kulon', 'KiajaranWetan', 'Langut',
                        'Lanjan', 'Larangan', 'Legok', 'Lohbener', 'Pamayahan',
                        'Rambatan Kulon', 'Sindangkerta', 'Waru'
                    ];
                    foreach ($kelurahan_list as $kel) {
                        echo "<option value='$kel'>$kel</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Input untuk detail patokan tempat kejadian -->
            <div class="form-group mb-3">
                <label class="fw-bold">Detail patokan Tempat/Jalan/Gang Kejadian</label>
                <?= form_input($nama_daerah); ?>
            </div>

            <!-- Input untuk koordinat latitude dan longitude -->
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
        <h5><i class="bi bi-info-circle-fill text-primary"></i> Panduan Mengisi Form & Mengambil Titik Lokasi</h5>
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
<!-- Memuat SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<!-- Memuat JavaScript Mapbox GL JS -->
<script src="https://api.mapbox.com/mapbox-gl-js/v3.7.0/mapbox-gl.js"></script>
<!-- Memuat SweetAlert2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Inisialisasi token Mapbox dari variabel lingkungan PHP
    mapboxgl.accessToken = '<?php echo env('MAPBOX_TOKEN'); ?>';
    let map; // Variabel untuk menyimpan objek peta
    let marker; // Variabel untuk menyimpan objek marker

    // Fungsi untuk menginisialisasi peta
    function initMap() {
        const defaultLocation = [108.270021, -6.402907];
        map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v12',
            center: defaultLocation,
            zoom: 13
        });

        map.addControl(new mapboxgl.NavigationControl());

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

        map.on('click', (e) => {
            const lng = e.lngLat.lng;
            const lat = e.lngLat.lat;
            placeMarker(lng, lat);
            updateFormFields(lat, lng);
            reverseGeocode(lat, lng);
        });
    }

    // Fungsi untuk menempatkan marker pada peta
    function placeMarker(lng, lat) {
        if (marker) {
            marker.remove();
        }
        marker = new mapboxgl.Marker({ draggable: true })
            .setLngLat([lng, lat])
            .addTo(map);

        marker.on('dragend', () => {
            const lngLat = marker.getLngLat();
            updateFormFields(lngLat.lat, lngLat.lng);
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
        const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=<?php echo env('MAPBOX_TOKEN'); ?>&language=id&types=address,poi,place,neighborhood,locality,postcode`;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.features && data.features.length > 0) {
                    let kelurahanName = '';
                    const kelurahanFeature = data.features.find(feature => 
                        feature.place_type.includes('locality') || feature.place_type.includes('neighborhood')
                    );

                    if (kelurahanFeature) {
                        kelurahanName = kelurahanFeature.text || '';
                    } else {
                        const feature = data.features[0];
                        kelurahanName = feature.place_name.split(',')[0].trim();
                    }

                    const validKelurahan = [
                        'Bojongslawi', 'Kiajaran Kulon', 'KiajaranWetan', 'Langut',
                        'Lanjan', 'Larangan', 'Legok', 'Lohbener', 'Pamayahan',
                        'Rambatan Kulon', 'Sindangkerta', 'Waru'
                    ];
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

                    if (!kelurahanFound) {
                        kelurahanSelect.value = '';
                        Swal.fire({
                            icon: 'warning',
                            title: 'Kelurahan Tidak Valid',
                            text: `Kelurahan "${kelurahanName}" tidak terdaftar. Pilih kelurahan di Wilayah Pengawasan Polsek Lohbener.`,
                        });
                    }
                } else {
                    document.getElementById('kelurahan').value = '';
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Mendapatkan Lokasi',
                        text: 'Gagal mendapatkan informasi lokasi dari Mapbox.',
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching geocode:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Koneksi',
                    text: 'Terjadi kesalahan saat mengambil data lokasi. Pastikan koneksi internet stabil.',
                });
                document.getElementById('kelurahan').value = '';
            });
    }

    // Fungsi untuk menampilkan/menyembunyikan input jenis kejahatan lainnya
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

    // Validasi sisi klien saat form dikirim
    document.querySelector('form').addEventListener('submit', function(e) {
        const namaDaerah = document.getElementById('nama_daerah').value.trim();
        const latitude = document.getElementById('latitude').value.trim();
        const longitude = document.getElementById('longitude').value.trim();
        const jenisKejahatan = document.getElementById('jenis_kejahatan').value;
        const customKejahatan = document.getElementById('custom_kejahatan').value.trim();

        if (!namaDaerah) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Lengkap',
                text: 'Detail patokan tempat wajib diisi.',
            });
            document.getElementById('nama_daerah').focus();
            return false;
        }

        if (!latitude || isNaN(parseFloat(latitude))) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Valid',
                text: 'Latitude wajib diisi dengan angka desimal.',
            });
            document.getElementById('latitude').focus();
            return false;
        }

        if (!longitude || isNaN(parseFloat(longitude))) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Valid',
                text: 'Longitude wajib diisi dengan angka desimal.',
            });
            document.getElementById('longitude').focus();
            return false;
        }

        if (jenisKejahatan === 'lainnya' && !customKejahatan) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Lengkap',
                text: 'Jenis kejahatan lainnya wajib diisi.',
            });
            document.getElementById('custom_kejahatan').focus();
            return false;
        }
    });

    // Memanggil fungsi inisialisasi peta saat halaman dimuat
    window.onload = initMap;
</script>