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
                <?php if (session()->has('errors')) : ?>
                    <ul class="alert alert-danger">
                        <?php foreach (session('errors') as $error) : ?>
                            <li><?= $error ?></li>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
                <!-- error data -->
                <form action="<?= base_url(); ?>pembayaran/simpan" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_mitra" value="<?= $id_mitra; ?>">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="nama_bank" class="col-sm-2 col-form-label">Nama Bank</label>
                            <div class="col-sm-10">
                                <div class="input-group row">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-university"></i></span>
                                    </div>
                                    <input name="nama_bank" type="text" value="<?= old('nama_bank') ?>" class="form-control <?php if (session('errors.nama_bank')) : ?>is-invalid<?php endif ?>" id="nama_bank" placeholder="Nama Bank">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="rekening" class="col-sm-2 col-form-label">Rekening</label>
                            <div class="col-sm-10">
                                <div class="input-group row">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                    </div>
                                    <input name="rekening" type="text" value="<?= old('rekening') ?>" class="form-control <?php if (session('errors.rekening')) : ?>is-invalid<?php endif ?>" id="rekening" placeholder="Nomor Rekening">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="atas_nama" class="col-sm-2 col-form-label">Atas Nama</label>
                            <div class="col-sm-10">
                                <div class="input-group row">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input name="atas_nama" value="<?= old('atas_nama') ?>" type="text" class="form-control <?php if (session('errors.atas_nama')) : ?>is-invalid<?php endif ?>" id="atas_nama" placeholder="Atas Nama">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="btn" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-4">
                                <div class="input-group row">
                                    <input type="submit" class="btn btn-success" value="Tambah Metode">&nbsp;&nbsp;
                                    <a onclick="location.replace('<?= base_url(); ?>pembayaran')" class="btn btn-default">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <br />
    </section>
    <!-- /.content -->
</div>
<?= $this->endSection(); ?>