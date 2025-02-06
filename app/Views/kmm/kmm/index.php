<?= $this->include('kmm/kmm_partial/dashboard/header'); ?>
<?= $this->include('kmm/kmm_partial/dashboard/top_menu'); ?>
<?php if(has_permission('admin')) : ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>
<?php else : ?>
<?= $this->include('kmm/kmm_partial/dashboard/side_menu'); ?>
<?php endif; ?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-6">
                        <?php
                            if(has_permission('admin') || has_permission('dosen') || has_permission('koor-kmm')) {
                                echo '<h2 class="mt-2 page-title">Halaman Pengelolaan KMM</h2>';
                            } else {
                                echo '<h2 class="mt-2 page-title">Halaman Pendaftaran KMM</h2>';
                            }
                        ?>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-kmm')): ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">KMM</a></li>
                            <li class="breadcrumb-item active">KMM</li>
                        </ol>
                    </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('kmm') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">KMM</a></li>
                            <li class="breadcrumb-item active">Pendaftaran KMM</li>
                        </ol>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="row my-3">
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-kmm')): ?>
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
                                <?php
                                if(has_permission('admin') || has_permission('koor-kmm')):
                                    echo '<a href="'. base_url('kmm/kmm/tambah') .'" class="btn btn-primary mb-3">Tambah</a>';
                                elseif(has_permission('mahasiswa')):
                                    if($proposal == 'disetujui'){
                                        if($kmm2 == null || $statuskmm == 'tidak lolos'){
                                            echo '<a href="'. base_url('kmm/kmm/tambah') .'" class="btn btn-primary mb-3">Tambah</a>';
                                        }
                                    }
                                endif;
                                ?>

                                <!-- table -->
                                <table class="table datatables" id="dataTable-1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <?php if(has_permission('dosen')): ?>
                                            <th>Nama Mahasiswa</th>
                                            <th>Angkatan</th>
                                            <th>Nama Mitra</th>
                                            <th>Pelaksanaan</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                            <?php elseif(has_permission('admin') || has_permission('koor-kmm')): ?>
                                            <th>Nama Mahasiswa</th>
                                            <th>Angkatan</th>
                                            <th>Nama Dosen Pembimbing</th>
                                            <th>Nama Mitra</th>
                                            <th>Pelaksanaan</th>
                                            <th>Status</th>
                                            <th>Verifikasi KMM</th>
                                            <th>Action</th>
                                            <?php elseif(has_permission('mahasiswa')): ?>
                                            <th>Nama Dosen Pembimbing</th>
                                            <th>Nama Mitra</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if (has_permission('admin') || has_permission('koor-kmm')):
                                            $no = 1;
                                            foreach ($kmm as $km) :
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $km->nm_mhs ?></td>
                                            <td><?= $km->th_masuk ?></td>
                                            <td><?= $km->nm_staf ?></td>
                                            <td><?= $km->nama_instansi ?></td>
                                            <td><?= date("d F Y", strtotime($km->tgl_mulai)) .' - '.date("d F Y", strtotime($km->tgl_selesai)) ?>
                                            </td>
                                            <td>
                                                <?php if($km->status_lolos == 'pending'){
                                                echo '<span class="badge badge-warning">proses seleksi</span>';
                                                } else if ($km->status_lolos == 'lolos') {
                                                echo '<span
                                                    class="badge badge-success">'. $km->status_lolos .'</span>';
                                                } else {
                                                echo '<span
                                                    class="badge badge-danger">'. $km->status_lolos .'</span>';
                                                } ?>
                                            </td>
                                            <td>
                                                <?php if($km->status_lolos == 'pending'): ?>
                                                <a class="mx-1 my-1 btn btn-sm btn-outline-success" data-toggle="modal"
                                                    href="#uploadLoA<?= $km->id_kmm ?>">
                                                    <span class="fe fe-check fe-16 align-middle"></span>
                                                </a>
                                                <a class="mx-1 my-1 btn btn-sm btn-outline-danger" data-toggle="modal"
                                                    href="#buktiGagal<?= $km->id_kmm ?>">
                                                    <span class="fe fe-x fe-16 align-middle"></span>
                                                </a>
                                                <?php else : ?>
                                                <span class="badge badge-success">Sudah Diverifikasi</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted sr-only">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        href="<?= base_url('kmm/kmm/detail/' . $km->id_kmm); ?>">Detail</a>
                                                    <a class="dropdown-item"
                                                        style="display: <?= $km->status_lolos == 'lolos' || $km->status_lolos == 'tidak lolos' ? 'none' : ''; ?>"
                                                        href="<?= base_url('kmm/kmm/edit/' . $km->id_kmm); ?>">Edit</a>
                                                    <form method="POST"
                                                        action="<?= base_url('kmm/kmm/hapus/' . $km->id_kmm); ?>">
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="submit" class="dropdown-item remove-item-btn"
                                                            data-toggle="tooltip" title='Delete'><i
                                                                class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                            Delete</button>
                                                    </form>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="uploadLoA<?= $km->id_kmm ?>" tabindex="-1"
                                            role="dialog" aria-labelledby="varyModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="varyModalLabel">Upload LoA <span
                                                                class="text-danger">*</span></h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="<?= base_url('kmm/kmm/verifikasi/lolos/' . $km->id_kmm) ?>"
                                                            enctype="multipart/form-data">
                                                            <div class="form-group">
                                                                <input type="file" name="loa" class="form-control">
                                                                <div class="text-danger text-italic">
                                                                    <span class="text-danger">*</span> File berupa pdf
                                                                    (Max. 5Mb)
                                                                </div>
                                                            </div>
                                                            <button type="submit"
                                                                class="btn mb-2 btn-primary">Simpan</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="buktiGagal<?= $km->id_kmm ?>" tabindex="-1"
                                            role="dialog" aria-labelledby="varyModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="varyModalLabel">Upload Bukti Tidak
                                                            Lolos KMM <span class="text-danger">*</span></h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="<?= base_url('kmm/kmm/verifikasi/tidak-lolos/' . $km->id_kmm) ?>"
                                                            enctype="multipart/form-data">
                                                            <div class="form-group">
                                                                <input type="file" name="bukti_gagal"
                                                                    class="form-control" required>
                                                                <div class="text-danger text-italic">
                                                                    <span class="text-danger">*</span> File berupa pdf
                                                                    (Max. 5Mb)
                                                                </div>
                                                            </div>
                                                            <button type="submit"
                                                                class="btn mb-2 btn-primary">Simpan</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                        <?php 
                                            elseif (has_permission('dosen')):
                                            $no = 1;
                                            foreach ($kmm3 as $dsn) :
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $dsn->nm_mhs ?></td>
                                            <td><?= $dsn->th_masuk ?></td>
                                            <td><?= $dsn->nama_instansi ?></td>
                                            <td><?= date("d F Y", strtotime($dsn->tgl_mulai)) .' - '.date("d F Y", strtotime($dsn->tgl_selesai)) ?>
                                            </td>
                                            <td>
                                                <?php if($dsn->status_lolos == 'pending'){
                                                echo '<span class="badge badge-warning">proses seleksi</span>';
                                                } else if ($dsn->status_lolos == 'lolos') {
                                                echo '<span
                                                    class="badge badge-success">'. $dsn->status_lolos .'</span>';
                                                } else {
                                                echo '<span
                                                    class="badge badge-danger">'. $dsn->status_lolos .'</span>';
                                                } ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-outline-primary"
                                                    href="<?= base_url('kmm/kmm/detail/' . $dsn->id_kmm) ?>">Detail</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; else :
                                            $no = 1;
                                            foreach ($kmm2 as $k) {
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $k->nm_staf ?></td>
                                            <td><?= $k->nama_instansi ?></td>
                                            <td>
                                                <?php if($k->status_lolos == 'pending'){ ?>
                                                <span class="badge badge-warning text-uppercase">proses seleksi</span>
                                                <?php } else if ($k->status_lolos == 'lolos') { ?>
                                                <span
                                                    class="badge badge-success text-uppercase"><?= $k->status_lolos ?></span>
                                                <?php } else { ?>
                                                <span
                                                    class="badge badge-danger text-uppercase"><?= $k->status_lolos ?></span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($k->status_lolos == 'pending') : ?>
                                                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted sr-only">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" data-toggle="modal"
                                                        href="#uploadLoA<?=$k->id_kmm ?>">
                                                        <span class="fe fe-check fe-16 align-middle"></span> Lolos
                                                    </a>
                                                    <a class="dropdown-item" data-toggle="modal"
                                                        href="#buktiGagal<?= $k->id_kmm ?>">
                                                        <span class="fe fe-x fe-16 align-middle"></span> Tidak Lolos
                                                    </a>
                                                </div>
                                                <?php else: ?>
                                                <form method="POST"
                                                    action="<?= base_url('kmm/kmm/hapus/' . $k->id_kmm); ?>">
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger remove-item-btn"
                                                        data-toggle="tooltip" title='Delete'>Delete</button>
                                                </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="uploadLoA<?= $k->id_kmm ?>" tabindex="-1"
                                            role="dialog" aria-labelledby="varyModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="varyModalLabel">Upload LoA <span
                                                                class="text-danger">*</span></h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="<?= base_url('kmm/kmm/verifikasi/lolos/' . $k->id_kmm) ?>"
                                                            enctype="multipart/form-data">
                                                            <div class="form-group">
                                                                <input type="file" name="loa" class="form-control">
                                                                <div class="text-danger text-italic">
                                                                    <span class="text-danger">*</span> File berupa pdf
                                                                    (Max. 5Mb)
                                                                </div>
                                                            </div>
                                                            <button type="submit"
                                                                class="btn mb-2 btn-primary">Simpan</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="buktiGagal<?= $k->id_kmm ?>" tabindex="-1"
                                            role="dialog" aria-labelledby="varyModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="varyModalLabel">Upload Bukti Tidak
                                                            Lolos KMM <span class="text-danger">*</span></h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="<?= base_url('kmm/kmm/verifikasi/tidak-lolos/' . $k->id_kmm) ?>"
                                                            enctype="multipart/form-data">
                                                            <div class="form-group">
                                                                <input type="file" name="bukti_gagal"
                                                                    class="form-control" required>
                                                                <div class="text-danger text-italic">
                                                                    <span class="text-danger">*</span> File berupa pdf
                                                                    (Max. 5Mb)
                                                                </div>
                                                            </div>
                                                            <button type="submit"
                                                                class="btn mb-2 btn-primary">Simpan</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } endif; ?>
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
            <?php if(has_permission('admin') || has_permission('koor-kmm')): ?>
            var url = "<?php echo base_url('kmm/kmm/getFilterDataKMM'); ?>" + "/" +
                th_masuk;
            <?php elseif(has_permission('dosen')): ?>
            var url = "<?php echo base_url('kmm/kmm/getFilterDataKMMByIdDosen'); ?>" + "/" +
                th_masuk;
            <?php endif; ?>
        }

        // Muat data dengan menggunakan AJAX
        $.ajax({
            url: url,
            method: "GET",
            dataType: 'json',
            success: function(data) {
                console.log(data)
                var dataAwal = data;
                // Tampilkan data ke dalam tabel
                $('#dataTable-1').DataTable().clear().destroy();
                // tambahkan baris kode berikut untuk menambahkan data ke dalam tabel
                $.each(data, function(i, item) {
                    var url_detail = '<?= base_url('kmm/kmm/detail'); ?>' + '/' +
                        item.id_kmm;
                    var url_delete = '<?= base_url('kmm/kmm/hapus'); ?>' + '/' +
                        item.id_kmm;
                    var url_edit = '<?= base_url('kmm/kmm/edit'); ?>' + '/' + item
                        .id_kmm;
                    var url_lolos = '#uploadLoA' + item.id_kmm;
                    var url_tidak_lolos = "#buktiGagal" + item.id_kmm;

                    const months = ["January", "February", "March", "April", "May",
                        "June", "July", "August", "September", "October",
                        "November", "December"
                    ];
                    const d = new Date(item.tgl_mulai).getMonth();
                    const e = new Date(item.tgl_selesai).getMonth();
                    var bln_mulai = months[d];
                    var bln_selesai = months[e];
                    var tgl_mulai = new Date(item.tgl_mulai).getDate() + ' ' +
                        bln_mulai + ' ' + new Date(item.tgl_mulai).getFullYear();
                    var tgl_selesai = new Date(item.tgl_selesai).getDate() + ' ' +
                        bln_selesai + ' ' + new Date(item.tgl_selesai)
                        .getFullYear();

                    $('#dataTable-1 tbody')
                    <?php if(has_permission('admin') || has_permission('koor-kmm')): ?>
                        .append('<tr><td>' + ((i++) + 1) + '</td><td>' + item
                            .nm_mhs + '</td><td>' + item.th_masuk + '</td><td>' +
                            item.nm_staf + '</td><td>' +
                            item.nama_instansi +
                            '</td><td>' + tgl_mulai + ' - ' + tgl_selesai +
                            '</td><td>' + ((item.status_lolos == 'pending') ?
                                '<span class="badge badge-warning">proses seleksi</span>' :
                                ((item.status_lolos == 'lolos') ?
                                    '<span class="badge badge-success">' + item
                                    .status_lolos + '</span>' :
                                    '<span class="badge badge-danger">' + item
                                    .status_lolos + '</span>')) + '</td><td>' + ((
                                    item.status_lolos != 'pending') ?
                                '<span class="badge badge-success">Sudah Diverifikasi</span>' :
                                '<a class="my-1 mx-1 btn btn-sm btn-outline-success" data-toggle="modal" href="' +
                                url_lolos +
                                '"><span class="fe fe-check fe-16 align-middle"></a><a class="my-1 mx-1 btn btn-sm btn-outline-danger" data-toggle="modal" href="' +
                                url_tidak_lolos +
                                '"><span class="fe fe-x fe-16 align-middle"></span></a>'
                            ) + '</td><td>' +
                            '<button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="' +
                            url_detail +
                            '">Detail</a><a class="dropdown-item" style="display' +
                            (item.status_lolos == 'lolos' ? 'none' : '') +
                            '" href="' +
                            url_edit + '">Edit</a><form method="POST" action="' +
                            url_delete +
                            '"><input name="_method" type="hidden" value="DELETE"><button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title="Delete"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete</button></form>' +
                            '</td></tr>');
                    <?php elseif(has_permission('dosen')): ?>
                        .append('<tr><td>' + ((i++) + 1) + '</td><td>' + item
                            .nm_mhs + '</td><td>' + item.th_masuk + '</td><td>' +
                            item.nama_instansi +
                            '</td><td>' + tgl_mulai + ' - ' + tgl_selesai +
                            '</td><td>' + ((item.status_lolos == 'pending') ?
                                '<span class="badge badge-warning">proses seleksi</span>' :
                                ((item.status_lolos == 'lolos') ?
                                    '<span class="badge badge-success">' + item
                                    .status_lolos + '</span>' :
                                    '<span class="badge badge-danger">' + item
                                    .status_lolos + '</span>')) +
                            '</td><td><a class="btn btn-sm btn-outline-primary" href="' +
                            url_detail + '">Detail</a></td></tr>');
                    <?php endif; ?>
                });
                $('#dataTable-1').DataTable({
                    columnDefs: [{
                        <?php if(has_permission('admin') || has_permission('koor-kmm')): ?>
                        targets: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                        <?php elseif(has_permission('dosen')): ?>
                        targets: [0, 1, 2, 3, 4, 5, 6],
                        <?php endif; ?>
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
                url: '<?php echo base_url('kmm/kmm');?>',
                method: "GET",
                dataType: 'json',
                success: function(data) {
                    // Tampilkan data ke dalam tabel
                    $('#dataTable-1').DataTable().clear().destroy();
                    // tambahkan baris kode berikut untuk menambahkan data ke dalam tabel
                    $.each(data, function(i, item) {
                        var url_detail =
                            '<?= base_url('kmm/kmm/detail'); ?>' + '/' +
                            item.id_kmm;
                        var url_delete =
                            '<?= base_url('kmm/kmm/hapus'); ?>' + '/' +
                            item.id_kmm;
                        var url_edit = '<?= base_url('kmm/kmm/edit'); ?>' +
                            '/' + item
                            .id_kmm;
                        var url_lolos = '#uploadLoA' + item.id_kmm;
                        var url_tidak_lolos = "#buktiGagal" + item.id_kmm;

                        $('#dataTable-1 tbody')
                        <?php if(has_permission('admin') || has_permission('koor-kmm')): ?>
                            .append('<tr><td>' + ((i++) + 1) + '</td><td>' +
                                item
                                .nm_mhs + '</td><td>' + item.th_masuk +
                                '</td><td>' +
                                item.nm_staf + '</td><td>' +
                                item.nama_instansi +
                                '</td><td>' + tgl_mulai + ' - ' +
                                tgl_selesai +
                                '</td><td>' + ((item.status_lolos ==
                                        'pending') ?
                                    '<span class="badge badge-warning">proses seleksi</span>' :
                                    ((item.status_lolos == 'lolos') ?
                                        '<span class="badge badge-success">' +
                                        item
                                        .status_lolos + '</span>' :
                                        '<span class="badge badge-danger">' +
                                        item
                                        .status_lolos + '</span>')) +
                                '</td><td>' + ((
                                        item.status_lolos != 'pending') ?
                                    '<span class="badge badge-success">Sudah Diverifikasi</span>' :
                                    '<a class="my-1 mx-1 btn btn-sm btn-outline-success" data-toggle="modal" href="' +
                                    url_lolos +
                                    '"><span class="fe fe-check fe-16 align-middle"></a><a class="my-1 mx-1 btn btn-sm btn-outline-danger" data-toggle="modal" href="' +
                                    url_tidak_lolos +
                                    '"><span class="fe fe-x fe-16 align-middle"></span></a>'
                                ) + '</td><td>' +
                                '<button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="' +
                                url_detail +
                                '">Detail</a><a class="dropdown-item" style="display' +
                                (item.status_lolos == 'lolos' ? 'none' :
                                    '') +
                                '" href="' +
                                url_edit +
                                '">Edit</a><form method="POST" action="' +
                                url_delete +
                                '"><input name="_method" type="hidden" value="DELETE"><button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title="Delete"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete</button></form>' +
                                '</td></tr>');
                        <?php elseif(has_permission('dosen')): ?>
                            .append('<tr><td>' + ((i++) + 1) + '</td><td>' +
                                item
                                .nm_mhs + '</td><td>' + item.th_masuk +
                                '</td><td>' +
                                item.nama_instansi +
                                '</td><td>' + tgl_mulai + ' - ' +
                                tgl_selesai +
                                '</td><td>' + ((item.status_lolos ==
                                        'pending') ?
                                    '<span class="badge badge-warning">proses seleksi</span>' :
                                    ((item.status_lolos == 'lolos') ?
                                        '<span class="badge badge-success">' +
                                        item
                                        .status_lolos + '</span>' :
                                        '<span class="badge badge-danger">' +
                                        item
                                        .status_lolos + '</span>')) +
                                '</td><td><a class="btn btn-sm btn-outline-primary" href="' +
                                url_detail + '">Detail</a></td></tr>');
                        <?php endif; ?>
                    });
                    $('#dataTable-1').DataTable({
                        columnDefs: [{
                            <?php if(has_permission('admin') || has_permission('koor-kmm')): ?>
                            targets: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                            <?php elseif(has_permission('dosen')): ?>
                            targets: [0, 1, 2, 3, 4, 5, 6],
                            <?php endif; ?>
                            orderable: true,
                        }],
                    });
                },
            });
        });
    });
});
</script>

<?= $this->include('kmm/kmm_partial/dashboard/footer'); ?>