<!-- Tambahan CSS -->
<style>
  .incident-box {
    border: 2px solid #dc3545;
    padding: 1rem;
    border-radius: 10px;
    display: inline-block;
    background-color: #fff0f0;
  }
</style>

<div class="row justify-content-center mt-4"><!-- Tambah margin top -->
  <div class="col-md-10">
    <div class="card shadow-lg border-0 rounded-4" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
      <div class="card-header bg-gradient-primary text-white rounded-top-4">
        <h4 class="card-title mb-0"><i class="fas fa-map-marker-alt me-2"></i>Detail Informasi Wilayah</h4>
      </div>
      <div class="card-body mb-5">
        <!-- Tombol Kembali diubah jadi biru solid -->
        <a href="<?= base_url('/wilayah'); ?>" class="btn btn-primary mb-3">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <hr>

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
                  <i class="fas fa-exclamation-triangle me-1"></i><?= esc($dWilayah->deskripsi); ?>
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Tabel -->
        <div class="table-responsive">
          <table class="table table-hover table-bordered shadow-sm rounded text-center">
            <thead class="table-dark text-center">
              <tr>
                <th><i class="fas fa-map-pin"></i> Latitude</th>
                <th><i class="fas fa-map-pin"></i> Longitude</th>
                <th><i class="fas fa-comment-dots"></i> Deskripsi</th>
                <th><i class="fas fa-cogs"></i> Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span class="text-primary"><?= esc($dWilayah->latitude); ?></span></td>
                <td><span class="text-success"><?= esc($dWilayah->longitude); ?></span></td>
                <td><?= esc($dWilayah->deskripsi); ?></td>
                <td>
                  <a href="/editWilayah/<?= $dWilayah->id; ?>" class="btn btn-warning btn-sm rounded-3">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                  <button class="btn btn-danger btn-sm rounded-3 ms-2" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $dWilayah->id ?>">
                    <i class="fas fa-trash-alt"></i> Hapus
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
