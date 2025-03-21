<!-- ===== JAVASCRIPT ===== -->
<script>
    // variables
    const newsType = document.getElementById('newsType');
    const newsdetails = document.getElementById('newsdetails');

    // array
    let newsDataArr = [];

    // APIs
    const HEADLINES_NEWS =
        'https://berita-indo-api.vercel.app/v1/tribun-news/jabar';

    window.onload = function() {
        newsType.innerHTML = '<h1>Berita Terbaru</h1>';
        headlinesNews();
    };

    const headlinesNews = async () => {
        const response = await fetch(HEADLINES_NEWS);
        newsDataArr = [];
        if (response.status >= 200 && response.status < 300) {
            const resJson = await response.json();
            newsDataArr = resJson.data;
            console.log(newsDataArr);
        } else {
            console.log(response.status, response.statusText);
            newsdetails.innerHTML = '<h4>Data tidak ditemukan</h4>';
            return;
        }

        displayNews();
    };

    function displayNews() {
        newsDataArr.forEach((news) => {
            let col = document.createElement('div');
            col.className = 'col-sm-12 col-md-4 col-lg-3 p-2 card';

            let card = document.createElement('div');
            card.className = 'p-2';

            let image = document.createElement('img');
            image.setAttribute('height', 'matchparent');
            image.setAttribute('width', '100%');
            image.src = news.image;

            let cardBody = document.createElement('div');

            let newsHeading = document.createElement('h5');
            newsHeading.className = 'card-title';
            newsHeading.innerHTML = news.title;

            let description = document.createElement('p');
            description.className = 'text-muted';
            description.innerHTML = news.contentSnippet;

            let link = document.createElement('a');
            link.className = 'btn btn-dark';
            link.setAttribute('target', '_blank');
            link.href = news.link;
            link.innerHTML = 'Selanjutnya';

            cardBody.appendChild(newsHeading);
            cardBody.appendChild(description);
            cardBody.appendChild(link);

            card.appendChild(image);
            card.appendChild(cardBody);

            col.appendChild(card);

            newsdetails.appendChild(col);
        });
    }

    function diskusi() {
        alert("Silakan login terlebih dahulu!!");
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>