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
                <a href="<?= base_url(); ?>pembayaran/tambah" class="btn btn-success"><i class="fas fa-plus"></i>&nbsp;&nbsp;&nbsp;Tambah Metode Pembayaran&nbsp;&nbsp;&nbsp;</a>
                <br /><br />
                <?php if (session()->getFlashdata('pesan')) : ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-check"></i> <?= session()->getFlashdata('pesan'); ?>
                    </div>
                <?php endif; ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable dtr-inline collapsed" id="daftar-pembayaran" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="25%" class="text-center">Nama Bank</th>
                                <th width="25%" class="text-center">Rekening</th>
                                <th width="25%" class="text-center">Atas Nama</th>
                                <th width="20%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($pembayaran as $row) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="text-center"><?= $row['nama_bank']; ?></td>
                                    <td class="text-center"><?= $row['rekening']; ?></td>
                                    <td class="text-center"><?= $row['atas_nama']; ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url(); ?>pembayaran/edit/<?= $row['id_pembayaran'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i>&nbsp; Edit</a>&nbsp;&nbsp;
                                        <a href="#" data-target=" #hapusModal<?= $row['id_pembayaran'] ?>" data-toggle="modal" class="btn sm bg-danger"><i class="fas fa-trash"></i> &nbsp;Hapus</a>
                                        <div class="modal fade" id="hapusModal<?= $row['id_pembayaran'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <form action="<?= base_url(); ?>pembayaran/hapus" method="post">
                                                <input type="hidden" name="id_pembayaran" value="<?= $row['id_pembayaran'] ?>">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Hapus Data Metode Pembayaran</h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-left">Pilih "Ya" untuk menghapus Metode Pembayaran</div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                                                            <button type="submit" class="btn btn-primary">Ya</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <br />
        <!-- Default box -->
        <div class="card">
            <div class="card-body">
                <form action="<?= base_url(); ?>pembayaran/ttd" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_mitra" value="<?= $row['id_mitra']; ?>">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="nama_billing" class="col-sm-2 col-form-label">Nama Billing</label>
                            <div class="col-sm-10">
                                <div class="input-group row">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                    </div>
                                    <input style="background-color: #ffffff;" name="nama_billing" value="<?= $billing['nama_billing'] ?>" type="text" value="<?= old('nama_billing') ?>" class="form-control <?php if (session('errors.nama_billing')) : ?>is-invalid<?php endif ?>" id="nama_billing" placeholder="Nama Billing">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cap" class="col-sm-2 col-form-label">Ttd dan Cap</label>
                            <div class="col-sm-10">
                                <?php if ($billing['ttd_cap'] != '') { ?>
                                    <img style="margin-left:-8px" class="mb-2" src="<?= base_url() ?>/img/cap/<?= $billing['ttd_cap'] ?>" width="200px">
                                    <i><b>File tersimpan : </b><?= $billing['ttd_cap'] ?></i>
                                <?php } ?>
                                <div class="input-group row">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-images"></i></span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" onchange="previewImgTtdCap()" name="ttd_cap" class="custom-file-input  <?php if (session('errors.ttd_cap')) : ?>is-invalid<?php endif ?>" id="ttd_cap">
                                        <label class="custom-file-label ttd_cap_nama" for="ttd_cap">Pilih File Gambar</label>
                                    </div>
                                </div>
                                <i style="font-size:14px;">Kosongkan jika tidak ingin merubah. Ttd dan Cap maksimal memiliki dimensi 300 pixels x 100 pixels</i>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="btn" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-4">
                                <div class="input-group row">
                                    <input type="submit" class="btn btn-success" value="Update Data">&nbsp;&nbsp;
                                    <a onclick="location.replace('<?= base_url(); ?>')" class="btn btn-default">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<?= $this->endSection(); ?>