
<!-- Kontainer utama untuk halaman statistik -->
<div class="container my-5">
    <!-- Kartu utama dengan bayangan dan sudut membulat -->
    <div class="card shadow-lg border-0 rounded-4">
        <!-- Badan kartu dengan padding -->
        <div class="card-body p-5">
            <!-- Judul statistik dengan ikon -->
            <div class="text-center mb-4">
                <h2 class="fw-bold">
                    <i class="bi bi-bar-chart-fill text-primary me-2"></i>Data Statistik Tindak Kriminalitas
                </h2>
            </div>

            <!-- Bagian grafik -->
            <div class="chart-container mb-5 mx-auto" style="max-width: 800px;">
                <!-- Elemen canvas untuk grafik Chart.js -->
                <canvas id="kejahatanChart"
                        data-labels='<?= json_encode(array_map(fn($item) => ucfirst($item->jenis_kejahatan), $statistik)); ?>'
                        data-values='<?= json_encode(array_map(fn($item) => (int)$item->total, $statistik)); ?>'>
                </canvas>
            </div>

            <!-- Deskripsi grafik -->
            <div class="text-muted text-center mt-3 mb-4 px-3" style="max-width: 800px; margin-left: auto; margin-right: auto;">
                Grafik di atas menunjukkan jumlah kasus kriminalitas berdasarkan jenis kejahatan yang terjadi di wilayah Lohbener. Setiap batang mewakili total laporan untuk Data ini berguna untuk mengidentifikasi jenis kejahatan yang paling sering terjadi, sehingga dapat membantu dalam pengambilan kebijakan pencegahan dan peningkatan kewaspadaan masyarakat.
            </div>

            <!-- Bagian wilayah rawan -->
            <div class="mb-5">
                <!-- Formulir filter laporan -->
                <div class="mb-4">
                    <!-- Formulir untuk memfilter data dengan tata letak responsif -->
                    <form id="filterForm" method="get" action="<?= base_url('/statistik'); ?>" class="bg-white p-3 rounded-3 shadow-sm d-flex align-items-center flex-wrap gap-2">
                        <!-- Filter tahun -->
                        <div class="d-flex align-items-center gap-2 filter-item">
                            <!-- Label untuk dropdown tahun -->
                            <label for="tahun" class="form-label fw-semibold mb-0">Tahun:</label>
                            <!-- Dropdown untuk memilih tahun -->
                            <select name="tahun" id="tahun" class="form-control fw-bold p-2 rounded-3" onchange="this.form.submit()">
                                <option value="">-- Pilih Tahun --</option>
                                <?php
                                // Mengambil tahun saat ini
                                $currentYear = date('Y');
                                // Loop untuk menampilkan 6 tahun terakhir
                                for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
                                    $selected = ($i == (int)$tahun) ? 'selected' : '';
                                    echo "<option value='$i' $selected>$i</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Filter bulan -->
                        <div class="d-flex align-items-center gap-2 filter-item">
                            <!-- Label untuk dropdown bulan -->
                            <label for="bulan" class="form-label fw-semibold mb-0">Bulan:</label>
                            <!-- Dropdown untuk memilih bulan -->
                            <select name="bulan" id="bulan" class="form-control fw-bold p-2 rounded-3" onchange="this.form.submit()">
                                <option value="">-- Pilih Bulan --</option>
                                <?php
                                // Daftar bulan dalam format kode dan nama
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
                        </div>

                        <!-- Filter jenis kejahatan -->
                        <div class="d-flex align-items-center gap-2 filter-item">
                            <!-- Label untuk dropdown jenis kejahatan -->
                            <label for="jenis_kejahatan" class="form-label fw-semibold mb-0">Jenis Kejahatan:</label>
                            <!-- Dropdown untuk memilih jenis kejahatan -->
                            <select name="jenis_kejahatan" id="jenis_kejahatan" class="form-control fw-bold p-2 rounded-3">
                                <option value="">Semua</option>
                                <?php if (isset($jenisList)): ?>
                                    <?php foreach ($jenisList as $jenis): ?>
                                        <option value="<?= esc($jenis->jenis_kejahatan); ?>"
                                                <?= $jenisDipilih == $jenis->jenis_kejahatan ? 'selected' : ''; ?>>
                                            <?= ucfirst($jenis->jenis_kejahatan); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Tombol untuk menampilkan hasil filter -->
                        <button type="submit" class="btn btn-primary fw-bold filter-item">
                            <i class="bi bi-search me-1"></i>Tampilkan
                        </button>
                        <!-- Tombol untuk mereset filter -->
                        <a href="<?= base_url('/statistik'); ?>" class="btn btn-secondary fw-bold filter-item">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                        </a>
                    </form>
                </div>

                <!-- Tabel responsif untuk data wilayah rawan -->
                <div class="table-responsive">
                    <!-- Tabel dengan garis dan border -->
                    <table class="table table-striped table-bordered">
                        <!-- Kepala tabel -->
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tempat/Jalan/Gang Kejadian</th>
                                <th>Jenis Kejahatan</th>
                                <th>Total Kasus</th>
                            </tr>
                        </thead>
                        <!-- Badan tabel -->
                        <tbody>
                            <?php if (empty($rankingData)): ?>
                                <!-- Baris untuk menampilkan pesan jika data kosong -->
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                                        Belum ada data untuk periode ini.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <!-- Loop untuk menampilkan data wilayah rawan -->
                                <?php foreach ($rankingData as $i => $row): ?>
                                    <tr>
                                        <td><?= $i + 1; ?></td>
                                        <td><?= esc($row->wilayah); ?></td>
                                        <td><?= ucfirst(esc($row->jenis_kejahatan)); ?></td>
                                        <td><?= esc($row->total); ?></td>
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

<!-- CSS untuk responsivitas filter -->
<style>
    /* Mengatur tata letak elemen filter */
    .filter-item {
        min-width: 150px; /* Lebar minimum untuk elemen filter di desktop */
        flex: 0 0 auto; /* Mencegah elemen melebar berlebihan */
    }

    .form-control, .btn {
        font-size: 0.9rem; /* Ukuran font lebih kecil untuk konsistensi */
        padding: 0.5rem; /* Padding lebih kompak */
    }

    .form-label {
        font-size: 0.9rem; /* Ukuran font label lebih kecil */
    }

    /* Media query untuk layar kecil (mobile) */
    @media (max-width: 768px) {
        .filter-item {
            flex: 1 1 100%; /* Elemen filter mengambil lebar penuh di mobile */
            min-width: 0; /* Menghapus lebar minimum untuk fleksibilitas */
        }
        .form-control, .btn {
            width: 100%; /* Input dan tombol penuh lebar di mobile */
            font-size: 0.85rem; /* Ukuran font lebih kecil di mobile */
        }
        .form-label {
            font-size: 0.85rem; /* Ukuran font label lebih kecil di mobile */
        }
        .gap-2 {
            gap: 1rem; /* Jarak antar elemen lebih kecil di mobile */
        }
    }

    /* Media query untuk layar sangat kecil (di bawah 576px) */
    @media (max-width: 576px) {
        .filter-item {
            margin-bottom: 0.5rem; /* Jarak vertikal antar elemen di mobile kecil */
        }
        .form-control, .btn {
            padding: 0.4rem; /* Padding lebih kecil untuk layar sangat kecil */
        }
    }
</style>
