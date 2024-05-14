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
                <form action="<?= base_url(); ?>kuitansi/update" method="post">
                    <?php foreach ($kuitansi as $kuitansi) : ?>
                        <input value="<?= $kuitansi['id_kuitansi_custom'] ?>" name="id_kuitansi_custom" type="hidden">
                        <?php if ((in_groups('superuser')) || (in_groups('admin'))) : ?>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="tgl_pemasukan" class="col-sm-2 col-form-label">Tanggal Input</label>
                                    <div class="col-sm-3">
                                        <div class="input-group row">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            </div>
                                            <input value="<?= $kuitansi['tgl_kuitansi'] ?>" name="tgl_kuitansi" type="date" placeholder="yyyy/mm/dd" class="form-control" id="tanggalinstalasi" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy/mm/dd" data-mask="" inputmode="numeric">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="summernote" class="col-sm-2 col-form-label">Nama Item Layanan Tambahan</label>
                                    <div class="col-sm-10">
                                        <div class="input-group row">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-list"></i></span>
                                            </div>
                                            <textarea name="item_pemasukan" class="form-control" placeholder="Nama Item Layanan Tambahan"><?= $kuitansi['item_layanan'] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="status_ppn" class="col-sm-2 col-form-label">PPN 11%</label>
                                    <div class="col-sm-10">
                                        <div class="input-group row">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
                                            </div>
                                            <select name="status_ppn" class="form-control" id="status_ppn">
                                                <option <?= $kuitansi['ppn'] == 'Ya' ? 'selected' : '' ?> value="Ya">Ya</option>
                                                <option <?= $kuitansi['ppn'] == 'Tidak' ? 'selected' : '' ?> value="Tidak">Tidak</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nominal" class="col-sm-2 col-form-label">Nominal</label>
                                    <div class="col-sm-10">
                                        <div class="input-group row">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-money-check-alt"></i></span>
                                            </div>
                                            <input value="<?= $kuitansi['nominal'] ?>" name="nominal" type="text" class="form-control" id="nominal" placeholder="Nominal">
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
                                        <input type="submit" class="form-control btn btn-success" value="Update Kuitansi">&nbsp;&nbsp;
                                        <a onclick="location.replace('<?= base_url(); ?>kuitansi')" class=" btn btn-default">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <!-- Script -->

    </section>
    <!-- /.content -->
</div>
<?= $this->endSection(); ?>