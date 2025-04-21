document.addEventListener('DOMContentLoaded', function () {
    const chartEl = document.getElementById('kejahatanChart');
    const ctx = chartEl.getContext('2d');

    const dataLabels = JSON.parse(chartEl.dataset.labels);
    const dataValues = JSON.parse(chartEl.dataset.values);

    const backgroundColors = dataLabels.map((_, i) => {
        const colors = [
            'rgba(214, 5, 5, 0.84)',
            'rgba(4, 44, 71, 0.9)',
            'rgb(251, 255, 0)',
            'rgb(7, 128, 21)',
            'rgba(153, 102, 255, 0.6)',
            'rgba(255, 159, 64, 0.6)',
        ];
        return colors[i % colors.length];
    });

    const borderColors = backgroundColors.map(color => {
        // untuk transparansi .6 menjadi 1 (jika ada), atau tetap jika solid
        return color.includes('0.') ? color.replace(/0\.\d+/, '1') : color;
    });

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
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: '#333',
                    font: {
                        weight: 'bold',
                        size: 12
                    },
                    formatter: Math.round
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    min: 0,
                    max: 20,
                    ticks: {
                        stepSize: 5
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
        },
        plugins: [ChartDataLabels]
    });
});
