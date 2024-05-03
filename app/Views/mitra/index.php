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
                <a href="<?= base_url(); ?>mitra/tambah" class="btn btn-success"><i class="fas fa-plus"></i>&nbsp;&nbsp;&nbsp;Tambah Mitra&nbsp;&nbsp;&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="<?= base_url(); ?>mitra/download" class="btn btn-primary"><i class="fas fa-download"></i>&nbsp;&nbsp;&nbsp;Download Data</a>
                <br /><br />
                <?php if (session()->getFlashdata('pesan')) : ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-check"></i> <?= session()->getFlashdata('pesan'); ?>
                    </div>
                <?php endif; ?>
                <div class="table-responsive">
                    <table style="font-size:14px" class="table table-bordered table-striped dataTable dtr-inline collapsed" id="daftar-mitra" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="10%" class="text-center">ID Mitra</th>
                                <th width="25%" class="text-center">Nama Mitra</th>
                                <th width="20%" class="text-center">Alamat</th>
                                <th width="15%" class="text-center">Status</th>
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
        <br />
    </section>
    <!-- /.content -->
</div>
<?= $this->endSection(); ?>