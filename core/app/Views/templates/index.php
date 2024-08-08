<!DOCTYPE html>
<html lang="en">


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


    <style>
        ol {
            padding-left: 1em;
            margin-bottom: 0;
        }

        #loader {
            border: 12px solid #f3f3f3;
            border-radius: 50%;
            border-top: 12px solid #444444;
            width: 70px;
            height: 70px;
            animation: spin 1s linear infinite;
        }

        .center {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        .disabled-link {
            pointer-events: none;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div id="loader" class="center"></div>
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?= $this->include('templates/topbar'); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?= $this->include('templates/sidebar'); ?>


        <!-- Content Wrapper. Contains page content -->
        <?= $this->renderSection('page-content');  ?>
        <!-- /.content-wrapper -->

        <footer class="main-footer">

            <i>Sistem Kemitraan T2 Net <strong>v1.0.0</strong></i><br />
            <strong>Copyright &copy; <?= date('Y'); ?> <a target="blank" href="https://t2net.id">PT. T2 Net</a>. </strong>All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="<?= base_url(); ?>plugins/jquery/jquery.min.js"></script>

    <script>
        document.onreadystatechange = function() {
            if (document.readyState !== "complete") {
                document.querySelector("body").style.visibility = "hidden";
                document.querySelector("#loader").style.visibility = "visible";
            } else {
                document.querySelector("#loader").style.display = "none";
                document.querySelector("body").style.visibility = "visible";
            }
        };
    </script>

    <script src="<?= base_url(); ?>plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- AdminLTE App -->
    <script src="<?= base_url(); ?>js/adminlte.min.js"></script>

    <!-- DataTables  & Plugins -->
    <script src="<?= base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url(); ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>plugins/jszip/jszip.min.js"></script>
    <script src="<?= base_url(); ?>plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?= base_url(); ?>plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?= base_url(); ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= base_url(); ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?= base_url(); ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?= base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>


    <!-- Summernote -->
    <script src="<?= base_url(); ?>plugins/summernote/summernote-bs4.min.js"></script>

    <!-- Databales Setting -->
    <script>
        $(function() {
            $("#daftar-user").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $("#daftar-pembayaran").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            <?php
            if (empty($id_mitra)) {
                $id_mitra = 0;
            }
            echo $id_mitra;
            ?>

            $("#daftar-pelanggan").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?= site_url('pelanggan/pelangganAjax/' . $id_mitra . ''); ?>",
                    "type": "POST",
                    "data": function(data) {
                        data.start = data.start || 0;
                        data.length = data.length || 10;
                    }
                },
                "columns": [{
                    "data": "id_pelanggan",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    "className": 'dt-body-center',
                }, {
                    "data": "kode_pelanggan",
                    "className": 'dt-body-center',
                }, {
                    "data": "nama_pelanggan",
                }, {
                    "data": "alamat_pelanggan",
                }, {
                    "data": "telp_pelanggan",
                    "className": 'dt-body-center',
                }, {
                    "creator": [{
                        "id_pelanggan": "id_pelanggan",
                        "kode_pelanggan": "kode_pelanggan",
                        "nama_pelanggan": "nama_pelanggan",
                    }],
                    "data": "status",
                    "className": 'dt-body-center',
                    render: function(data, type, row) {
                        if (data == 1) {
                            html = "<a href='#' data-target='#activateModal" + row.id_pelanggan + "' data-toggle='modal' class='btn btn-sm bg-success' title='Klik untuk Menonaktifkan'><i class = 'fas fa-check'></i> Aktif </a>";
                            html += "<div class='modal fade' id='activateModal" + row.id_pelanggan + "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
                            html += "<form action='<?= base_url(); ?>pelanggan/activate' method='post'>";
                            html += "<input type='hidden' name='kode_pelanggan' value='" + row.kode_pelanggan + "'>";
                            html += "<input type='hidden' name='nama_pelanggan' value='" + row.nama_pelanggan + "'>";
                            html += "<input type='hidden' name='id_pelanggan' value='" + row.id_pelanggan + "'>";
                            html += "<div class='modal-dialog' role='document'>";
                            html += "<div class='modal-content'>";
                            html += "<div class='modal-header'>";
                            html += "<h5 class='modal-title' id='exampleModalLabel'>Update Pelanggan</h5>";
                            html += "<button class='close' type='button' data-dismiss='modal' aria-label='Close'>";
                            html += "<span aria-hidden='true'>×</span>";
                            html += "</button>";
                            html += "</div>";
                            html += "<div class='text-left modal-body'>Pilih 'Ya' untuk mengupdate Pelanggan</div>";
                            html += "<div class='modal-footer'>";
                            html += "<input type='hidden' name='id_pelanggan' class='id' value='" + row.id_pelanggan + "'>";
                            html += "<input type='hidden' name='active' class='active' value='" + data + "'>";
                            html += "<button class='btn btn-secondary' type='button' data-dismiss='modal'>Tidak</button>";
                            html += "<button type='submit' class='btn btn-primary'>Ya</button>";
                            html += "</div>";
                            html += "</div>";
                            html += "</div>";
                            html += "</form>";
                            html += "</div>";
                            return html;

                        } else if (data == 0) {
                            html = "<a href='#' data-target='#activateModal" + row.id_pelanggan + "' data-toggle='modal' class='btn btn-sm bg-danger' title='Klik untuk Mengaktifkan'><i class='fas fa-times-circle'></i> Tidak Aktif</a>";
                            html += "<div class='modal fade' id='activateModal" + row.id_pelanggan + "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
                            html += "<form action='<?= base_url(); ?>pelanggan/activate' method='post'>";
                            html += "<input type='hidden' name='kode_pelanggan' value='" + row.kode_pelanggan + "'>";
                            html += "<input type='hidden' name='nama_pelanggan' value='" + row.nama_pelanggan + "'>";
                            html += "<input type='hidden' name='id_pelanggan' value='" + row.id_pelanggan + "'>";
                            html += "<div class='modal-dialog' role='document'>";
                            html += "<div class='modal-content'>";
                            html += "<div class='modal-header'>";
                            html += "<h5 class='modal-title' id='exampleModalLabel'>Update Pelanggan</h5>";
                            html += "<button class='close' type='button' data-dismiss='modal' aria-label='Close'>";
                            html += "<span aria-hidden='true'>×</span>";
                            html += "</button>";
                            html += "</div>";
                            html += "<div class='text-left modal-body'>Pilih 'Ya' untuk mengupdate Pelanggan</div>";
                            html += "<div class='modal-footer'>";
                            html += "<input type='hidden' name='id_pelanggan' class='id' value='" + row.id_pelanggan + "'>";
                            html += "<input type='hidden' name='active' class='active' value='" + data + "'>";
                            html += "<button class='btn btn-secondary' type='button' data-dismiss='modal'>Tidak</button>";
                            html += "<button type='submit' class='btn btn-primary'>Ya</button>";
                            html += "</div>";
                            html += "</div>";
                            html += "</div>";
                            html += "</form>";
                            html += "</div>";
                            return html;
                        }
                    }
                }, {
                    "data": "id_pelanggan",
                    "className": 'dt-body-center',
                    render: function(data, type, row) {
                        return "<a href = '<?= base_url(); ?>pelanggan/detail/" + data + "' class = 'btn btn-primary btn-circle btn-sm' title='Detail Data Pelanggan'> <i class='fas fa-eye'> </i> </a> <a href = '<?= base_url(); ?>pelanggan/edit/" + data + "'class = 'btn btn-warning btn-circle btn-sm' title = 'Edit Data Pelanggan' ><i class='fas fa-edit'></i> </a>";
                    }
                }],
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#table-responsive .col-md-6:eq(0)');

            $("#daftar-pelanggan-all").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?= site_url('pelanggan/pelangganAjaxAll'); ?>",
                    "type": "POST",
                    "data": function(data) {
                        data.start = data.start || 0;
                        data.length = data.length || 10;
                    }
                },
                "columns": [{
                    "data": "id_pelanggan",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    "className": 'dt-body-center',
                }, {
                    "data": "kode_pelanggan",
                    "className": 'dt-body-center',
                }, {
                    "data": "nama_mitra",
                }, {
                    "data": "nama_pelanggan",
                }, {
                    "data": "alamat_pelanggan",
                }, {
                    "data": "telp_pelanggan",
                    "className": 'dt-body-center',
                }, {
                    "creator": [{
                        "id_pelanggan": "id_pelanggan",
                        "kode_pelanggan": "kode_pelanggan",
                        "nama_pelanggan": "nama_pelanggan",
                    }],
                    "data": "status",
                    "className": 'dt-body-center',
                    render: function(data, type, row) {
                        if (data == 1) {
                            html = "<a href='#' data-target='#activateModal" + row.id_pelanggan + "' data-toggle='modal' class='btn btn-sm bg-success' title='Klik untuk Menonaktifkan'><i class = 'fas fa-check'></i> Aktif </a>";
                            html += "<div class='modal fade' id='activateModal" + row.id_pelanggan + "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
                            html += "<form action='<?= base_url(); ?>pelanggan/activate' method='post'>";
                            html += "<input type='hidden' name='kode_pelanggan' value='" + row.kode_pelanggan + "'>";
                            html += "<input type='hidden' name='nama_pelanggan' value='" + row.nama_pelanggan + "'>";
                            html += "<input type='hidden' name='id_pelanggan' value='" + row.id_pelanggan + "'>";
                            html += "<div class='modal-dialog' role='document'>";
                            html += "<div class='modal-content'>";
                            html += "<div class='modal-header'>";
                            html += "<h5 class='modal-title' id='exampleModalLabel'>Update Pelanggan</h5>";
                            html += "<button class='close' type='button' data-dismiss='modal' aria-label='Close'>";
                            html += "<span aria-hidden='true'>×</span>";
                            html += "</button>";
                            html += "</div>";
                            html += "<div class='text-left modal-body'>Pilih 'Ya' untuk mengupdate Pelanggan</div>";
                            html += "<div class='modal-footer'>";
                            html += "<input type='hidden' name='id_pelanggan' class='id' value='" + row.id_pelanggan + "'>";
                            html += "<input type='hidden' name='active' class='active' value='" + data + "'>";
                            html += "<button class='btn btn-secondary' type='button' data-dismiss='modal'>Tidak</button>";
                            html += "<button type='submit' class='btn btn-primary'>Ya</button>";
                            html += "</div>";
                            html += "</div>";
                            html += "</div>";
                            html += "</form>";
                            html += "</div>";
                            return html;

                        } else if (data == 0) {
                            html = "<a href='#' data-target='#activateModal" + row.id_pelanggan + "' data-toggle='modal' class='btn btn-sm bg-danger' title='Klik untuk Mengaktifkan'><i class='fas fa-times-circle'></i> Tidak Aktif</a>";
                            html += "<div class='modal fade' id='activateModal" + row.id_pelanggan + "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
                            html += "<form action='<?= base_url(); ?>pelanggan/activate' method='post'>";
                            html += "<input type='hidden' name='kode_pelanggan' value='" + row.kode_pelanggan + "'>";
                            html += "<input type='hidden' name='nama_pelanggan' value='" + row.nama_pelanggan + "'>";
                            html += "<input type='hidden' name='id_pelanggan' value='" + row.id_pelanggan + "'>";
                            html += "<div class='modal-dialog' role='document'>";
                            html += "<div class='modal-content'>";
                            html += "<div class='modal-header'>";
                            html += "<h5 class='modal-title' id='exampleModalLabel'>Update Pelanggan</h5>";
                            html += "<button class='close' type='button' data-dismiss='modal' aria-label='Close'>";
                            html += "<span aria-hidden='true'>×</span>";
                            html += "</button>";
                            html += "</div>";
                            html += "<div class='text-left modal-body'>Pilih 'Ya' untuk mengupdate Pelanggan</div>";
                            html += "<div class='modal-footer'>";
                            html += "<input type='hidden' name='id_pelanggan' class='id' value='" + row.id_pelanggan + "'>";
                            html += "<input type='hidden' name='active' class='active' value='" + data + "'>";
                            html += "<button class='btn btn-secondary' type='button' data-dismiss='modal'>Tidak</button>";
                            html += "<button type='submit' class='btn btn-primary'>Ya</button>";
                            html += "</div>";
                            html += "</div>";
                            html += "</div>";
                            html += "</form>";
                            html += "</div>";
                            return html;
                        }
                    }
                }, {
                    "data": "id_pelanggan",
                    "className": 'dt-body-center',
                    render: function(data, type, row) {
                        return "<a href = '<?= base_url(); ?>pelanggan/detail/" + data + "' class = 'btn btn-primary btn-circle btn-sm' title='Detail Data Pelanggan'> <i class='fas fa-eye'> </i> </a> <a href = '<?= base_url(); ?>pelanggan/edit/" + data + "'class = 'btn btn-warning btn-circle btn-sm' title = 'Edit Data Pelanggan' ><i class='fas fa-edit'></i> </a>";
                    }
                }],
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#table-responsive .col-md-6:eq(0)');

            $("#daftar-mitra").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?= site_url('mitra/mitraAjax'); ?>",
                    "type": "POST",
                    "data": function(data) {
                        data.start = data.start || 0;
                        data.length = data.length || 10;
                    }
                },
                "columns": [{
                    "data": "id_mitra",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    "className": 'dt-body-center',
                }, {
                    "data": "kode_mitra",
                    "className": 'dt-body-center',
                }, {
                    "creator": [{
                        "id_mitra": "id_mitra",
                        "nama_mitra": "nama_mitra",
                        "penanggung_jawab": "penanggung_jawab",
                        "telepon": "telepon",
                        "username": "username",
                    }],
                    "data": "nama_mitra",
                    render: function(data, type, row) {
                        html = row.nama_mitra + "<br/><br/><b>Penanggung Jawab: </b>";
                        html += row.penanggung_jawab + "<br>";
                        html += "<b>Telepon :</b> 0" + row.telepon + "<br>";
                        html += "<span style='font-size:15px' class='badge badge-success'><b>Username :</b> " + row.username + "</span>";
                        return html;
                    },
                }, {
                    "data": "alamat",
                }, {
                    "creator": [{
                        "id_mitra": "id_mitra",
                        "jumlah_pelanggan": "jumlah_pelanggan",
                    }],
                    "data": "id_mitra",
                    "className": 'dt-body-center',
                    render: function(data, type, row) {
                        html = "<a href='<?= base_url(); ?>pelanggan/daftar/" + data + "' class='btn btn-sm bg-maroon' title='Klik untuk Melihat Daftar Pelanggan'><i class = 'fas fa-users'></i> Lihat Pelanggan</a>";
                        html += "<br/><span style='font-size:14px;padding:7px;' class='mt-2 badge badge bg-lightblue'>Jumlah Pelanggan : " + row.jumlah_pelanggan + "</span>";
                        return html;
                    }
                }, {
                    "creator": [{
                        "id_mitra": "id_mitra",
                        "kode_mitra": "kode_mitra",
                        "nama_mitra": "nama_mitra",
                        "username": "username",
                    }],
                    "data": "status",
                    "className": 'dt-body-center',
                    render: function(data, type, row) {
                        if (data == 1) {
                            html = "<a href='#' data-target='#activateModal" + row.id_mitra + "' data-toggle='modal' class='btn btn-sm bg-success' title='Klik untuk Menonaktifkan'><i class = 'fas fa-check'></i> Aktif </a>";
                            html += "<div class='modal fade' id='activateModal" + row.id_mitra + "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
                            html += "<form action='<?= base_url(); ?>mitra/activate' method='post'>";
                            html += "<input type='hidden' name='kode_mitra' value='" + row.kode_mitra + "'>";
                            html += "<input type='hidden' name='nama_mitra' value='" + row.nama_mitra + "'>";
                            html += "<input type='hidden' name='id_mitra' value='" + row.id_mitra + "'>";
                            html += "<input type='hidden' name='username' value='" + row.username + "'>";
                            html += "<input type='hidden' name='active' value='" + row.status + "'>";
                            html += "<div class='modal-dialog' role='document'>";
                            html += "<div class='modal-content'>";
                            html += "<div class='modal-header'>";
                            html += "<h5 class='modal-title' id='exampleModalLabel'>Update Mitra</h5>";
                            html += "<button class='close' type='button' data-dismiss='modal' aria-label='Close'>";
                            html += "<span aria-hidden='true'>×</span>";
                            html += "</button>";
                            html += "</div>";
                            html += "<div class='text-left modal-body'>Pilih 'Ya' untuk mengupdate Mitra</div>";
                            html += "<div class='modal-footer'>";
                            html += "<input type='hidden' name='id_mitra' class='id' value='" + row.id_mitra + "'>";
                            html += "<input type='hidden' name='active' class='active' value='" + data + "'>";
                            html += "<button class='btn btn-secondary' type='button' data-dismiss='modal'>Tidak</button>";
                            html += "<button type='submit' class='btn btn-primary'>Ya</button>";
                            html += "</div>";
                            html += "</div>";
                            html += "</div>";
                            html += "</form>";
                            html += "</div>";
                            return html;

                        } else if (data == 0) {
                            html = "<a href='#' data-target='#activateModal" + row.id_mitra + "' data-toggle='modal' class='btn btn-sm bg-danger' title='Klik untuk Mengaktifkan'><i class='fas fa-times-circle'></i> Tidak Aktif</a>";
                            html += "<div class='modal fade' id='activateModal" + row.id_mitra + "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
                            html += "<form action='<?= base_url(); ?>mitra/activate' method='post'>";
                            html += "<input type='hidden' name='kode_mitra' value='" + row.kode_mitra + "'>";
                            html += "<input type='hidden' name='nama_mitra' value='" + row.nama_mitra + "'>";
                            html += "<input type='hidden' name='id_mitra' value='" + row.id_mitra + "'>";
                            html += "<input type='hidden' name='username' value='" + row.username + "'>";
                            html += "<div class='modal-dialog' role='document'>";
                            html += "<div class='modal-content'>";
                            html += "<div class='modal-header'>";
                            html += "<h5 class='modal-title' id='exampleModalLabel'>Update Mitra</h5>";
                            html += "<button class='close' type='button' data-dismiss='modal' aria-label='Close'>";
                            html += "<span aria-hidden='true'>×</span>";
                            html += "</button>";
                            html += "</div>";
                            html += "<div class='text-left modal-body'>Pilih 'Ya' untuk mengupdate Mitra</div>";
                            html += "<div class='modal-footer'>";
                            html += "<input type='hidden' name='id_mitra' class='id' value='" + row.id_mitra + "'>";
                            html += "<input type='hidden' name='active' class='active' value='" + data + "'>";
                            html += "<button class='btn btn-secondary' type='button' data-dismiss='modal'>Tidak</button>";
                            html += "<button type='submit' class='btn btn-primary'>Ya</button>";
                            html += "</div>";
                            html += "</div>";
                            html += "</div>";
                            html += "</form>";
                            html += "</div>";
                            return html;
                        }
                    }
                }, {
                    "creator": [{
                        "id_mitra": "id_mitra",
                        "kode_mitra": "kode_mitra",
                        "nama_mitra": "nama_mitra",
                        "username": "username",
                        "id_users": "id_users",
                    }],
                    "data": "id_mitra",
                    "className": 'dt-body-center',
                    render: function(data, type, row) {
                        html = "<a href='#' data-target='#bhpModal" + data + "' data-toggle='modal' class='btn btn-success btn-block btn-circle btn-sm' title='Download BHP'><i class='fas fa-download'></i> Download BHP</a>";
                        html += "<div class='modal fade' id='bhpModal" + data + "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
                        html += "<form action='<?= base_url(); ?>mitra/downloadbhp' method='post'>";
                        html += "<input type='hidden' name='id_mitra' value='" + data + "'>";
                        html += "<div class='modal-dialog' role='document'>";
                        html += "<div class='modal-content'>";
                        html += "<div class='modal-header'>";
                        html += "<h5 class='modal-title' id='exampleModalLabel'>Downloads BHP</h5>";
                        html += "<button class='close' type='button' data-dismiss='modal' aria-label='Close'>";
                        html += "<span aria-hidden='true'>×</span>";
                        html += "</button>";
                        html += "</div>";
                        html += "<div class='modal-body'>";
                        html += "<div class='list-group-item p-3'>";
                        html += "<div class='row align-items-start'>";
                        html += "<div class='col-md-4 mb-8pt mb-md-0'>";
                        html += "<div class='media align-items-left'>";
                        html += "<div class='d-flex flex-column media-body media-middle'>";
                        html += "<span class='card-title' style='font-size:16px'>Pilih Tahun</span>";
                        html += "</div>";
                        html += "</div>";
                        html += "</div>";
                        html += "<div class='col mb-8pt mb-md-0'>";
                        html += "<select name='tahun' class='form-control' data-toggle='select'>";
                        <?php
                        $bulan_sekarang = date('m');
                        $tahun_sekarang = date('Y');
                        $db      = \Config\Database::connect();
                        $builder = $db->table('tagihan');
                        $tahun_pekerjaan = $builder->select('tahun')
                            ->groupBy('tahun')
                            ->get()->getResultArray();
                        foreach ($tahun_pekerjaan as $row1) :
                        ?>
                            html += "<option <?= $tahun_sekarang == $row1['tahun'] ? 'selected' : ''; ?> value='<?= $row1['tahun'] ?>'><?= $row1['tahun'] ?></option>";
                        <?php endforeach; ?>
                        html += "</select>";
                        html += "</div>";
                        html += "</div>";
                        html += "<br />";
                        html += "<div class='row align-items-start'>";
                        html += "<div class='col-md-4 mb-8pt mb-md-0'>";
                        html += "<div class='media align-items-left'>";
                        html += "<div class='d-flex flex-column media-body media-middle'>";
                        html += "<span class='card-title' style='font-size:16px'>Pilih Bulan</span>";
                        html += "</div>";
                        html += "</div>";
                        html += "</div>";
                        html += "<div class='col mb-8pt mb-md-0'>";
                        html += "<select name='bulan' class='form-control' data-toggle='select'>";
                        <?php $bulan = date('m'); ?>
                        html += "<option <?= $bulan == '01' ? 'selected' : ''; ?> value='01'>Januari</option>";
                        html += "<option <?= $bulan == '02' ? 'selected' : ''; ?> value='02'>Februari</option>";
                        html += "<option <?= $bulan == '03' ? 'selected' : ''; ?> value='03'>Maret</option>";
                        html += "<option <?= $bulan == '04' ? 'selected' : ''; ?> value='04'>April</option>";
                        html += "<option <?= $bulan == '05' ? 'selected' : ''; ?> value='05'>Mei</option>";
                        html += "<option <?= $bulan == '06' ? 'selected' : ''; ?> value='06'>Juni</option>";
                        html += "<option <?= $bulan == '07' ? 'selected' : ''; ?> value='07'>Juli</option>";
                        html += "<option <?= $bulan == '08' ? 'selected' : ''; ?> value='08'>Agustus</option>";
                        html += "<option <?= $bulan == '09' ? 'selected' : ''; ?> value='09'>September</option>";
                        html += "<option <?= $bulan == '10' ? 'selected' : ''; ?> value='10'>Oktober</option>";
                        html += "<option <?= $bulan == '11' ? 'selected' : ''; ?> value='11'>November</option>";
                        html += "<option <?= $bulan == '12' ? 'selected' : ''; ?> value='12'>Desember</option>";
                        html += "</select>";
                        html += "</div>";
                        html += "</div>";
                        html += "</div>";
                        html += "</div>";
                        html += "<div class='modal-footer'>";
                        html += "<button class='btn btn-secondary' type='button' data-dismiss='modal'>Batal</button>";
                        html += "<button type='submit' class='btn btn-primary'>Download Data</button>";
                        html += "</div>";
                        html += "</div>";
                        html += "</div>";
                        html += "</form>";
                        html += "</div>";
                        html += "<a href = '<?= base_url(); ?>mitra/detail/" + data + "' class = 'btn btn-primary btn-block btn-circle btn-sm mt-2' title='Detail Data Mitra'> <i class='fas fa-eye'> </i> Lihat Mitra</a>";
                        html += "<a href = '<?= base_url(); ?>mitra/edit/" + data + "'class = 'btn btn-warning btn-block btn-circle btn-sm mt-2' title = 'Edit Data Mitra' ><i class='fas fa-edit'></i> Edit Data</a>";
                        html += "<a href='<?= base_url(); ?>users/changePassword/" + row.id_users + "/" + row.id_mitra + "' class='btn btn-secondary btn-block btn-circle btn-sm mt-2' title='Ubah Password'> <i class='fas fa-key'></i> Reset Password</a>";
                        // html += "<a href='#' data-target='#hapusModal" + data + "' data-toggle='modal' class='btn btn-sm bg-danger btn-block mt-2' title='Klik untuk Menghapus'><i class='fas fa-trash'></i> Hapus Data</a>";
                        // html += "<div class='modal fade' id='hapusModal" + data + "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
                        // html += "<form action='<php base_url(); ?>mitra/hapus' method='post'>";
                        // html += "<input type='hidden' name='id_mitra' value='" + data + "'>";
                        // html += "<div class='modal-dialog' role='document'>";
                        // html += "<div class='modal-content'>";
                        // html += "<div class='modal-header'>";
                        // html += "<h5 class='modal-title' id='exampleModalLabel'>Hapus Data Mitra</h5>";
                        // html += "<button class='close' type='button' data-dismiss='modal' aria-label='Close'>";
                        // html += "<span aria-hidden='true'>×</span>";
                        // html += "</button>";
                        // html += "</div>";
                        // html += "<div class='modal-body text-left'>Pilih 'Ya' untuk menghapus Data Mitra</div>";
                        // html += "<div class='modal-footer'>";
                        // html += "<button class='btn btn-secondary' type='button' data-dismiss='modal'>Tidak</button>";
                        // html += "<button type='submit' class='btn btn-primary'>Ya</button>";
                        // html += "</div>";
                        // html += "</div>";
                        // html += "</div>";
                        // html += "</form>";
                        // html += "</div>";
                        return html;
                    }
                }],
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#table-responsive .col-md-6:eq(0)');

            $("#daftar-mitra-tagihan").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?= site_url('mitra/mitraAjaxTagihan'); ?>",
                    "type": "POST",
                    "data": function(data) {
                        data.start = data.start || 0;
                        data.length = data.length || 10;
                    }
                },
                "columns": [{
                    "data": "id_mitra",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    "className": 'dt-body-center',
                }, {
                    "data": "kode_mitra",
                    "className": 'dt-body-center',
                }, {
                    "data": "nama_mitra",
                    "className": 'dt-body-center',
                }, {
                    "data": "alamat",
                }, {
                    "data": "jumlah_pelanggan",
                    "className": 'dt-body-center',
                }, {
                    "data": "terbit",
                    "className": 'dt-body-center',
                }, {
                    "data": "terbayar",
                    "className": 'dt-body-center',
                }, {
                    "data": "total_tagihan",
                    "className": 'dt-body-center',
                    render: function(data, type, row) {
                        html = Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR"
                        }).format(data);
                        return html;
                    }
                }],
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#table-responsive .col-md-6:eq(0)');


            <?php
            if (empty($bulan_angka)) {
                $bulan_angka = date('m');
            }
            if (empty($tahun)) {
                $tahun = date('Y');
            }
            ?>
            $("#daftar-tagihan").DataTable({
                "processing": true,
                "serverSide": true,
                "serverMethod": 'post',
                "ajax": "<?= site_url('tagihan/tagihanAjax/' . $bulan_angka . '/' . $tahun . '/' . $id_mitra . ''); ?>",
                "columns": [{
                    "data": "id_tagihan",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    "className": 'dt-body-center',
                }, {
                    "data": "kode_pelanggan",
                    "className": 'dt-body-center',
                }, {
                    "data": "nama_pelanggan",
                }, {
                    "data": "total_tagihan",
                    "className": 'dt-body-center',
                    render: function(data, type, row) {
                        html = Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR"
                        }).format(data);
                        return html;
                    }
                }, {
                    "data": "id_pelanggan",
                    "creator": [{
                        "status": "status",
                        "id_tagihan": "id_tagihan",
                        "id_pelanggan": "id_pelanggan",
                        "nama_pelanggan": "nama_pelanggan",
                        "tahun": "tahun",
                        "bulan": "bulan",
                    }],
                    "className": 'dt-body-center',
                    render: function(data, type, row) {
                        html = "<a href='#' onclick=\"window.open('<?= base_url() ?>tagihan/downloadinvoice/" + row.id_pelanggan + "/" + row.id_tagihan + "/" + row.tahun + "/" + row.bulan + "', 'popup', 'width=600,height=600'); return false;\" class='btn btn-sm btn-primary'>";
                        html += "<i class='fas fa-download'></i> Download Invoice";
                        html += "</a>";
                        return html;
                    }
                }, {
                    "creator": [{
                        "status": "status",
                        "id_tagihan": "id_tagihan",
                        "id_kuitansi": "id_kuitansi",
                        "id_pelanggan": "id_pelanggan",
                        "nama_pelanggan": "nama_pelanggan",
                        "id_mitra": "id_mitra",
                        "tahun": "tahun",
                        "bulan": "bulan",
                    }],
                    "data": "status",
                    "className": 'dt-body-center',
                    render: function(data, type, row) {
                        //Tombol Buat Kuitansi
                        if (data == 1 || data == 2 || data == 4) {
                            html = "<a href='#' data-target='#metodeBayar" + row.id_tagihan + "' data-toggle='modal' class='btn btn-warning btn-sm'>";
                            html += "<i class='fas fa-plus'></i>&nbsp;Buat Kuitansi";
                            html += "</a>";
                            html += "<div class='modal fade' id='metodeBayar" + row.id_tagihan + "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
                            html += "<form action='<?= base_url(); ?>tagihan/buatkuitansi' method='post'>";
                            html += "<div class='modal-dialog modal-lg' role='document'>";
                            html += "<div class='modal-content'>";
                            html += "<div class='modal-header'>";
                            html += "<h5 class='modal-title' id='exampleModalLabel'>Pilih Metode Pembayaran</h5>";
                            html += "<button class='close' type='button' data-dismiss='modal' aria-label='Close'>";
                            html += "<span aria-hidden='true'>×</span>";
                            html += "</button>";
                            html += "</div>";
                            html += "<div class='modal-body'>";
                            html += "<div class='list-group-item p-3'>";
                            html += "<div class='row align-items-start'>";
                            html += "<div class='col-md-4 mb-8pt mb-md-0'>";
                            html += "<div class='media align-items-left'>";
                            html += "<div class='d-flex flex-column media-body media-middle'>";
                            html += "<span class='card-title'>Metode Bayar</span>";
                            html += "</div>";
                            html += "</div>";
                            html += "</div>";
                            html += "<div class='col mb-8pt mb-md-0'>";
                            html += "<input type='hidden' name='id_pembayaran' class='id' value='" + row.id_tagihan + "'>";
                            html += "<input type='hidden' name='id_pelanggan' class='id' value='" + row.id_pelanggan + "'>";
                            html += "<input type='hidden' name='id_tagihan' class='id' value='" + row.id_tagihan + "'>";
                            html += "<input type='hidden' name='tahun' class='id' value='" + row.tahun + "'>";
                            html += "<input type='hidden' name='bulan' class='id' value='" + row.bulan + "'>";
                            html += "<select name='id_pembayaran' class='form-control' data-toggle='select'>";
                            <?php
                            $db      = \Config\Database::connect();

                            //Cek ID Mitra

                            //Cek Pembayaran Terakhir
                            $builder = $db->table('pembayaran');
                            $pembayaran   = $builder->where('id_mitra', $id_mitra)
                                ->get()->getResultArray();
                            foreach ($pembayaran as $row) {
                            ?>
                                html += "<option value='<?= $row['id_pembayaran']; ?>'><?= $row['nama_bank']; ?> (<?= $row['atas_nama']; ?>)</option>";
                            <?php
                            }
                            ?>
                            html += "</select>";
                            html += "</div>";
                            html += "</div>";
                            html += "</div>";
                            html += "</div>";
                            html += "<div class='modal-footer'>";
                            html += "<input type='hidden' name='id' class='id'>";
                            html += "<button class='btn btn-secondary' type='button' data-dismiss='modal'>Batal</button>";
                            html += "<button type='submit' class='btn btn-success'>Simpan</button>";
                            html += "</div>";
                            html += "</div>";
                            html += "</div>";
                            html += "</form>";
                            html += "</div>";
                        }
                        //Tombol Cetak Kuitansi
                        if (data == 3) {
                            html = "<a href='#' onclick=\"window.open('<?= base_url(); ?>tagihan/downloadkuitansi/" + row.id_pelanggan + "/" + row.id_kuitansi + "', 'popup', 'width=600,height=600'); return false;\" class='btn btn-sm btn-success'>";
                            html += "<i class='fas fa-download'></i> Download Kuitansi";
                            html += "</a>";
                        }
                        return html;
                    }
                }, {
                    "data": "id_tagihan",
                    "creator": [{
                        "status": "status",
                        "id_tagihan": "id_tagihan",
                        "id_kuitansi": "id_kuitansi",
                        "id_pelanggan": "id_pelanggan",
                        "id_mitra": "id_mitra",
                        "nama_pelanggan": "nama_pelanggan",
                        "tahun": "tahun",
                        "bulan": "bulan",
                    }],
                    "className": 'dt-body-center',
                    render: function(data, type, row) {
                        <?php if ((in_groups('superuser'))) { ?>
                            html = "<a href='#' data-target='#batalTagihan" + row.id_tagihan + "' data-toggle='modal' class='btn btn-sm btn-danger'><i class='fas fa-times-circle'></i> Batalkan Tagihan </a>";

                            //Modal Batal Tagihan
                            html += "<div class='modal fade' id='batalTagihan" + row.id_tagihan + "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
                            html += "<form action='<?= base_url(); ?>tagihan/bataltagihanindividu' method='post'>";
                            html += "<input type='hidden' name='id_pelanggan' value='" + row.id_pelanggan + "'>";
                            html += "<input type='hidden' name='id_tagihan' value='" + row.id_tagihan + "'>";
                            html += "<input type='hidden' name='id_mitra' value='" + row.id_mitra + "'>";
                            html += "<input type='hidden' name='bulan' value='" + row.bulan + "'>";
                            html += "<input type='hidden' name='tahun' value='" + row.tahun + "'>";
                            html += "<div class='modal-dialog' role='document'>";
                            html += "<div class='modal-content'>";
                            html += "<div class='modal-header'>";
                            html += "<h5 class='modal-title' id='exampleModalLabel'>Batalkan Tagihan Pelanggan</h5>";
                            html += "<button class='close' type='button' data-dismiss='modal' aria-label='Close'>";
                            html += "<span aria-hidden='true'>×</span>";
                            html += "</button>";
                            html += "</div>";
                            html += "<div class='text-left modal-body'>Pilih 'Ya' untuk membatalkan tagihan Pelanggan</div>";
                            html += "<div class='modal-footer'>";
                            html += "<button class='btn btn-secondary' type='button' data-dismiss='modal'>Tidak</button>";
                            html += "<button type='submit' class='btn btn-primary'>Ya</button>";
                            html += "</div>";
                            html += "</div>";
                            html += "</div>";
                            html += "</form>";
                            html += "</div>";
                        <?php } else { ?>
                            html = '-';
                        <?php } ?>
                        return html;
                    }
                }],
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#table-responsive .col-md-6:eq(0)');

            $("#daftar-kuitansi").DataTable({
                "processing": true,
                "serverSide": true,
                "serverMethod": 'post',
                "ajax": "<?= site_url('pembayaran/pembayaranAjax'); ?>",
                "columns": [{
                    "data": "id_kuitansi",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    "className": 'dt-body-center',
                }, {
                    "data": "tgl_kuitansi",
                    "className": 'dt-body-center',
                }, {
                    "data": "nama_pelanggan",
                    "className": 'dt-body-center',
                }, {
                    "data": "no_kuitansi",
                    "creator": [{
                        "informasi_kuitansi": "informasi_kuitansi",
                        "no_kuitansi": "no_kuitansi",
                    }],
                    render: function(data, type, row) {
                        html = data;
                        html += "<br/><br/><b>Nama Item</b><br/>";
                        html += row.informasi_kuitansi;
                        return html;
                    }
                }, {
                    "data": "nominal_kuitansi",
                    "className": 'dt-body-center',
                    render: function(data, type, row) {
                        html = Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR"
                        }).format(data);
                        return html;
                    }
                }, {
                    "data": "id_kuitansi",
                    "className": 'dt-body-center',
                    render: function(data, type, row) {
                        return "<a href = '<?= base_url(); ?>pembayaran/detail/" + data + "' class = 'btn btn-success btn-circle btn-sm' title='Detail Pembayaran'> <i class='fas fa-edit'> </i> Detail Pembayaran</a>";
                    }
                }],
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#table-responsive .col-md-6:eq(0)');


            <?php
            if (empty($bulan_log)) {
                $bulan_log = date('m');
            }
            if (empty($tahun_log)) {
                $tahun_log = date('Y');
            }
            ?>

            $("#daftar-log").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?= site_url('log/logAjax/' . $bulan_log . '/' . $tahun_log); ?>",
                    "type": "POST",
                    "data": function(data) {
                        data.start = data.start || 0;
                        data.length = data.length || 10;
                    }
                },
                "columns": [{
                    "data": "id_log",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    "className": 'dt-body-center',
                }, {
                    "data": "tgl",
                    "className": 'dt-body-center',
                }, {
                    "data": "deskripsi",
                }, {
                    "data": "tipe_log",
                }],
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#daftar-log .col-md-6:eq(0)');

            $("#daftar-log-admin").DataTable({
                "processing": true,
                "serverSide": true,
                "serverMethod": 'post',
                "ajax": "<?= site_url('log/logAjaxadmin/' . $bulan_log . '/' . $tahun_log); ?>",
                "columns": [{
                    "data": "id_log",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    "className": 'dt-body-center',
                }, {
                    "data": "tgl",
                    "className": 'dt-body-center',
                }, {
                    "data": "deskripsi",
                }, {
                    "data": "tipe_log",
                }],
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#daftar-log-admin .col-md-6:eq(0)');

            $("#daftar-bulan").DataTable({
                "responsive": true,
                "pageLength": 50,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });
    </script>

    <script>
        $(function() {
            // Summernote
            $('#summernote').summernote({
                width: '100%',
                removeFormat: true,
            })
        })
    </script>

    <script>
        $(function() {
            $(".pelanggan-baru").hide();
            $(".cek-pelanggan").click(function() {
                if ($(this).is(":checked")) {
                    $(".pelanggan-baru").show();
                    $(".pelanggan-lama").hide();
                } else {
                    $(".pelanggan-baru").hide();
                    $(".pelanggan-lama").show();
                }
            });
        });
    </script>

    <!-- Select2 JS -->
    <script type="text/javascript" src="<?= base_url(); ?>/plugins/select2new/dist/js/select2.min.js"></script>
    <script type='text/javascript'>
        $(document).ready(function() {

            // Initialize select2
            $("#selUser").select2({
                ajax: {
                    url: "<?= site_url('pelanggan/ajaxsearch') ?>",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            searchTerm: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response.data
                        };
                    },
                    cache: true
                }
            });

            $("#selMitra").select2({
                ajax: {
                    url: "<?= site_url('mitra/ajaxsearch') ?>",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            searchTerm: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response.data
                        };
                    },
                    cache: true
                }
            });

        });
    </script>

    <!-- Script Image Preview -->
    <script>
        function previewImg() {
            const logo = document.querySelector('#logo');
            const logolabel = document.querySelector('.custom-file-label');
            logolabel.textContent = logo.files[0].name;
        }
    </script>
    <!-- Script Image Preview -->
    <script>
        function previewImgTtdCap() {
            const logo = document.querySelector('#ttd_cap');
            const logolabel = document.querySelector('.ttd_cap_nama');
            logolabel.textContent = logo.files[0].name;
        }
    </script>

</body>

</html>