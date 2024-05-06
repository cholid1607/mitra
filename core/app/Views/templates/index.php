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

            <strong>Copyright &copy; <?= date('Y'); ?> <a target="blank" href="https://t2net.id">PT. T2 Net</a>. <br /></strong> All rights reserved.
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
                        html = "<a href='pelanggan/daftar/" + data + "' class='btn btn-sm bg-maroon' title='Klik untuk Melihat Daftar Pelanggan'><i class = 'fas fa-users'></i> Lihat Pelanggan</a>";
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
                            html += "<input type='text' name='username' value='" + row.username + "'>";
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
                            html += "<input type='text' name='username' value='" + row.username + "'>";
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
                    "data": "id_mitra",
                    "className": 'dt-body-center',
                    render: function(data, type, row) {
                        html = "<a href = '<?= base_url(); ?>mitra/detail/" + data + "' class = 'btn btn-primary btn-block btn-circle btn-sm' title='Detail Data Mitra'> <i class='fas fa-eye'> </i> Lihat Mitra</a>";
                        html += "<a href = '<?= base_url(); ?>mitra/edit/" + data + "'class = 'btn btn-warning btn-block btn-circle btn-sm mt-2' title = 'Edit Data Mitra' ><i class='fas fa-edit'></i> Edit Data</a>";
                        html += "<a href='<?= base_url(); ?>users/changePassword/" + data + "' class='btn btn-secondary btn-block btn-circle btn-sm mt-2' title='Ubah Password'> <i class='fas fa-key'></i> Reset Password</a>";
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
                "ajax": "<?= site_url('tagihan/tagihanAjax/' . $bulan_angka . '/' . $tahun . ''); ?>",
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
                        "data": "status",
                        "id_pelanggan": "id_pelanggan",
                        "className": 'dt-body-center',
                        render: function(data, id_pelanggan, type, row) {
                            if (data == 1) {
                                return "<div class='btn btn-sm bg-primary'><i class='fas fa-info-circle'></i>&nbsp;&nbsp;Invoice Sudah Terbit</div>";

                            } else if (data == 0) {
                                return "<div class='btn btn-sm bg-danger'><i class='fas fa-times-circle'></i>&nbsp;&nbsp;Invoice Belum Terbit</div>";
                            } else if (data == 2) {
                                return "<div class='btn btn-sm bg-warning'><i class='fas fa-paper-plane'></i>&nbsp;&nbsp;Invoice Terkirim</div>";
                            } else if (data == 3) {
                                return "<div class='btn btn-sm bg-success'><i class='fas fa-check'></i>&nbsp;&nbsp;Terbayar</div>";
                            } else if (data == 4) {
                                return "<div class='btn btn-sm bg-warning'><i class='fas fa-check'></i>&nbsp;&nbsp;Belum Lunas</div>";
                            }
                        }
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
                    },
                    {
                        "creator": [{
                            "status": "status",
                            "id_tagihan": "id_tagihan",
                            "id_pelanggan": "id_pelanggan",
                            "nama_pelanggan": "nama_pelanggan",
                            "tahun": "tahun",
                            "bulan": "bulan",
                        }],
                        "data": "status",
                        "className": 'dt-body-center',
                        render: function(data, type, row) {
                            html = "<div class='btn-group'>";
                            html += "<button type='button' class='btn btn-success'>Aksi</button>";
                            html += "<button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>";
                            html += "<span class='sr-only'>Toggle Dropdown</span>";
                            html += "</button>";
                            html += "<div class='dropdown-menu' role='menu'>";
                            if (data == 0) {
                                html += "<a href='#' data-target='#terbitInvoice" + row.id_tagihan + "' data-toggle='modal' class='dropdown-item' title='Klik untuk Menonaktifkan'>";
                                html += "Terbitkan Invoice";
                                html += "</a>";
                            }
                            if (data == 1) {
                                //html += "<a href='#' class='dropdown-item'>";
                                //html += "Kirim Invoice";
                                //html += "</a>";
                            }
                            if (data == 1 || data == 2 || data == 4) {
                                html += "<a target='_blank' href='<?= base_url() ?>tagihan/downloadinvoice/" + row.id_pelanggan + "/" + row.id_tagihan + "/" + row.tahun + "/" + row.bulan + "' class='dropdown-item'>";
                                html += "Download Invoice";
                                html += "</a>";
                            }
                            if (data == 1 || data == 2 || data == 4) {
                                html += "<form action='<?= base_url(); ?>tagihan/konfirmasi' method='POST'>";
                                html += "<input type='hidden' name='id_pelanggan' value='" + row.id_pelanggan + "'>";
                                html += "<input type='hidden' name='id_tagihan' value='" + row.id_tagihan + "'>";
                                html += "<input type='hidden' name='bulan' value='" + row.bulan + "'>";
                                html += "<input type='hidden' name='tahun' value='" + row.tahun + "'>";
                                html += "<input type='submit' class='dropdown-item' value='Konfirmasi Pembayaran'>";
                                html += "</form>";
                            }
                            if (data == 1 || data == 2 || data == 4) {
                                html += "<a href='#' data-target='#activateModal" + row.id_tagihan + "' data-toggle='modal' class='dropdown-item'>Tambah Diskon</a>";
                            }
                            if (data == 1 || data == 2 || data == 4) {
                                html += "<a href='#' data-target='#batalTagihan" + row.id_tagihan + "' data-toggle='modal' class='dropdown-item'>Batalkan Tagihan </a>";
                            }
                            if (data == 3 || data == 4) {
                                html += "<a href='<?= base_url(); ?>tagihan/kuitansi/" + row.id_pelanggan + "' class='dropdown-item'>";
                                html += "Lihat Kuitansi";
                                html += "</a>";
                            }
                            html += "</div>";
                            html += "</div>";

                            //Modal Batal Tagihan
                            html += "<div class='modal fade' id='batalTagihan" + row.id_tagihan + "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
                            html += "<form action='<?= base_url(); ?>tagihan/bataltagihanindividu' method='post'>";
                            html += "<input type='hidden' name='id_pelanggan' value='" + row.id_pelanggan + "'>";
                            html += "<input type='hidden' name='id_tagihan' value='" + row.id_tagihan + "'>";
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
                            html += "<input type='hidden' name='id_pelanggan' class='id' value='" + row.id_pelanggan + "'>";
                            html += "<input type='hidden' name='active' class='active' value='" + data + "'>";
                            html += "<button class='btn btn-secondary' type='button' data-dismiss='modal'>Tidak</button>";
                            html += "<button type='submit' class='btn btn-primary'>Ya</button>";
                            html += "</div>";
                            html += "</div>";
                            html += "</div>";
                            html += "</form>";
                            html += "</div>";

                            //Modal Tambah Diskon
                            html += "<div class='modal fade' id='activateModal" + row.id_tagihan + "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
                            html += "<form action='<?= base_url(); ?>tagihan/tambahdiskon' method='post'>";
                            html += "<input type='hidden' name='id_tagihan' value='" + row.id_tagihan + "'>";
                            html += "<input type='hidden' name='bulan' value='" + row.bulan + "'>";
                            html += "<input type='hidden' name='tahun' value='" + row.tahun + "'>";
                            html += "<input type='hidden' name='id_pelanggan' value='" + row.id_pelanggan + "'>";
                            html += "<div class='modal-dialog' role='document'>";
                            html += "<div class='modal-content'>";
                            html += "<div class='modal-header'>";
                            html += "<h5 class='modal-title' id='exampleModalLabel'>Tambah Diskon a.n " + row.nama_pelanggan + "</h5>";
                            html += "<button class='close' type='button' data-dismiss='modal' aria-label='Close'>";
                            html += "<span aria-hidden='true'>×</span>";
                            html += "</button>";
                            html += "</div>";
                            html += "<div class='text-left modal-body'>";
                            html += "<div class='list-group-item p-3'>";
                            html += "<div class='row align-items-start'>";
                            html += "<div class='col-md-4 mb-8pt mb-md-0'>";
                            html += "<div class='media align-items-left'>";
                            html += "<div class='d-flex flex-column media-body media-middle'>";
                            html += "<span class='card-title'>Diskon</span>";
                            html += "</div>";
                            html += "</div>";
                            html += "</div>";
                            html += "<div class='col mb-8pt mb-md-0'><input type='text' name='diskon' class='form-control'></div>";
                            html += "</div>";
                            html += "</div>";
                            html += "</div>";
                            html += "<div class='modal-footer'>";
                            html += "<button class='btn btn-secondary' type='button' data-dismiss='modal'>Batal</button>";
                            html += "<button type='submit' class='btn btn-primary'>Simpan</button>";
                            html += "</div>";
                            html += "</div>";
                            html += "</div>";
                            html += "</form>";
                            html += "</div>";
                            return html;
                        }
                    }
                ],
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

            $("#daftar-piutang-pelanggan").DataTable({
                "processing": true,
                "serverSide": true,
                "serverMethod": 'post',
                "ajax": "<?= site_url('pelanggan/pelangganAjax'); ?>",
                "columns": [{
                    "data": "id_pelanggan",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    "className": 'dt-body-center',
                }, {
                    "data": "nama_pelanggan",
                    "creator": [{
                        "kode_pelanggan": "kode_pelanggan",
                        "nama_pelanggan": "nama_pelanggan",
                    }],
                    render: function(data, type, row) {
                        html = data;
                        html += "&nbsp;<br/><b><i>(" + row.kode_pelanggan + ")</i></b>";
                        return html;
                    }
                }, {
                    "data": "alamat_pelanggan",
                }, {
                    "data": "telp_pelanggan",
                    "className": 'dt-body-center',
                }, {
                    "data": "piutang",
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
                    "className": 'dt-body-center',
                    render: function(data, type, row) {
                        return "<a href = '<?= base_url(); ?>tagihan/tagihanpelanggan/" + data + "' class = 'btn btn-success btn-circle btn-sm' title='Detail Tagihan'> <i class='fas fa-file-invoice'> </i> Detail Tagihan</a>";
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

            $("#daftar-bts").DataTable({
                "processing": true,
                "serverSide": true,
                "serverMethod": 'post',
                "ajax": "<?= site_url('bts/btsAjax'); ?>",
                "columns": [{
                    "data": "id_bts",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    "className": 'dt-body-center',
                }, {
                    "data": "jenis",
                    "className": 'dt-body-center',
                    render: function(data, id_pelanggan, type, row) {
                        if (data == 1) {
                            return "<div class='btn btn-sm bg-success'><i class='fas fa-broadcast-tower'></i>&nbsp;&nbsp;Link</div>";

                        } else if (data == 2) {
                            return "<div class='btn btn-sm bg-primary'><i class='fas fa-broadcast-tower'></i>&nbsp;&nbsp;BTS</div>";
                        }
                    }
                }, {
                    "data": "kode",
                    "className": 'dt-body-center',

                }, {
                    "data": "nama_bts",
                }, {
                    "data": "alamat_bts",
                }, {
                    "creator": [{
                        "id_bts": "id_bts",
                        "nama_bts": "nama_bts",
                    }],
                    "data": "id_bts",
                    "className": 'dt-body-center',
                    render: function(data, type, row) {
                        html = "<a href='<?= base_url(); ?>bts/detail/" + row.id_bts + "' class='btn btn-primary btn-circle btn-sm' title='Detail Data BTS'><i class='fas fa-eye'></i></a>&nbsp;";
                        html += "<a href='<?= base_url(); ?>bts/edit/" + row.id_bts + "' class='btn btn-warning btn-circle btn-sm' title='Edit Data BTS'><i class='fas fa-edit'></i></a>&nbsp;";
                        html += "<a href='#' data-target='#hapusModal" + row.id_bts + "' data-toggle='modal' class='btn btn-sm bg-danger' title='Klik untuk Menghapus'><i class='fas fa-trash'></i></a>";
                        html += "<div class='modal fade' id='hapusModal" + row.id_bts + "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
                        html += "<form action='<?= base_url(); ?>bts/hapus' method='post'>";
                        html += "<input type='hidden' name='id_bts' value='" + row.id_bts + "'>";
                        html += "<input type='hidden' name='nama_bts' value='" + row.nama_bts + "'>";
                        html += "<div class='modal-dialog' role='document'>";
                        html += "<div class='modal-content'>";
                        html += "<div class='modal-header'>";
                        html += "<h5 class='modal-title' id='exampleModalLabel'>Hapus Data BTS</h5>";
                        html += "<button class='close' type='button' data-dismiss='modal' aria-label='Close'>";
                        html += "<span aria-hidden='true'>×</span>";
                        html += "</button>";
                        html += "</div>";
                        html += "<div class='modal-body text-left'>Pilih 'Ya' untuk menghapus Data BTS</div>";
                        html += "<div class='modal-footer'>";
                        html += "<button class='btn btn-secondary' type='button' data-dismiss='modal'>Tidak</button>";
                        html += "<button type='submit' class='btn btn-primary'>Ya</button>";
                        html += "</div>";
                        html += "</div>";
                        html += "</div>";
                        html += "</form>";
                        html += "</div>";
                        return html;
                    }
                }],
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#table-responsive .col-md-6:eq(0)');

            $("#daftar-aset").DataTable({
                "processing": true,
                "serverSide": true,
                "serverMethod": 'post',
                "ajax": "<?= site_url('aset/asetAjax'); ?>",
                "columns": [{
                    "data": "id_aset",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    "className": 'dt-body-center',
                }, {
                    "data": "nama_kualifikasi",
                    "className": 'dt-body-center',
                }, {
                    "data": "kode_item",
                    "className": 'dt-body-center',
                }, {
                    "data": "nama_item",
                }, {
                    "data": "stok",
                    "className": 'dt-body-center',
                }, {
                    "creator": [{
                        "id_aset": "id_aset",
                        "nama_item": "nama_item",
                    }],
                    "data": "id_aset",
                    "className": 'dt-body-center',
                    render: function(data, type, row) {
                        html = "<a href='<?= base_url(); ?>aset/detail/" + row.id_aset + "' class='btn btn-primary btn-circle btn-sm' title='Detail Data BTS'><i class='fas fa-eye'></i></a>&nbsp;";
                        html += "<a href='<?= base_url(); ?>aset/edit/" + row.id_aset + "' class='btn btn-warning btn-circle btn-sm' title='Edit Data BTS'><i class='fas fa-edit'></i></a>&nbsp;";
                        html += "<a href='#' data-target='#hapusModal" + row.id_aset + "' data-toggle='modal' class='btn btn-sm bg-danger' title='Klik untuk Menghapus'><i class='fas fa-trash'></i></a>";
                        html += "<div class='modal fade' id='hapusModal" + row.id_aset + "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
                        html += "<form action='<?= base_url(); ?>aset/hapus' method='post'>";
                        html += "<input type='hidden' name='id_aset' value='" + row.id_aset + "'>";
                        html += "<input type='hidden' name='nama_item' value='" + row.nama_item + "'>";
                        html += "<div class='modal-dialog' role='document'>";
                        html += "<div class='modal-content'>";
                        html += "<div class='modal-header'>";
                        html += "<h5 class='modal-title' id='exampleModalLabel'>Hapus Data Aset</h5>";
                        html += "<button class='close' type='button' data-dismiss='modal' aria-label='Close'>";
                        html += "<span aria-hidden='true'>×</span>";
                        html += "</button>";
                        html += "</div>";
                        html += "<div class='modal-body text-left'>Pilih 'Ya' untuk menghapus Data Aset</div>";
                        html += "<div class='modal-footer'>";
                        html += "<button class='btn btn-secondary' type='button' data-dismiss='modal'>Tidak</button>";
                        html += "<button type='submit' class='btn btn-primary'>Ya</button>";
                        html += "</div>";
                        html += "</div>";
                        html += "</div>";
                        html += "</form>";
                        html += "</div>";
                        return html;
                    }
                }],
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#table-responsive .col-md-6:eq(0)');

            $("#daftar-pengajuan").DataTable({
                "responsive": true,
                "pageLength": 5,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $("#daftar-survey").DataTable({
                "responsive": true,
                "pageLength": 5,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $("#daftar-setuju").DataTable({
                "responsive": true,
                "pageLength": 5,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $("#daftar-tolak").DataTable({
                "responsive": true,
                "pageLength": 5,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $("#daftar-registrasi").DataTable({
                "responsive": true,
                "lengthChange": true,
                "pageLength": 5,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $("#daftar-workorder").DataTable({
                "responsive": true,
                "lengthChange": true,
                "pageLength": 30,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $("#daftar-bulan").DataTable({
                "responsive": true,
                "pageLength": 50,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


            $('#example2').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            $("#daftar-error-terbanyak").DataTable({
                "responsive": true,
                "pageLength": 10,
                "lengthChange": true,
                "ordering": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#daftar-error-terbanyak .col-md-6:eq(0)');

        });
    </script>

    <script>
        $(function() {
            // Summernote
            $('#summernote').summernote({
                width: '100%',
                removeFormat: true,
            })

            // Summernote
            $('#summernote1').summernote({
                width: '100%',
            })

            // Summernote
            $('#summernote2').summernote({
                width: '100%',
            })

            // Summernote
            $('#summernote3').summernote({
                width: '100%',
            })

            // Summernote
            $('#summernote4').summernote({
                width: '100%',
            })

            // Summernote
            $('#summernote5').summernote({
                width: '100%',
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
                    url: "<?= site_url('pemasukan/ajaxsearch') ?>",
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

            // Initialize select2
            $("#selTeknisi").select2({
                ajax: {
                    url: "<?= site_url('pekerjaan/ajaxsearch') ?>",
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

            $("#selTeknisi1").select2({
                ajax: {
                    url: "<?= site_url('pekerjaan/ajaxsearch') ?>",
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

            $("#selTeknisi2").select2({
                ajax: {
                    url: "<?= site_url('pekerjaan/ajaxsearch') ?>",
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

            $("#selTeknisi3").select2({
                ajax: {
                    url: "<?= site_url('pekerjaan/ajaxsearch') ?>",
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

            $("#selTeknisi4").select2({
                ajax: {
                    url: "<?= site_url('pekerjaan/ajaxsearch') ?>",
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

            $("#selHDO").select2({
                ajax: {
                    url: "<?= site_url('error/ajaxsearch') ?>",
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

            $("#selBTS").select2({
                ajax: {
                    url: "<?= site_url('error/ajaxbts') ?>",
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

</body>

</html>