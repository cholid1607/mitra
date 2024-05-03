<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="T2Net">
    <meta name="description" content="Invoice">
    <title>Kuitansi <?= $no_kuitansi; ?> - <?= $nama_pelanggan; ?></title>

    <style>
        .tableutama {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
        }

        .tableutama td,
        .tableutama th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        body {
            font-size: 12px;
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

        h4.header {
            color: #3e7fe6;
            margin-bottom: 0;
            font-size: 13px;
        }

        h2.header {
            color: #3e7fe6;
            margin-bottom: 0;
            font-size: 20px;
        }

        .kontak {
            font-size: 12px;
        }

        ul {
            font-size: 12px;
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

        i.box {
            border: 2px solid black;
            font-style: normal;
            margin-left: 1em;
            padding: 0.5em;
            font-size: 12px;
        }

        .container {
            position: relative;
            width: 100%;
            padding: 10px;
            border: 3px solid black;
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

        h3.judullogo,
        h4.judullogo {
            margin: 0;
            text-align: left;
        }
    </style>
    <link rel="shortcut icon" type="image/png" href="t2net.png">
</head>

<body>
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
    ?>

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
        <div class="container">
            <table width="100%" cellspacing="0">
                <tr>

                    <!--<td><img height="auto" src="data:image/png;base64,{{ base64_encode(file_get_contents('http://localhost/img/AdminLTELogo.png'))}}"></td>-->
                    <td>
                        <img height="auto" width="55%" src='logo-t2net.png'>
                        <br />
                        <h3 class="judullogo">PT. TONGGAK TEKNOLOGI NETIKOM</h3>
                        <h4 class="judullogo">INTERNET SERVICE PROVIDER</h4>
                    </td>
                    <td class="kontak text-right">
                        <h2 class="header" style="margin-right:2em;">KUITANSI</h2>
                        <table style="margin-left:16em; font-size: 12px;">
                            <tr>
                                <td>No. Kuitansi</td>
                                <td>: <?= $row['no_kuitansi']; ?></td>
                            </tr>
                            <tr>
                                <td>Tgl. Pembayaran</td>
                                <td>: <?= tgl_indo($row['tgl_kuitansi']); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br />
            <br />
            <table width="100%" valign="top" style="font-style: italic; font-size: 12px;">
                <tr valign="top">
                    <td width="33%">Sudah terima pembayaran dari</td>
                    <td width="2%">:</td>
                    <td colspan="2" width="40%"><?= $row['nama_pelanggan']; ?></td>
                </tr>
                <tr valign="top">
                    <td colspan="4">
                        <hr>
                    </td>
                </tr>
                <tr valign="top">
                    <td>Untuk pembayaran</td>
                    <td>:</td>
                    <td valign="top">
                        <?php
                        $cek1 = str_replace('<p>', '', $row['item_layanan']);
                        $cek2 = str_replace('</p>', '', $cek1);
                        $cek3 = str_replace('<ol>', '<ul>', $cek2);
                        $cek4 = str_replace('</ol>', '</ul>', $cek3);
                        echo $cek4;
                        ?>
                    </td>
                    <td width="20%">
                        <?= 'Rp' . number_format($row['nominal_kuitansi']);  ?>
                    </td>
                </tr>
                <tr valign="top">
                    <td colspan="4">
                        <hr>
                    </td>
                </tr>
                <tr valign="top">
                    <td>Terbilang</td>
                    <td>:</td>
                    <td colspan="2"><?= '<b>' . ucwords(terbilang($row['nominal_kuitansi'])) . ' Rupiah</b>'; ?></td>
                </tr>
            </table>
            <br />
            <br />
            <b style="margin-left:2em;">Jumlah</b><i class="box">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rp <?= number_format($row['nominal_kuitansi']); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>
            <br /><br />
            <table width="100%">
                <tr>
                    <td width="50%">
                        <b>METODE PEMBAYARAN</b><br />
                        <table>
                            <tr>
                                <td>
                                    <input type="checkbox" <?= $row['akun_bank'] == 'Mandiri - Hari Ismanto' ? 'checked' : ''; ?>>
                                </td>
                                <td>
                                    Mandiri a.n Hari Ismanto
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" <?= $row['akun_bank'] == 'BCA - Titin Setyowati' ? 'checked' : ''; ?>>
                                </td>
                                <td>
                                    BCA a.n Titin Setyowati
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" <?= $row['akun_bank'] == 'BCA - PT. Tonggak Teknologi Netikom' ? 'checked' : ''; ?>>
                                </td>
                                <td>
                                    BCA - PT. Tonggak Teknologi Netikom
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" <?= $row['akun_bank'] == 'BPD - PT. Tonggak Teknologi Netikom' ? 'checked' : ''; ?>>
                                </td>
                                <td>
                                    BPD - PT. Tonggak Teknologi Netikom
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" <?= $row['akun_bank'] == 'BPD - Hari Ismanto' ? 'checked' : ''; ?>>
                                </td>
                                <td>
                                    BPD A.n Hari Ismanto
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" <?= $row['akun_bank'] == 'QRIS' ? 'checked' : ''; ?>>
                                </td>
                                <td>
                                    QRIS
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" <?= $row['akun_bank'] == 'Tunai' ? 'checked' : ''; ?>>
                                </td>
                                <td>
                                    Tunai
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%" class="text-center">
                        <b>PT. TONGGAK TEKNOLOGI NETIKOM</b><br /><br /><br /><br /><br /><br /><br />
                        <b>Mei Wulan</b>
                        <br />
                        <b>Finance & Billing</b>
                    </td>
                </tr>
            </table>

            <br /><br />
            <div class="text-center">Jl. Merpati, Jaban Tridadi Sleman Yogyakarta 55511 || Telepon : 0274 288 0464 || Email : adm@t2net.id || Website : www.t2net.id
                <br />
                <i>Dicetak oleh <?= user()->username; ?> pada <?= date('j F Y') ?> jam <?= date('H:i:s'); ?></i>
            </div>
            <div>
            <?php
        endforeach;
            ?>
</body>

</html>