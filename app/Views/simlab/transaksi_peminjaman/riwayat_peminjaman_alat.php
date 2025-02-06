<?=$this->include('simlab/simlab_partial/dashboard/header')?>
<?=$this->include('simlab/simlab_partial/dashboard/top_menu')?>
<?=$this->include('simlab/simlab_partial/dashboard/side_menu')?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <!-- Breadcrumbs -->
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Halaman <?=$title?></h2>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a href="<?=base_url('simlab')?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?=base_url('simlab/transaksi')?>">Peminjaman</a></li>
                            <li class="breadcrumb-item active">Riwayat Peminjaman Alat Laboratorium</li>
                        </ol>
                    </div>
                </div>
                <!-- Small table -->
                <div class="card shadow">
                    <div class="card-body">
                        <!-- table -->
                        <table class="table datatables" id="dataTable-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width: 1%;">No</th>
                                    <th style="width: 20%;">Nama Peminjam</th>
                                    <th style="width: 10%;">NIP/NIM</th>
                                    <th>Status Pengajuan</th>
                                    <th>Status Peminjaman</th>
                                    <th>Waktu Konfirmasi Pengembalian</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;?>
                                <?php foreach ($peminjamanalat as $pmja): ?>
                                <?php if ($pmja->status_ajuan == 'Disetujui' && $pmja->status_peminjaman == 'Dikembalikan' || $pmja->status_ajuan == 'Ditolak'): ?>
                                <tr>
                                    <td style="width: 1%;"><?=$no++?></td>
                                    <td style="width: 20%;"><?php if ($pmja->nama_mahasiswa): ?>
                                        <?=$pmja->nama_mahasiswa?>
                                        <?php elseif ($pmja->nama_staff): ?>
                                        <?=$pmja->nama_staff?>
                                        <?php endif;?>
                                    </td>
                                    <td style="width: 10%;"><?php if ($pmja->nama_mahasiswa): ?>
                                        <?=$pmja->nim?>
                                        <?php elseif ($pmja->nama_staff): ?>
                                        <?=$pmja->nip?>
                                        <?php endif;?>
                                    </td>
                                    <td>
                                        <?php if ($pmja->status_ajuan == 'Disetujui') {?>
                                        <span class="badge badge-success"><?=$pmja->status_ajuan?></span>
                                        <?php } else {?>
                                        <span class="badge badge-danger"><?=$pmja->status_ajuan?></span>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?php if ($pmja->status_ajuan == 'Disetujui') {?>
                                        <span class="badge badge-info"><?=$pmja->status_peminjaman?></span>
                                        <?php } else {?>
                                        <span class="badge badge-danger">Status Pengajuan Ditolak</span>
                                        <?php }?>
                                    </td>
                                    <td><?php if ($pmja->status_ajuan == 'Disetujui'): ?>
                                        <?=date("d M Y, H:i", round($pmja->waktu_konfirmasi_kembali / 1000))?> WIB
                                        <?php elseif ($pmja->status_ajuan == 'Ditolak'): ?>
                                        <span class="badge badge-danger">Status Pengajuan Ditolak</span>
                                        <?php endif;?>
                                    </td>
                                    <td><button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                            data-target="#detailpinjamalat" data-id="<?=$pmja->id_pinjam_alat?>">
                                            <i class="fe fe-alert-circle fe-16 align-middle"></i></button>
                                    </td>
                                </tr>
                                <?php endif?>
                                <?php endforeach?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- .col-12 -->
    </div> <!-- .row -->
    </div> <!-- .container-fluid -->

    <!-- Modal Detail Peminjaman Alat Laboratorium-->
    <div class="modal fade" id="detailpinjamalat" tabindex="-1" aria-labelledby="detailpinjamalatLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailpinjamalatLabel">Detail Peminjaman Alat Laboratorium</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="content-wrapper">
                        <div class="card-body">

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th>Nama Peminjam</th>
                                            <td>:</td>
                                        </tr>
                                        <tr>
                                            <th>NIP/NIM</th>
                                            <td>:</td>
                                        </tr>
                                        <tr>
                                            <th>No. Telp</th>
                                            <td>:</td>
                                        </tr>
                                        <tr>
                                            <th>Keperluan</th>
                                            <td>:</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Pengajuan</th>
                                            <td>:</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Peminjaman</th>
                                            <td>:</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Pengembalian</th>
                                            <td>:</td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="form-group col-md-8">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td id="nama_peminjam"></td>
                                        </tr>
                                        <tr>
                                            <td id="nipnim"></td>
                                        </tr>
                                        <tr>
                                            <td id="no_telp"></td>
                                        </tr>
                                        <tr>
                                            <td id="keperluan"></td>
                                        </tr>
                                        <tr>
                                            <td id="tanggal_ajuan"></td>
                                        </tr>
                                        <tr>
                                            <td id="tanggal_pinjam"></td>
                                        </tr>
                                        <tr>
                                            <td id="tanggal_kembali"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td><strong>No</strong></td>
                                                <td><strong>Nama Alat</strong></td>
                                                <td><strong>Nomor Inventaris</strong></td>
                                                <td><strong>Letak</strong></td>
                                                <td><strong>Jumlah Peminjaman</strong></td>
                                                <td><strong>Kondisi Pengembalian</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody id=alatTableBody></tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn mb-2 btn-outline-success download"
                        href="<?=base_url("simlab/surat-peminjaman/alat-laboratorium/");?>">Download
                        Surat Peminjaman
                    </a>
                    <button type="button" class="btn mb-2 btn-warning" data-dismiss="modal">Tutup</button>
                </div>
                <!-- End Modal Detail Peminjaman Alat Laboratorium-->

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <!-- Detail Alat -->
                <script>
                $(document).on('click', 'button[data-target="#detailpinjamalat"]', function() {
                    var id = $(this).attr('data-id');

                    $.ajax({
                        url: "<?=base_url('simlab/detail-peminjaman/alat-laboratorium');?>" +
                            "/" + id,
                        method: "GET",
                        dataType: 'json',
                        success: function(data) {
                            var pinjamalat = data.pinjamalat;
                            var detailpinjamalat = data.detailpinjamalat;

                            if (pinjamalat.nama_staff && pinjamalat.nip && pinjamalat.telp_staff) {
                                $('#nama_peminjam').html(pinjamalat.nama_staff);
                                $('#nipnim').html(pinjamalat.nip);
                                $('#no_telp').html(pinjamalat.telp_staff);
                            } else if (pinjamalat.nama_mahasiswa && pinjamalat.nim && pinjamalat.telp_mahasiswa) {
                                $('#nama_peminjam').html(pinjamalat.nama_mahasiswa);
                                $('#nipnim').html(pinjamalat.nim);
                                $('#no_telp').html(pinjamalat.telp_mahasiswa);
                            }
                            $('#keperluan').html(pinjamalat.keperluan)
                            $('#tanggal_ajuan').text(formatDate(pinjamalat.tanggal_ajuan));
                            $('#tanggal_pinjam').text(formatDate2(pinjamalat.tanggal_pinjam));
                            $('#tanggal_kembali').text(formatDate(pinjamalat.tanggal_kembali));
                            $("#alatTableBody").empty();
                            $.each(detailpinjamalat, function(index, item) {
                                var row = "<tr>" +
                                    "<td>" + (index + 1) + "</td>" +
                                    "<td>" + item.nama_alat + "</td>" +
                                    "<td>" + item.no_inventaris + "</td>" +
                                    "<td>" + item.nama_ruang + "</td>" +
                                    "<td>" + item.jumlah_pinjam + "</td>" +
                                    "<td>" + item.kondisi_pengembalian + "</td>" +
                                    "</tr>";
                                $("#alatTableBody").append(row);
                            });
                            // Show the modal
                            $('#detailpinjamalat').modal('show');
                            
                            var downloadLink =
                                "<?=base_url('simlab/surat-peminjaman/alat-laboratorium');?>" +'/'+
                                pinjamalat.id_pinjam_alat;
                            $('.download').attr('href', downloadLink);
                        }
                    });
                });

                function formatDate(dateString) {
                    var date = new Date(parseInt(dateString, 10));
                    return date.toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });
                }
                function formatDate2(dateString) {
                    var date = new Date(dateString);
                    return date.toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });
                }
                </script>
                <!-- End Detail Alat -->
</main>

<?=$this->include('simlab/simlab_partial/dashboard/footer')?>