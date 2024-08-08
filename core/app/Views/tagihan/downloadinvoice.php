<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="T2Net">
    <meta name="description" content="Invoice">
    <title>Invoice <?= $no_invoice; ?> - <?= $nama_pelanggan; ?></title>

    <style>
        .tableutama {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 13px;
        }

        .tableutama td,
        .tableutama th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        body {
            font-size: 13px;
        }

        .tableutama tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .tableutama tr:hover {
            background-color: #ddd;
        }

        .tableutama th {
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: left;
            background-color: #09295c;
            color: white;
            text-align: center;
            vertical-align: middle;
        }

        h3 {
            text-align: center;
        }

        .tablepayment tr,
        .tablepayment td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        h4 {
            color: #3e7fe6;
            margin-bottom: 0;
            font-size: 14px;
        }

        .kontak {
            font-size: 12px;
        }

        ul {
            font-size: 13px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        li {
            margin: 0;
            padding: 0;
            border-bottom: 2px solid #fff;
            padding-left: 1em;
            text-indent: -1em;
        }

        i.rekening {
            color: #3e7fe6;
            font-style: normal;
        }

        .container {
            position: relative;
            width: 100%;
        }

        .alamat {
            position: fixed;
            width: 100%;
            left: 50%;
            bottom: 0;
            transform: translate(-50%, -50%);
            margin: 0 auto;
            text-align: center;
        }
    </style>
    <link rel="shortcut icon" type="image/png" href="t2net.png">
</head>

<body>
    <?php
    $no = 1;
    foreach ($last_tagihan as $row) :

    ?>
        <div class="container">
            <div style="position: fixed; 
            bottom: 600px; 
            left: 220px;
            z-index: -10000;
            font-size:100px; 
            color: red; 
            opacity: 0.6;">
                <img width="250px" src="t2-watermark.png">
            </div>
            <table width="100%" cellspacing="0">
                <tr>

                    <!--<td><img height="auto" src="data:image/png;base64,{{ base64_encode(file_get_contents('http://localhost/img/AdminLTELogo.png'))}}"></td>-->
                    <td>
                        <img height="auto" width="auto" height="80px" src='<?= base_url(); ?>/img/logo/<?= $logo_mitra; ?>'>
                        <br />
                        Supported By :<br />
                        PT. Tonggak Teknologi Netikom
                    </td>
                    <td class="kontak text-right">
                        <h4 style="font-size:20px;"><?= $nama_mitra; ?></h4>
                        <?= $alamat_mitra; ?><br />
                        Telepon : <?= $telepon_mitra; ?> Email : <?= $email_mitra; ?> <br />
                    </td>
                </tr>
            </table>
            <hr>
            <h3>INVOICE BILL<br /></h3>
            <table width="100%" valign="top">
                <tr valign="top">
                    <td valign="top" width="10%">Kepada</td>
                    <td valign="top" width="5%" class="text-right">:</td>
                    <td valign="top" width="35%"><?= $row['nama_pelanggan']; ?></td>
                    <td rowspan="4" valign="top" width="15%">
                        No. Invoice<br />
                        Tanggal Invoice<br />
                        Jatuh Tempo<br />
                        ID Pelanggan<br />
                    </td>
                    <td rowspan="4" valign="top" class="text-right" width="5%">
                        :<br />
                        :<br />
                        :<br />
                        :<br />
                    </td>
                    <td rowspan="4" valign="top" width="30%">
                        <?= $row['no_invoice']; ?><br />
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
                        <?= tgl_indo($row['tgl_invoice']); ?><br />
                        <?= tgl_indo($row['tgl_jatuhtempo']); ?><br />
                        <?= $row['kode_pelanggan']; ?><br />
                    </td>
                </tr>
                <tr valign="top">
                    <td valign="top">Alamat</td>
                    <td valign="top" class="text-right">:</td>
                    <td valign="top"><?= $alamat; ?></td>
                </tr>
                <tr valign="top">
                    <td valign="top">Telepon</td>
                    <td valign="top" class="text-right">:</td>
                    <td valign="top"><?= $telepon; ?></td>
                </tr>
            </table>
            <br /><br />
            <table class="tableutama" width="100%">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="15%" class="text-center">Layanan</th>
                        <th width="35%" class="text-center">Keterangan</th>
                        <th width="15%" class="text-center">Harga</th>
                        <th width="15%" class="text-center">PPN 11%</th>
                        <th width="15%" class="text-center">Jumlah Tagihan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr valign="top">
                        <td class="text-center"><?= $no++; ?></td>
                        <td class="text-center"><?= $layanan; ?></td>
                        <td><?= $row['item_layanan']; ?></td>
                        <?php $ceksisa_tagihan = $row['nominal'] + $row['ppn'];
                        if ($row['total_tagihan'] == $ceksisa_tagihan) {
                        ?>
                            <td class="text-center">Rp<?= number_format($row['nominal']); ?></td>
                            <td class="text-center">
                                <?php
                                if ($row['ppn'] == 0) {
                                    echo '-';
                                } else {
                                    echo 'Rp' . number_format($row['ppn']);
                                }
                                ?>
                            </td>
                        <?php } else { ?>
                            <td class="text-center">Rp<?= number_format($row['total_tagihan']); ?></td>
                            <td class="text-center">-</td>
                        <?php } ?>
                        <td class="text-center">Rp<?= number_format($row['total_tagihan']); ?></td>
                    </tr>
                    <tr valign="top">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php if (!empty($tagihan_piutang)) { ?>
                        <tr valign="top">
                            <td colspan="6" class="text-left"><i>Piutang</i></td>
                        </tr>
                    <?php } ?>
                    <?php
                    $no = 1;
                    $tagihan_terutang = 0;
                    $myArray = array();
                    foreach ($tagihan_piutang as $row1) :
                    ?>
                        <tr valign="top">
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="text-center"><?= $layanan; ?></td>
                            <td><?= $row1['item_layanan']; ?></td>
                            <?php $ceksisa_tagihan = $row1['nominal'] + $row1['ppn'];
                            if ($row1['total_tagihan'] == $ceksisa_tagihan) {
                            ?>
                                <td class="text-center">Rp<?= number_format($row1['nominal']); ?></td>
                                <td class="text-center">
                                    <?php
                                    if ($row1['ppn'] == 0) {
                                        echo '-';
                                    } else {
                                        echo 'Rp' . number_format($row1['ppn']);
                                    }
                                    ?>
                                </td>
                            <?php } else { ?>
                                <td class="text-center">Rp<?= number_format($row1['total_tagihan']); ?></td>
                                <td class="text-center">-</td>
                            <?php } ?>
                            <td class="text-center">Rp<?= number_format($row1['total_tagihan']); ?></td>
                        </tr>
                        <?php $tagihan_terutang = $tagihan_terutang + $row1['total_tagihan']; ?>
                    <?php
                    endforeach; ?>
                    <tr valign="top">
                        <td colspan="5" class="text-right"><b>Total Tagihan</b></td>
                        <td class="text-center">Rp<?= number_format($tagihan_terutang + $row['total_tagihan']); ?></td>
                    </tr>
                </tbody>
            </table>
            <?php
            function terbilang($x)
            {
                $angka = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];

                if ($x < 12)
                    return " " . $angka[$x];
                elseif ($x < 20)
                    return terbilang($x - 10) . " belas";
                elseif ($x < 100)
                    return terbilang($x / 10) . " puluh" . terbilang($x % 10);
                elseif ($x < 200)
                    return "seratus" . terbilang($x - 100);
                elseif ($x < 1000)
                    return terbilang($x / 100) . " ratus" . terbilang($x % 100);
                elseif ($x < 2000)
                    return "seribu" . terbilang($x - 1000);
                elseif ($x < 1000000)
                    return terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
                elseif ($x < 1000000000)
                    return terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
            }
            echo '<br/>';
            echo '<b><i>Terbilang : ' . ucwords(terbilang($tagihan_terutang + $row['total_tagihan'])) . ' Rupiah</b></i>';
            ?>
            <br /><br />
            <table width="100%">
                <tr>
                    <td width="50%">
                        <table class="tablepayment" width="100%">
                            <tr class="text-center">
                                <td><b>PAYMENT INFORMATION</b></td>
                            </tr>
                            <tr>
                                <td>
                                    <ol>
                                        <?php
                                        $db      = \Config\Database::connect();
                                        $builder = $db->table('pembayaran');
                                        $pembayaran = $builder->where('id_mitra', $row['id_mitra'])->get()->getResultArray();
                                        foreach ($pembayaran as $pembayaran) :
                                        ?>
                                            <li>
                                                <b><?= $pembayaran['nama_bank']; ?></b> <br />
                                                <?php if ($pembayaran['nama_bank'] != 'Tunai') { ?>
                                                    No. Rek <i class="rekening"><?= $pembayaran['rekening']; ?></i><br />
                                                    Atas nama <?= $pembayaran['atas_nama']; ?>
                                                <?php } ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ol>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%" class="text-center">
                        <b>PT. TONGGAK TEKNOLOGI NETIKOM</b><br>
                        <b><?= $nama_mitra; ?></b><br>
                        <table width="100%">
                            <tr>
                                <td width="60%" class="text-right">
                                    <img width="60%" src="img/cap/<?= $billing->ttd_cap; ?>">
                                </td>
                                <td width="40%" valign="bottom">
                                    <?= $qrcode; ?>
                                </td>
                            </tr>
                        </table>
                        <br />
                        </br>
                        <b><?= $billing->nama_billing ?></b>
                    </td>
                </tr>
            </table>
            <br /><br />
            Jika pembayaran dilakukan melalui Bank/Transfer mohon simpan bukti transaksi sebagai bukti pembayaran Anda, serta mencantumkan ID Pelanggan pada bukti pembayaran atau pada saat konfirmasi. Terimakasih
            <div>
                <br /><br />
                Jl. Merpati, Jaban Tridadi Sleman Yogyakarta 55511 || Telepon : 0274 288 0464 || Email : adm@t2net.id || Website : www.t2net.id
                <br />
                <br />
                <div class="text-center"><i>Dicetak oleh <?= user()->username; ?> pada <?= date('j F Y') ?> jam <?= date('H:i:s'); ?></i></div>
            </div>
            <div>
            <?php
        endforeach;
            ?>
</body>

</html>