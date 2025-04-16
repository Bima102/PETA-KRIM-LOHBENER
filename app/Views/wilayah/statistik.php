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
            
            <!-- Wilayah Rawan -->
            <div class="mb-5">
                <h5 class="fw-semibold">Wilayah dengan Kasus Kejahatannya</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Wilayah</th>
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

            <!-- Tips Aman -->
            <div class="mb-5">
                <h5 class="fw-semibold">Tips Aman Berdasarkan Jenis Kejahatan</h5>
                <div class="accordion" id="tipsAccordion">
                    <!-- Curanmor -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#tip1">
                                <i class="fas fa-motorcycle me-2"></i> Curanmor
                            </button>
                        </h2>
                        <div id="tip1" class="accordion-collapse collapse show" data-bs-parent="#tipsAccordion">
                            <div class="accordion-body">
                                Gunakan kunci ganda, parkir di tempat terang dan ramai, serta pasang alarm kendaraan.
                            </div>
                        </div>
                    </div>

                    <!-- Perampokan -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tip2">
                                <i class="fas fa-mask me-2"></i> Perampokan
                            </button>
                        </h2>
                        <div id="tip2" class="accordion-collapse collapse" data-bs-parent="#tipsAccordion">
                            <div class="accordion-body">
                                Hindari berjalan sendirian di malam hari, waspadai lingkungan sekitar, dan jangan pamer barang berharga.
                            </div>
                        </div>
                    </div>

                    <!-- Begal -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tip3">
                                <i class="fas fa-user-ninja me-2"></i> Begal
                            </button>
                        </h2>
                        <div id="tip3" class="accordion-collapse collapse" data-bs-parent="#tipsAccordion">
                            <div class="accordion-body">
                                Hindari berkendara sendirian di malam hari, gunakan rute yang ramai dan terang, serta selalu waspada terhadap pengendara mencurigakan di sekitar.
                            </div>
                        </div>
                    </div>

                    <!-- Tawuran -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tip4">
                                <i class="fas fa-users me-2"></i> Tawuran
                            </button>
                        </h2>
                        <div id="tip4" class="accordion-collapse collapse" data-bs-parent="#tipsAccordion">
                            <div class="accordion-body">
                                Jauhi area yang sering dijadikan tempat nongkrong kelompok tertentu, hindari ikut provokasi, dan segera cari tempat aman jika situasi mulai tidak kondusif.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
