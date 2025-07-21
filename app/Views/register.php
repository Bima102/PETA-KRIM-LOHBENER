<!-- Kontainer utama untuk halaman registrasi dengan latar belakang -->
<div class="container py-5 my-5 d-flex justify-content-center align-items-center" 
     style="min-height: 100vh; background-image: url('<?= base_url('assets/bg-blur.jpg'); ?>'); background-size: cover;">
    <!-- Kolom untuk formulir registrasi dengan bayangan dan latar belakang putih -->
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

        <!-- Judul dan deskripsi formulir registrasi -->
        <div class="mt-3 mb-2">
            <!-- Judul formulir -->
            <h5 class="text-dark">Buat Akun Baru</h5>
            <!-- Deskripsi formulir -->
            <p class="text-muted">Silakan isi form di bawah</p>
        </div>

        <!-- Notifikasi error dari session flashdata -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <!-- Menampilkan pesan error -->
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <!-- Notifikasi sukses dari session flashdata -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <!-- Menampilkan pesan sukses -->
                <?= session()->getFlashdata('success'); ?>
            </div>
        <?php endif; ?>

        <!-- Notifikasi validasi dari errors -->
        <?php if (isset($validation)): ?>
            <div class="alert alert-danger">
                <!-- Menampilkan daftar error validasi -->
                <?= $validation->listErrors(); ?>
            </div>
        <?php endif; ?>

        <!-- Garis pemisah -->
        <hr>

        <!-- Formulir registrasi -->
        <form action="/register" method="post">
            <!-- Kolom input nama depan -->
            <div class="form-group mb-3 text-start">
                <!-- Label untuk input nama depan -->
                <label for="firstname" class="fw-bold">Nama Depan</label>
                <!-- Input untuk nama depan dengan placeholder dan wajib diisi -->
                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Masukkan nama depan" required>
            </div>

            <!-- Kolom input nama belakang -->
            <div class="form-group mb-3 text-start">
                <!-- Label untuk input nama belakang -->
                <label for="lastname" class="fw-bold">Nama Belakang</label>
                <!-- Input untuk nama belakang dengan placeholder dan wajib diisi -->
                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Masukkan nama belakang" required>
            </div>

            <div class="form-group mb-3 text-start">
                <label for="phone" class="fw-bold">Nomor Handphone</label>
                <input type="text" class="form-control" name="phone" id="phone" placeholder="Masukkan nomor handphone" required>
            </div>

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

            <!-- Kolom input konfirmasi password -->
            <div class="form-group mb-3 text-start">
                <!-- Label untuk input konfirmasi password -->
                <label for="password_confirm" class="fw-bold">Konfirmasi Password</label>
                <!-- Input untuk konfirmasi password dengan placeholder dan wajib diisi -->
                <input type="password" class="form-control" name="password_confirm" id="password_confirm" placeholder="Masukkan ulang password" required>
            </div>

            <!-- Tombol submit untuk registrasi -->
            <button type="submit" class="btn btn-warning w-100 fw-bold">Daftar</button>
        </form>

        <!-- Tautan ke halaman login -->
        <div class="text-center mt-3">
            <!-- Tautan untuk pengguna yang sudah memiliki akun -->
            <a href="/login" class="text-decoration-none text-dark">Sudah punya akun? Login di sini</a>
        </div>
    </div>
</div>