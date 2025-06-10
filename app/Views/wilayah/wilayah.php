<?php
// Konfigurasi input untuk nama daerah
$nama_daerah = [
    'name'        => 'nama_daerah',
    'id'          => 'nama_daerah',
    'class'       => 'form-control text-dark fw-bold',
    'value'       => old('nama_daerah'), // Menggunakan nilai lama jika ada
    'placeholder' => 'Detail patokan Tempat/Jalan/Gang Kejadian'
];

// Konfigurasi input untuk latitude
$lat = [
    'name'        => 'latitude',
    'id'          => 'latitude',
    'class'       => 'form-control text-dark fw-bold',
    'value'       => old('latitude'), // Menggunakan nilai lama jika ada
    'placeholder' => 'Contoh: -6.123456'
];

// Konfigurasi input untuk longitude
$long = [
    'name'        => 'longitude',
    'id'          => 'longitude',
    'class'       => 'form-control text-dark fw-bold',
    'value'       => old('longitude'), // Menggunakan nilai lama jika ada
    'placeholder' => 'Contoh: 108.123456'
];

// Konfigurasi tombol submit
$submit = [
    'name'  => 'submit',
    'id'    => 'submit',
    'value' => 'Simpan Data',
    'class' => 'btn btn-warning fw-bold px-4',
    'type'  => 'submit'
];
?>

<!-- Bagian tabel dan modal untuk data wilayah -->
<div class="row mt-4">
    <!-- Kolom penuh untuk kartu -->
    <div class="col-md-12">
        <!-- Kartu dengan bayangan dan sudut membulat -->
        <div class="card shadow-sm border-0 rounded-4 px-3">
            <!-- Header kartu dengan latar putih -->
            <div class="card-header bg-white border-bottom rounded-top py-3 px-4 d-flex align-items-center justify-content-center">
                <!-- Judul header dengan ikon -->
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-map-marked-alt me-2 text-primary"></i> Data Wilayah
                </h5>
            </div>

            <!-- Badan kartu dengan padding -->
            <div class="card-body p-4">
                <!-- Notifikasi sukses jika ada pesan flashdata -->
                <?php if (session()->getFlashdata('msg')) : ?>
                    <!-- Alert sukses dengan ikon -->
                    <div class="alert alert-success shadow-sm fw-bold mt-3" role="alert">
                        <i class="fas fa-check-circle me-2 text-success"></i>
                        <?= session()->getFlashdata('msg'); ?>
                    </div>
                <?php endif; ?>

                <!-- Bagian validasi laporan masyarakat -->
                <hr class="my-5">
                <!-- Judul validasi laporan dengan ikon -->
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-check-circle text-success me-2"></i> Validasi Laporan Masyarakat
                </h5>

                <!-- Tabel responsif untuk menampilkan laporan -->
                <div class="table-responsive">
                    <!-- Tabel dengan border dan teks rata tengah -->
                    <table class="table table-bordered table-sm text-center align-middle">
                        <!-- Kepala tabel dengan latar kuning -->
                        <thead class="bg-warning text-dark">
                            <tr>
                                <th>Kelurahan</th>
                                <th>Detail patokan Tempat/Jalan/Gang Kejadian</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Jenis Kejahatan</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <!-- Badan tabel untuk menampilkan data laporan -->
                        <tbody>
                            <?php foreach ($pengaduan as $row): ?>
                                <tr>
                                    <!-- Kolom kelurahan -->
                                    <td><?= $row->kelurahan ?></td>
                                    <!-- Kolom detail patokan tempat -->
                                    <td class="text-nowrap"><?= $row->nama_daerah ?></td>
                                    <!-- Kolom latitude dengan tautan ke Google Maps -->
                                    <td class="text-nowrap">
                                        <a href="https://www.google.com/maps?q=<?= $row->latitude ?>,<?= $row->longitude ?>" target="_blank">
                                            <?= $row->latitude ?>
                                        </a>
                                    </td>
                                    <!-- Kolom longitude dengan tautan ke Google Maps -->
                                    <td class="text-nowrap">
                                        <a href="https://www.google.com/maps?q=<?= $row->latitude ?>,<?= $row->longitude ?>" target="_blank">
                                            <?= $row->longitude ?>
                                        </a>
                                    </td>
                                    <!-- Kolom jenis kejahatan dengan huruf kapital awal -->
                                    <td class="text-nowrap"><?= ucfirst($row->jenis_kejahatan) ?></td>
                                    <!-- Kolom gambar dengan pratinjau -->
                                    <td><img src="/img/<?= $row->gambar ?>" width="60" class="rounded-3"></td>
                                    <!-- Kolom aksi untuk terima atau tolak laporan -->
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="/wilayah/aduanTerima/<?= $row->id ?>" class="btn btn-success btn-sm">Terima</a>
                                            <a href="/wilayah/aduanTolak/<?= $row->id ?>" class="btn btn-danger btn-sm">Tolak</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

                <!-- Bagian filter, cetak, dan tambah data -->
                <div class="d-flex justify-content-start align-items-center my-4">
                    <!-- Form untuk filter berdasarkan tahun dan bulan -->
                    <form id="filterForm" method="get" action="" class="d-flex gap-2 me-3">
                        <!-- Dropdown untuk memilih tahun -->
                        <select name="tahun" id="tahun" class="form-control custom-select-sm fw-bold rounded-3" onchange="this.form.submit()">
                            <option value="">-- Pilih Tahun --</option>
                            <?php
                            $currentYear = date('Y');
                            for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
                                $selected = ($i == (int)$tahun) ? 'selected' : '';
                                echo "<option value='$i' $selected>$i</option>";
                            }
                            ?>
                        </select>
                        <!-- Dropdown untuk memilih bulan -->
                        <select name="bulan" id="bulan" class="form-control custom-select-sm fw-bold rounded-3" onchange="this.form.submit()">
                            <option value="">-- Pilih Bulan --</option>
                            <?php
                            $bulanList = [
                                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                                '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                                '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                            ];
                            foreach ($bulanList as $key => $value) {
                                $selected = ($key == $bulan) ? 'selected' : '';
                                echo "<option value='$key' $selected>$value</option>";
                            }
                            ?>
                        </select>
                    </form>
                    <!-- Tombol untuk mereset filter -->
                    <button type="button" class="btn btn-secondary btn-sm-custom fw-bold shadow-sm me-3" onclick="resetFilter()">
                        <i class="fas fa-sync-alt me-1"></i> Reset
                    </button>
                    <!-- Tombol untuk mencetak laporan -->
                    <button type="button" class="btn btn-success btn-sm-custom fw-bold shadow-sm me-3" onclick="cetakLaporan()">
                        <i class="fas fa-print me-1"></i> Cetak
                    </button>
                    <!-- Tombol untuk membuka modal tambah data -->
                    <button type="button" class="btn btn-primary btn-sm-custom fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="fas fa-plus me-1"></i> Tambah Data
                    </button>
                </div>

                <!-- Tabel untuk menampilkan data wilayah -->
                <div class="table-responsive px-2">
                    <!-- Tabel dengan efek hover dan sudut membulat -->
                    <table class="table table-hover align-middle text-nowrap table-borderless shadow-sm rounded-4 overflow-hidden">
                        <!-- Kepala tabel dengan latar gelap -->
                        <thead class="bg-dark text-white text-center">
                            <tr class="fw-bold">
                                <th style="width: 5%;">No</th>
                                <th style="width: 25%;">Kelurahan</th>
                                <th>Detail patokan Tempat/Jalan/Gang Kejadian</th>
                                <th style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <!-- Badan tabel untuk menampilkan data -->
                        <tbody class="bg-white text-center">
                            <?php if (empty($content)) : ?>
                                <!-- Pesan jika tidak ada data -->
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                                        Belum ada data wilayah.
                                    </td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($content as $row => $value) : ?>
                                    <!-- Baris data wilayah -->
                                    <tr class="border-bottom border-light">
                                        <td class="fw-semibold"><?= $row + 1; ?></td>
                                        <td><?= $value->kelurahan; ?></td>
                                        <td><?= $value->nama_daerah; ?></td>
                                        <!-- Kolom aksi untuk melihat detail -->
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

<!-- Modal untuk menambah data wilayah -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!-- Dialog modal dengan lebar besar dan posisi tengah -->
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <!-- Konten modal dengan bayangan -->
        <div class="modal-content rounded-4 shadow">
            <!-- Header modal dengan latar gelap -->
            <div class="modal-header bg-dark text-white rounded-top">
                <!-- Judul modal dengan ikon -->
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Data Wilayah
                </h5>
                <!-- Tombol tutup modal -->
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Badan modal dengan form -->
            <div class="modal-body p-4">
                <!-- Form untuk menyimpan data baru -->
                <form action="/wilayah_data_save" method="POST" enctype="multipart/form-data">
                    <!-- Dropdown untuk memilih kelurahan -->
                    <div class="form-group mb-3">
                        <!-- Label untuk dropdown kelurahan -->
                        <?= form_label('Kelurahan', 'kelurahan'); ?>
                        <select name="kelurahan" id="kelurahan" class="form-control fw-bold p-2 rounded-3" required>
                            <option value="" disabled selected>-- Pilih Kelurahan --</option>
                            <?php foreach ($kelurahan as $kel): ?>
                                <!-- Opsi kelurahan -->
                                <option value="<?= $kel; ?>"><?= $kel; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Input untuk detail patokan tempat -->
                    <div class="form-group mb-3">
                        <!-- Label untuk input nama daerah -->
                        <?= form_label('Detail patokan Tempat/Jalan/Gang Kejadian', 'nama_daerah'); ?>
                        <!-- Input teks untuk nama daerah -->
                        <?= form_input($nama_daerah); ?>
                    </div>

                    <!-- Input untuk koordinat latitude dan longitude -->
                    <div class="row mb-3">
                        <!-- Kolom untuk latitude -->
                        <div class="col-md-6">
                            <!-- Label untuk input latitude -->
                            <?= form_label('Latitude', 'latitude'); ?>
                            <!-- Input teks untuk latitude -->
                            <?= form_input($lat); ?>
                        </div>
                        <!-- Kolom untuk longitude -->
                        <div class="col-md-6">
                            <!-- Label untuk input longitude -->
                            <?= form_label('Longitude', 'longitude'); ?>
                            <!-- Input teks untuk longitude -->
                            <?= form_input($long); ?>
                        </div>
                    </div>

                    <!-- Dropdown untuk memilih jenis kejahatan -->
                    <div class="form-group mb-3">
                        <!-- Label untuk dropdown jenis kejahatan -->
                        <?= form_label('Jenis Kejahatan', 'jenis_kejahatan'); ?>
                        <select name="jenis_kejahatan" id="jenis_kejahatan" class="form-control fw-bold p-2 rounded-3" required onchange="toggleCustomInput()">
                            <option value="" disabled <?= !old('jenis_kejahatan') ? 'selected' : '' ?>>-- Pilih Jenis Kejahatan --</option>
                            <option value="curanmor" <?= old('jenis_kejahatan') == 'curanmor' ? 'selected' : '' ?>>Curanmor</option>
                            <option value="perampokan" <?= old('jenis_kejahatan') == 'perampokan' ? 'selected' : '' ?>>Perampokan</option>
                            <option value="begal" <?= old('jenis_kejahatan') == 'begal' ? 'selected' : '' ?>>Begal</option>
                            <option value="tawuran" <?= old('jenis_kejahatan') == 'tawuran' ? 'selected' : '' ?>>Tawuran</option>
                            <option value="lainnya" <?= old('jenis_kejahatan') == 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                        <!-- Input tambahan untuk jenis kejahatan lainnya -->
                        <div id="custom_kejahatan_div" class="form-group mt-2" style="display: none;">
                            <!-- Label untuk input jenis kejahatan lainnya -->
                            <?= form_label('Jenis Kejahatan Lainnya', 'custom_kejahatan'); ?>
                            <!-- Input teks untuk jenis kejahatan lainnya -->
                            <input type="text" 
                                   name="custom_kejahatan" 
                                   id="custom_kejahatan" 
                                   class="form-control fw-bold p-2 rounded-3" 
                                   value="<?= old('custom_kejahatan') ?>" 
                                   placeholder="Masukkan jenis kejahatan lainnya">
                        </div>
                    </div>

                    <!-- Input untuk mengunggah gambar -->
                    <div class="form-group mb-4">
                        <!-- Label untuk input gambar -->
                        <?= form_label('Upload Gambar Wilayah', 'gambar'); ?>
                        <!-- Input file untuk mengunggah gambar -->
                        <input type="file" 
                               class="form-control text-dark fw-bold p-2" 
                               id="gambar" 
                               name="gambar">
                    </div>

                    <!-- Tombol aksi untuk tutup dan simpan -->
                    <div class="modal-footer justify-content-between">
                        <!-- Tombol untuk menutup modal -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times-circle me-1"></i> Tutup
                        </button>
                        <!-- Tombol submit untuk menyimpan data -->
                        <?= form_submit($submit); ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Memuat pustaka jsPDF untuk mencetak laporan -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    // Fungsi untuk mencetak laporan dalam format PDF
    function cetakLaporan() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Log untuk debugging
        console.log("Fungsi cetakLaporan dipanggil");

        // Header laporan
        doc.setFontSize(14);
        doc.setFont("helvetica", "bold");
        doc.text('LAPORAN KRIMINALITAS POLSEK LOHBENER', 105, 15, { align: 'center' });
        doc.setFontSize(10);
        doc.setFont("helvetica", "normal");

        // Menentukan periode laporan
        <?php
        $periode = '';
        if ($tahun && !$bulan) {
            $periode = "TAHUN $tahun";
        } elseif ($bulan && $tahun) {
            $bulanList = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
            $periode = $bulanList[$bulan] . " $tahun";
        } else {
            $periode = "TAHUN " . date('Y');
        }
        ?>
        doc.text('<?= $periode ?>', 105, 25, { align: 'center' });

        // Header tabel laporan
        doc.setFontSize(10);
        doc.setFont("helvetica", "bold");
        doc.setFillColor(255, 204, 0);
        doc.rect(10, 35, 190, 10, 'F');
        doc.text('No', 15, 42);
        doc.text('Kelurahan', 30, 42);
        doc.text('Curanmor', 70, 42);
        doc.text('Perampokan', 95, 42);
        doc.text('Begal', 125, 42);
        doc.text('Tawuran', 150, 42);
        doc.text('Total Kejahatan', 175, 42);

        // Garis pembatas header tabel
        doc.setLineWidth(0.2);
        doc.line(10, 45, 200, 45);

        // Data laporan dari controller
        const data = [
            <?php
            if (!empty($laporanData)) {
                $no = 1;
                foreach ($laporanData as $row) {
                    echo "{ no: $no, kelurahan: '" . addslashes($row->kelurahan) . "', curanmor: {$row->curanmor}, perampokan: {$row->perampokan}, begal: {$row->begal}, tawuran: {$row->tawuran}, total_kejahatan: {$row->total_kejahatan} },\n";
                    $no++;
                }
            }
            ?>
        ];

        // Log data untuk debugging
        console.log("Data untuk laporan:", data);

        // Menghitung total kejahatan
        let totalCuranmor = 0;
        let totalPerampokan = 0;
        let totalBegal = 0;
        let totalTawuran = 0;
        let totalKejahatan = 0;

        data.forEach(item => {
            totalCuranmor += item.curanmor;
            totalPerampokan += item.perampokan;
            totalBegal += item.begal;
            totalTawuran += item.tawuran;
            totalKejahatan += item.total_kejahatan;
        });

        // Menampilkan data atau pesan jika tidak ada data
        if (data.length === 0) {
            doc.text('Tidak ada data untuk periode ini.', 105, 55, { align: 'center' });
        } else {
            let y = 55;
            const rowHeight = 10; // Tinggi baris tabel
            doc.setFont("helvetica", "normal");
            data.forEach((item, index) => {
                // Baris data
                doc.setFillColor(255, 255, 255);
                doc.rect(10, y - rowHeight, 190, rowHeight, 'F');
                doc.text(String(item.no), 15, y - 2);
                doc.text(item.kelurahan, 30, y - 2);
                doc.text(String(item.curanmor), 70, y - 2);
                doc.text(String(item.perampokan), 95, y - 2);
                doc.text(String(item.begal), 125, y - 2);
                doc.text(String(item.tawuran), 150, y - 2);
                doc.text(String(item.total_kejahatan), 175, y - 2);
                y += rowHeight;
            });

            // Baris total
            doc.setFillColor(200, 200, 200);
            doc.rect(10, y - rowHeight, 190, rowHeight, 'F');
            doc.setFont("helvetica", "bold");
            doc.text('TOTAL KEJAHATAN', 30, y - 2);
            doc.text(String(totalCuranmor), 70, y - 2);
            doc.text(String(totalPerampokan), 95, y - 2);
            doc.text(String(totalBegal), 125, y - 2);
            doc.text(String(totalTawuran), 150, y - 2);
            doc.text(String(totalKejahatan), 175, y - 2);
            y += rowHeight;

            // Garis pembatas tabel
            for (let i = 55; i <= y - rowHeight; i += rowHeight) {
                doc.line(10, i, 200, i);
            }
            doc.line(10, 35, 10, y - rowHeight);
            doc.line(25, 35, 25, y - rowHeight);
            doc.line(65, 35, 65, y - rowHeight);
            doc.line(90, 35, 90, y - rowHeight);
            doc.line(120, 35, 120, y - rowHeight);
            doc.line(145, 35, 145, y - rowHeight);
            doc.line(170, 35, 170, y - rowHeight);
            doc.line(200, 35, 200, y - rowHeight);

            // Footer laporan
            doc.setFont("helvetica", "normal");
            doc.text('Indramayu, <?= date('d M Y') ?>', 150, y + 20);
            doc.text('Kepala Polisi Sektor Lohbener,', 150, y + 45);
            doc.text('NIP. 1234567890', 150, y + 50);
        }

        // Menyimpan file PDF
        doc.save('Laporan_Kriminalitas_Lohbener.pdf');
    }

    // Fungsi untuk mereset filter
    function resetFilter() {
        console.log("Fungsi resetFilter dipanggil"); // Log untuk debugging
        window.location.href = '/wilayah'; // Mengarahkan ke rute tanpa filter
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
</script>
