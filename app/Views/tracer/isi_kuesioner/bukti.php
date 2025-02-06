<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Bukti telah mengisi kuesioner dengan NIRM</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            margin-top: 1cm;
            margin-left: 1cm;
            margin-right: 1cm;
            /* margin-bottom: 1cm; */
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            /* border-collapse:inherit; */
            border-spacing: 0;
        }

        .logo {
            text-align: left !important;
            width: 1%;
            white-space: nowrap;
            margin-top: 10px;

        }

        .border-bottom {
            margin-top: 10px;
            margin-bottom: 10px;
            padding: 5px 0;
            width: 100%;
            border-bottom: 2px solid #000;
            display: inline-block;
        }

        .border-bottom:before {
            content: "";
            display: block;
            left: 0;
            bottom: 2px;
            width: 100%;
            height: 4px;
            background: #000;
        }

        .header {
            text-align: center;
            font-weight: bold;
            color: #000;
            white-space: pre-line;
            vertical-align: top;
            font-size: 18px;
        }


        #nama_perguruan {
            white-space: pre-line;
            font-size: 18pt;
            padding-left: 15px;
        }

        /* .header td {
            vertical-align: top;
        }
        .header td h3{
            padding-bottom: 20px;
        } */

        .address {
            font-size: 14px;
            font-weight: normal;
        }

        .body .header td {
            font-size: 16px;
            border: none;
            text-transform: uppercase;
            line-height: 1.2;
            padding-bottom: 50px;
        }

        .content td {
            text-align: left;
            vertical-align: top;
            padding: 0 5px 5px 5px;
        }

        .content th {
            vertical-align: top;
            white-space: nowrap;
            font-weight: bold;
            padding: 0 5px 0 0;
        }

        .faux-borders {
            padding: 1px 25%;
        }

        .signature {
            border-bottom: 2px dotted #000;
        }

        .photo {
            width: 200px;
            height: 300px;
        }
    </style>
</head>

<body>
    <table class="body" border="0">
        <tr class="header">
            <td>
                KARTU BUKTI PENGISIAN KUESIONER<br>
            </td>
        </tr>
        <tr class="content">
            <td>
                <table border="0">
                <?php foreach ($mahasiswa as $m): ?>
                    <tr>
                        <th align="left">Nama</th>
                        <th>:</th>
                        <td><?= $m->nama; ?></td>
                    </tr>
                    <tr>
                        <th align="left">NIM</th>
                        <th>:</th>
                        <td><?= $m->nim; ?></td>
                    </tr>
                    <tr>
                        <th align="left">Prodi</th>
                        <th>:</th>
                        <td><?= $m->prodi; ?></td>
                    </tr>
                    <tr>
                        <th align="left">Kelas</th>
                        <th>:</th>
                        <td><?= $m->kelas; ?></td>
                    </tr>
                    <tr>
                        <th align="left">Tahun Lulus</th>
                        <th>:</th>
                        <td><?= $m->th_lulus; ?></td>
                    </tr>
                <?php endforeach ?>
                </table>
            </td>

        </tr>
    </table>
    <br><br><br>
    <table border="0">
        <tr>
            <td width="50%" valign="top" align="right">
                <img src="" style="width: 115px;">
            </td>
        </tr>
    </table>
    <sub style="margin-top:100px;">Waktu Cetak: <?= date('d-m-Y H:i:s') ?></sub>
</body>

</html>