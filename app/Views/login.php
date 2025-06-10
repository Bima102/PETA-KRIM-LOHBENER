<!-- Kontainer utama untuk halaman login dengan latar belakang -->
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh; background-image: url('<?= base_url('assets/bg-blur.jpg'); ?>'); background-size: cover;">
    <!-- Kolom untuk formulir login dengan bayangan dan latar belakang putih -->
    <div class="col-md-6 col-lg-4 shadow-lg p-4 bg-white rounded text-center">
        <!-- Logo aplikasi -->
        <div class="mb-3">
            <!-- Gambar logo dengan tinggi maksimum 120px -->
            <img src="<?= base_url('assets/img/log.png'); ?>" alt="Logo Kriminalitas" class="img-fluid" style="max-height: 120px;">
        </div>

        <!-- Judul aplikasi -->
        <h5 class="fw-bold" style="font-family: 'Anton', sans-serif; font-size: 1.7rem; color: rgb(0, 0, 0);">
            PETA-KRIM LOHBENER
        </h5>

        <!-- Notifikasi error dari session flashdata -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger mt-3">
                <!-- Menampilkan pesan error -->
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <!-- Notifikasi sukses dari session flashdata -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success mt-3">
                <!-- Menampilkan pesan sukses -->
                <?= session()->getFlashdata('success'); ?>
            </div>
        <?php endif; ?>

        <!-- Garis pemisah -->
        <hr>

        <!-- Formulir login -->
        <form action="/index" method="post">
            <!-- Kolom input email -->
            <div class="form-group mb-3 text-start">
                <!-- Label untuk input email -->
                <label for="email" class="fw-bold">Email</label>
                <!-- Input untuk email dengan placeholder dan wajib diisi -->
                <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan email Anda" required>
            </div>

            <!-- Kolom input password -->
            <div class="form-group mb-3 text-start">
                <!-- Label untuk input password -->
                <label for="password" class="fw-bold">Password</label>
                <!-- Input untuk password dengan placeholder dan wajib diisi -->
                <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan password Anda" required>
            </div>

            <!-- Tombol submit untuk login -->
            <button type="submit" class="btn btn-warning w-100 fw-bold">LOG IN</button>
        </form>

        <!-- Tautan untuk registrasi -->
        <div class="text-center mt-3">
            <!-- Tautan ke halaman registrasi -->
            <a href="/register" class="text-decoration-none text-dark">Belum punya akun? Daftar di sini</a>
        </div>
    </div>
</div>  