<!-- Hero Section -->
<div class="jumbotron hero text-white">
  <div class="container text-center" data-aos="fade-up">
    <h1 class="fw-bold mb-2">Hi, <?= session()->get('firstname') ?></h1>
    <h2 class="display-6 fw-semibold mb-3 text-light">Selamat datang di</h2>
    <h1 class="display-5 fw-bold mb-3 text-white">Sistem Pemetaan Wilayah Rawan Kriminalitas</h1>
    <h2 class="display-6 fw-bold mb-2 text-light">di Kecamatan Lohbener Berbasis Web</h2>
    <h3 class="display-6 fw-bold" style="color: #ffc107;">(PETA-KRIM LOHBENER)</h3>
  </div>
</div>


<!-- Timeline Section -->
<div class="container my-5">
  <h2 class="text-center fw-bold mb-5" data-aos="fade-up">
    <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
    Langkah Pencegahan Kriminalitas
  </h2>

  <div class="timeline" data-aos="fade-up" data-aos-delay="100">
    
    <div class="timeline-item mb-4">
      <div class="timeline-icon bg-primary shadow"><i class="bi bi-shield-lock-fill text-white"></i></div>
      <div class="timeline-content shadow-sm rounded-3 p-4 bg-light">
        <h4 class="fw-bold mb-2">Lapor Polisi</h4>
        <p class="mb-0">
          <i class="bi bi-telephone-fill text-primary me-2"></i>
          Segera laporkan kejadian mencurigakan atau tindakan kejahatan ke pihak berwajib untuk tindakan cepat dan tepat.
        </p>
      </div>
    </div>

    <div class="timeline-item mb-4">
      <div class="timeline-icon bg-success shadow"><i class="bi bi-eye-fill text-white"></i></div>
      <div class="timeline-content shadow-sm rounded-3 p-4 bg-light">
        <h4 class="fw-bold mb-2">Aktif dalam Ronda</h4>
        <p class="mb-0">
          <i class="bi bi-people-fill text-success me-2"></i>
          Partisipasi dalam ronda malam adalah bentuk kepedulian warga terhadap keamanan lingkungan sekitar.
        </p>
      </div>
    </div>

    <div class="timeline-item mb-4">
      <div class="timeline-icon bg-warning shadow"><i class="bi bi-camera-video-fill text-white"></i></div>
      <div class="timeline-content shadow-sm rounded-3 p-4 bg-light">
        <h4 class="fw-bold mb-2">Pemasangan CCTV</h4>
        <p class="mb-0">
          <i class="bi bi-camera-fill text-warning me-2"></i>
          Pasang CCTV di titik rawan sebagai langkah pencegahan dan dokumentasi bila terjadi kejadian mencurigakan.
        </p>
      </div>
    </div>

  </div>
</div>
