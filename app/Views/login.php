<!-- Kontainer utama untuk halaman login dengan latar belakang -->
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh; background-image: url('<?= base_url('assets/bg-blur.jpg'); ?>'); background-size: cover;">
    <div class="col-md-6 col-lg-4 shadow-lg p-4 bg-white rounded text-center">
        <div class="mb-3">
            <img src="<?= base_url('assets/img/log.png'); ?>" alt="Logo Kriminalitas" class="img-fluid" style="max-height: 120px;">
        </div>

        <h5 class="fw-bold" style="font-family: 'Anton', sans-serif; font-size: 1.7rem; color: rgb(0, 0, 0);">
            PETA-KRIM LOHBENER
        </h5>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger mt-3">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success mt-3">
                <?= session()->getFlashdata('success'); ?>
            </div>
        <?php endif; ?>

        <hr>

        <!-- Ubah action ke /login -->
        <form action="/login" method="post">
            <div class="form-group mb-3 text-start">
                <label for="email" class="fw-bold">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan email Anda" required>
            </div>

            <div class="form-group mb-3 text-start">
                <label for="password" class="fw-bold">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan password Anda" required>
            </div>

            <button type="submit" class="btn btn-warning w-100 fw-bold">LOG IN</button>
        </form>

        <div class="text-center mt-3">
            <a href="/register" class="text-decoration-none text-dark">Belum punya akun? Daftar di sini</a>
        </div>
    </div>
</div>