<?php
$nama_daerah = [
    'name'        => 'nama_daerah',
    'id'          => 'nama_daerah',
    'class'       => 'form-control text-dark fw-bold',
    'value'       => old('nama_daerah'),
    'placeholder' => 'Detail patokan Tempat/Jalan/Gang Kejadian'
];

$lat = [
    'name'        => 'latitude',
    'id'          => 'latitude',
    'class'       => 'form-control text-dark fw-bold',
    'value'       => old('latitude'),
    'placeholder' => 'Contoh: -6.123456'
];

$long = [
    'name'        => 'longitude',
    'id'          => 'longitude',
    'class'       => 'form-control text-dark fw-bold',
    'value'       => old('longitude'),
    'placeholder' => 'Contoh: 108.123456'
];

$nama_pelapor = [
    'name'        => 'nama_pelapor',
    'id'          => 'nama_pelapor',
    'class'       => 'form-control text-dark fw-bold',
    'value'       => old('nama_pelapor'),
    'placeholder' => 'Nama pelapor'
];

$no_hp = [
    'name'        => 'no_hp',
    'id'          => 'no_hp',
    'class'       => 'form-control text-dark fw-bold',
    'value'       => old('no_hp'),
    'placeholder' => 'Nomor telepon (contoh: 081234567890)'
];

$deskripsi = [
    'name'        => 'deskripsi',
    'id'          => 'deskripsi',
    'class'       => 'form-control text-dark fw-bold',
    'value'       => old('deskripsi'),
    'placeholder' => 'Kronologi kejadian'
];

$submit = [
    'name'  => 'submit',
    'id'    => 'submit',
    'value' => 'Simpan Data',
    'class' => 'btn btn-warning fw-bold px-4',
    'type'  => 'submit'
];
?>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-4 px-3">
            <div class="card-header bg-white border-bottom rounded-top py-3 px-4 d-flex align-items-center justify-content-center">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-map-marked-alt me-2 text-primary"></i> Data Wilayah
                </h5>
            </div>

            <div class="card-body p-4">
                <?php if (session()->getFlashdata('msg')) : ?>
                    <div class="alert alert-success shadow-sm fw-bold mt-3" role="alert">
                        <i class="fas fa-check-circle me-2 text-success"></i>
                        <?= session()->getFlashdata('msg'); ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger shadow-sm fw-bold mt-3" role="alert">
                        <i class="fas fa-exclamation-circle me-2 text-danger"></i>
                        <?= session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <hr class="my-5">

                <h5 class="fw-bold mb-3">
                    <i class="fas fa-check-circle text-success me-2"></i> Validasi Laporan Masyarakat
                </h5>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm text-center align-middle">
                        <thead class="bg-warning text-dark">
                            <tr>
                                <th>Kelurahan</th>
                                <th>Patokan Tempat/Jalan</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Jenis Kejahatan</th>
                                <th>Nama Pelapor</th>
                                <th>Nomor Telepon</th>
                                <th>Deskripsi Kejadian</th>
                                <th>Gambar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($pengaduan)) : ?>
                                <tr>
                                    <td colspan="11" class="text-center text-muted py-4">
                                        <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                                        Tidak ada laporan yang perlu divalidasi.
                                    </td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($pengaduan as $row): ?>
                                    <tr>
                                        <td><?= esc($row->kelurahan) ?></td>
                                        <td class="text-nowrap"><?= esc($row->nama_daerah) ?></td>
                                        <td class="text-nowrap">
                                            <a href="https://www.google.com/maps?q=<?= esc($row->latitude) ?>,<?= esc($row->longitude) ?>" target="_blank">
                                                <?= esc($row->latitude) ?>
                                            </a>
                                        </td>
                                        <td class="text-nowrap">
                                            <a href="https://www.google.com/maps?q=<?= esc($row->latitude) ?>,<?= esc($row->longitude) ?>" target="_blank">
                                                <?= esc($row->longitude) ?>
                                            </a>
                                        </td>
                                        <td class="text-nowrap"><?= ucfirst(esc($row->jenis_kejahatan)) ?></td>
                                        <td class="text-nowrap"><?= esc($row->nama_pelapor) ?></td>
                                        <td class="text-nowrap"><?= esc($row->no_hp) ?></td>
                                        <td class="text-wrap" style="max-width: 150px;"><?= esc($row->deskripsi) ?></td>
                                        <td><img src="/img/<?= esc($row->gambar) ?>" width="60" class="rounded-3"></td>
                                        <td class="text-nowrap"><?= esc($row->status) ?></td>
                                        <td>
                                            <form action="/wilayah/updateStatus/<?= esc($row->id) ?>" method="POST">
                                                <select name="status" class="form-control status-dropdown" onchange="this.form.submit()">
                                                    <option value="" <?= $row->status == 'pending' ? 'selected' : '' ?>>Pilih Salah Satu</option>
                                                    <option value="Diproses" <?= $row->status == 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                                                    <option value="Selesai" <?= $row->status == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                                    <option value="Ditolak">Ditolak</option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <hr class="my-5">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-check-circle text-success me-2"></i> Laporan Selesai
                </h5>

                                <!-- Memindahkan filter dan button ke atas kiri tabel -->
                <div class="d-flex justify-content-start align-items-center my-4 flex-wrap gap-2">
                    <form id="filterForm" method="get" action="" class="d-flex gap-2 me-3">
                        <select name="tahun" id="tahun" class="form-control fw-bold rounded-3" onchange="this.form.submit()">
                            <option value="">-- Tahun --</option>
                            <?php
                            $currentYear = date('Y');
                            for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
                                $selected = ($i == (int)$tahun) ? 'selected' : '';
                                echo "<option value='$i' $selected>$i</option>";
                            }
                            ?>
                        </select>
                        <select name="bulan" id="bulan" class="form-control fw-bold rounded-3" onchange="this.form.submit()">
                            <option value="">-- Bulan --</option>
                            <?php
                            $bulanList = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
                            foreach ($bulanList as $key => $value) {
                                $selected = ($key == $bulan) ? 'selected' : '';
                                echo "<option value='$key' $selected>$value</option>";
                            }
                            ?>
                        </select>
                    </form>
                    <button type="button" class="btn btn-secondary fw-bold shadow-sm me-3" onclick="resetFilter()">
                        <i class="fas fa-sync-alt me-1"></i> Reset
                    </button>
                    <button type="button" class="btn btn-success fw-bold shadow-sm me-3" onclick="cetakLaporan()">
                        <i class="fas fa-print me-1"></i> Cetak
                    </button>
                    <button type="button" class="btn btn-primary fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="fas fa-plus me-1"></i> Tambah
                    </button>
                </div>

                <div class="table-responsive px-2">
                    <table class="table table-hover align-middle table-borderless shadow-sm rounded-4 overflow-hidden">
                        <thead class="bg-dark text-white text-center">
                            <tr class="fw-bold">
                                <th>Kelurahan</th>
                                <th>Patokan Tempat/Jalan</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Jenis Kejahatan</th>
                                <th>Nama Pelapor</th>
                                <th>Nomor Telepon</th>
                                <th>Deskripsi Kejadian</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white text-center">
                            <?php if (empty($selesai)) : ?>
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-4">
                                        <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                                        Tidak ada laporan selesai.
                                    </td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($selesai as $row): ?>
                                    <tr class="border-bottom border-light">
                                        <td><?= esc($row->kelurahan) ?></td>
                                        <td class="text-nowrap"><?= esc($row->nama_daerah) ?></td>
                                        <td class="text-nowrap">
                                            <a href="https://www.google.com/maps?q=<?= esc($row->latitude) ?>,<?= esc($row->longitude) ?>" target="_blank">
                                                <?= esc($row->latitude) ?>
                                            </a>
                                        </td>
                                        <td class="text-nowrap">
                                            <a href="https://www.google.com/maps?q=<?= esc($row->latitude) ?>,<?= esc($row->longitude) ?>" target="_blank">
                                                <?= esc($row->longitude) ?>
                                            </a>
                                        </td>
                                        <td class="text-nowrap"><?= ucfirst(esc($row->jenis_kejahatan)) ?></td>
                                        <td class="text-nowrap"><?= esc($row->nama_pelapor) ?></td>
                                        <td class="text-nowrap"><?= esc($row->no_hp) ?></td>
                                        <td class="text-wrap" style="max-width: 150px;"><?= esc($row->deskripsi) ?></td>
                                        <td><img src="/img/<?= esc($row->gambar) ?>" width="60" class="rounded-3"></td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="/editWilayah/<?= esc($row->id) ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= esc($row->id) ?>">Hapus</button>
                                            </div>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="deleteModal<?= esc($row->id) ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= esc($row->id) ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content shadow-lg">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="deleteModalLabel<?= esc($row->id) ?>">Konfirmasi Hapus</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Yakin hapus data ini?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <a href="/wilayahDelete/<?= esc($row->id) ?>" class="btn btn-danger">Ya</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header bg-dark text-white rounded-top">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Data Wilayah
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <form action="/wilayah_data_save" method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-12">
                            <?= form_label('Kelurahan', 'kelurahan'); ?>
                            <select name="kelurahan" id="kelurahan" class="form-control fw-bold p-2 rounded-3" required>
                                <option value="" disabled selected>-- Pilih Kelurahan --</option>
                                <?php foreach ($kelurahan as $kel): ?>
                                    <option value="<?= esc($kel) ?>"><?= esc($kel) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12">
                            <?= form_label('Patokan Tempat/Jalan', 'nama_daerah'); ?>
                            <?= form_input($nama_daerah); ?>
                        </div>

                        <div class="col-6">
                            <?= form_label('Latitude', 'latitude'); ?>
                            <?= form_input($lat); ?>
                        </div>
                        <div class="col-6">
                            <?= form_label('Longitude', 'longitude'); ?>
                            <?= form_input($long); ?>
                        </div>

                        <div class="col-12">
                            <?= form_label('Jenis Kejahatan', 'jenis_kejahatan'); ?>
                            <select name="jenis_kejahatan" id="jenis_kejahatan" class="form-control fw-bold p-2 rounded-3" required onchange="toggleCustomInput()">
                                <option value="" disabled <?= !old('jenis_kejahatan') ? 'selected' : '' ?>>-- Pilih Jenis --</option>
                                <option value="curanmor" <?= old('jenis_kejahatan') == 'curanmor' ? 'selected' : '' ?>>Curanmor</option>
                                <option value="perampokan" <?= old('jenis_kejahatan') == 'perampokan' ? 'selected' : '' ?>>Perampokan</option>
                                <option value="begal" <?= old('jenis_kejahatan') == 'begal' ? 'selected' : '' ?>>Begal</option>
                                <option value="tawuran" <?= old('jenis_kejahatan') == 'tawuran' ? 'selected' : '' ?>>Tawuran</option>
                                <option value="lainnya" <?= old('jenis_kejahatan') == 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
                            </select>
                            <div id="custom_kejahatan_div" class="form-group mt-2" style="display: none;">
                                <?= form_label('Jenis Kejahatan Lainnya', 'custom_kejahatan'); ?>
                                <input type="text" name="custom_kejahatan" id="custom_kejahatan" class="form-control fw-bold p-2 rounded-3" value="<?= old('custom_kejahatan') ?>" placeholder="Jenis kejahatan lainnya">
                            </div>
                        </div>

                        <div class="col-6">
                            <?= form_label('Nama Pelapor', 'nama_pelapor'); ?>
                            <?= form_input($nama_pelapor); ?>
                        </div>
                        <div class="col-6">
                            <?= form_label('Nomor Telepon', 'no_hp'); ?>
                            <?= form_input($no_hp); ?>
                        </div>

                        <div class="col-12">
                            <?= form_label('Kronologi Kejadian', 'deskripsi'); ?>
                            <?= form_textarea($deskripsi); ?>
                        </div>

                        <div class="col-12">
                            <?= form_label('Upload Gambar', 'gambar'); ?>
                            <input type="file" class="form-control text-dark fw-bold p-2" id="gambar" name="gambar">
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times-circle me-1"></i> Tutup
                        </button>
                        <?= form_submit($submit); ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    function cetakLaporan() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.setFontSize(14);
        doc.setFont("helvetica", "bold");
        doc.text('LAPORAN KRIMINALITAS POLSEK LOHBENER', 105, 15, { align: 'center' });
        doc.setFontSize(10);
        doc.setFont("helvetica", "normal");

        <?php
        $periode = '';
        if ($tahun && !$bulan) {
            $periode = "TAHUN $tahun";
        } elseif ($bulan && $tahun) {
            $bulanList = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
            $periode = $bulanList[$bulan] . " $tahun";
        } else {
            $periode = "TAHUN " . date('Y');
        }
        ?>
        doc.text('<?= $periode ?>', 105, 25, { align: 'center' });

        doc.setFontSize(10);
        doc.setFont("helvetica", "bold");
        doc.setFillColor(255, 204, 0);
        doc.rect(10, 35, 190, 10, 'F');
        doc.text('No', 15, 42);
        doc.text('Kelurahan', 30, 42);
        doc.text('Curanmor', 70, 42);
        doc.text('Perampokan', 95, 42);
        doc.text('Begal', 125, 42);
        doc.text('Tawuran', 150, 42);
        doc.text('Total', 175, 42);

        doc.setLineWidth(0.2);
        doc.line(10, 45, 200, 45);

        const data = [
            <?php
            if (!empty($laporanData)) {
                $no = 1;
                foreach ($laporanData as $row) {
                    echo "{ no: $no, kelurahan: '" . addslashes($row->kelurahan) . "', curanmor: {$row->curanmor}, perampokan: {$row->perampokan}, begal: {$row->begal}, tawuran: {$row->tawuran}, total_kejahatan: {$row->total_kejahatan} },\n";
                    $no++;
                }
            }
            ?>
        ];

        let totalCuranmor = 0;
        let totalPerampokan = 0;
        let totalBegal = 0;
        let totalTawuran = 0;
        let totalKejahatan = 0;

        data.forEach(item => {
            totalCuranmor += item.curanmor;
            totalPerampokan += item.perampokan;
            totalBegal += item.begal;
            totalTawuran += item.tawuran;
            totalKejahatan += item.total_kejahatan;
        });

        if (data.length === 0) {
            doc.text('Tidak ada data.', 105, 55, { align: 'center' });
        } else {
            let y = 55;
            const rowHeight = 10;
            doc.setFont("helvetica", "normal");
            data.forEach((item, index) => {
                doc.setFillColor(255, 255, 255);
                doc.rect(10, y - rowHeight, 190, rowHeight, 'F');
                doc.text(String(item.no), 15, y - 2);
                doc.text(item.kelurahan, 30, y - 2);
                doc.text(String(item.curanmor), 70, y - 2);
                doc.text(String(item.perampokan), 95, y - 2);
                doc.text(String(item.begal), 125, y - 2);
                doc.text(String(item.tawuran), 150, y - 2);
                doc.text(String(item.total_kejahatan), 175, y - 2);
                y += rowHeight;
            });

            doc.setFillColor(200, 200, 200);
            doc.rect(10, y - rowHeight, 190, rowHeight, 'F');
            doc.setFont("helvetica", "bold");
            doc.text('TOTAL', 30, y - 2);
            doc.text(String(totalCuranmor), 70, y - 2);
            doc.text(String(totalPerampokan), 95, y - 2);
            doc.text(String(totalBegal), 125, y - 2);
            doc.text(String(totalTawuran), 150, y - 2);
            doc.text(String(totalKejahatan), 175, y - 2);
            y += rowHeight;

            for (let i = 55; i <= y - rowHeight; i += rowHeight) {
                doc.line(10, i, 200, i);
            }
            doc.line(10, 35, 10, y - rowHeight);
            doc.line(25, 35, 25, y - rowHeight);
            doc.line(65, 35, 65, y - rowHeight);
            doc.line(90, 35, 90, y - rowHeight);
            doc.line(120, 35, 120, y - rowHeight);
            doc.line(145, 35, 145, y - rowHeight);
            doc.line(170, 35, 170, y - rowHeight);
            doc.line(200, 35, 200, y - rowHeight);

            doc.setFont("helvetica", "normal");
            doc.text('Indramayu, <?= date('d M Y') ?>', 150, y + 20);
            doc.text('Kepala Polsek Lohbener,', 150, y + 45);
            doc.text('NIP. 1234567890', 150, y + 50);
        }

        doc.save('Laporan_Kriminalitas_Lohbener.pdf');
    }

    function resetFilter() {
        window.location.href = '/wilayah';
    }

    function toggleCustomInput() {
        const jenisKejahatan = document.getElementById('jenis_kejahatan').value;
        const customDiv = document.getElementById('custom_kejahatan_div');
        const customInput = document.getElementById('custom_kejahatan');
        if (jenisKejahatan === 'lainnya') {
            customDiv.style.display = 'block';
            customInput.required = true;
        } else {
            customDiv.style.display = 'none';
            customInput.required = false;
            customInput.value = '';
        }
    }
</script>