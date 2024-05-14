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
                <br />
                <h5 class="text-center"><b>Pilih Mitra</b></h5>
                <hr>
                <?php if (session()->getFlashdata('pesan')) : ?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-exclamation-triangle"></i> <?= session()->getFlashdata('pesan'); ?>
                    </div>
                <?php endif; ?>
                <br />
                <form action="<?= base_url(); ?>tagihan/list" method="post">
                    <div class="form-group row">
                        <label for="akun_bank" class="col-sm-2 col-form-label">Nama Mitra</label>
                        <div class="col-sm-4">
                            <div class="input-group row">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                                </div>
                                <select id="selMitra" class="form-control" name="id_mitra">
                                    <option value="0">-- Pilih Mitra --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="akun_bank" class="col-sm-2 col-form-label">&nbsp;</label>
                        <div class="col-sm-2">
                            <div class="input-group row">
                                <button type="submit" name="tampilkan" class="form-control btn btn-success" value="Tampilkan"><i class="fas fa-eye"></i>&nbsp;Tampilkan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<?= $this->endSection(); ?>