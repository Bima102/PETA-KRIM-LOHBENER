<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <h2 class="fw-bold"><i class="bi bi-bar-chart-fill text-primary me-2"></i><?= esc($title) ?></h2>
                <p class="text-muted mb-0">Visualisasi data kriminalitas berdasarkan kategori kejahatan</p>
            </div>

            <!-- Grafik -->
            <div class="chart-container mb-5 mx-auto" style="max-width: 800px;">
                <canvas id="kejahatanChart"
                        data-labels='<?= json_encode(array_map(fn($item) => ucfirst($item->jenis_kejahatan), $statistik)) ?>'
                        data-values='<?= json_encode(array_map(fn($item) => (int)$item->total, $statistik)) ?>'>
                </canvas>
            </div>

            <!-- Deskripsi -->
            <div class="mb-4 px-2">
                <h5 class="fw-semibold">Deskripsi Statistik Kejahatan</h5>
                <p>
                    Grafik di atas menggambarkan frekuensi berbagai jenis kejahatan yang terjadi, seperti 
                    <strong>curanmor</strong>, <strong>perampokan</strong>, <strong>begal</strong>, dan <strong>tawuran</strong>. 
                    Data ini dapat digunakan untuk menganalisis tren dan menentukan prioritas penanganan.
                </p>
                <p>
                    Dengan mengetahui jenis kejahatan yang paling dominan, masyarakat dan aparat bisa bekerja sama 
                    dalam upaya pencegahan dan meningkatkan keamanan di lingkungan masing-masing.
                </p>
            </div>

            <!-- Tabel -->
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th><i class="bi bi-shield-exclamation me-2"></i>Jenis Kejahatan</th>
                            <th><i class="bi bi-graph-up-arrow me-2"></i>Jumlah Kasus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($statistik)) : ?>
                            <?php foreach ($statistik as $item) : ?>
                                <tr>
                                    <td><?= esc(ucfirst($item->jenis_kejahatan)) ?></td>
                                    <td><?= esc($item->total) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="2" class="text-center text-muted">Tidak ada data kejahatan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



