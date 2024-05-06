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
                <a href="<?= base_url(); ?>kuitansi/tambah" class="btn btn-success"><i class="fas fa-plus"></i>&nbsp;&nbsp;&nbsp;Buat Custom Kuitansi&nbsp;&nbsp;&nbsp;</a>
                <br /><br />
                <?php if (session()->getFlashdata('pesan')) : ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-check"></i> <?= session()->getFlashdata('pesan'); ?>
                    </div>
                <?php endif; ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable dtr-inline collapsed" id="daftar-user" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="15%" class="text-center">Tanggal</th>
                                <th width="15%" class="text-center">Nama Pelanggan</th>
                                <th width="25%" class="text-center">Item Layanan</th>
                                <th width="15%" class="text-center">Nominal</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            function tgl_indo($tanggal)
                            {
                                $bulan = array(
                                    1 =>   'Januari',
                                    'Februari',
                                    'Maret',
                                    'April',
                                    'Mei',
                                    'Juni',
                                    'Juli',
                                    'Agustus',
                                    'September',
                                    'Oktober',
                                    'November',
                                    'Desember'
                                );
                                $pecahkan = explode('-', $tanggal);

                                // variabel pecahkan 0 = tanggal
                                // variabel pecahkan 1 = bulan
                                // variabel pecahkan 2 = tahun

                                return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
                            }
                            ?>
                            <?php
                            $no = 1;
                            foreach ($kuitansi as $row) :
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td class="text-center"><?= tgl_indo($row['tgl_kuitansi']); ?></td>
                                    <td class="text-center">
                                        <?= $row['nama_pelanggan'] ?> - <?= $row['kode_pelanggan'] ?>
                                    </td>
                                    <td class="kustomindex">
                                        <style>
                                            .kustomindex ul {
                                                font-size: 17px;
                                                margin: 0;
                                                padding: 0;
                                                list-style: none;
                                            }

                                            .kustomindex li {
                                                margin: 0;
                                                padding: 0;
                                                padding-left: 1em;
                                                text-indent: -1em;
                                            }

                                            .kustomindex li:before {
                                                content: "-";
                                                padding-right: 5px;
                                            }
                                        </style>
                                        <?php
                                        $cek1 = str_replace('<p>', '', $row['item_layanan']);
                                        $cek2 = str_replace('</p>', '', $cek1);
                                        $cek3 = str_replace('<ol>', '<ul>', $cek2);
                                        $cek4 = str_replace('</ol>', '</ul>', $cek3);
                                        echo $cek4;
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        Rp. <?= number_format($row['nominal_kuitansi']); ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success">Aksi</button>
                                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <a href="<?= base_url() ?>kuitansi/edit/<?= $row['id_kuitansi_custom']; ?>" class="dropdown-item">
                                                    Edit Kuitansi
                                                </a>
                                                <a href="#" data-target="#hapusModal<?= $row['id_kuitansi_custom']; ?>" data-toggle="modal" class="dropdown-item" title="Klik untuk Menghapus">
                                                    Hapus Kuitansi
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a target="_blank" href="<?= base_url() ?>kuitansi/downloadkuitansi/<?= $row['id_kuitansi_custom']; ?>" class="dropdown-item">
                                                    Download Kuitansi
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="hapusModal<?= $row['id_kuitansi_custom']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <form action="<?= base_url(); ?>kuitansi/hapus" method="post">
                                        <input type="hidden" name="id_kuitansi_custom" value="<?= $row['id_kuitansi_custom'] ?>">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Kuitansi</h5>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">Pilih "Ya" untuk menghapus Data Kuitansi</div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                                                    <button type="submit" class="btn btn-primary">Ya</button>
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