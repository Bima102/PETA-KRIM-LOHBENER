<?php
// API endpoint
$apiUrl = 'https://berita-indo-api.vercel.app/v1/tribun-news/jabar';
$newsDataArr = [];

// Fetch data
$response = file_get_contents($apiUrl);
if ($response !== FALSE) {
    $resJson = json_decode($response, true);
    if (isset($resJson['data'])) {
        $newsDataArr = $resJson['data'];
    }
}
?>

<!-- Footer Content Start -->
<div id="newsType" class="text-center mt-5 mb-4">
    <h1>Berita Terbaru</h1>
</div>

<!-- News Grid -->
<div id="newsdetails" class="container">
    <div class="row g-4"> <!-- Gunakan g-4 untuk spacing antar grid item -->
        <?php if (!empty($newsDataArr)) : ?>
            <?php foreach ($newsDataArr as $news) : ?>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= htmlspecialchars($news['image']) ?>" class="card-img-top" alt="News Image" style="height: 180px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($news['title']) ?></h5>
                            <p class="card-text text-muted"><?= htmlspecialchars($news['contentSnippet']) ?></p>
                            <a href="<?= htmlspecialchars($news['link']) ?>" target="_blank" class="btn btn-dark mt-auto">Selanjutnya</a>
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
    #newsdetails .card {
        border-radius: 12px;
    }
</style>

<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>
</html>
