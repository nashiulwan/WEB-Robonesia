// File: public/js/analytics.js

document.addEventListener('DOMContentLoaded', function () {
    // Fetch data for charts
    fetch('/admin/analytics/getChartData')
        .then(response => response.json())
        .then(data => {
            // Data untuk Bar Chart: Artikel per Kategori
            const categoryLabels = data.categories.map(item => item.category);
            const categoryCounts = data.categories.map(item => item.total);

            const categoryCtx = document.getElementById('categoryChart').getContext('2d');
            new Chart(categoryCtx, {
                type: 'bar',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        label: 'Jumlah Artikel',
                        data: categoryCounts,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Data untuk Line Chart: Total View per Artikel
            const viewLabels = data.views.map(item => item.title);
            const viewCounts = data.views.map(item => item.views);

            const viewCtx = document.getElementById('viewChart').getContext('2d');
            new Chart(viewCtx, {
                type: 'line',
                data: {
                    labels: viewLabels,
                    datasets: [{
                        label: 'Jumlah View',
                        data: viewCounts,
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error:', error));
});
