<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    </script>
    <style>
    .line-title {
        border: 0;
        border-style: unset;
        border-top: 1px solid #000;
    }

    body {
        font-family: "Times New Roman", serif;
        font-size: 14px;
    }

    .table-border {
        font-size: 14px;
        width: 100%;
        border-collapse: collapse;
        text-align: center;
        border: 1px solid #333;
    }

    .table-border th {
        font-size: 1 solid #000;
        font-weight: bold;
        border: 1 solid #000;
    }

    .table-border td {
        border: 1 solid #000;
    }

    /* .box {
        width: 100%;
        height: 750px;
        border: 1px solid black;
    } */
    .signature {
        /* position: absolute; */
        bottom: 0;
        left: 70%;
    }
    </style>
</head>

<body>
    <img src="<?=base_url('../landing_assets/images/logo-uns-biru.png')?>"
        style="width:125px;height:auto;position:absolute; margin: 23px auto auto 50px">
    <table style="width:100%; margin-left:40px;">
        <tr>
            <td align="center">
                <span style="line-height:1.6; font-size:16px;">
                    KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, <br> RISET, DAN TEKNOLOGI
                </span>
                <br>
                <span style="font-size:14px;">
                    UNIVERSITAS SEBELAS MARET <br><strong>SEKOLAH VOKASI</strong>
                </span>
                <br>
                <span style="font-size:14px;">PROGRAM STUDI D3 TEKNIK INFORMATIKA (MADIUN)</span><br>
                <span style="font-size:12px;">Jalan Imam Bonjol, Pandean, Mejayan, Madiun <br> Telepon( 0351 ) 4486943
                    Faksimile(0351)
                    4486943</span><br>
                <span style="font-size:12px;">Website: https://prodi.vokasi.uns.ac.id/psdku-tekinfo/, Email:
                    d3ti.vokasiuns@gmail.com</span>
            </td>
        </tr>
    </table>
    <hr class="line-title">
    <h6 class="text-center"><b>Laporan Alat Laboratorium Rusak</b></h6>
    <br>
    <div class="row">
        <div class="col-md-6" style="font-size;12px;">
            <span><b>Nama Ruang : </b> <?=$data[0]->nama_ruang?></span>
        </div>
        <div class="col-md-6"></div>
    </div>
    <br>
    <div class="box">
        <table class="table-border">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Nama Alat</th>
                    <th>Nomor Inventaris</th>
                    <th>Tanggal Perubahan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;?>
                <?php foreach ($data as $dt): ?>
                <tr>
                    <td><?=$no++?></td>
                    <td><?=$dt->nama_kategori?></td>
                    <td><?=$dt->nama_alat?></td>
                    <td> <?php if ($dt->nama_kategori == 'Peralatan'): ?>
                        <?=$dt->no_inventaris?>
                        <?php elseif ($dt->nama_kategori == 'Barang Habis Pakai'): ?>
                        -
                        <?php endif;?>
                    </td>
                    <td><?=$dt->tanggal_perubahan?></td>
                    <td><?=$dt->jumlah_masuk?> <?=$dt->satuan?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <!-- </div> -->

        <br>
        <br>

        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6 signature">
                <span>Madiun, <?= date('d M Y')?></span>
                <br>
                <span>Laboran D3 Teknik Informatika,</span>
                <br>
                <br>
                <br>
                <br>
                <span>Ahmat Nurwakit, S.Kom.</span>
                <br>
                <span>NIP. 1979040820200801</span>
            </div>
        </div>
</body>

</html>