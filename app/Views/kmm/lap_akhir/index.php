<?= $this->include('master_partial/dashboard/header'); ?>
<?= $this->include('kmm/kmm_partial/dashboard/top_menu'); ?>
<?php if(has_permission('admin')) : ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>
<?php elseif(has_permission('mitra')): ?>
<?= $this->include('mitra/mitra_partial/dashboard/side_menu'); ?>
<?php else: ?>
<?= $this->include('kmm/kmm_partial/dashboard/side_menu'); ?>
<?php endif; ?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-8">
                        <?php
                            if(has_permission('mahasiswa')) {
                                echo '<h2 class="mt-2 page-title">Halaman Pengumpulan Laporan Akhir</h2>';
                            } else {
                                echo '<h2 class="mt-2 page-title">Halaman Pengelolaan Laporan Akhir</h2>';
                            }
                        ?>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <?php if(has_permission('admin')): ?>
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                            <?php elseif(has_permission('mitra')): ?>
                            <li class="breadcrumb-item"><a href="<?= base_url('mitra/dashboard') ?>">Dashboard</a></li>
                            <?php else: ?>
                            <li class="breadcrumb-item"><a href="<?= base_url('kmm') ?>">Dashboard</a></li>
                            <?php endif; ?>
                            <li class="breadcrumb-item active">KMM</a></li>
                            <li class="breadcrumb-item active">Laporan Akhir</li>
                        </ol>
                    </div>
                </div>
                <div class="row my-3">
                    <?php if(has_permission('mahasiswa') || has_permission('mitra')): ?>
                    <?php else: ?>
                    <div class="col-md-12">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title">Pencarian Data Mahasiswa</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class=" form-group mb-3">
                                            <label>Tahun Angkatan <span class="text-danger"></span></label>
                                            <select class="form-control select2 required" name="th_masuk" id="th_masuk">
                                                <option value="">Pilih Tahun Angkatan</option>
                                                <?php foreach($mhs as $akt): ?>
                                                <option value="<?= $akt->th_masuk ?>"><?= $akt->th_masuk ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button id="prosesFilter" class="btn btn-primary">Proses</button>
                                        <button id="resetFilter" class="btn btn-danger">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <table class="table datatables" id="dataTable-1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <?php if(has_permission('admin') || has_permission('koor-kmm')): ?>
                                            <th>Nama Mahasiswa</th>
                                            <th>Angkatan</th>
                                            <th>Nama Dosen Pembimbing</th>
                                            <th>Nama Mitra</th>
                                            <?php elseif(has_permission('dosen')): ?>
                                            <th>Nama Mahasiswa</th>
                                            <th>Angkatan</th>
                                            <th>Nama Mitra</th>
                                            <?php elseif(has_permission('mahasiswa')): ?>
                                            <th>Nama Dosen Pembimbing</th>
                                            <th>Nama Mitra</th>
                                            <?php else: ?>
                                            <th>Nama Mahasiswa</th>
                                            <th>Nama Dosen Pembimbing</th>
                                            <th>Pelaksanaan</th>
                                            <?php endif; ?>
                                            <th>Laporan Akhir</th>
                                            <?php if(has_permission('mitra')): ?>
                                            <?php else: ?>
                                            <th>Status Verifikasi</th>
                                            <th>Catatan</th>
                                            <?php endif; ?>
                                            <?php if(has_permission('dosen') || has_permission('mahasiswa')): ?>
                                            <th>Action</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(has_permission('admin') || has_permission('koor-kmm')):
                                            $no = 1;
                                            foreach ($kmm3 as $kmm) :
                                                if($kmm->status_lolos == 'lolos') :
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $kmm->nm_mhs ?></td>
                                            <td><?= $kmm->th_masuk ?></td>
                                            <td><?= $kmm->nm_staf ?></td>
                                            <td><?= $kmm->nama_instansi ?></td>
                                            <td>
                                                <?php if($kmm->laporan_akhir == null){
                                                    echo '<span class="badge badge-primary">Belum Diupload</span>';
                                                } else {
                                                    echo '<a class="btn btn-sm btn-outline-primary" href="'. base_url('kmm/lap-akhir/download/'.$kmm->id_kmm) .'">Download</a>'; } ?>
                                            </td>
                                            <td>
                                                <?php
                                                if($kmm->status_laporan == 'pending') {
                                                    if($kmm->laporan_akhir == null) {
                                                        echo '<span class="badge badge-primary">Belum Diupload</span>';
                                                    } else {
                                                        echo '<span class="badge badge-primary">'. $kmm->status_laporan .'</span>';
                                                    }
                                                } else if ($kmm->status_laporan == 'disetujui') {
                                                    echo '<span class="badge badge-success">'. $kmm->status_laporan .'</span>';
                                                } else {
                                                    echo '<span class="badge badge-warning">'. $kmm->status_laporan .'</span>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                if ($kmm->catatan_lap_akhir == null) {
                                                    echo '<span class="badge badge-warning">Belum Ada Catatan</span>';
                                                } else {
                                                    if ($kmm->status_laporan == 'disetujui') {
                                                        echo '<span class="badge badge-success">'.$kmm->catatan_lap_akhir.'</span>';
                                                    } else {
                                                        echo $kmm->catatan_lap_akhir;
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php endif; endforeach; endif; ?>

                                        <?php
                                        if(has_permission('mahasiswa')):
                                            $no = 1;
                                            foreach ($kmm as $k) :
                                                if($k->status_lolos == 'lolos') :
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $k->nm_staf ?></td>
                                            <td><?= $k->nama_instansi ?></td>
                                            <td>
                                                <?php if($k->laporan_akhir == null){
                                                    echo '<span class="badge badge-primary">Belum Diupload</span>';
                                                } else {
                                                    echo '<a class="btn btn-sm btn-outline-primary" href="'. base_url('kmm/lap-akhir/download/'.$k->id_kmm) .'">Download</a>'; } ?>
                                            </td>
                                            <td>
                                                <?php
                                                if($k->status_laporan == 'pending') {
                                                    if($k->laporan_akhir == null) {
                                                        echo '<span class="badge badge-primary">Belum Diupload</span>';
                                                    } else {
                                                        echo '<span class="badge badge-primary">'. $k->status_laporan .'</span>';
                                                    }
                                                } else if ($k->status_laporan == 'disetujui') {
                                                    echo '<span class="badge badge-success">'. $k->status_laporan .'</span>';
                                                } else {
                                                    echo '<span class="badge badge-warning">'. $k->status_laporan .'</span>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                if ($k->catatan_lap_akhir == null) {
                                                    echo '<span class="badge badge-warning">Belum Ada Catatan</span>';
                                                } else {
                                                    if ($k->status_laporan == 'disetujui') {
                                                        echo '<span class="badge badge-success">'.$k->catatan_lap_akhir.'</span>';
                                                    } else {
                                                        echo $k->catatan_lap_akhir;
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if($k->laporan_akhir == null){
                                                    echo '<a class="btn btn-outline-primary btn-sm" data-toggle="modal" href="#uploadLapAkhir'. $k->id_kmm .'">Upload Laporan</a>';
                                                } else {
                                                    if($k->status_laporan == 'revisi'){
                                                        echo '<a class="btn btn-outline-primary btn-sm" data-toggle="modal" href="#uploadLapAkhir'. $k->id_kmm .'">Upload Laporan</a>';
                                                    } elseif ($k->status_laporan == 'disetujui') {
                                                        echo '<span class="badge badge-success">Telah Disetujui</span>';
                                                    } else {
                                                        echo '<span class="badge badge-primary">Sudah Diupload</span>';
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="uploadLapAkhir<?= $k->id_kmm ?>" tabindex="-1"
                                            role="dialog" aria-labelledby="varyModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="varyModalLabel">Upload Laporan Akhir
                                                            KMM <span class="text-danger">*</span></h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="<?= base_url('kmm/lap-akhir/upload/' . $k->id_kmm) ?>"
                                                            enctype="multipart/form-data">
                                                            <div class="form-group">
                                                                <input type="file" name="laporan_akhir"
                                                                    class="form-control" required>
                                                                <div class="text-danger">
                                                                    * File berupa pdf (Max. 5Mb)
                                                                </div>
                                                            </div>
                                                            <button type="submit"
                                                                class="btn mb-2 btn-primary">Simpan</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; endforeach; ?>

                                        <?php elseif(has_permission('dosen')):
                                            $no = 1;
                                            foreach($kmm2 as $dsn):
                                            if($dsn->status_lolos == 'lolos'): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $dsn->nm_mhs ?></td>
                                            <td><?= $dsn->th_masuk ?></td>
                                            <td><?= $dsn->nama_instansi ?></td>
                                            <td>
                                                <?php if($dsn->laporan_akhir == null){
                                                    echo '<span class="badge badge-danger">Belum Diupload</span>';
                                                } else {
                                                        echo '<a class="btn btn-sm btn-outline-primary" href="'. base_url('kmm/lap-akhir/download/'.$dsn->id_kmm) .'">Download</a>'; } ?>
                                            </td>
                                            <td>
                                                <?php
                                                if($dsn->status_laporan == 'pending') {
                                                    if($dsn->laporan_akhir == null) {
                                                        echo '<span class="badge badge-primary">Belum Diupload</span>';
                                                    } else {
                                                        echo '<span class="badge badge-primary">'. $dsn->status_laporan .'</span>';
                                                    }
                                                } else if ($dsn->status_laporan == 'disetujui') {
                                                    echo '<span class="badge badge-success">'. $dsn->status_laporan .'</span>';
                                                } else {
                                                    echo '<span class="badge badge-warning">'. $dsn->status_laporan .'</span>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                if ($dsn->catatan_lap_akhir == null) {
                                                    echo '<span class="badge badge-primary">Belum Ada Catatan</span>';
                                                } else {
                                                    if ($dsn->status_laporan == 'disetujui') {
                                                        echo '<span class="badge badge-success">'.$dsn->catatan_lap_akhir.'</span>';
                                                    } else {
                                                        echo $dsn->catatan_lap_akhir;
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php if($dsn->status_laporan == 'pending' && $dsn->laporan_akhir == null) : ?>
                                                <span class="badge badge-primary">Belum Ada Laporan Akhir</span>
                                                <?php elseif($dsn->status_laporan == 'disetujui') : ?>
                                                <span class="badge badge-success">Telah Disetujui</span>
                                                <?php else: ?>
                                                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted sr-only">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        href="<?= base_url('kmm/lap-akhir/verifikasi-setuju/' . $dsn->id_kmm) ?>"
                                                        style="display:<?= ($dsn->status_laporan == 'disetujui') ? 'none' : '' ?>">
                                                        <span class="fe fe-check fe-16 align-middle"></span> Disetujui
                                                    </a>
                                                    <a class="dropdown-item" data-toggle="modal"
                                                        href=<?= "#verifLapAkhir" . $dsn->id_kmm ?>
                                                        style="display:<?= ($dsn->status_laporan == 'disetujui') ? 'none' : '' ?>">
                                                        <span class="fe fe-x fe-16 align-middle"></span> Revisi
                                                    </a>
                                                </div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id=<?= "verifLapAkhir" . $dsn->id_kmm ?> tabindex="-1"
                                            role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="verticalModalTitle">Catatan <span
                                                                class="text-danger">*</span></h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form
                                                            action="<?= base_url('kmm/lap-akhir/verifikasi-revisi/' . $dsn->id_kmm) ?>"
                                                            method="post">
                                                            <div class="form-group">
                                                                <textarea name="catatan_lap_akhir" class="form-control"
                                                                    rows="4"></textarea>
                                                            </div>
                                                            <button type="submit"
                                                                class="btn btn-primary">Simpan</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; endforeach; else: ?>

                                        <?php
                                            $no = 1;
                                            foreach ($kmm4 as $kmm) :
                                                if($kmm->status_lolos == 'lolos') :
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $kmm->nm_mhs ?></td>
                                            <td><?= $kmm->nm_staf ?></td>
                                            <td><?= date('d F Y', strtotime($kmm->tgl_mulai)) . ' - ' . date('d F Y', strtotime($kmm->tgl_selesai)) ?>
                                            </td>
                                            <td>
                                                <?php if($kmm->laporan_akhir == null){
                                                    echo '<span class="badge badge-primary">Belum Diupload</span>';
                                                } else {
                                                    echo '<a class="btn btn-sm btn-outline-primary" href="'. base_url('kmm/lap-akhir/download/'.$kmm->id_kmm) .'">Download</a>'; } ?>
                                            </td>
                                        </tr>
                                        <?php endif; endforeach; endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- simple table -->
                </div>
                <!-- end section -->
            </div>
            <!-- .col-12 -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container-fluid -->
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Ketika tombol "Proses" ditekan
    $('#prosesFilter').on('click', function(event) {
        event.preventDefault();
        // Ambil nilai dari form
        var th_masuk = $('#th_masuk').val();

        // Tambahkan parameter pada URL berdasarkan nilai-nilai form
        if (th_masuk != '') {
            <?php if(has_permission('dosen')): ?>
            var url = "<?php echo base_url('kmm/lap-akhir/getFilterDataLapAkhirByIdDosen'); ?>" + "/" +
                th_masuk;
            <?php elseif(has_permission('koor-kmm')): ?>
            var url = "<?php echo base_url('kmm/lap-akhir/getFilterDataLapAkhir'); ?>" + "/" +
                th_masuk;
            <?php endif; ?>
        }

        // Muat data dengan menggunakan AJAX
        $.ajax({
            url: url,
            method: "GET",
            dataType: 'json',
            success: function(data) {
                var dataAwal = data;
                // Tampilkan data ke dalam tabel
                $('#dataTable-1').DataTable().clear().destroy();
                // tambahkan baris kode berikut untuk menambahkan data ke dalam tabel
                $.each(data, function(i, item) {
                    var url_disetujui =
                        "<?= base_url('kmm/lap-akhir/verifikasi-setuju') ?>" + "/" +
                        item.id_kmm;
                    var url_revisi = "#verifLapAkhir" + item.id_kmm;
                    var url_download = "<?= base_url('kmm/lap-akhir/download') ?>" +
                        "/" + item.id_kmm;

                    $('#dataTable-1 tbody')
                    <?php if(has_permission('dosen')): ?>
                        .append('<tr><td>' + ((i++) + 1) + '</td><td>' + item
                            .nm_mhs + '</td><td>' + item.th_masuk +
                            '</td><td>' + item
                            .nama_instansi + '</td><td>' + ((item.laporan_akhir ==
                                    null) ?
                                '<span class="badge badge-primary">Belum Diupload</span>' :
                                '<a class="btn btn-sm btn-outline-primary" href="' +
                                url_download + '">Download</a>') +
                            '</td><td>' + ((item.status_laporan == 'pending') ? ((
                                        item.laporan_akhir == null) ?
                                    '<span class="badge badge-primary">Belum Diupload</span>' :
                                    '<span class="badge badge-primary">' + item
                                    .status_laporan + '</span>') : (item
                                    .status_laporan == 'disetujui') ?
                                '<span class="badge badge-success">' + item
                                .status_laporan + '</span>' :
                                '<span class="badge badge-warning">' + item
                                .status_laporan + '</span>') + '</td><td>' + ((item
                                    .catatan_lap_akhir == null) ?
                                '<span class="badge badge-primary">Belum Ada Catatan</span>' :
                                (item.status_laporan == 'disetujui') ?
                                '<span class="badge badge-success">' + item
                                .catatan_lap_akhir + '</span>' : +item
                                .catatan_lap_akhir) + '</td><td>' + ((item
                                    .status_laporan == 'pending' && item
                                    .laporan_akhir == null) ?
                                '<span class="badge badge-primary">Belum Ada Laporan Akhir</span>' :
                                (item.status_laporan == 'disetujui') ?
                                '<span class="badge badge-success">Telah Disetujui</span>' :
                                '<button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="' +
                                url_disetujui +
                                '"><span class="fe fe-check fe-16 align-middle"></span> Disetujui</a><a class="dropdown-item" data-toggle="modal" href="' +
                                url_revisi +
                                '"><span class="fe fe-x fe-16 align-middle"></span> Revisi</a></div>'
                            ) + '</td></tr>'
                        );
                    <?php elseif(has_permission('koor-kmm')): ?>
                        .append('<tr><td>' + ((i++) + 1) + '</td><td>' + item
                            .nm_mhs + '</td><td>' + item.th_masuk +
                            '</td><td>' + item.nm_staf +
                            '</td><td>' + item
                            .nama_instansi + '</td><td>' + ((item.laporan_akhir ==
                                    null) ?
                                '<span class="badge badge-primary">Belum Diupload</span>' :
                                '<a class="btn btn-sm btn-outline-primary" href="' +
                                url_download + '">Download</a>') +
                            '</td><td>' + ((item.status_laporan == 'pending') ? ((
                                        item.laporan_akhir == null) ?
                                    '<span class="badge badge-primary">Belum Diupload</span>' :
                                    '<span class="badge badge-primary">' + item
                                    .status_laporan + '</span>') : (item
                                    .status_laporan == 'disetujui') ?
                                '<span class="badge badge-success">' + item
                                .status_laporan + '</span>' :
                                '<span class="badge badge-warning">' + item
                                .status_laporan + '</span>') + '</td><td>' + ((item
                                    .catatan_lap_akhir == null) ?
                                '<span class="badge badge-primary">Belum Ada Catatan</span>' :
                                (item.status_laporan == 'disetujui') ?
                                '<span class="badge badge-success">' + item
                                .catatan_lap_akhir + '</span>' : +item
                                .catatan_lap_akhir) + '</td></tr>'
                        );
                    <?php endif; ?>
                });
                $('#dataTable-1').DataTable({
                    columnDefs: [{
                        targets: [0, 1, 2, 3, 4, 5, 6, 7],
                        orderable: true,
                    }],
                });
            },
        });
    });

    $(document).ready(function() {
        $('#resetFilter').click(function() {
            $('#th_masuk').val(null).trigger('change');

            $.ajax({
                url: '<?php echo base_url('kmm/lap-akhir');?>',
                method: "GET",
                dataType: 'json',
                success: function(data) {
                    // Tampilkan data ke dalam tabel
                    $('#dataTable-1').DataTable().clear().destroy();
                    // tambahkan baris kode berikut untuk menambahkan data ke dalam tabel
                    $.each(data, function(i, item) {
                        $('#dataTable-1 tbody')
                        <?php if(has_permission('dosen')): ?>
                            .append('<tr><td>' + ((i++) + 1) + '</td><td>' +
                                item
                                .nm_mhs + '</td><td>' + item
                                .nama_instansi + '</td><td>' + item
                                .laporan_akhir +
                                '</td><td>' + item.status_laporan +
                                '</td><td>' + item
                                .catatan_lap_akhir +
                                '</td></tr>'
                            );
                        <?php endif; ?>
                    });
                    $('#dataTable-1').DataTable({
                        columnDefs: [{
                            targets: [0, 1, 2, 3],
                            orderable: true,
                        }],
                    });
                },
            });
        });
    });
});
</script>

<?= $this->include('master_partial/dashboard/footer'); ?>