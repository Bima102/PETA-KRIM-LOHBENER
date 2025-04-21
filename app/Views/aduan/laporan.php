<div class="container mt-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-clipboard-data me-2"></i> Laporan Aduan</h2>
        <hr class="w-25 mx-auto border-2 border-dark opacity-50">
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-nowrap shadow-sm rounded-4 overflow-hidden">
                    <thead class="table-dark text-center">
                        <tr class="align-middle">
                            <th>No</th>
                            <th>Jenis Kejahatan</th>
                            <th>Kelurahan</th>
                            <th>Daerah / Jalan</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Pelapor</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($aduan)): ?>
                            <?php $no = 1; foreach ($aduan as $row): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= esc($row['jenis_kejahatan']) ?></td>
                                    <td><?= esc($row['kelurahan']) ?></td>
                                    <td><?= esc($row['daerah']) ?></td>
                                    <td><?= esc($row['latitude']) ?></td>
                                    <td><?= esc($row['longitude']) ?></td>
                                    <td><?= esc($row['pelapor']) ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-danger btn-sm shadow-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $row['id'] ?>">
                                            <i class="bi bi-trash3-fill me-1"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="bi bi-info-circle-fill me-2 fs-5"></i> Belum ada laporan aduan.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header bg-danger text-white rounded-top">
                <h5 class="modal-title fw-bold" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="mb-3 fs-6">Apakah Anda yakin ingin menghapus laporan ini?</p>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <form id="deleteForm" method="get">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger px-4">Ya,Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk kirim ID ke form delete -->
<script>
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const form = deleteModal.querySelector('#deleteForm');
        form.action = `/aduan/delete/${id}`;
    });
</script>
