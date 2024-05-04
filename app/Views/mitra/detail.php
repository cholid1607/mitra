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
                <!-- error data -->
                <div class="card-body">
                    <div class="form-group row">
                        <label for="kodemitra" class="col-sm-2 col-form-label">Kode Mitra</label>
                        <div class="col-sm-10">
                            <div class="input-group row">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                </div>
                                <input disabled style="background-color: #ffffff;" name="kode_mitra" value="<?= $mitra[0]['kode_mitra'] ?>" type="text" value="<?= old('kode_mitra') ?>" class="form-control <?php if (session('errors.kode_mitra')) : ?>is-invalid<?php endif ?>" id="kode_mitra" placeholder="Kode Mitra">
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
                                <input disabled style="background-color: #ffffff;" name="nama_users" value="<?= $mitra[0]['nama_mitra'] ?>" type="text" class="form-control <?php if (session('errors.nama_mitra')) : ?>is-invalid<?php endif ?>" id="nama_mitra" placeholder="Nama Mitra">
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
                                <input disabled style="background-color: #ffffff;" name="penanggung_jawab" value="<?= $mitra[0]['penanggung_jawab'] ?>" type="text" class="form-control <?php if (session('errors.penanggung_jawab')) : ?>is-invalid<?php endif ?>" id="penanggungjawab" placeholder="Nama Penanggung Jawab">
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
                                <textarea disabled style="background-color: #ffffff;" name="alamat" class="form-control <?php if (session('errors.alamat')) : ?>is-invalid<?php endif ?>" id="alamat" placeholder="Alamat Mitra"><?= $mitra[0]['alamat'] ?></textarea>
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
                                <input disabled style="background-color: #ffffff;" name="telepon" value="<?= $mitra[0]['telepon'] ?>" type="text" class="form-control <?php if (session('errors.telepon')) : ?>is-invalid<?php endif ?>" id="telepon" placeholder="89123456789">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="logo" class="col-sm-2 col-form-label">Logo</label>
                        <div class="col-sm-10">
                            <?php if ($mitra[0]['logo'] != '') { ?>
                                <img style="margin-left:-8px" class="mb-2" src="<?= base_url() ?>/img/logo/<?= $mitra[0]['logo'] ?>" width="200px">
                            <?php } else {
                                echo "Gambar Tidak Tersedia";
                            } ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="btn" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4">
                            <div class="input-group row">
                                <a onclick="location.replace('<?= base_url(); ?>mitra')" class="btn btn-default">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <br />
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Log Pelanggan</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="20%" class="text-center">Tanggal</th>
                            <th width="75%" class="text-center">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (!empty($log)) {
                            foreach ($log as $row) :
                        ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="text-center"><?= $row['tgl']; ?></td>
                                    <td><?= $row['deskripsi']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="3" class="text-center">Data Tidak Ditemukan</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br />
    </section>
    <!-- /.content -->
</div>
<?= $this->endSection(); ?>