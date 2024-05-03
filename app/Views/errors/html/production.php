<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>T2 Netikom</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>css/adminlte.min.css">
    <link rel="shortcut icon" type="image/png" href="/t2net.png">
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <br /><br /><br /><br /><br /><br /><br />
        <section class="content">
            <div class=" error-page">
                <h2 class="headline text-danger"> 500</h2>

                <div class="error-content">
                    <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Terjadi Kesalahan Akses.</h3>

                    <p>
                        Hubungi Administrator jika ada kendala atau akun anda tidak mendapatkan izin untuk mengakses halaman ini.
                        Anda dapat kembali ke menu <a href="<?= base_url(); ?>">dashboard</a>.
                    </p>
                </div>
                <!-- /.error-content -->
            </div>
            <!-- /.error-page -->
        </section>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="<?= base_url(); ?>plugins/jquery/jquery.min.js"></script>

    <!-- InputMask -->
    <script src="<?= base_url(); ?>plugins/moment/moment.min.js"></script>
    <script src="<?= base_url(); ?>plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url(); ?>js/adminlte.min.js"></script>

</body>

</html>