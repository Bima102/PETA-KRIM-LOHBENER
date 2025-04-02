<div class="container mt-5">
    <h2 class="text-center mb-4">Laporan Aduan</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>No</th>
                    <th>Jenis Kejahatan</th>
                    <th>Kecamatan</th>
                    <th>Kelurahan</th>
                    <th>Daerah/Jalan</th>
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
                        <td><?= esc($row['kecamatan']) ?></td>
                        <td><?= esc($row['kelurahan']) ?></td>
                        <td><?= esc($row['daerah']) ?></td>
                        <td><?= esc($row['pelapor']) ?></td>
                        <td class="text-center">
                            <a href="/aduan/delete/<?= esc($row['id']) ?>" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada laporan aduan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
