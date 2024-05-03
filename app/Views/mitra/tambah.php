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
                <form action="<?= base_url(); ?>mitra/simpan" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="kodemitra" class="col-sm-2 col-form-label">Kode Mitra</label>
                            <div class="col-sm-10">
                                <div class="input-group row">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                    </div>
                                    <input name="kode_mitra" type="text" value="<?= old('kode_mitra') ?>" class="form-control <?php if (session('errors.kode_mitra')) : ?>is-invalid<?php endif ?>" id="kode_mitra" placeholder="Kode Mitra">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="namamitra" class="col-sm-2 col-form-label">Nama Mitra</label>
                            <div class="col-sm-10">
                                <div class="input-group row">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-handshake"></i></span>
                                    </div>
                                    <input name="nama_mitra" value="<?= old('nama_mitra') ?>" type="text" class="form-control <?php if (session('errors.nama_mitra')) : ?>is-invalid<?php endif ?>" id="nama_mitra" placeholder="Nama Mitra">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="penanggungjawab" class="col-sm-2 col-form-label">Penanggung Jawab</label>
                            <div class="col-sm-10">
                                <div class="input-group row">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user-cog"></i></span>
                                    </div>
                                    <input name="penanggung_jawab" value="<?= old('penanggung_jawab') ?>" type="text" class="form-control <?php if (session('errors.penanggung_jawab')) : ?>is-invalid<?php endif ?>" id="penanggungjawab" placeholder="Nama Penanggung Jawab">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <div class="input-group row">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <textarea name="alamat" class="form-control <?php if (session('errors.alamat')) : ?>is-invalid<?php endif ?>" id="alamat" placeholder="Alamat Mitra"><?= old('alamat') ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telepon" class="col-sm-2 col-form-label">Telepon</label>
                            <div class="col-sm-10">
                                <div class="input-group row">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><b>+62</b></span>
                                    </div>
                                    <input name="telepon" value="<?= old('telepon') ?>" type="text" class="form-control <?php if (session('errors.telepon')) : ?>is-invalid<?php endif ?>" id="telepon" placeholder="89123456789">
                                </div>
                                <i style="font-size:14px;">Hilangkan angka 0 yang ada di paling depan. Contoh : 089123456789 ditulis 89123456789</i>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="logo" class="col-sm-2 col-form-label">Logo</label>
                            <div class="col-sm-10">
                                <div class="input-group row">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-images"></i></span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" onchange="previewImg()" name="logo" class="custom-file-input  <?php if (session('errors.telepon')) : ?>is-invalid<?php endif ?>" id="logo">
                                        <label class="custom-file-label" for="logo">Pilih File Gambar</label>
                                    </div>
                                </div>
                                <i style="font-size:14px;">Logo maksimal memiliki dimensi 300 pixels x 100 pixels</i>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="btn" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-4">
                                <div class="input-group row">
                                    <input type="submit" class="btn btn-success" value="Tambah Mitra">&nbsp;&nbsp;
                                    <a onclick="location.replace('<?= base_url(); ?>mitra')" class="btn btn-default">Kembali</a>
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