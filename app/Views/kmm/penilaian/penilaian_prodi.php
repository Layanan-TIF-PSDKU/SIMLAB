<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('../assets/css/app-light.css') ?>" id="lightTheme" />

    <style>
    .line-title {
        border: 0;
        border-style: unset;
        border-top: 1px solid #000;
    }

    body {
        font-family: "Times New Roman", serif;
        font-size: 14px;
        color: #000;
        background-color: #fff;
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
        padding: 5px;
    }

    .table-border td {
        border: 1 solid #000;
        padding: 5px;
    }

    h6 {
        color: #000;
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
                <span style="font-size:12px;">Website: <a
                        href="https://prodi.vokasi.uns.ac.id/psdku-tekinfo/"><u>https://prodi.vokasi.uns.ac.id/psdku-tekinfo/</u></a>,
                    Email:
                    d3ti.vokasiuns@gmail.com</span>
            </td>
        </tr>
    </table>
    <hr class="line-title">
    <h6 class="text-center"><b>FORMULIR PENILAIAN KINERJA KEGIATAN MAGANG MAHASISWA</b></h6>
    <br>
    <div class="row">
        <table class="px-3">
            <tr>
                <td>Nama Mahasiswa</td>
                <td>:</td>
                <td class="pl-2 text-justify"><?= $kmm->nm_mhs ?></td>
            </tr>
            <tr>
                <td>NIM</td>
                <td>:</td>
                <td class="pl-2 text-justify"><?= $kmm->nim ?></td>
            </tr>
            <tr>
                <td>Jurusan / Program Studi</td>
                <td>:</td>
                <td class="pl-2 text-justify"><?= $kmm->prodi ?></td>
            </tr>
            <tr>
                <td>Judul KMM</td>
                <td>:</td>
                <td class="px-2 text-justify"><?= $kmm->judul_kmm ?></td>
            </tr>
        </table>
    </div>
    <br>
    <table class="table-border">
        <thead>
            <tr>
                <th>No</th>
                <th>Uraian</th>
                <th>Nilai Maksimum</th>
                <th>Penilaian</th>
            </tr>
        </thead>
        <tbody>
            <?php
                    $no = 1;
                    foreach ($pertanyaan as $p):
                ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $p->pertanyaan ?></td>
                <td><?= $p->nilai_maks ?></td>
                <td>
                    <?php
                        foreach ($penilaian as $pn) {
                            if($p->id_pertanyaan == $pn->id_pertanyaan){
                                echo $pn->nilai;
                            }
                        }
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td class="text-uppercase" style="text-align:right; padding-right:20px;" colspan="3"><b>Jumlah Total</b>
                </td>
                <td class="text-center"><?= $total ?></td>
            </tr>
        </tbody>
    </table>
    <!-- </div> -->

    <br>
    <br>

    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6" style="left:65%;">
            <span>Madiun, <?= date('d F Y')?></span>
            <br>
            <span>Pembimbing/Penguji</span>
            <br>
            <br>
            <br>
            <br>
            <span><u><?= $kmm->nm_staf ?></u></span>
            <br>
            <span>NIP. <?= $kmm->nip ?></span>
        </div>
    </div>
</body>

</html>