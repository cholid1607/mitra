<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title; ?>&nbsp;<?= $pelanggan['nama_pelanggan']; ?></h1>
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
                <form action="<?= base_url(); ?>pelanggan/update" method="post">
                    <?php if ((in_groups('superuser')) || (in_groups('mitra'))) : ?>
                        <input name="id_pelanggan" value="<?= $pelanggan['id_pelanggan']; ?>" type="hidden">
                        <div class="card-body">
                            <?php if ((in_groups('superuser'))) : ?>
                                <div class="form-group row">
                                    <label for="nama_mitra" class="col-sm-2 col-form-label">Nama Mitra</label>
                                    <div class="col-sm-10">
                                        <div class="input-group row">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-tools"></i></span>
                                            </div>
                                            <select id="selMitra" class="form-control" name="id_mitra">
                                                <?php if ($id_mitra != 0) { ?>
                                                    <option value="<?= $pelanggan['id_mitra']; ?>"><?= $pelanggan['nama_mitra'] ?>&nbsp;(<?= $pelanggan['kode_mitra']; ?>)</option>
                                                <?php } ?>
                                                <option value="0">-- Pilih Mitra --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="form-group row">
                                <label for="kodepelanggan" class="col-sm-2 col-form-label">Kode Pelanggan</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                        </div>
                                        <input name="kode_pelanggan" value="<?= $pelanggan['kode_pelanggan']; ?>" type="text" class="form-control" id="kodepelanggan" placeholder="Kode Pelanggan">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="namapelanggan" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input name="nama_pelanggan" value="<?= $pelanggan['nama_pelanggan']; ?>" type="text" class="form-control" id="namapelanggan" placeholder="Nama Pelanggan">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nik" class="col-sm-2 col-form-label">NIK</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        </div>
                                        <input name="nik_pelanggan" value="<?= $pelanggan['nik_pelanggan']; ?>" type="text" class="form-control" id="nik" placeholder="NIK Pelanggan">
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
                                        <textarea name="alamat_pelanggan" class="form-control" id="alamat" placeholder="Alamat Pelanggan"><?= $pelanggan['alamat_pelanggan']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telepon" class="col-sm-2 col-form-label">Telepon</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input name="telp_pelanggan" value="<?= $pelanggan['telp_pelanggan']; ?>" type="text" class="form-control" id="telepon" placeholder="Telepon Pelanggan">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="paketlangganan" class="col-sm-2 col-form-label">Paket Langganan</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-list"></i></span>
                                        </div>
                                        <input name="paket_langganan" value="<?= $pelanggan['paket_langganan']; ?>" type="text" class="form-control" id="paketlangganan" placeholder="Paket Langganan">
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
                                        <input name="bandwidth" value="<?= $pelanggan['bandwidth']; ?>" type="text" class="form-control" id="bandwidth" placeholder="Bandwidth Pelanggan">
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
                                        <input name="harga" type="text" class="form-control number-separator" id="result_input" value="<?= $pelanggan['harga']; ?>" placeholder="Nominal Pelanggan">
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
                                            <option <?= $pelanggan['ppn'] != 0 ? 'selected' : ''; ?> value="Ya">Ya</option>
                                            <option <?= $pelanggan['ppn'] == 0 ? 'selected' : ''; ?> value="Tidak">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nominal" class="col-sm-2 col-form-label">Nominal</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        Rp.<?= number_format($pelanggan['nominal']); ?>

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
                                            <option value="prabayar" <?= $pelanggan['ket_pelanggan'] == 'prabayar' ? 'selected' : '' ?>>Prabayar</option>
                                            <option value="pascabayar" <?= $pelanggan['ket_pelanggan'] == 'pascabayar' ? 'selected' : '' ?>>Pascabayar</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="btn" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-3">
                                <div class="input-group row">
                                    <input type="submit" class="btn btn-success" value="Update Data">&nbsp;&nbsp;
                                    <a onclick="location.replace('<?= base_url(); ?>pelanggan')" class=" btn btn-default">Kembali</a>
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