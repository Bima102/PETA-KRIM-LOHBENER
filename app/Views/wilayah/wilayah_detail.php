<!-- Kontainer utama untuk halaman detail wilayah dengan padding vertikal -->
<div class="container py-4">
    <!-- Kartu utama dengan bayangan untuk menampilkan detail wilayah -->
    <div class="card shadow-lg">
        <!-- Header kartu dengan latar abu-abu dan teks hitam -->
        <div class="card-header bg-grey text-black">
            <!-- Judul kartu dengan ikon tambah -->
            <h5 class="modal-title fw-bold" id="exampleModalLabel">
                <i class="fas fa-plus-circle me-2"></i> Detail Wilayah
            </h5>
        </div>

        <!-- Badan kartu untuk menampilkan konten detail -->
        <div class="card-body">
            <!-- Tombol kembali ke halaman daftar wilayah -->
            <a href="<?= base_url('/wilayah'); ?>" class="btn btn-primary mb-3">
                Kembali
            </a>

            <!-- Baris untuk menampilkan gambar dan informasi lokasi -->
            <div class="row mb-4 align-items-center">
                <!-- Kolom untuk menampilkan gambar wilayah -->
                <div class="col-md-5 text-center">
                    <!-- Gambar wilayah dengan lebar penuh, sudut membulat, dan bayangan -->
                    <img src="/img/<?= esc($dWilayah->gambar); ?>" 
                         width="100%" 
                         alt="Gambar Wilayah" 
                         class="img-fluid rounded shadow-sm">
                </div>

                <!-- Kolom untuk menampilkan informasi lokasi dan jenis kejahatan -->
                <div class="col-md-7">
                    <!-- Kontainer dengan padding untuk informasi -->
                    <div class="p-3">
                        <!-- Nama daerah/lokasi kejadian -->
                        <h5 class="fw-bold">Lokasi: <?= esc($dWilayah->nama_daerah); ?></h5>

                        <!-- Kotak untuk menampilkan jenis kejahatan -->
                        <div class="incident-box mt-2">
                            <!-- Label untuk jenis kejahatan -->
                            <p class="text-muted mb-1">Jenis kejadian yang tercatat:</p>
                            <!-- Badge untuk menampilkan jenis kejahatan dengan ikon -->
                            <span class="badge bg-danger p-2 fs-6">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                <?= esc($dWilayah->jenis_kejahatan); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel responsif untuk menampilkan detail koordinat dan aksi -->
            <div class="table-responsive">
                <!-- Tabel dengan border dan penyelarasan tengah -->
                <table class="table table-bordered align-middle">
                    <!-- Kepala tabel dengan latar gelap dan teks putih -->
                    <thead class="bg-dark text-white text-center">
                        <tr>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Jenis Kejahatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <!-- Badan tabel untuk menampilkan data wilayah -->
                    <tbody class="text-center">
                        <tr>
                            <!-- Kolom untuk menampilkan latitude -->
                            <td><?= $dWilayah->latitude; ?></td>
                            <!-- Kolom untuk menampilkan longitude -->
                            <td><?= $dWilayah->longitude; ?></td>
                            <!-- Kolom untuk menampilkan jenis kejahatan -->
                            <td><?= $dWilayah->jenis_kejahatan; ?></td>
                            <!-- Kolom untuk aksi edit dan hapus -->
                            <td>
                                <!-- Tombol untuk mengedit data wilayah -->
                                <a href="/editWilayah/<?= $dWilayah->id; ?>" 
                                   class="btn btn-warning btn-sm px-3">Edit</a>
                                <!-- Tombol untuk membuka modal konfirmasi hapus -->
                                <button type="button" 
                                        class="btn btn-danger btn-sm px-3" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal">
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

<!-- Modal untuk konfirmasi penghapusan data -->
<div class="modal fade" 
     id="deleteModal" 
     tabindex="-1" 
     aria-labelledby="deleteModalLabel" 
     aria-hidden="true">
    <!-- Dialog modal dengan penyelarasan tengah -->
    <div class="modal-dialog modal-dialog-centered">
        <!-- Konten modal dengan bayangan -->
        <div class="modal-content shadow-lg">
            <!-- Header modal dengan latar merah dan teks putih -->
            <div class="modal-header bg-danger text-white">
                <!-- Judul modal -->
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <!-- Tombol tutup modal -->
                <button type="button" 
                        class="btn-close btn-close-white" 
                        data-bs-dismiss="modal" 
                        aria-label="Tutup"></button>
            </div>

            <!-- Badan modal dengan pesan konfirmasi -->
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data wilayah ini?
            </div>

            <!-- Footer modal dengan tombol aksi -->
            <div class="modal-footer">
                <!-- Tombol untuk membatalkan penghapusan -->
                <button type="button" 
                        class="btn btn-secondary" 
                        data-bs-dismiss="modal">Batal</button>
                <!-- Tombol untuk mengonfirmasi penghapusan -->
                <a href="/wilayahDelete/<?= $dWilayah->id; ?>" 
                   class="btn btn-danger">Ya, Hapus</a>
            </div>
        </div>
    </div>
</div>