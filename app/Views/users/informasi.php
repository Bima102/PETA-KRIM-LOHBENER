<div class="container mt-5">
  <h2 class="text-center mb-4">Jenis Kejahatan</h2>
  <div class="row g-4">
    <?php 
    $data = [
        [
            "img" => "pencuri.jpg",
            "title" => "Pencurian Biasa (CUBIS)",
            "desc" => "Pencurian biasa, sebagaimana diatur dalam Pasal 362 KUHP, adalah tindakan mengambil barang milik orang lain dengan maksud untuk memilikinya secara melawan hukum. Tindakan ini mencakup unsur-unsur seperti perbuatan mengambil, objek berupa barang, kepemilikan oleh orang lain, dan niat untuk memiliki secara melawan hukum...",
            "url" => "https://www.hukumonline.com/klinik/a/ini-bunyi-pasal-362-kuhp-tentang-pencurian-lt65802c0e6e0f9/" 
        ],
        [
            "img" => "malingmotor.jpg",
            "title" => "Pencurian Kendaraan Bermotor (CURANMOR)",
            "desc" => "​Pencurian kendaraan bermotor (curanmor) adalah tindakan mengambil kendaraan bermotor milik orang lain secara melawan hukum dengan tujuan memiliki atau menjualnya kembali. Modus operandi yang umum digunakan antara lain merusak kunci kontak, memecahkan kaca kendaraan, atau menggunakan kunci palsu. Kasus curanmor seringkali menimbulkan kerugian material yang signifikan bagi korban, serta menurunkan rasa aman dalam masyarakat. ...",
            "url" => "https://www.liputan6.com/feeds/read/5922507/memahami-makna-curanmor-sebuah-kejahatan-pencurian-kendaraan-bermotor?"
        ],
        [
            "img" => "begal.jpg",
            "title" => "Pencurian Dengan Kekerasan (CURAS)",
            "desc" => "Pencurian dengan kekerasan (curas) adalah tindakan mengambil barang milik orang lain dengan menggunakan ancaman atau kekerasan fisik, seringkali disertai dengan pembunuhan. Berbeda dengan pencurian biasa yang dilakukan secara diam-diam, curas melibatkan kekerasan langsung terhadap korban untuk mencapai tujuan pelaku...",
            "url" => "https://www.detik.com/hikmah/khazanah/d-6639301/hudud-pengertian-dan-penerapan-hukumnya-di-indonesia?"
        ],
        [
            "img" => "Pencurianp.jpg",
            "title" => "Pencurian Dengan Pemberatan (CURAT)",
            "desc" => "​Pencurian dengan pemberatan (curat) adalah tindakan mengambil barang milik orang lain dengan cara memasuki rumah atau bangunan korban, biasanya dengan merusak pintu atau jendela, untuk mengambil barang berharga. Modus operandi ini sering melibatkan perencanaan dan pengamatan terhadap target sebelum aksi dilakukan...",
            "url" => "https://news.detik.com/berita/d-7015208/polres-metro-bekasi-ungkap-13-kasus-pidana-pencurian-hingga-pembunuhan?"
        ],
        [
            "img" => "pembunuhan.jpg",
            "title" => "Pembunuhan",
            "desc" => "​Pembunuhan adalah tindakan sengaja yang mengakibatkan hilangnya nyawa seseorang, dilakukan dengan niat oleh pelakunya. Unsur utama dalam pembunuhan adalah adanya niat atau kesengajaan dari pelaku untuk menghilangkan nyawa korban. Dalam hukum Indonesia, pembunuhan dibagi menjadi beberapa kategori, antara lain pembunuhan biasa, pembunuhan dengan pemberatan, dan pembunuhan berencana, yang masing-masing memiliki unsur dan konsekuensi hukum yang berbeda...",
            "url" => "https://www.detik.com/hikmah/khazanah/d-7090974/diyat-pengertian-faktor-jenis-dan-hikmahnya?"
        ]
    ];

    foreach ($data as $item) : ?>
      <div class="col-md-6 col-lg-4">
        <div class="card crime-card">
          <img src="<?= base_url(); ?>/assets/img/<?= $item['img']; ?>" class="card-img-top" alt="<?= $item['title']; ?>" />
          <div class="card-body">
            <h5 class="card-title"><?= $item['title']; ?></h5>
            <p class="card-text"><?= $item['desc']; ?></p>
            <a href="<?= $item['url']; ?>" class="btn btn-dark btn-sm" target="_blank">Selengkapnya</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
