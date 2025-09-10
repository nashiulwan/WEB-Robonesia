<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<!-- Main Content -->
<div id="content">
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Analytics</h1>
        <p class="mb-4">Informasi dan data diambil dari Google Analytics.</p>

        <!-- Content Row -->
        <!-- STATISTIK LEBIH DETAIL -->
        <div class="row">
            <!-- Card: Total Pengguna Aktif -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Pengguna Aktif Belakangan Ini
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="activeUsers">-</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Card: Jumlah Sesi -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Jumlah Sesi
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalSessions">-</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Card: Rata-rata Durasi Sesi -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Durasi Per Sesi
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="avgSessionDuration">-</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Card: Perangkat yang Digunakan -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Device yang Digunakan
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="deviceUsage">-</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-mobile-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!-- CHART -->
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <!-- Area Chart: Statistik Pengunjung -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Kunjungan Terbanyak</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="visitorChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Top Pages Data -->
        <div class="row" style="display: none;">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Halaman Paling Banyak Dikunjungi</h6>
                    </div>
                    <div class="card-body">
                        <ul id="topPagesList" class="list-group">
                            <li class="list-group-item">Memuat data...</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

<!-- Fetch Data from API and Render Charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    
    
    fetch('/admin/analytics/getStatistics')
        .then(response => response.json())
        .then(data => {
            // Jika data.rows tidak ada, gunakan array kosong
            let rows = data.rows || [];
            let labels = [];
            let visitorCounts = [];
            
            rows.forEach(row => {
                labels.push(moment(row.dimensionValues[0].value).format("DD MMM")); // Tanggal
                visitorCounts.push(row.metricValues[0].value); // Jumlah Pengunjung
            });
            
            
            // Render grafik dengan Chart.js\n            let ctx = document.getElementById('visitorChart').getContext('2d');
            let chartElement = document.getElementById('visitorChart');
            if (chartElement) {
                let ctx = chartElement.getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Pengunjung',
                            data: visitorCounts,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 2,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: { title: { display: true, text: "Tanggal" } },
                            y: { title: { display: true, text: "Jumlah Pengunjung" }, beginAtZero: true }
                        }
                    }
                });
            } else {
                console.error("Canvas visitorChart tidak ditemukan di DOM");
            }

        })
        .catch(error => {
            console.error("Error fetching analytics data:", error);
        });
});

</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    fetch('/admin/analytics/getDetailedStatistics')
        .then(response => response.json())
        .then(data => {
            let rows = data.rows || [];

            let activeUsers = 0;
            let totalSessions = 0;
            let avgSessionDuration = 0;
            let deviceCounts = { desktop: 0, mobile: 0, tablet: 0 };

            rows.forEach(row => {
                let metricValues = row.metricValues;
                let dimensions = row.dimensionValues;

                // Ambil data metrik utama
                activeUsers = metricValues[0] ? metricValues[0].value : 0;
                totalSessions = metricValues[1] ? metricValues[1].value : 0;
                avgSessionDuration = metricValues[2] ? metricValues[2].value : 0;

                // Hitung perangkat yang digunakan
                if (dimensions[0].value === "desktop") {
                    deviceCounts.desktop += parseInt(metricValues[0].value);
                } else if (dimensions[0].value === "mobile") {
                    deviceCounts.mobile += parseInt(metricValues[0].value);
                } else if (dimensions[0].value === "tablet") {
                    deviceCounts.tablet += parseInt(metricValues[0].value);
                }
            });

            // Update tampilan data
            document.getElementById("activeUsers").textContent = activeUsers;
            document.getElementById("totalSessions").textContent = totalSessions;
            document.getElementById("avgSessionDuration").textContent = (avgSessionDuration / 60).toFixed(2) + " min";

            let deviceText = `
                📱 Mobile : ${deviceCounts.mobile} 
                💻 Desktop : ${deviceCounts.desktop} 
                📟 Tablet : ${deviceCounts.tablet}`;
            document.getElementById("deviceUsage").textContent = deviceText;
        })
        .catch(error => {
            console.error("Error fetching analytics data:", error);
            document.getElementById('analytics-data').innerHTML = "<p class='text-danger'>Gagal mengambil data Google Analytics</p>";
        });
});

</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    fetch('/admin/analytics/getTopPages')
        .then(response => response.json())
        .then(data => {
            let pages = data.pages || [];
            let listHtml = pages.map(page => `<li class='list-group-item'>${page.url} - ${page.visits} kunjungan</li>`).join("\n");
            document.getElementById('topPagesList').innerHTML = listHtml;
        })
        .catch(error => {
            console.error("Error fetching top pages data:", error);
            document.getElementById('topPagesList').innerHTML = "<li class='list-group-item text-danger'>Gagal mengambil data</li>";
        });
});
</script>


<?= $this->endSection() ?>
