document.addEventListener('DOMContentLoaded', function () {
    const chartEl = document.getElementById('kejahatanChart');
    const ctx = chartEl.getContext('2d');

    const dataLabels = JSON.parse(chartEl.dataset.labels);
    const dataValues = JSON.parse(chartEl.dataset.values);

    // Generate warna random yang konsisten
    const backgroundColors = dataLabels.map((_, i) => {
        const colors = [
            'rgba(255, 99, 132, 0.6)',   // merah
            'rgba(54, 162, 235, 0.6)',  // biru
            'rgba(255, 206, 86, 0.6)',  // kuning
            'rgba(75, 192, 192, 0.6)',  // hijau
            'rgba(153, 102, 255, 0.6)', // ungu
            'rgba(255, 159, 64, 0.6)',  // oranye
        ];
        return colors[i % colors.length]; // putar jika lebih dari 6 data
    });

    const borderColors = backgroundColors.map(color => color.replace('0.6', '1'));

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: dataLabels,
            datasets: [{
                label: 'Jumlah Kasus',
                data: dataValues,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1,
                borderRadius: 8,
                barThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Jumlah: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Kasus',
                        color: '#555'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Jenis Kejahatan',
                        color: '#555'
                    }
                }
            }
        }
    });
});
