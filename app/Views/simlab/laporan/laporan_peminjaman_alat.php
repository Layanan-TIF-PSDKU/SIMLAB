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
        left: 81%;
    }
    </style>
</head>

<body>
    <img src="<?=base_url('../landing_assets/images/logo-uns-biru.png')?>"
        style="width:125px;height:auto;position:absolute; margin: 15px auto auto 240px">
    <table style="width:100%; margin-left:40px;">
        <tr>
            <td align="center">
                <span style="line-height:1.6; font-size:16px;">
                    KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI
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
    <h6 class="text-center"><b>Laporan Peminjaman Alat Laboratorium</b></h6>
    <br>
    <div class="box">
        <table class="table-border">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>NIM/NIP</th>
                    <th>Alat yang Dipinjam</th>
                    <th>Jumlah</th>
                    <th>Keperluan</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Pengembalian</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;?>
                <?php foreach ($data as $dt): ?>
                <tr>
                    <td><?=$no++?></td>
                    <td><?php if ($dt->nama_mahasiswa): ?>
                        <?=$dt->nama_mahasiswa?>
                        <?php elseif ($dt->nama_staff): ?>
                        <?=$dt->nama_staff?>
                        <?php endif;?></td>
                    <td>
                        <?php if ($dt->nim): ?>
                        <?=$dt->nim?>
                        <?php elseif ($dt->nip): ?>
                        <?=$dt->nip?>
                        <?php endif;?>
                    </td>
                    <td><?=$dt->nama_alat?></td>
                    <td><?=$dt->jumlah_pinjam?></td>
                    <td><?=$dt->keperluan?></td>
                    <td><?=date('d M Y',round($dt->tanggal_ajuan/1000))?></td>
                    <td><?=date('d M Y', strtotime($dt->tanggal_pinjam))?></td>
                    <td><?=date('d M Y', round($dt->tanggal_kembali/1000))?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <!-- </div> -->

        <br>
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