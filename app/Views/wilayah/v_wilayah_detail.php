<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title">Menu Detail Wilayah</h4>
      </div>
      <div class="card-body">
        <a href="<?= base_url('/wilayah'); ?>" class="btn btn-primary">Kembali</a>
        <hr>
        <div class="row">
          <div class="col">
            <img src="/img/<?= $dWilayah->gambar; ?>" width="300" alt="Gambar 1">
          </div>
          <div class="col">
            <p>Di daerah <?= $dWilayah->nama_daerah; ?> Sering terjadi <?= $dWilayah->deskripsi; ?></p>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark text-center">
              <tr>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr class="text-center">
                <td><?= esc($dWilayah->latitude); ?></td>
                <td><?= esc($dWilayah->longitude); ?></td>
                <td><?= esc($dWilayah->deskripsi); ?></td>
                <td>
                  <a href="/editWilayah/<?= $dWilayah->id; ?>" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                  <a href="/wilayahDelete/<?= $dWilayah->id; ?>" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus?')" class="btn btn-sm btn-danger ms-1">
                    <i class="fas fa-trash-alt"></i> Hapus
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>