<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <h2 class="fw-bold">
                    <i class="bi bi-bar-chart-fill text-primary me-2"></i> Data Statistik Tindak Kriminalitas 
                </h2>
            </div>

            <!-- Grafik -->
            <div class="chart-container mb-5 mx-auto" style="max-width: 800px;">
                <canvas id="kejahatanChart"
                        data-labels='<?= json_encode(array_map(fn($item) => ucfirst($item->jenis_kejahatan), $statistik)) ?>'
                        data-values='<?= json_encode(array_map(fn($item) => (int)$item->total, $statistik)) ?>'>
                </canvas>
            </div>

            <!-- Deskripsi Grafik -->
            <div class="text-muted text-center mt-3 mb-4 px-3" style="max-width: 800px; margin-left: auto; margin-right: auto;">
                Grafik di atas menunjukkan jumlah kasus kriminalitas berdasarkan jenis kejahatan yang terjadi di wilayah. 
                Setiap batang mewakili total laporan untuk kategori kejahatan tertentu seperti 
                <strong>curanmor</strong>, <strong>perampokan</strong>, <strong>begal</strong>, dan <strong>tawuran</strong>. 
                Data ini berguna untuk mengidentifikasi jenis kejahatan yang paling sering terjadi, sehingga dapat membantu dalam pengambilan kebijakan pencegahan dan peningkatan kewaspadaan masyarakat.
            </div>

            <!-- Wilayah Rawan -->
            <div class="mb-5">
                <!-- Filter Laporan -->
                <div class="mb-4">
                    <form id="filterForm" method="get" action="<?= base_url('/statistik') ?>" class="bg-white p-3 rounded-3 shadow-sm d-flex align-items-center gap-3 flex-wrap">
                        <div class="d-flex align-items-center gap-2">
                            <label for="tahun" class="form-label fw-semibold mb-0">
                                <i class="bi bi-calendar-year me-2 text-primary"></i>Tahun:
                            </label>
                            <select name="tahun" id="tahun" class="form-control fw-bold p-2 rounded-3" onchange="this.form.submit()">
                                <option value="">-- Pilih Tahun --</option>
                                <?php
                                $currentYear = date('Y');
                                for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
                                    $selected = ($i == (int)$tahun) ? 'selected' : '';
                                    echo "<option value='$i' $selected>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <label for="bulan" class="form-label fw-semibold mb-0">
                                <i class="bi bi-calendar-month me-2 text-primary"></i>Bulan:
                            </label>
                            <select name="bulan" id="bulan" class="form-control fw-bold p-2 rounded-3" onchange="this.form.submit()">
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
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <label for="jenis_kejahatan" class="form-label fw-semibold mb-0">
                                <i class="bi bi-funnel-fill me-2 text-primary"></i>Jenis Kejahatan:
                            </label>
                            <select name="jenis_kejahatan" id="jenis_kejahatan" class="form-control fw-bold p-2 rounded-3">
                                <option value="">Semua</option>
                                <?php if (isset($jenisList)): ?>
                                    <?php foreach ($jenisList as $jenis): ?>
                                        <option value="<?= esc($jenis->jenis_kejahatan) ?>"
                                            <?= $jenisDipilih == $jenis->jenis_kejahatan ? 'selected' : '' ?>>
                                            <?= ucfirst($jenis->jenis_kejahatan) ?>
                                        </option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary fw-bold">
                            <i class="bi bi-search me-1"></i> Tampilkan
                        </button>
                        <a href="<?= base_url('/statistik') ?>" class="btn btn-secondary fw-bold">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                        </a>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tempat/Jalan/Gang Kejadian</th>
                                <th>Jenis Kejahatan</th>
                                <th>Total Kasus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($rankingData)): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                                        Belum ada data untuk periode ini.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($rankingData as $i => $row): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= esc($row->wilayah) ?></td>
                                        <td><?= ucfirst(esc($row->jenis_kejahatan)) ?></td>
                                        <td><?= esc($row->total) ?></td>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>