<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<!-- Main Content -->
<div id="content">
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Analytics</h1>
        <p class="mb-4">Informasi analitik mengenai artikel seperti jumlah artikel, jumlah view, dan lainnya.</p>

        <!-- Content Row -->
        <div class="row">

            <div class="col-xl-8 col-lg-7">

                <!-- Area Chart: Total View per Artikel -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Total View per Artikel</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="viewChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Bar Chart: Artikel per Kategori -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Artikel per Kategori</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-bar">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

<?= $this->endSection() ?>
