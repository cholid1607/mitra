<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <?php if (in_groups('superuser')) : ?>
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><b>Statistik</b></h3>

                    <div class="card-tools">
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-lg-12 row">
                        <!-- ./col -->
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?= $jml_mitra; ?></h3>

                                    <p>Jumlah Mitra</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <a href="<?= base_url(); ?>mitra" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?= $jml_pelanggan; ?></h3>

                                    <p>Jumlah Pelanggan</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <a href="<?= base_url(); ?>pelanggan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?= $jml_users; ?></h3>

                                    <p>Jumlah User Aktif</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <a href="<?= base_url(); ?>users" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- Default box -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><b>Daftar Tagihan Pelanggan Mitra <?= date('F') . ' ' . date('Y'); ?></b></h3>
                    <div class="card-tools">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped dataTable dtr-inline collapsed" id="daftar-mitra-tagihan" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th width="10%" class="text-center">Kode Mitra</th>
                                    <th width="10%" class="text-center">Nama Mitra</th>
                                    <th width="15%" class="text-center">Alamat</th>
                                    <th width="15%" class="text-center">Jumlah Pelanggan</th>
                                    <th width="15%" class="text-center">Sudah Terbit</th>
                                    <th width="15%" class="text-center">Sudah Terbayar</th>
                                    <th width="15%" class="text-center">Total Terbayar</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><b>Grafik Jumlah Pelanggan</b></h3>
                    <div class="card-tools">
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                    <!-- jQuery -->
                    <script src="<?= base_url(); ?>plugins/jquery/jquery.min.js"></script>
                    <!-- ChartJS -->
                    <script src="<?= base_url(); ?>plugins/chart.js/Chart.min.js"></script>
                    <script>
                        $(function() {
                            /* ChartJS
                             * -------
                             * Here we will create a few charts using ChartJS
                             */
                            //- LINE CHART -
                            //--------------
                            var labels = <?php echo json_encode($chart_data['labels']); ?>;
                            var values = <?php echo json_encode($chart_data['values']); ?>;

                            var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
                            var areaChartData = {
                                labels: labels,
                                datasets: [{
                                    backgroundColor: "rgba(60,141,188,0.9)",
                                    borderColor: "rgba(255,0,0,0.8)",
                                    data: values,
                                }, ],
                            };

                            var areaChartOptions = {
                                maintainAspectRatio: false,
                                responsive: true,
                                legend: {
                                    display: false,
                                },
                            };

                            var lineChartOptions = areaChartOptions;
                            var lineChartData = areaChartData;
                            lineChartData.datasets[0].fill = false;
                            lineChartOptions.datasetFill = false;

                            var lineChart = new Chart(lineChartCanvas, {
                                type: "line",
                                data: lineChartData,
                                options: lineChartOptions,
                            });
                        });
                    </script>
                </div>
            </div>
        <?php
        endif;
        if (in_groups('mitra')) : ?>
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><b>Statistik</b></h3>

                    <div class="card-tools">
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-lg-12 row">
                        <!-- ./col -->
                        <div class="col-lg-4 col-md-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?= $jml_pelanggan_mitra; ?></h3>

                                    <p>Jumlah <br />Pelanggan</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <a href="<?= base_url(); ?>pelanggan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-4 col-md-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>Rp. <?= number_format($total_ppn); ?></h3>

                                    <p>Jumlah PPN <br />yang Dibayarkan Bulan Ini</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                                <a href="<?= base_url(); ?>pelanggan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-4 col-md-6">
                            <!-- small box -->
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <h3>Rp. <?= number_format($total_bhp); ?></h3>

                                    <p>Jumlah BHP, USO dan Admin <br />yang Dibayarkan Bulan Ini</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div>
                                <a href="<?= base_url(); ?>pelanggan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 row">
                        <!-- ./col -->
                        <div class="col-lg-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>Rp. <?= number_format($total_tagihan); ?></h3>

                                    <p>Total Tagihan Bulan Ini</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-invoice"></i>
                                </div>
                                <a href="<?= base_url(); ?>pelanggan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>Rp. <?= number_format($total_terbayar); ?></h3>

                                    <p>Total Tagihan Terbayar Bulan Ini</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <a href="<?= base_url(); ?>pelanggan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        <?php endif; ?>
    </section>
    <br />
    <!-- /.content -->
</div>
<?= $this->endSection(); ?>