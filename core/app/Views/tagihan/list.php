<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title; ?> (<i><?= $nama_mitra; ?></i>)</h1>
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
                <form action="<?= base_url(); ?>tagihan/tampilkan" method="post">
                    <input type="hidden" name="id_mitra" value="<?= $id_mitra; ?>">
                    <div class="form-group row">
                        <div class="col-sm-12 col-form-label">
                            <div class="input-group row">
                                <div class="col-sm-3 mt-2"><button type="submit" name="status" class="form-control btn btn-warning" value="Status Sebelumnya"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;&nbsp;Tagihan Sebelumnya</button></div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php if (session()->getFlashdata('pesan')) : ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-check"></i> <?= session()->getFlashdata('pesan'); ?>
                    </div>
                <?php endif; ?>
                <h5><b>Status Tagihan Tahun <?= date("Y"); ?></b></h5>
                <hr />
                <table class="table table-bordered table-striped dataTable dtr-inline collapsed" id="daftar-bulan" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="22%" class="text-center">Bulan</th>
                            <th width="22%" class="text-center">Status</th>
                            <th width="22%" class="text-center">Bulan</th>
                            <th width="21%" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td class="text-center">Januari</td>
                            <td class="text-center">
                                <?php if ($inv_januari != 0) { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/01/<?= date('Y'); ?>" class="btn btn-sm bg-success">
                                        <i class="fas fa-check"></i> Sudah Terbit
                                    </a>
                                <?php } else { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/01/<?= date('Y'); ?>" class="btn btn-sm bg-danger">
                                        <i class="fas fa-times-circle"></i> Belum Terbit
                                    </a>
                                <?php } ?>
                            </td>
                            <td class="text-center">Juli</td>
                            <td class="text-center">
                                <?php if ($inv_juli != 0) { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/07/<?= date('Y'); ?>" class="btn btn-sm bg-success">
                                        <i class="fas fa-check"></i> Sudah Terbit
                                    </a>
                                <?php } else { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/07/<?= date('Y'); ?>" class="btn btn-sm bg-danger">
                                        <i class="fas fa-times-circle"></i> Belum Terbit
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td class="text-center">Februari</td>
                            <td class="text-center">
                                <?php if ($inv_februari != 0) { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/02/<?= date('Y'); ?>" class="btn btn-sm bg-success">
                                        <i class="fas fa-check"></i> Sudah Terbit
                                    </a>
                                <?php } else { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/02/<?= date('Y'); ?>" class="btn btn-sm bg-danger">
                                        <i class="fas fa-times-circle"></i> Belum Terbit
                                    </a>
                                <?php } ?>
                            </td>
                            <td class="text-center">Agustus</td>
                            <td class="text-center">
                                <?php if ($inv_agustus != 0) { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/08/<?= date('Y'); ?>" class="btn btn-sm bg-success">
                                        <i class="fas fa-check"></i> Sudah Terbit
                                    </a>
                                <?php } else { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/08/<?= date('Y'); ?>" class="btn btn-sm bg-danger">
                                        <i class="fas fa-times-circle"></i> Belum Terbit
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td class="text-center">Maret</td>
                            <td class="text-center">
                                <?php if ($inv_maret != 0) { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/03/<?= date('Y'); ?>" class="btn btn-sm bg-success">
                                        <i class="fas fa-check"></i> Sudah Terbit
                                    </a>
                                <?php } else { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/03/<?= date('Y'); ?>" class="btn btn-sm bg-danger">
                                        <i class="fas fa-times-circle"></i> Belum Terbit
                                    </a>
                                <?php } ?>
                            </td>
                            <td class="text-center">September</td>
                            <td class="text-center">
                                <?php if ($inv_september != 0) { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/09/<?= date('Y'); ?>" class="btn btn-sm bg-success">
                                        <i class="fas fa-check"></i> Sudah Terbit
                                    </a>
                                <?php } else { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/09/<?= date('Y'); ?>" class="btn btn-sm bg-danger">
                                        <i class="fas fa-times-circle"></i> Belum Terbit
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">4</td>
                            <td class="text-center">April</td>
                            <td class="text-center">
                                <?php if ($inv_april != 0) { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/04/<?= date('Y'); ?>" class="btn btn-sm bg-success">
                                        <i class="fas fa-check"></i> Sudah Terbit
                                    </a>
                                <?php } else { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/04/<?= date('Y'); ?>" class="btn btn-sm bg-danger">
                                        <i class="fas fa-times-circle"></i> Belum Terbit
                                    </a>
                                <?php } ?>
                            </td>
                            <td class="text-center">Oktober</td>
                            <td class="text-center">
                                <?php if ($inv_oktober != 0) { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/10/<?= date('Y'); ?>" class="btn btn-sm bg-success">
                                        <i class="fas fa-check"></i> Sudah Terbit
                                    </a>
                                <?php } else { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/10/<?= date('Y'); ?>" class="btn btn-sm bg-danger">
                                        <i class="fas fa-times-circle"></i> Belum Terbit
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">5</td>
                            <td class="text-center">Mei</td>
                            <td class="text-center">
                                <?php if ($inv_mei != 0) { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/05/<?= date('Y'); ?>" class="btn btn-sm bg-success">
                                        <i class="fas fa-check"></i> Sudah Terbit
                                    </a>
                                <?php } else { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/05/<?= date('Y'); ?>" class="btn btn-sm bg-danger">
                                        <i class="fas fa-times-circle"></i> Belum Terbit
                                    </a>
                                <?php } ?>
                            </td>
                            <td class="text-center">November</td>
                            <td class="text-center">
                                <?php if ($inv_november != 0) { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/11/<?= date('Y'); ?>" class="btn btn-sm bg-success">
                                        <i class="fas fa-check"></i> Sudah Terbit
                                    </a>
                                <?php } else { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/11/<?= date('Y'); ?>" class="btn btn-sm bg-danger">
                                        <i class="fas fa-times-circle"></i> Belum Terbit
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">6</td>
                            <td class="text-center">Juni</td>
                            <td class="text-center">
                                <?php if ($inv_juni != 0) { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/06/<?= date('Y'); ?>" class="btn btn-sm bg-success">
                                        <i class="fas fa-check"></i> Sudah Terbit
                                    </a>
                                <?php } else { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/06/<?= date('Y'); ?>" class="btn btn-sm bg-danger">
                                        <i class="fas fa-times-circle"></i> Belum Terbit
                                    </a>
                                <?php } ?>
                            </td>
                            <td class="text-center">Desember</td>
                            <td class="text-center">
                                <?php if ($inv_desember != 0) { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/12/<?= date('Y'); ?>" class="btn btn-sm bg-success">
                                        <i class="fas fa-check"></i> Sudah Terbit
                                    </a>
                                <?php } else { ?>
                                    <a href="<?= base_url(); ?>tagihan/daftar/<?= $id_mitra; ?>/12/<?= date('Y'); ?>" class="btn btn-sm bg-danger">
                                        <i class="fas fa-times-circle"></i> Belum Terbit
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<?= $this->endSection(); ?>