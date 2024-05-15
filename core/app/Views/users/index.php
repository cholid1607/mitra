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
                <a href="<?= base_url(); ?>users/tambah" class="btn btn-success"><i class="fas fa-plus"></i>&nbsp;&nbsp;&nbsp;Tambah Akun&nbsp;&nbsp;&nbsp;</a>
                <br />
                <br />
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable dtr-inline collapsed" id="daftar-user" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">ID</th>
                                <th width="25%" class="text-center">Username</th>
                                <th width="30%" class="text-center">Email</th>
                                <th width="15%" class="text-center">Role</th>
                                <th width="15%" class="text-center">Status</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($users as $row) : ?>
                                <?php
                                if ($row->active == 0) {
                                    $active = '0';
                                } else {
                                    $active = '1';
                                } ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td><?= $row->username; ?></td>
                                    <td><?= $row->email; ?></td>
                                    <td class="text-center">
                                        <?php if ($row->nama_grup == 'superuser') { ?>
                                            <a href="#" class="btn btn-danger btn-sm"><?= $row->description; ?></a>
                                        <?php } else if ($row->nama_grup == 'mitra') { ?>
                                            <a href="#" class="btn btn-primary btn-sm"><?= $row->description; ?></a>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($active == 1) { ?>
                                            <a href="#" <?php if ($row->nama_grup == 'superuser') : ?> data-target="#activateModal<?= $row->id; ?>" <?php endif; ?> data-toggle="modal" class="btn btn-sm bg-success" title="Klik untuk Menonaktifkan">
                                                <i class="fas fa-check"></i> Aktif
                                            </a>
                                        <?php } else if ($active == 0) { ?>
                                            <a href="#" <?php if ($row->nama_grup == 'superuser') : ?> data-target="#activateModal<?= $row->id; ?>" <?php endif; ?> data-toggle="modal" class="btn btn-sm bg-danger" title="Klik untuk Mengaktifkan">
                                                <i class="fas fa-times-circle"></i> Tidak Aktif
                                            </a>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url(); ?>users/changePassword/<?= $row->id; ?>" class="btn btn-warning btn-circle btn-sm" title="Ubah Password">
                                            <i class="fas fa-key"></i>
                                        </a>
                                        <a href="#" data-target="#changeGroupModal<?= $row->id; ?>" data-toggle="modal" class="btn btn-success btn-circle btn-sm btn-change-role" title="Ubah Role">
                                            <i class="fas fa-tasks"></i>
                                        </a>
                                    </td>
                                </tr>

                                <div class="modal fade" id="activateModal<?= $row->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <form action="<?= base_url(); ?>/users/activate" method="post">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">Pilih "Ya" untuk mengupdate User</div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="id" class="id" value="<?= $row->id; ?>">
                                                    <input type="hidden" name="active" class="active" value="<?= $active; ?>">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                                                    <button type="submit" class="btn btn-primary">Ya</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>



                                <div class="modal fade" id="changeGroupModal<?= $row->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <form action="<?= base_url(); ?>users/changeGroup" method="post">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ubah Role</h5>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="list-group-item p-3">
                                                        <div class="row align-items-start">
                                                            <div class="col-md-4 mb-8pt mb-md-0">
                                                                <div class="media align-items-left">
                                                                    <div class="d-flex flex-column media-body media-middle">
                                                                        <span class="card-title">Role</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col mb-8pt mb-md-0">
                                                                <input type="hidden" name="id_user" class="id" value="<?= $row->id; ?>">
                                                                <select name="group" class="form-control" data-toggle="select">
                                                                    <?php
                                                                    foreach ($groups as $key => $row1) {
                                                                    ?>
                                                                        <option value="<?= $row1->id; ?>"><?= $row1->description; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="id" class="id">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Update Role</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<?= $this->endSection(); ?>