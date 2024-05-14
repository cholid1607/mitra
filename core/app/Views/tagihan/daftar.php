<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title; ?> <?= $bulan; ?> <?= $tahun; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dasboard</a></li>
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-body">
                <?php if ($tagihan == null) { ?>
                    <div class="col-sm-3 mb-4">
                        <form action="<?= base_url(); ?>tagihan/generate" method="post">
                            <input type="hidden" name="bulan" value="<?= $bulan_angka; ?>">
                            <input type="hidden" name="tahun" value="<?= $tahun; ?>">
                            <input type="hidden" name="id_mitra" value="<?= $id_mitra; ?>">
                            <div class="row">
                                <button type="submit" class="btn btn-success"><i class="fas fa-list-alt"></i>&nbsp;&nbsp;&nbsp;Genarate Tagihan <?= $bulan; ?>&nbsp;&nbsp;&nbsp;</button>
                            </div>
                        </form>
                    </div>
                <?php } ?>
                <?php if (session()->getFlashdata('pesan')) : ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-check"></i> <?= session()->getFlashdata('pesan'); ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-exclamation-triangle"></i> <?= session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable dtr-inline collapsed" id="daftar-tagihan" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="10%" class="text-center">Kode Pelanggan</th>
                                <th width="20%" class="text-center">Nama Pelanggan</th>
                                <th width="20%" class="text-center">Nominal</th>
                                <th width="15%" class="text-center">Invoice</th>
                                <th width="15%" class="text-center">Kuitansi</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<?= $this->endSection(); ?>