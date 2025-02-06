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
    <h6 class="text-center"><b>Formulir Peminjaman Alat Laboratorium</b></h6>
    <br>
    <div class="form-row">
        <div class="form-group col-md-4">
            <h6>A. Peminjam</h6>
            <table class="table table-borderless" style="font-size:14px; margin-left:10px;">
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><?php if ($peminjaman->nama_mahasiswa): ?>
                        <?=$peminjaman->nama_mahasiswa?>
                        <?php elseif ($peminjaman->nama_staff): ?>
                        <?=$peminjaman->nama_staff?>
                        <?php endif;?></td>
                </tr>
                <tr>
                    <td>NIM/NIP</td>
                    <td>:</td>
                    <td><?php if ($peminjaman->nim): ?>
                        <?=$peminjaman->nim?>
                        <?php elseif ($peminjaman->nip): ?>
                        <?=$peminjaman->nip?>
                        <?php endif;?></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>:</td>
                    <td><?php if ($peminjaman->nama_mahasiswa): ?>
                        Mahasiswa
                        <?php elseif ($peminjaman->nama_staff): ?>
                        Staff/Dosen
                        <?php endif;?></td>
                </tr>
                <tr>
                    <td>No Telp</td>
                    <td>:</td>
                    <td><?php if ($peminjaman->nama_mahasiswa): ?>
                        <?=$peminjaman->telp_mahasiswa?>
                        <?php elseif ($peminjaman->nama_staff): ?>
                        <?=$peminjaman->telp_staff?>
                        <?php endif;?></td>
                </tr>
            </table>
        </div>
    </div>
    <h6>B. Alat Laboratorium</h6>
    <table class="table table-borderless" style="font-size:14px; margin-left:10px;">
        <tr>
            <td>Keperluan</td>
            <td>:</td>
            <td><?=$peminjaman->keperluan?></td>
        </tr>
        <tr>
            <td>Tanggal Peminjaman</td>
            <td>:</td>
            <td><?=date('d M Y', strtotime($peminjaman->tanggal_pinjam))?></td>
        </tr>
        <tr>
            <td>Tanggal Pengembalian</td>
            <td>:</td>
            <td><?=date('d M Y', round($peminjaman->tanggal_kembali/1000))?></td>
            <td type="hidden"></td>
            <td type="hidden"></td>
            <td type="hidden"></td>
            <td type="hidden"></td>
            <td type="hidden"></td>
            <td type="hidden"></td>
            <td type="hidden"></td>
            <td type="hidden"></td>
            <td type="hidden"></td>
        </tr>
    </table>
    <table class="table-border">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Alat</th>
                <th>Nomor Inventaris</th>
                <th>Ruang/Letak</th>
                <th>Jumlah Pinjam</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;?>
            <?php foreach ($detail_peminjaman_alat as $detail): ?>
            <tr>
                <td><?=$no++?></td>
                <td><?=$detail->nama_alat?></td>
                <td><?=$detail->no_inventaris?></td>
                <td><?=$detail->nama_ruang?></td>
                <td><?=$detail->jumlah_pinjam?> <?=strtoupper($detail->satuan)?>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>

    <br>
    <br>

    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6 signature">
            <span>Madiun, <?= date('d M Y')?></span>
            <br>
            <span>Peminjam,</span>
            <br>
            <br>
            <br>
            <br>
            <span><?php if ($peminjaman->nama_mahasiswa): ?>
                <?=$peminjaman->nama_mahasiswa?>
                <?php elseif ($peminjaman->nama_staff): ?>
                <?=$peminjaman->nama_staff?>
                <?php endif;?></span>
            <br>
            <span><?php if ($peminjaman->nama_mahasiswa): ?>
                        NIM. <?=$peminjaman->nim?>
                        <?php elseif ($peminjaman->nama_staff): ?>
                        NIP. <?=$peminjaman->nip?>
                        <?php endif;?></span>
        </div>
    </div>
</body>

</html>