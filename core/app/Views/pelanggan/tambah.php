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
                <form action="<?= base_url(); ?>pelanggan/simpan" method="post">
                    <?php if ((in_groups('superuser')) || (in_groups('admin')) || (in_groups('hdo'))) : ?>
                        <h5><b>Data Utama Pelanggan</b></h5>
                        <hr />
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="kodepelanggan" class="col-sm-2 col-form-label">Kode Pelanggan</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                        </div>
                                        <input required name="kode_pelanggan" type="text" class="form-control" id="kodepelanggan" placeholder="Kode Pelanggan">
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
                                        <input required name="nama_pelanggan" type="text" class="form-control" id="namapelanggan" placeholder="Nama Pelanggan">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tgl_pemasangan" class="col-sm-2 col-form-label">Tanggal Instalasi</label>
                                <div class="col-sm-3">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input required name="tgl_pemasangan" type="date" placeholder="yyyy/mm/dd" class="form-control" id="tanggalinstalasi" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy/mm/dd" data-mask="" inputmode="numeric">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tgl_tagihan" class="col-sm-2 col-form-label">Tanggal Tagihan</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input name="tgl_tagihan" value="10" type="number" placeholder="Tuliskan Tanggal saja 1-31" class="form-control" id="tgl_tagihan">
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
                                        <input required name="nik_pelanggan" type="text" class="form-control" id="nik" placeholder="NIK Pelanggan">
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
                                        <textarea required name="alamat_pelanggan" class="form-control" id="alamat" placeholder="Alamat Pelanggan"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telepon" class="col-sm-2 col-form-label">Telepon</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><b>+62</b></span>
                                        </div>
                                        <input required name="telp_pelanggan" type="text" class="form-control" id="telepon" placeholder="89123456789">
                                    </div>
                                    <i style="font-size:14px;">Hilangkan angka 0 yang ada di paling depan. Contoh : 089123456789 ditulis 89123456789</i>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ((in_groups('superuser')) || (in_groups('admin'))) : ?>
                        <h5><b>Data Keuangan Pelanggan</b></h5>
                        <hr />
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="paketlangganan" class="col-sm-2 col-form-label">Paket Langganan</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-list"></i></span>
                                        </div>
                                        <input name="paket_langganan" type="text" class="form-control" id="paketlangganan" placeholder="Paket Langganan">
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
                                        <input name="bandwidth" type="text" class="form-control" id="bandwidth" placeholder="Bandwidth Pelanggan">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kualifikasi" class="col-sm-2 col-form-label">Kualifikasi</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-star"></i></span>
                                        </div>
                                        <input name="kualifikasi" type="text" class="form-control" id="kualifikasi" placeholder="Kualifikasi Pelanggan">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="periode" class="col-sm-2 col-form-label">Periode</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                        </div>
                                        <input name="periode" type="text" class="form-control" id="periode" placeholder="Periode Pelanggan">
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
                                        <input required name="harga" type="text" class="form-control" id="result_input" placeholder="Nominal Pelanggan">
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
                                        <select required name="status_ppn" class="form-control" id="prioritas">
                                            <option value="Ya">Ya</option>
                                            <option value="Tidak">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="prioritas" class="col-sm-2 col-form-label">Kualifikasi Prioritas</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-tachometer-alt"></i></span>
                                        </div>
                                        <select required name="kualifikasi_prioritas" class="form-control" id="prioritas">
                                            <option value="personal">Prioritas 4 - Personal</option>
                                            <option value="premium">Prioritas 3 - Personal Premium</option>
                                            <option value="dedicated">Prioritas 2 - Dedicated/Sekolah</option>
                                            <option value="bts">Prioritas 1 - BTS</option>
                                        </select>
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
                                        <select name="ket_pelanggan" class="form-control" id="keteranganpelanggan">
                                            <option value="prabayar">Prabayar</option>
                                            <option value="pascabayar">Pascabayar</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ((in_groups('superuser')) || (in_groups('hdo'))) : ?>
                        <h5><b>Data Teknis Pelanggan</b></h5>
                        <hr />
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="alamatpasang" class="col-sm-2 col-form-label">Alamat Pemasangan</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                                        </div>
                                        <textarea name="alamat_pemasangan" class="form-control" id="alamatpasang" placeholder="Alamat Pemasangan"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bts" class="col-sm-2 col-form-label">BTS</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-broadcast-tower"></i></span>
                                        </div>
                                        <input name="bts" type="text" class="form-control" id="bts" placeholder="BTS">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="metode" class="col-sm-2 col-form-label">Metode Pemasangan</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-tools"></i></span>
                                        </div>
                                        <input name="metode_pemasangan" type="text" class="form-control" id="metode" placeholder="Metode Pemasangan">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="apdude" class="col-sm-2 col-form-label">AP Nama Dude</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-wifi"></i></span>
                                        </div>
                                        <input name="ap_nama_dude" type="text" class="form-control" id="apdude" placeholder="AP Nama Dude">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ipap" class="col-sm-2 col-form-label">AP IP Address</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-network-wired"></i></span>
                                        </div>
                                        <input name="ip_akses_point" type="text" class="form-control" id="ipap" placeholder="AP IP Address">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="namadeviceap" class="col-sm-2 col-form-label">AP Nama Device</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signal"></i></span>
                                        </div>
                                        <input name="ap_nama_device" type="text" class="form-control" id="namadeviceap" placeholder="AP Nama Device">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="apssid" class="col-sm-2 col-form-label">AP SSID</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                        </div>
                                        <input name="ap_ssid" type="text" class="form-control" id="apssid" placeholder="AP SSID">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="antenaap" class="col-sm-2 col-form-label">AP Antena</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-satellite-dish"></i></span>
                                        </div>
                                        <input name="ap_antena" type="text" class="form-control" id="antenaap" placeholder="AP Antena">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="besiap" class="col-sm-2 col-form-label">AP Besi</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-ruler"></i></span>
                                        </div>
                                        <input name="ap_besi" type="text" class="form-control" id="besiap" placeholder="AP Besi">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="loginap" class="col-sm-2 col-form-label">AP Login</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-users"></i></span>
                                        </div>
                                        <input name="ap_login" type="text" class="form-control" id="loginap" placeholder="AP Login">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="passwordap" class="col-sm-2 col-form-label">AP Password</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        </div>
                                        <input name="ap_password" type="text" class="form-control" id="passwordap" placeholder="AP Password">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ketap" class="col-sm-2 col-form-label">AP Keterangan</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                        </div>
                                        <textarea name="ket_ap" class="form-control" id="ketap" placeholder="AP Keterangan"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ip_station" class="col-sm-2 col-form-label">ST IP Address</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signal"></i></span>
                                        </div>
                                        <input name="ip_station" type="text" class="form-control" id="ip_station" placeholder="ST IP Address">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="namadevicest" class="col-sm-2 col-form-label">ST Nama Device</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signal"></i></span>
                                        </div>
                                        <input name="st_nama_device" type="text" class="form-control" id="namadevicest" placeholder="ST Nama Device">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="stssid" class="col-sm-2 col-form-label">ST SSID</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                        </div>
                                        <input name="st_ssid" type="text" class="form-control" id="stssid" placeholder="ST SSID">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="stantena" class="col-sm-2 col-form-label">ST Antena</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-satellite-dish"></i></span>
                                        </div>
                                        <input name="st_antena" type="text" class="form-control" id="stantena" placeholder="ST Antena">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="stbesi" class="col-sm-2 col-form-label">ST Besi</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-ruler"></i></span>
                                        </div>
                                        <input name="st_besi" type="text" class="form-control" id="stbesi" placeholder="ST Besi">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="stlogin" class="col-sm-2 col-form-label">ST Login</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-users"></i></span>
                                        </div>
                                        <input name="st_login" type="text" class="form-control" id="stlogin" placeholder="ST Login">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="stpassword" class="col-sm-2 col-form-label">ST Password</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        </div>
                                        <input name="st_password" type="text" class="form-control" id="stpassword" placeholder="ST Password">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ketst" class="col-sm-2 col-form-label">ST Ket. </label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                        </div>
                                        <textarea name="ket_st" class="form-control" id="ketst" placeholder="ST Keterangan"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="namahotspot" class="col-sm-2 col-form-label">Nama Hotspot</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signal"></i></span>
                                        </div>
                                        <input name="nama_hotspot" type="text" class="form-control" id="namahotspot" placeholder="Nama Hotspot">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="iphotspot" class="col-sm-2 col-form-label">IP Hotspot</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-network-wired"></i></span>
                                        </div>
                                        <input name="ip_hotspot" type="text" class="form-control" id="iphotspot" placeholder="IP Hotspot">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="hotspotlogin" class="col-sm-2 col-form-label">Hotspot Login</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-users"></i></span>
                                        </div>
                                        <input name="login_hotspot" type="text" class="form-control" id="hotspotlogin" placeholder="Hotspot Login">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="hotspotpassword" class="col-sm-2 col-form-label">Hotspot Password</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        </div>
                                        <input name="password_hotspot" type="text" class="form-control" id="hotspotpassword" placeholder="Hotspot Password">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ketperangkat" class="col-sm-2 col-form-label">Ket. Perangkat</label>
                                <div class="col-sm-10">
                                    <div class="input-group row">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                        </div>
                                        <textarea name="ket_perangkat" class="form-control" id="ketperangkat" placeholder="Keterangan Perangkat"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="btn" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-4">
                                <div class="input-group row">
                                    <input type="submit" class="btn btn-success" value="Tambah Pelanggan">&nbsp;&nbsp;
                                    <a onclick="location.replace('<?= base_url(); ?>pelanggan')" class="btn btn-default">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<?= $this->endSection(); ?>