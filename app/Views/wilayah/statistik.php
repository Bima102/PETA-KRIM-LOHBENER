<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <h2 class="fw-bold">
                    <i class="bi bi-bar-chart-fill text-primary me-2"></i><?= esc($title) ?>
                </h2>
                <p class="text-muted mb-0">
                    Statistik data kriminalitas berdasarkan kategori kejahatan
                </p>
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
                Grafik di atas menunjukkan jumlah kasus kriminalitas berdasarkan jenis kejahatan yang terjadi di wilayah Lohbener. 
                Setiap batang mewakili total laporan untuk kategori kejahatan tertentu seperti 
                <strong>curanmor</strong>, <strong>perampokan</strong>, <strong>begal</strong>, dan <strong>tawuran</strong>. 
                Data ini berguna untuk mengidentifikasi jenis kejahatan yang paling sering terjadi, sehingga dapat membantu dalam pengambilan kebijakan pencegahan dan peningkatan kewaspadaan masyarakat.
            </div>
            
            <!-- Wilayah Rawan -->
            <div class="mb-5">
                <h5 class="fw-semibold">
                    Wilayah dengan total Kasus Kejahatannya
                </h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Jalan</th>
                                <th>Jenis Kejahatan</th>
                                <th>Total Kasus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rankingData as $i => $row): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($row->wilayah) ?></td>
                                <td><?= esc($row->jenis_kejahatan) ?></td>
                                <td><?= esc($row->total) ?></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
