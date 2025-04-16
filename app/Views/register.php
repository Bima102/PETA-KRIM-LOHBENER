<div class="container py-5 my-5 d-flex justify-content-center align-items-center" style="min-height: 100vh; background-image: url('/assets/bg-blur.jpg'); background-size: cover;">
  <div class="col-md-6 col-lg-4 shadow-lg p-4 bg-white rounded text-center">
    
    <!-- Logo -->
    <div class="mb-3">
      <img src="<?= base_url('assets/img/polisi.png') ?>" alt="Logo Kriminalitas" class="img-fluid" style="max-height: 120px;">
    </div>

    <!-- Judul / Instansi -->
    <h5 class="fw-bold">PETA-KRIM LOHBENER</h5>

    <!-- Judul Form -->
    <div class="mt-3 mb-2">
      <h5 class="text-dark">Buat Akun Baru</h5>
      <p class="text-muted">Silakan isi form di bawah</p>
    </div>

    <!-- Notifikasi -->
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (isset($validation)): ?>
      <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
    <?php endif; ?>

    <hr>

    <!-- Form Register -->
    <form action="/register" method="post">
      <div class="form-group mb-3 text-start">
        <label for="firstname" class="fw-bold">Nama Depan</label>
        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Masukkan nama depan" required>
      </div>
      <div class="form-group mb-3 text-start">
        <label for="lastname" class="fw-bold">Nama Belakang</label>
        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Masukkan nama belakang" required>
      </div>
      <div class="form-group mb-3 text-start">
        <label for="email" class="fw-bold">Email</label>
        <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan email Anda" required>
      </div>
      <div class="form-group mb-3 text-start">
        <label for="password" class="fw-bold">Password</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan password Anda" required>
      </div>
      <div class="form-group mb-3 text-start">
        <label for="password_confirm" class="fw-bold">Konfirmasi Password</label>
        <input type="password" class="form-control" name="password_confirm" id="password_confirm" placeholder="Masukkan ulang password" required>
      </div>
      <button type="submit" class="btn btn-warning w-100 fw-bold">Daftar</button>
    </form>

    <div class="text-center mt-3">
      <a href="/login" class="text-decoration-none text-dark">Sudah punya akun? Login di sini</a>
    </div>
  </div>
</div>
