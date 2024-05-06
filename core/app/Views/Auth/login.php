<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>T2 Net | Tiketing</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url(); ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url(); ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>/css/adminlte.min.css">
    <link rel="shortcut icon" type="image/png" href="/t2net.png">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img width="60%" src="<?= base_url(); ?>/logo-t2net-hd.png"><br />
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <?= view('Myth\Auth\Views\_message_block') ?>
            <form action="<?= url_to('login') ?>" method="post">
                <?= csrf_field() ?>
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Masukkan Username dan Password Anda</p>

                    <form action="<?= base_url(); ?>/index3.html" method="post">

                        <?php if ($config->validFields === ['email']) : ?>
                            <div class="input-group mb-3">
                                <input type="email" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?= lang('Auth.email') ?>">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="input-group mb-3">
                                <input type="text" required class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?= lang('Auth.emailOrUsername') ?>">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-users"></span>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="input-group mb-3">
                            <input type="password" required name="password" class="form-control  <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <?php if ($config->allowRemembering) : ?>
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="remember" checked name="remember" <?php if (old('remember')) : ?> checked <?php endif ?>>
                                        <label for="remember">
                                            <?= lang('Auth.rememberMe') ?>
                                        </label>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.loginAction') ?></button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                    <?php if ($config->allowRegistration) : ?>
                        <p><a href="<?= url_to('register') ?>"><?= lang('Auth.needAnAccount') ?></a></p>
                    <?php endif; ?>
                </div>
                <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url(); ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url(); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url(); ?>/js/adminlte.min.js"></script>
</body>

</html>