<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
  <div class="col-md-6 col-lg-4 shadow-lg p-4 bg-white rounded">
    <div class="text-center mb-4">
      <h3 class="text-primary">Selamat Datang</h3>
      <p class="text-muted">Silakan login terlebih dahulu untuk melanjutkan</p>
    </div>

    <!-- Notifikasi -->
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <hr>

    <form action="/index" method="post">
      <div class="form-group mb-3">
        <label for="email" class="fw-bold">Email</label>
        <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan email Anda" required>
      </div>
      <div class="form-group mb-3">
        <label for="password" class="fw-bold">Password</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan password Anda" required>
      </div>
      <div class="d-flex justify-content-between align-items-center">
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </div>
    </form>

    <div class="text-center mt-3">
      <a href="/register" class="text-decoration-none">Belum punya akun? Daftar di sini</a>
    </div>
  </div>
</div>
