<?= $this->include('master_partial/dashboard/header'); ?>
<?= $this->include('kmm/kmm_partial/dashboard/top_menu'); ?>
<?php if(has_permission('admin')) : ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>
<?php else: ?>
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
                                echo '<h2 class="mt-2 page-title">Halaman Pengelolaan Seminar KMM</h2>';
                            } else {
                                echo '<h2 class="mt-2 page-title">Halaman Pendaftaran Seminar KMM</h2>';
                            }
                        ?>
                    </div>
                    <?php if(has_permission('admin')): ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">KMM</a></li>
                            <li class="breadcrumb-item active">Seminar KMM</li>
                        </ol>
                    </div>
                    <?php else: ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('kmm') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">KMM</a></li>
                            <li class="breadcrumb-item active">Seminar KMM</li>
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
                                            <th>Tanggal Seminar</th>
                                            <?php if(has_permission('koor-kmm')): ?>
                                            <th>Action</th>
                                            <?php endif; ?>
                                            <?php else: ?>
                                            <?php if(has_permission('mahasiswa')): ?>
                                            <th>Nama Dosen Pembimbing</th>
                                            <?php elseif(has_permission('dosen')): ?>
                                            <th>Nama Mahasiswa</th>
                                            <th>Angkatan</th>
                                            <?php endif; ?>
                                            <th>Nama Mitra</th>
                                            <th>Tanggal Seminar</th>
                                            <th>Action</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (has_permission('admin') || has_permission('koor-kmm')): ?>
                                        <?php
                                            $no = 1;
                                            foreach ($seminar as $sem) :
                                            if($sem->status_laporan == 'disetujui') :
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $sem->nm_mhs ?></td>
                                            <td><?= $sem->th_masuk ?></td>
                                            <td><?= $sem->nm_staf ?></td>
                                            <td><?= $sem->nama_instansi ?></td>
                                            <td>
                                                <?= ($sem->tgl_seminar == null) ? '<span class="badge badge-primary">Belum Ditentukan</span>' : date("d F Y", strtotime($sem->tgl_seminar)) ?>
                                            </td>
                                            <?php if(has_permission('koor-kmm')): ?>
                                            <td>
                                                <?php
                                                if($sem->tgl_seminar == null) :
                                                    if($sem->judul_kmm == null) {
                                                        echo '<span class="badge badge-primary">Belum Daftar Seminar</span>';
                                                    } else {
                                                        echo '<a class="btn btn-outline-primary btn-sm" data-toggle="modal" href="#updateJadwal'. $sem->id_kmm .'">Update Jadwal Seminar</a>';
                                                    }
                                                else:
                                                    echo '<span class="badge badge-success">Jadwal Seminar Telah Ditetapkan</span>';
                                                endif; ?>
                                            </td>
                                            <?php endif; ?>
                                        </tr>
                                        <div class="modal fade" id="updateJadwal<?= $sem->id_kmm ?>" tabindex="-1"
                                            role="dialog" aria-labelledby="varyModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="varyModalLabel">Penetapan Jadwal
                                                            Seminar KMM</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="<?= base_url('kmm/seminar/update/' . $sem->id_kmm) ?>"
                                                            enctype="multipart/form-data">
                                                            <div class="form-group">
                                                                <label>Tanggal Seminar KMM <span
                                                                        class="text-danger">*</span></label>
                                                                <input name="tgl_seminar" type="date"
                                                                    class="form-control" required>
                                                            </div>
                                                            <button type="submit"
                                                                class="btn mb-2 btn-primary">Simpan</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; endforeach; ?>

                                        <?php elseif(has_permission('mahasiswa')) : ?>
                                        <?php
                                            $no = 1;
                                            foreach ($seminar2 as $sm) :
                                            if($sm->status_laporan == 'disetujui') :
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $sm->nama ?></td>
                                            <td><?= $sm->nama_instansi ?></td>
                                            <td>
                                                <?= ($sm->tgl_seminar == null) ? '<span class="badge badge-primary">Belum Ditentukan</span>' : date("d F Y", strtotime($sm->tgl_seminar)) ?>
                                            </td>
                                            <td>
                                                <?php if($sm->judul_kmm == null) : ?>
                                                <a class="btn btn-sm btn-outline-primary"
                                                    href="<?= base_url('kmm/seminar/daftar/' . $sm->id_kmm) ?>">Daftar
                                                    Seminar</a>
                                                <?php else : ?>
                                                <span class="badge badge-success">Berhasil Terdaftar</span>
                                                <?php endif;?>
                                            </td>
                                        </tr>
                                        <?php endif; endforeach; ?>

                                        <?php else: ?>
                                        <?php
                                            $no = 1;
                                            foreach ($seminar3 as $dsn) :
                                            if($dsn->status_laporan == 'disetujui') :
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $dsn->nm_mhs ?></td>
                                            <td><?= $dsn->th_masuk ?></td>
                                            <td><?= $dsn->nama_instansi ?></td>
                                            <td><?= ($dsn->tgl_seminar == null) ? '<span class="badge badge-primary">Belum Ditentukan</span>' : date("d F Y", strtotime($dsn->tgl_seminar)) ?>
                                            </td>
                                            <td>
                                                <?php
                                                if($dsn->tgl_seminar == null) :
                                                    if($dsn->judul_kmm == null) {
                                                        echo '<span class="badge badge-primary">Belum Daftar Seminar</span>';
                                                    } else {
                                                        echo '<a class="btn btn-outline-primary btn-sm" data-toggle="modal" href="#updateJadwal'. $dsn->id_kmm .'">Update Jadwal Seminar</a>';
                                                    }
                                                else:
                                                    echo '<span class="badge badge-success">Jadwal Seminar Telah Ditetapkan</span>';
                                                endif; ?>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="updateJadwal<?=$dsn->id_kmm ?>" tabindex="-1"
                                            role="dialog" aria-labelledby="varyModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="varyModalLabel">Penetapan Jadwal
                                                            Seminar KMM</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="<?= base_url('kmm/seminar/update/' . $dsn->id_kmm) ?>"
                                                            enctype="multipart/form-data">
                                                            <div class="form-group">
                                                                <label>Tanggal Seminar KMM <span
                                                                        class="text-danger">*</span></label>
                                                                <input name="tgl_seminar" type="date"
                                                                    class="form-control" required>
                                                            </div>
                                                            <button type="submit"
                                                                class="btn mb-2 btn-primary">Simpan</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; endforeach; ?>
                                        <?php endif; ?>

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
            var url = "<?php echo base_url('kmm/seminar/getFilterDataSeminar'); ?>" + "/" +
                th_masuk;
            <?php elseif(has_permission('dosen')): ?>
            var url = "<?php echo base_url('kmm/seminar/getFilterDataSeminarByIdDosen'); ?>" + "/" +
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
                    var url_jadwal_seminar = "#updateJadwal" + item.id_kmm;
                    const months = ["January", "February", "March", "April", "May",
                        "June", "July", "August", "September", "October",
                        "November", "December"
                    ];
                    const d = new Date(item.tgl_seminar).getMonth();
                    var bln = months[d];
                    var tgl = new Date(item.tgl_seminar).getDate() + ' ' + bln +
                        ' ' + new Date(item.tgl_seminar).getFullYear();

                    $('#dataTable-1 tbody')
                    <?php if(has_permission('admin')): ?>
                        .append('<tr><td>' + ((i++) + 1) + '</td><td>' + item
                            .nm_mhs + '</td><td>' + item.th_masuk + '</td><td>' +
                            item
                            .nm_staf + '</td><td>' + item.nama_instansi +
                            '</td><td>' + ((item.tgl_seminar == null) ?
                                '<span class="badge badge-primary">Belum Ditentukan</span>' :
                                tgl) + '</td><td>'++'</td></tr>'
                        );
                    <?php elseif(has_permission('dosen')): ?>
                        .append('<tr><td>' + ((i++) + 1) + '</td><td>' + item
                            .nm_mhs + '</td><td>' + item.th_masuk +
                            '</td><td>' + item
                            .nama_instansi + '</td><td>' + ((item.tgl_seminar ==
                                    null) ?
                                '<span class="badge badge-primary">Belum Ditentukan</span>' :
                                tgl) + '</td><td>' + ((item.tgl_seminar == null) ?
                                ((item.judul_kmm == null) ?
                                    '<span class="badge badge-primary">Belum Daftar Seminar</span>' :
                                    '<a class="btn btn-outline-primary btn-sm" data-toggle="modal" href="' +
                                    url_jadwal_seminar +
                                    '">Update Jadwal Seminar</a>') :
                                '<span class="badge badge-success">Jadwal Seminar Telah Ditetapkan</span>'
                            ) + '</td></tr>');
                    <?php elseif(has_permission('koor-kmm')): ?>
                        .append('<tr><td>' + ((i++) + 1) + '</td><td>' + item
                            .nm_mhs + '</td><td>' + item.th_masuk +
                            '</td><td>' + item.nm_staf + '</td><td>' + item
                            .nama_instansi + '</td><td>' + ((item.tgl_seminar ==
                                    null) ?
                                '<span class="badge badge-primary">Belum Ditentukan</span>' :
                                tgl) + '</td><td>' + ((item.tgl_seminar == null) ?
                                ((item.judul_kmm == null) ?
                                    '<span class="badge badge-primary">Belum Daftar Seminar</span>' :
                                    '<a class="btn btn-outline-primary btn-sm" data-toggle="modal" href="' +
                                    url_jadwal_seminar +
                                    '">Update Jadwal Seminar</a>') :
                                '<span class="badge badge-success">Jadwal Seminar Telah Ditetapkan</span>'
                            ) + '</td></tr>');
                    <?php endif; ?>
                });
                $('#dataTable-1').DataTable({
                    columnDefs: [{
                        <?php if(has_permission('admin')): ?>
                        targets: [0, 1, 2, 3, 4],
                        <?php elseif(has_permission('koor-kmm')): ?>
                        targets: [0, 1, 2, 3, 4, 5, 6],
                        <?php elseif(has_permission('dosen')): ?>
                        targets: [0, 1, 2, 3, 4, 5],
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
                url: '<?php echo base_url('kmm/seminar');?>',
                method: "GET",
                dataType: 'json',
                success: function(data) {
                    // Tampilkan data ke dalam tabel
                    $('#dataTable-1').DataTable().clear().destroy();
                    // tambahkan baris kode berikut untuk menambahkan data ke dalam tabel
                    $.each(data, function(i, item) {
                        $('#dataTable-1 tbody')
                        <?php if(has_permission('admin')): ?>
                            .append('<tr><td>' + ((i++) + 1) + '</td><td>' +
                                item
                                .nm_mhs + '</td><td>' + item.th_masuk +
                                '</td><td>' + item
                                .nm_staf + '</td><td>' + item
                                .nama_instansi +
                                '</td><td>' + ((item.tgl_seminar == null) ?
                                    '<span class="badge badge-primary">Belum Ditentukan</span>' :
                                    tgl) + '</td></tr>'
                            );
                        <?php elseif(has_permission('dosen') || has_permission('koor-kmm')): ?>
                            .append('<tr><td>' + ((i++) + 1) + '</td><td>' +
                                item.nm_mhs + item.th_masuk + '</td><td>' +
                                '</td><td>' + item.nama_instansi +
                                '</td><td>' + ((item.tgl_seminar ==
                                        null) ?
                                    '<span class="badge badge-primary">Belum Ditentukan</span>' :
                                    tgl) + '</td><td>' + ((item
                                        .tgl_seminar == null) ?
                                    ((item.judul_kmm == null) ?
                                        '<span class="badge badge-primary">Belum Daftar Seminar</span>' :
                                        '<a class="btn btn-outline-primary btn-sm" data-toggle="modal" href="' +
                                        url_jadwal_seminar +
                                        '">Update Jadwal Seminar</a>') :
                                    '<span class="badge badge-success">Jadwal Seminar Telah Ditetapkan</span>'
                                ) + '</td></tr>');
                        <?php endif; ?>
                    });
                    $('#dataTable-1').DataTable({
                        columnDefs: [{
                            <?php if(has_permission('admin')): ?>
                            targets: [0, 1, 2, 3, 4],
                            <?php elseif(has_permission('dosen') || has_permission('koor-kmm')): ?>
                            targets: [0, 1, 2, 3, 4, 5],
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