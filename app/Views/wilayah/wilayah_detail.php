<div class="container py-4">
  <div class="card shadow-lg">
    <div class="card-header bg-grey text-black">
      <h5 class="modal-title fw-bold" id="exampleModalLabel">
        <i class="fas fa-plus-circle me-2"></i> Detail Wilayah
      </h5>
    </div>

    <div class="card-body">
      <a href="<?= base_url('/wilayah'); ?>" class="btn btn-primary mb-3">
        Kembali
      </a>

      <div class="row mb-4 align-items-center">
        <div class="col-md-5 text-center">
          <img src="/img/<?= esc($dWilayah->gambar); ?>" width="100%" alt="Gambar Wilayah" class="img-fluid rounded shadow-sm">
        </div>

        <div class="col-md-7">
          <div class="p-3">
            <h5 class="fw-bold">Lokasi: <?= esc($dWilayah->nama_daerah); ?></h5>

            <div class="incident-box mt-2">
              <p class="text-muted mb-1">Jenis kejadian yang tercatat:</p>
              <span class="badge bg-danger p-2 fs-6">
                <i class="fas fa-exclamation-triangle me-1"></i><?= esc($dWilayah->jenis_kejahatan); ?>
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead class="bg-dark text-white text-center">
            <tr>
              <th>Latitude</th>
              <th>Longitude</th>
              <th>Jenis Kejahatan</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody class="text-center">
            <tr>
              <td><?= $dWilayah->latitude; ?></td>
              <td><?= $dWilayah->longitude; ?></td>
              <td><?= $dWilayah->jenis_kejahatan; ?></td>
              <td>
                <a href="/editWilayah/<?= $dWilayah->id; ?>" class="btn btn-warning btn-sm px-3">Edit</a>
                <button type="button" class="btn btn-danger btn-sm px-3" data-bs-toggle="modal" data-bs-target="#deleteModal">
                  Hapus
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>

      <div class="modal-body">
        Apakah Anda yakin ingin menghapus data wilayah ini?
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <a href="/wilayahDelete/<?= $dWilayah->id; ?>" class="btn btn-danger">Ya, Hapus</a>
      </div>
    </div>
  </div>
</div>