<?php
// API endpoint
$apiUrl = 'https://berita-indo-api-next.vercel.app/api/cnbc-news/';
$newsDataArr = [];

// Fetch data
$response = @file_get_contents($apiUrl);
if ($response !== FALSE) {
    $resJson = json_decode($response, true);
    if (isset($resJson['data'])) {
        // Ambil hanya 8 berita saja
        $newsDataArr = array_slice($resJson['data'], 0, 8);
    }
}
?>

<!-- Footer Content Start -->
<div class="text-center mb-4">
    <h3 class="fw-bold"><i class="bi bi-newspaper me-2 text-primary"></i>Berita & Update Terkini</h3>
</div>

<!-- News Grid -->
<div id="newsdetails" class="container py-4">
    <div class="row g-4 auto-scroll" id="newsCarousel">
        <?php if (!empty($newsDataArr)) : ?>
            <?php foreach ($newsDataArr as $news) : ?>
                <div class="col-4">
                    <div class="card h-100 shadow-sm">
                        <?php
                        // Ambil URL gambar dari array image (misalnya 'large')
                        $imageUrl = isset($news['image']) && is_array($news['image']) && isset($news['image']['large'])
                            ? $news['image']['large']
                            : 'https://via.placeholder.com/300x180.png?text=Gambar+Tidak+Tersedia';
                        ?>
                        <img src="<?= htmlspecialchars($imageUrl) ?>" class="card-img-top" alt="News Image" style="height: 180px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars(is_string($news['title'] ?? '') ? $news['title'] : '') ?></h5>
                            <p class="card-text text-muted"><?= htmlspecialchars(is_string($news['contentSnippet'] ?? '') ? $news['contentSnippet'] : '') ?></p>
                            <a href="<?= htmlspecialchars(is_string($news['link'] ?? '') ? $news['link'] : '#') ?>" target="_blank" class="btn btn-dark mt-auto">Selanjutnya</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <h4 class="text-center">Data tidak ditemukan</h4>
        <?php endif; ?>
    </div>
</div>

<!-- Optional Custom Styling -->
<style>
    body {
        background-color: #f0f0f0;
    }

    #newsdetails {
        background-color: #f0f0f0;
    }

    #newsdetails .card {
        border-radius: 12px;
        background-color: #ffffff;
        transition: transform 0.3s ease;
    }

    #newsdetails .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    h3.fw-bold {
        margin-top: 2rem;
    }

    /* Ensure the row doesn't wrap and enable horizontal scrolling */
    .row.auto-scroll {
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        scroll-behavior: smooth;
    }

    /* Ensure cards take up the correct width and don't shrink too much */
    .col-4 {
        flex: 0 0 33.333333% !important;
        max-width: 33.333333% !important;
        min-width: 250px; /* Prevent cards from becoming too narrow on very small screens */
    }

    /* Hide the scrollbar for a cleaner look (but still scrollable) */
    .row.auto-scroll::-webkit-scrollbar {
        display: none;
    }

    .row.auto-scroll {
        -ms-overflow-style: none; /* IE and Edge */
        scrollbar-width: none; /* Firefox */
    }
</style>

<!-- JavaScript for Auto Scroll -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.getElementById('newsCarousel');
    let scrollPosition = 0;
    const cardWidth = carousel.querySelector('.col-4').offsetWidth + 16; // Include gutter (g-4 = 16px)
    const maxScroll = carousel.scrollWidth - carousel.clientWidth;

    function autoScroll() {
        scrollPosition += cardWidth;
        if (scrollPosition >= maxScroll) {
            scrollPosition = 0; // Reset to start
        }
        carousel.scrollTo({
            left: scrollPosition,
            behavior: 'smooth'
        });
    }

    setInterval(autoScroll, 3000); // Scroll every 3 seconds
});
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>