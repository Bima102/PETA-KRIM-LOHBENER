<?php
// Konfigurasi tombol submit untuk memperbarui data
$submit = [
    'name'  => 'submit',
    'id'    => 'submit',
    'value' => 'Update',
    'class' => 'btn btn-warning px-4 fw-bold shadow-sm',
    'type'  => 'submit'
];

// Konfigurasi input untuk nama daerah agar konsisten
$nama_daerah = [
    'type'        => 'text',
    'name'        => 'nama_daerah',
    'id'          => 'nama_daerah',
    'class'       => 'form-control fw-bold p-2 rounded-3',
    'placeholder' => 'Contoh: Jl. Merdeka / RT 01 RW 02',
    'value'       => old('nama_daerah', esc($wilayah->nama_daerah)), // Menggunakan nilai lama atau data existing
    'required'    => true
];

// Konfigurasi input untuk latitude agar konsisten
$latitude = [
    'type'        => 'text',
    'name'        => 'latitude',
    'id'          => 'latitude',
    'class'       => 'form-control fw-bold p-2 rounded-3',
    'placeholder' => 'Contoh: -7.123456',
    'value'       => old('latitude', esc($wilayah->latitude)), // Menggunakan nilai lama atau data existing
    'required'    => true
];

// Konfigurasi input untuk longitude agar konsisten
$longitude = [
    'type'        => 'text',
    'name'        => 'longitude',
    'id'          => 'longitude',
    'class'       => 'form-control fw-bold p-2 rounded-3',
    'placeholder' => 'Contoh: 109.123456',
    'value'       => old('longitude', esc($wilayah->longitude)), // Menggunakan nilai lama atau data existing
    'required'    => true
];
?>

<!-- Kontainer utama untuk form edit dengan penyelarasan tengah -->
<div class="row justify-content-center mt-4 mb-5">
    <!-- Kolom dengan lebar maksimum 10/12 untuk kartu -->
    <div class="col-md-10">
        <!-- Kartu dengan bayangan, border hilang, dan efek blur -->
        <div class="card shadow-lg border-0 rounded-4" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
            <!-- Header kartu dengan latar gelap dan teks kuning -->
            <div class="card-header bg-dark text-warning d-flex align-items-center rounded-top">
                <!-- Judul form dengan ikon edit -->
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-edit me-2"></i> Formulir Edit Data Wilayah
                </h5>
            </div>

            <!-- Notifikasi sukses jika ada pesan flashdata -->
            <?php if (session()->getFlashdata('msg')) : ?>
                <!-- Alert sukses dengan ikon dan bayangan -->
                <div class="alert alert-success m-4 text-dark fw-bold shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2 text-success"></i>
                    <?= esc(session()->getFlashdata('msg')); ?>
                </div>
            <?php endif; ?>

            <!-- Notifikasi error validasi jika ada kesalahan input -->
            <?php if (isset($validation) && $validation->getErrors()) : ?>
                <!-- Alert error dengan ikon dan daftar pesan kesalahan -->
                <div class="alert alert-danger m-4 text-dark fw-bold shadow-sm" role="alert">
                    <i class="fas fa-exclamation-circle me-2 text-danger"></i>
                    <ul class="mb-0">
                        <?php foreach ($validation->getErrors() as $error) : ?>
                            <!-- Menampilkan setiap pesan error -->
                            <li><?= esc($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Badan kartu dengan padding untuk form -->
            <div class="card-body p-4">
                <!-- Form untuk mengirim data pembaruan -->
                <form action="/wilayah/wilayahUpdate/<?= esc($wilayah->id); ?>" method="POST" enctype="multipart/form-data">
                    <!-- Input tersembunyi untuk menyimpan nama gambar lama -->
                    <input type="hidden" name="gambarLama" value="<?= esc($wilayah->gambar); ?>">

                    <!-- Dropdown untuk memilih kelurahan -->
                    <div class="form-group mb-3">
                        <!-- Label untuk dropdown kelurahan dengan ikon -->
                        <?= form_label('<i class="fas fa-map-pin me-1"></i> Kelurahan', 'kelurahan'); ?>
                        <select id="kelurahan" class="form-control fw-bold p-2 rounded-3" name="kelurahan" required>
                            <option value="" disabled hidden>Pilih Kelurahan</option>
                            <?php foreach ($kelurahan as $kel) : ?>
                                <!-- Opsi kelurahan dengan nilai terpilih berdasarkan data existing -->
                                <option value="<?= esc($kel); ?>" <?= $kel == $wilayah->kelurahan ? 'selected' : ''; ?>>
                                    <?= esc($kel); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Input untuk detail patokan tempat -->
                    <div class="form-group mb-3">
                        <!-- Label untuk input nama daerah dengan ikon -->
                        <?= form_label('<i class="fas fa-road me-1"></i> Detail patokan Tempat/Jalan/Gang Kejadian', 'nama_daerah'); ?>
                        <!-- Input teks untuk nama daerah -->
                        <?= form_input($nama_daerah); ?>
                    </div>

                    <!-- Input untuk koordinat latitude dan longitude -->
                    <div class="row mb-3">
                        <!-- Kolom untuk latitude -->
                        <div class="col">
                            <!-- Label untuk input latitude dengan ikon -->
                            <?= form_label('<i class="fas fa-location-arrow me-1"></i> Latitude', 'latitude'); ?>
                            <!-- Input teks untuk latitude -->
                            <?= form_input($latitude); ?>
                            <!-- Petunjuk format input latitude -->
                            <small class="form-text text-muted">Masukkan dalam format desimal, misalnya: -7.123456</small>
                        </div>
                        <!-- Kolom untuk longitude -->
                        <div class="col">
                            <!-- Label untuk input longitude dengan ikon -->
                            <?= form_label('<i class="fas fa-location-arrow me-1"></i> Longitude', 'longitude'); ?>
                            <!-- Input teks untuk longitude -->
                            <?= form_input($longitude); ?>
                            <!-- Petunjuk format input longitude -->
                            <small class="form-text text-muted">Masukkan dalam format desimal, misalnya: 109.123456</small>
                        </div>
                    </div>

                    <!-- Dropdown untuk memilih jenis kejahatan -->
                    <div class="form-group mb-3">
                        <!-- Label untuk dropdown jenis kejahatan dengan ikon -->
                        <?= form_label('<i class="fas fa-info-circle me-1"></i> Jenis Kejahatan', 'jenis_kejahatan'); ?>
                        <select name="jenis_kejahatan" id="jenis_kejahatan" class="form-control fw-bold p-2 rounded-3" required onchange="toggleCustomInput()">
                            <option value="" disabled hidden>Pilih Jenis Kejahatan</option>
                            <!-- Opsi jenis kejahatan dengan nilai terpilih berdasarkan data existing -->
                            <option value="curanmor" <?= old('jenis_kejahatan', $wilayah->jenis_kejahatan) == 'curanmor' ? 'selected' : ''; ?>>Curanmor</option>
                            <option value="perampokan" <?= old('jenis_kejahatan', $wilayah->jenis_kejahatan) == 'perampokan' ? 'selected' : ''; ?>>Perampokan</option>
                            <option value="begal" <?= old('jenis_kejahatan', $wilayah->jenis_kejahatan) == 'begal' ? 'selected' : ''; ?>>Begal</option>
                            <option value="tawuran" <?= old('jenis_kejahatan', $wilayah->jenis_kejahatan) == 'tawuran' ? 'selected' : ''; ?>>Tawuran</option>
                            <option value="lainnya" <?= old('jenis_kejahatan', $wilayah->jenis_kejahatan) == 'lainnya' || (strpos($wilayah->jenis_kejahatan, 'lainnya') === false && !in_array($wilayah->jenis_kejahatan, ['curanmor', 'perampokan', 'begal', 'tawuran'])) ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                        <!-- Input tambahan untuk jenis kejahatan lainnya -->
                        <div id="custom_kejahatan_div" class="form-group mt-2" style="display: <?= (old('jenis_kejahatan', $wilayah->jenis_kejahatan) == 'lainnya' || (strpos($wilayah->jenis_kejahatan, 'lainnya') === false && !in_array($wilayah->jenis_kejahatan, ['curanmor', 'perampokan', 'begal', 'tawuran']))) ? 'block' : 'none'; ?>;">
                            <!-- Label untuk input jenis kejahatan lainnya -->
                            <?= form_label('Jenis Kejahatan Lainnya', 'custom_kejahatan'); ?>
                            <!-- Input teks untuk jenis kejahatan lainnya -->
                            <input type="text" 
                                   name="custom_kejahatan" 
                                   id="custom_kejahatan" 
                                   class="form-control fw-bold p-2 rounded-3" 
                                   value="<?= old('custom_kejahatan', (strpos($wilayah->jenis_kejahatan, 'lainnya') === false && !in_array($wilayah->jenis_kejahatan, ['curanmor', 'perampokan', 'begal', 'tawuran'])) ? esc($wilayah->jenis_kejahatan) : ''); ?>" 
                                   placeholder="Masukkan jenis kejahatan lainnya">
                        </div>
                    </div>

                    <!-- Input untuk mengunggah gambar -->
                    <div class="form-group mb-4">
                        <!-- Label untuk input gambar dengan ikon -->
                        <?= form_label('<i class="fas fa-image me-1"></i> Upload Gambar Wilayah', 'gambar'); ?>
                        <!-- Input file untuk mengunggah gambar -->
                        <input type="file" 
                               class="form-control fw-bold p-2 rounded-3" 
                               id="gambar" 
                               name="gambar" 
                               accept="image/jpeg,image/jpg,image/png">
                        <!-- Petunjuk ukuran dan format file -->
                        <small class="form-text text-muted">Maksimal 1 MB, format: JPG, JPEG, atau PNG</small>
                        <!-- Pratinjau gambar sebelumnya -->
                        <div class="mt-3">
                            <img src="/img/<?= esc($wilayah->gambar); ?>" 
                                 width="200" 
                                 alt="Gambar Sebelumnya" 
                                 class="img-thumbnail shadow">
                        </div>
                    </div>

                    <!-- Tombol aksi untuk kembali dan submit -->
                    <div class="d-flex justify-content-end gap-2">
                        <!-- Tombol kembali ke halaman daftar wilayah -->
                        <a href="<?= base_url('/wilayah'); ?>" 
                           class="btn btn-secondary fw-bold px-4 shadow-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <!-- Tombol submit untuk memperbarui data -->
                        <?= form_submit($submit); ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk menangani input jenis kejahatan lainnya -->
<script>
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

    // Memanggil fungsi saat halaman dimuat untuk menyesuaikan tampilan
    document.addEventListener('DOMContentLoaded', function() {
        toggleCustomInput();
    });
</script>
