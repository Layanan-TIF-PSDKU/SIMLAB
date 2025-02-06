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
                            <li class="breadcrumb-item active">Riwayat Peminjaman Ruang Laboratorium</li>
                        </ol>
                    </div>
                </div>
                <!-- Small table -->
                <div class="card shadow">
                    <div class="card-body">
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
                                <?php foreach ($peminjamanruang as $pmjr): ?>
                                <?php if ($pmjr->status_ajuan == 'Disetujui' && $pmjr->status_peminjaman == 'Dikembalikan' || $pmjr->status_ajuan == 'Ditolak'): ?>
                                <tr>
                                    <td style="width: 1%;"><?=$no++?></td>
                                    <td style="width: 20%;"><?php if ($pmjr->nama_mahasiswa): ?>
                                        <?=$pmjr->nama_mahasiswa?>
                                        <?php elseif ($pmjr->nama_staff): ?>
                                        <?=$pmjr->nama_staff?>
                                        <?php endif;?>
                                    </td>
                                    <td style="width: 10%;"><?php if ($pmjr->nama_mahasiswa): ?>
                                        <?=$pmjr->nim?>
                                        <?php elseif ($pmjr->nama_staff): ?>
                                        <?=$pmjr->nip?>
                                        <?php endif;?>
                                    </td>

                                    <td>
                                        <?php if ($pmjr->status_ajuan == 'Disetujui') {?>
                                        <span class="badge badge-success"><?=$pmjr->status_ajuan?></span>
                                        <?php } else {?>
                                        <span class="badge badge-danger"><?=$pmjr->status_ajuan?></span>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?php if ($pmjr->status_ajuan == 'Disetujui'): ?>
                                        <span class="badge badge-info"><?=$pmjr->status_peminjaman?></span>
                                        <?php elseif ($pmjr->status_ajuan == 'Ditolak'): ?>
                                        <span class="badge badge-danger">Status Pengajuan Ditolak</span>
                                        <?php endif;?>

                                    </td>
                                    <td><?php if ($pmjr->status_ajuan == 'Disetujui'): ?>
                                        <?=date("d M Y, H:i", round($pmjr->waktu_konfirmasi_kembali / 1000))?> WIB
                                        <?php elseif ($pmjr->status_ajuan == 'Ditolak'): ?>
                                        <span class="badge badge-danger">Status Pengajuan Ditolak</span>
                                        <?php endif;?>
                                    </td>
                                    <td><button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                            data-target="#detailpinjamruang" data-id="<?=$pmjr->id_pinjam_ruang?>">
                                            <i class="fe fe-alert-circle fe-16 align-middle"></i></button>
                                    </td>
                                </tr>
                                <?php endif;?>
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

    <!-- Modal Detail Peminjaman Ruang Laboratorium-->
    <div class="modal fade" id="detailpinjamruang" tabindex="-1" aria-labelledby="detailpinjamruangLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailpinjamruangLabel">Detail Peminjaman Ruang Laboratorium
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="content-wrapper">
                        <!-- <div class="card shadow mb-4"> -->
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
                                            <th>Ruang yang Dipinjam</th>
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
                                            <th>Waktu Peminjaman</th>
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
                                            <td id="nama_ruang"></td>
                                        </tr>
                                        <tr>
                                            <td id="keperluan"></td>
                                        </tr>
                                        <tr>
                                            <td id="tanggal_ajuan"></td>
                                        </tr>
                                        <tr>
                                            <td id="waktu_peminjaman"></td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn mb-2 btn-outline-success download"
                        href="<?=base_url("simlab/surat-peminjaman/ruang-laboratorium/");?>">Download
                        Surat Peminjaman
                    </a>
                    <button type="button" class="btn mb-2 btn-warning" data-dismiss="modal">Tutup</button>
                </div>
                <!-- End Modal Detail Peminjaman Ruang Laboratorium-->

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <!-- Detail Ruang -->
                <script>
                $(document).on('click', 'button[data-target="#detailpinjamruang"]', function() {
                    var id = $(this).attr('data-id');

                    $.ajax({
                        url: "<?=base_url('simlab/detail-peminjaman/ruang-laboratorium');?>" +
                            "/" + id,
                        method: "GET",
                        dataType: 'json',
                        success: function(data) {
                            if (data.nama_staff && data.nip && data.telp_staff) {
                                $('#nama_peminjam').html(data.nama_staff);
                                $('#nipnim').html(data.nip);
                                $('#no_telp').html(data.telp_staff);
                            } else if (data.nama_mahasiswa && data.nim && data.telp_mahasiswa) {
                                $('#nama_peminjam').html(data.nama_mahasiswa);
                                $('#nipnim').html(data.nim);
                                $('#no_telp').html(data.telp_mahasiswa);
                            }
                            $('#nama_ruang').html(data.nama_ruang)
                            $('#keperluan').html(data.keperluan)
                            $('#tanggal_ajuan').text(formatDate(data.tanggal_ajuan));
                            var waktuPeminjaman = data.hari + ', ' +
                                formatDate2(data.tanggal_pinjam) + ' / ' +
                                data.waktu_mulai + ' - ' + data.waktu_selesai;
                            $('#waktu_peminjaman').html(waktuPeminjaman + ' WIB');

                            var downloadLink =
                                "<?=base_url('simlab/surat-peminjaman/ruang-laboratorium');?>" +
                                '/' +
                                data.id_pinjam_ruang;
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
                <!-- End Detail Ruang-->
</main>

<?=$this->include('simlab/simlab_partial/dashboard/footer')?>