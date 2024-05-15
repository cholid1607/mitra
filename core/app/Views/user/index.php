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
    </section>
    <!-- /.content -->
</div>
<?= $this->endSection(); ?>