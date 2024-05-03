<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update Password</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Update Password</li>
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
                <?php if (isset($validation)) { ?>
                    <div class="col-md-12">
                        <?php foreach ($validation->getErrors() as $error) : ?>
                            <div class="alert alert-warning" role="alert">
                                <i class="mdi mdi-alert-outline me-2"></i>
                                <?= esc($error) ?>
                            </div>
                        <?php endforeach ?>
                    </div>
                <?php } ?>

                <form action="<?= base_url(); ?>reset/setpassword" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <input type="hidden" name="id" class="id" value="<?= user_id(); ?>">
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input id="password" type="password" name="password" class="form-control form-control-user <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pass_confirm" class="col-sm-2 col-form-label">Ulangi Password</label>
                            <div class="col-sm-10">
                                <input id="pass_confirm" type="password" name="pass_confirm" class="form-control form-control-user <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pass_confirm" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Update Password</button>
                                <a onclick="location.replace('<?= base_url(); ?>')" class=" btn btn-default">Kembali</a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<?= $this->endSection(); ?>