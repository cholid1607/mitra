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
        <?= view('\Myth\Auth\Views\_message_block') ?>

        <form class="form-horizontal user" action="<?= base_url(); ?>users/save" method="post">
          <?= csrf_field() ?>
          <div class="card-body">
            <div class="form-group row">
              <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input id="inputEmail" type="email" class="form-control form-control-user <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputUsername" class="col-sm-2 col-form-label">Username</label>
              <div class="col-sm-10">
                <input type="text" id="inputUsername" class="form-control form-control-user <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputUser" class="col-sm-2 col-form-label">Nama Lengkap User</label>
              <div class="col-sm-10">
                <input type="text" id="inputUser" class="form-control form-control-user" name="nama_users" placeholder="Tuliskan Nama Lengkap Pengguna">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
              <div class="col-sm-10">
                <input type="password" id="inputPassword" name="password" class="form-control form-control-user <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputUlangiPassword" class="col-sm-2 col-form-label">Ulangi Password</label>
              <div class="col-sm-10">
                <input type="password" id="inputUlangiPassword" name="pass_confirm" class="form-control form-control-user <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputUlangiPassword" class="col-sm-2 col-form-label">&nbsp;</label>
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary btn-user">&nbsp;&nbsp;Buat Akun&nbsp;&nbsp;</button>
              </div>
            </div>

          </div>

          <!-- /.card-body -->
        </form>
      </div>
      <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<?= $this->endSection(); ?>