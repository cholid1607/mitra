<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title; ?>&nbsp;<?= $detail['nama_pelanggan']; ?></h1>
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
        <!-- Default box -->
        <div class="card">
            <div class="card-body">
                <?php if ((in_groups('superuser')) || (in_groups('mitra'))) : ?>
                    <a href='#' data-target='#activateModal<?= $detail['id_pelanggan']; ?>' data-toggle='modal' class='btn bg-success' title='Klik untuk Menerbitkan Tagihan Bulan Tertentu'><i class='fas fa-list-alt'></i> Terbitkan Tagihan Bulan Tertentu </a>
                    <div class='modal fade' id='activateModal<?= $detail['id_pelanggan']; ?>' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <form action='<?= base_url(); ?>tagihan/terbitindividu' method='post'>
                            <input type='hidden' name='kode_pelanggan' value='<?= $detail['kode_pelanggan']; ?>'>
                            <input type='hidden' name='nama_pelanggan' value='<?= $detail['nama_pelanggan']; ?>'>
                            <input type='hidden' name='id_pelanggan' value='<?= $detail['id_pelanggan']; ?>'>
                            <input type='hidden' name='id_mitra' value='<?= $detail['id_mitra']; ?>'>
                            <div class='modal-dialog' role='document'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Terbitkan Tagihan</h5>
                                        <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>×</span>
                                        </button>
                                    </div>
                                    <div class='text-left modal-body'>
                                        <div class="list-group-item p-3">
                                            <div class="row align-items-start">
                                                <div class="col-md-4 mb-8pt mb-md-0">
                                                    <div class="media align-items-left">
                                                        <div class="d-flex flex-column media-body media-middle">
                                                            <span class="card-title">Pilih Bulan</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col mb-8pt mb-md-0">
                                                    <select name="bulan" class="form-control">
                                                        <?php $month_now = date("m"); ?>
                                                        <option value="01" <?= $month_now == '01' ? 'selected' : ''; ?>>Januari</option>
                                                        <option value="02" <?= $month_now == '02' ? 'selected' : ''; ?>>Februari</option>
                                                        <option value="03" <?= $month_now == '03' ? 'selected' : ''; ?>>Maret</option>
                                                        <option value="04" <?= $month_now == '04' ? 'selected' : ''; ?>>April</option>
                                                        <option value="05" <?= $month_now == '05' ? 'selected' : ''; ?>>Mei</option>
                                                        <option value="06" <?= $month_now == '06' ? 'selected' : ''; ?>>Juni</option>
                                                        <option value="07" <?= $month_now == '07' ? 'selected' : ''; ?>>Juli</option>
                                                        <option value="08" <?= $month_now == '08' ? 'selected' : ''; ?>>Agustus</option>
                                                        <option value="09" <?= $month_now == '09' ? 'selected' : ''; ?>>September</option>
                                                        <option value="10" <?= $month_now == '10' ? 'selected' : ''; ?>>Oktober</option>
                                                        <option value="11" <?= $month_now == '11' ? 'selected' : ''; ?>>November</option>
                                                        <option value="12" <?= $month_now == '12' ? 'selected' : ''; ?>>Desember</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item p-3">
                                            <div class="row align-items-start">
                                                <div class="col-md-4 mb-8pt mb-md-0">
                                                    <div class="media align-items-left">
                                                        <div class="d-flex flex-column media-body media-middle">
                                                            <span class="card-title">Pilih Tahun</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col mb-8pt mb-md-0">
                                                    <select name="tahun" class="form-control">
                                                        <?php
                                                        $year_now = date("Y");
                                                        for ($tahun = 2022; $tahun <= 2050; $tahun++) {
                                                        ?>
                                                            <option value="<?= $tahun; ?>" <?= $year_now == $tahun ? 'selected' : ''; ?>><?= $tahun; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <input type='hidden' name='id_pelanggan' class='id' value='<?= $detail['id_pelanggan']; ?>'>
                                        <input type='hidden' name='active' class='active' value='<?= $detail['status']; ?>'>
                                        <button class='btn btn-secondary' type='button' data-dismiss='modal'>Batal</button>
                                        <button type='submit' class='btn btn-primary'>Terbitkan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
                <br /><br />
                <?php if (session()->getFlashdata('error_tagihan')) : ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-times-circle"></i> <?= session()->getFlashdata('error_tagihan'); ?>
                    </div>
                <?php endif; ?>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="kodepelanggan" class="col-sm-2 col-form-label">Kode Pelanggan</label>
                        <div class="col-sm-10">
                            <div class="input-group row">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                </div>
                                <input disabled style="background-color: #ffffff;" name="kode_pelanggan" value="<?= $detail['kode_pelanggan']; ?>" type="text" class="form-control" id="kodepelanggan" placeholder="-">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="namapelanggan" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                        <div class="col-sm-10">
                            <div class="input-group row">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input disabled style="background-color: #ffffff;" name="nama_pelanggan" value="<?= $detail['nama_pelanggan']; ?>" type="text" class="form-control" id="namapelanggan" placeholder="-">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nik" class="col-sm-2 col-form-label">NIK</label>
                        <div class="col-sm-10">
                            <div class="input-group row">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input disabled style="background-color: #ffffff;" name="nik_pelanggan" value="<?= $detail['nik_pelanggan']; ?>" type="text" class="form-control" id="nik" placeholder="-">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <div class="input-group row">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                </div>
                                <textarea disabled style="background-color: #ffffff;" name="alamat_pelanggan" class="form-control" id="alamat" placeholder="-"><?= $detail['alamat_pelanggan']; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="telepon" class="col-sm-2 col-form-label">Telepon</label>
                        <div class="col-sm-10">
                            <div class="input-group row">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input disabled style="background-color: #ffffff;" name="telp_pelanggan" value="<?= $detail['telp_pelanggan']; ?>" type="text" class="form-control" id="telepon" placeholder="-">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="paketlangganan" class="col-sm-2 col-form-label">Paket Langganan</label>
                        <div class="col-sm-10">
                            <div class="input-group row">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-list"></i></span>
                                </div>
                                <input disabled style="background-color: #ffffff;" name="paket_langganan" value="<?= $detail['paket_langganan']; ?>" type="text" class="form-control" id="paketlangganan" placeholder="-">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bandwidth" class="col-sm-2 col-form-label">Bandwidth</label>
                        <div class="col-sm-10">
                            <div class="input-group row">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-signal"></i></span>
                                </div>
                                <input disabled style="background-color: #ffffff;" name="bandwidth" value="<?= $detail['bandwidth']; ?>" type="text" class="form-control" id="bandwidth" placeholder="-">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nominal" class="col-sm-2 col-form-label">Harga</label>
                        <div class="col-sm-10">
                            <div class="input-group row">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                </div>
                                <input disabled style="background-color: #ffffff;" name="nominal" value="<?= number_format($detail['harga']); ?>" type="text" class="form-control" id="nominal" placeholder="-">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nominal" class="col-sm-2 col-form-label">PPN 11%</label>
                        <div class="col-sm-10">
                            <div class="input-group row">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                                </div>
                                <select disabled style="background-color: #ffffff;" required name="status_ppn" class="form-control" id="prioritas">
                                    <option <?= $detail['ppn'] != 0 ? 'selected' : ''; ?> value="Ya">Ya</option>
                                    <option <?= $detail['ppn'] == 0 ? 'selected' : ''; ?> value="Tidak">Tidak</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nominal" class="col-sm-2 col-form-label">Nominal</label>
                        <div class="col-sm-10">
                            <div class="input-group row">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-file-invoice-dollar"></i></span>
                                </div>
                                <input disabled style="background-color: #ffffff;" name="nominal" value="Rp. <?= number_format($detail['nominal']); ?>" type="text" class="form-control" id="nominal" placeholder="-">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="keteranganpelanggan" class="col-sm-2 col-form-label">Ket. Pelanggan</label>
                        <div class="col-sm-10">
                            <div class="input-group row">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-newspaper"></i></span>
                                </div>
                                <select disabled style="background-color: #ffffff;" name="ket_pelanggan" class="form-control" id="keteranganpelanggan">
                                    <option value="prabayar" <?= $detail['ket_pelanggan'] == 'prabayar' ? 'selected' : '' ?>>Prabayar</option>
                                    <option value="pascabayar" <?= $detail['ket_pelanggan'] == 'pascabayar' ? 'selected' : '' ?>>Pascabayar</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="btn" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-3">
                            <div class="input-group row">
                                <a onclick="history.back()" class=" btn btn-default">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Log Pelanggan</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="20%" class="text-center">Tanggal</th>
                            <th width="75%" class="text-center">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (!empty($log)) {
                            foreach ($log as $row) :
                        ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="text-center"><?= $row['tgl']; ?></td>
                                    <td><?= $row['deskripsi']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="3" class="text-center">Data Tidak Ditemukan</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br />
    </section>
    <!-- /.content -->
</div>
<?= $this->endSection(); ?>