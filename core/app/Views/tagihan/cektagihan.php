<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mitra T2 Netikom</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>css/adminlte.min.css">
    <link rel="shortcut icon" type="image/png" href="/t2net.png">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/summernote/summernote-bs4.min.css">

    <!-- Select2 
    <link rel="stylesheet" href="<?php // base_url(); 
                                    ?>plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php // base_url(); 
                                    ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    -->

    <!-- Select2 CSS -->
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/plugins/select2new/dist/css/select2.css" />
</head>

<body>
    <div class="wrapper">
        <!-- Main content -->
        <section class="content">
            <br />
            <br />
            <br />
            <div class="error-page">
                <?php if ($tagihan == null) { ?>
                    <h2 class="headline text-warning"> 404</h2>

                    <div class="error-content">
                        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Data Invoice Tidak Ditemukan.</h3>

                        <p>
                            Mohon maaf data invoice tidak ditemukan, silahkan hubungi admin mitra T2Net untuk konfirmasi lebih lanjut.<br />
                            Terima Kasih.
                        </p>
                    </div>
                <?php } else { ?>
                    <h2 class="headline text-success"> OK</h2>
                    <div class="error-content">
                        <h3><i class="fas fa-check-circle text-success"></i> Data Invoice Ditemukan.</h3>

                        <p>
                        <table>
                            <tr>
                                <td>Nomor Invoice</td>
                                <td>: <?= $tagihan['no_invoice']; ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Invoice</td>
                                <td>: <?= $tagihan['tgl_tagihan']; ?></td>
                            </tr>
                            <tr>
                                <td>Nama Pelanggan</td>
                                <td>: <?= $tagihan['nama_pelanggan']; ?></td>
                            </tr>
                            <tr>
                                <td>Kode Pelanggan</td>
                                <td>: <?= $tagihan['kode_pelanggan']; ?></td>
                            </tr>
                            <tr>
                                <td>Nama Mitra</td>
                                <td>: <?= $mitra['nama_mitra']; ?></td>
                            </tr>
                        </table>

                        <br />
                        Terima Kasih.
                        </p>
                    </div>
            </div>
        <?php } ?>
        <!-- /.error-content -->
    </div>
    <!-- /.error-page -->
    </section>
    <!-- /.content -->
    </div>
</body>

</html>