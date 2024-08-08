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
                                <?php if (in_groups('superadmin')) { ?>
                                    <a href="<?= base_url(); ?>mitra" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    <?php } else {
                                    $username = user()->username;
                                    $db      = \Config\Database::connect();
                                    $builder = $db->table('mitra');
                                    $mitra =  $builder->where('username', $username)->get()->getFirstRow();
                                    if ($mitra) {
                                    ?>
                                    <a href="<?= base_url(); ?>pelanggan/pelangganmitra/<?= $mitra->id_mitra; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                <?php }
                                } ?>
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
                                <?php if (in_groups('superadmin')) { ?>
                                    <a href="<?= base_url(); ?>pelanggan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    <?php } else {
                                    $username = user()->username;
                                    $db      = \Config\Database::connect();
                                    $builder = $db->table('mitra');
                                    $mitra =  $builder->where('username', $username)->get()->getFirstRow();
                                    if ($mitra) {
                                    ?>
                                        <a href="<?= base_url(); ?>pelanggan/pelangganmitra/<?= $mitra->id_mitra; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                <?php }
                                } ?>
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
                        <div class="col-lg-3 col-md-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?= $jml_pelanggan_mitra; ?></h3>

                                    <p>Jumlah <br />Pelanggan</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-md-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>Rp. <?= number_format($total_ppn); ?></h3>

                                    <p>Jumlah PPN <br />yang Dibayarkan Bulan Ini</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-md-6">
                            <!-- small box -->
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <h3>Rp. <?= number_format($total_bhp); ?></h3>

                                    <p>Jumlah BHP, USO dan Admin <br />yang Dibayarkan Bulan Ini</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-md-6">
                            <!-- small box -->
                            <div class="small-box bg-pink">
                                <div class="inner">
                                    <h3><i class="fas fa-download"></i></h3>

                                    <p>Unduh Rekap <br />BHP, USO, Admin, PPN</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-download"></i>
                                </div>
                                <a href="#" data-target="#bhpModal" data-toggle="modal" class="small-box-footer" title="Download BHP">Download <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="bhpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <form action="<?= base_url(); ?>mitra/downloadbhp" method="post">
                            <input type="hidden" name="id_mitra" value="<?= $id_mitra; ?>">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Downloads BHP</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="list-group-item p-3">
                                            <div class="row align-items-start">
                                                <div class="col-md-4 mb-8pt mb-md-0">
                                                    <div class="media align-items-left">
                                                        <div class="d-flex flex-column media-body media-middle">
                                                            <span class="card-title" style="font-size:16px">Pilih Tahun</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col mb-8pt mb-md-0">
                                                    <select name="tahun" class="form-control" data-toggle="select">
                                                        <?php
                                                        $bulan_sekarang = date("m");
                                                        $tahun_sekarang = date("Y");
                                                        $db      = \Config\Database::connect();
                                                        $builder = $db->table("tagihan");
                                                        $tahun_pekerjaan = $builder->select("tahun")
                                                            ->groupBy("tahun")
                                                            ->get()->getResultArray();
                                                        foreach ($tahun_pekerjaan as $row1) :
                                                        ?>
                                                            <option <?= $tahun_sekarang == $row1["tahun"] ? "selected" : ""; ?> value="<?= $row1["tahun"] ?>"><?= $row1["tahun"] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="row align-items-start">
                                                <div class="col-md-4 mb-8pt mb-md-0">
                                                    <div class="media align-items-left">
                                                        <div class="d-flex flex-column media-body media-middle">
                                                            <span class="card-title" style="font-size:16px">Pilih Bulan</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col mb-8pt mb-md-0">
                                                    <select name="bulan" class="form-control" data-toggle="select">
                                                        <?php $bulan = date("m"); ?>
                                                        <option <?= $bulan == "01" ? "selected" : ""; ?> value="01">Januari</option>
                                                        <option <?= $bulan == "02" ? "selected" : ""; ?> value="02">Februari</option>
                                                        <option <?= $bulan == "03" ? "selected" : ""; ?> value="03">Maret</option>
                                                        <option <?= $bulan == "04" ? "selected" : ""; ?> value="04">April</option>
                                                        <option <?= $bulan == "05" ? "selected" : ""; ?> value="05">Mei</option>
                                                        <option <?= $bulan == "06" ? "selected" : ""; ?> value="06">Juni</option>
                                                        <option <?= $bulan == "07" ? "selected" : ""; ?> value="07">Juli</option>
                                                        <option <?= $bulan == "08" ? "selected" : ""; ?> value="08">Agustus</option>
                                                        <option <?= $bulan == "09" ? "selected" : ""; ?> value="09">September</option>
                                                        <option <?= $bulan == "10" ? "selected" : ""; ?> value="10">Oktober</option>
                                                        <option <?= $bulan == "11" ? "selected" : ""; ?> value="11">November</option>
                                                        <option <?= $bulan == "12" ? "selected" : ""; ?> value="12">Desember</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Download Data</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
                                <?php
                                    $username = user()->username;
                                    $db      = \Config\Database::connect();
                                    $builder = $db->table('mitra');
                                    $mitra =  $builder->where('username', $username)->get()->getFirstRow();
                                    if ($mitra) {
                                    ?>
                                        <a href="<?= base_url(); ?>pelanggan/pelangganmitra/<?= $mitra->id_mitra; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                <?php } ?>
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
                                <?php
                                    $username = user()->username;
                                    $db      = \Config\Database::connect();
                                    $builder = $db->table('mitra');
                                    $mitra =  $builder->where('username', $username)->get()->getFirstRow();
                                    if ($mitra) {
                                    ?>
                                        <a href="<?= base_url(); ?>pelanggan/pelangganmitra/<?= $mitra->id_mitra; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                <?php } ?>
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