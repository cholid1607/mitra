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
                <form action="<?= base_url(); ?>pelanggan/simpan" method="post">
                    <input type="hidden" name="id_mitra" value="<?= $id_mitra; ?>">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="namapelanggan" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                            <div class="col-sm-10">
                                <div class="input-group row">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input required name="nama_pelanggan" type="text" value="<?= old('nama_pelanggan') ?>" class="form-control" id="namapelanggan" placeholder="Nama Pelanggan">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nik" class="col-sm-2 col-form-label">NIK/NPWP</label>
                            <div class="col-sm-10">
                                <div class="input-group row">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    </div>
                                    <input required name="nik_pelanggan" type="text" value="<?= old('nik_pelanggan') ?>" class="form-control" id="nik" placeholder="NIK Pelanggan">
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
                                    <textarea required name="alamat_pelanggan" class="form-control" id="alamat" placeholder="Alamat Pelanggan"><?= old('alamat_pelanggan') ?></textarea>
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
                                    <input required name="telp_pelanggan" type="text" value="<?= old('telp_pelanggan') ?>" class="form-control" id="telepon" placeholder="89123456789">
                                </div>
                                <i style="font-size:14px;">Hilangkan angka 0 yang ada di paling depan. Contoh : 089123456789 ditulis 89123456789</i>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="paketlangganan" class="col-sm-2 col-form-label">Paket Langganan</label>
                            <div class="col-sm-10">
                                <div class="input-group row">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-list"></i></span>
                                    </div>
                                    <input name="paket_langganan" type="text" value="<?= old('paket_langganan') ?>" class="form-control" id="paketlangganan" placeholder="Paket Langganan">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bandwidth" class="col-sm-2 col-form-label">Bandwidth</label>
                            <div class="col-sm-10">
                                <div class="input-group row">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-signal"></i></span>
                                    </div>
                                    <input name="bandwidth" type="text" value="<?= old('bandwidth') ?>" class="form-control" id="bandwidth" placeholder="Bandwidth Pelanggan">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nominal" class="col-sm-2 col-form-label">Harga</label>
                            <div class="col-sm-10">
                                <div class="input-group row">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    </div>
                                    <input required name="harga" type="text" value="<?= old('harga') ?>" class="form-control" id="result_input" placeholder="Nominal Pelanggan">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nominal" class="col-sm-2 col-form-label">PPN 11%</label>
                            <div class="col-sm-10">
                                <div class="input-group row">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                                    </div>
                                    <select required name="status_ppn" class="form-control" id="prioritas">
                                        <option value="Ya">Ya</option>
                                        <option value="Tidak">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="keteranganpelanggan" class="col-sm-2 col-form-label">Ket. Pelanggan</label>
                            <div class="col-sm-10">
                                <div class="input-group row">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-newspaper"></i></span>
                                    </div>
                                    <select name="ket_pelanggan" class="form-control" id="keteranganpelanggan">
                                        <option value="prabayar">Prabayar</option>
                                        <option value="pascabayar">Pascabayar</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="btn" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4">
                            <div class="input-group row">
                                <input type="submit" class="btn btn-success" value="Tambah Pelanggan">&nbsp;&nbsp;
                                <a onclick="location.replace('<?= base_url(); ?>pelanggan')" class="btn btn-default">Kembali</a>
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