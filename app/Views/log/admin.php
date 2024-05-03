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
                <form action="<?= base_url(); ?>log/admin" method="post">
                    <div class="form-group row">
                        <label for="pilih_bulan" class="col-sm-2 col-form-label">Pilih Bulan</label>
                        <div class="col-sm-10">
                            <div class="input-group row">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <select name="bulan" class="form-control col-sm-2" id="pilih_bulan">
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

                    <div class="form-group row">
                        <label for="pilih_tahun" class="col-sm-2 col-form-label">Pilih Tahun</label>
                        <div class="col-sm-10">
                            <div class="input-group row">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <select name="tahun" class="form-control col-sm-2" id="pilih_tahun">
                                    <?php
                                    $year_now = date("Y");
                                    for ($tahun = 2023; $tahun <= 2050; $tahun++) {
                                    ?>
                                        <option value="<?= $tahun; ?>" <?= $year_now == $tahun ? 'selected' : ''; ?>><?= $tahun; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">

                        <div class="col-sm-12 col-form-label">
                            <div class="input-group row">
                                <div class="col-sm-3 mt-2"><button type="submit" name="tampilkan" class="form-control btn btn-success" value="Tampilkan"><i class="fas fa-eye"></i>&nbsp;&nbsp;&nbsp;Tampilkan</button></div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable dtr-inline collapsed" id="daftar-log-admin" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="20%" class="text-center">Tanggal</th>
                                <th width="55%" class="text-center">Deskripsi</th>
                                <th width="20%" class="text-center">Tipe Log</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <br />
    </section>
    <!-- /.content -->
</div>
<?= $this->endSection(); ?>