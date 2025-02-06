<?= $this->include('master_partial/dashboard/header'); ?>
<?= $this->include('kmm/kmm_partial/dashboard/top_menu'); ?>
<?php if(has_permission('admin')) : ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>
<?php elseif(has_permission('mitra')) : ?>
<?= $this->include('mitra/mitra_partial/dashboard/side_menu'); ?>
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
                            if(has_permission('admin') || has_permission('koor-kmm')) {
                                echo '<h2 class="mt-2 page-title">Halaman Pengelolaan Penilaian KMM</h2>';
                            } else {
                                echo '<h2 class="mt-2 page-title">Halaman Penilaian KMM</h2>';
                            }
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <?php if(has_permission('admin')): ?>
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                            <?php elseif(has_permission('mitra')): ?>
                            <li class="breadcrumb-item"><a href="<?= base_url('mitra/dashboard') ?>">Dashboard</a></li>
                            <?php else: ?>
                            <li class="breadcrumb-item"><a href="<?= base_url('kmm') ?>">Dashboard</a></li>
                            <?php endif; ?>
                            <li class="breadcrumb-item active">KMM</a></li>
                            <li class="breadcrumb-item active">Penilaian KMM</li>
                        </ol>
                    </div>
                </div>
                <div class="row my-4">
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
                                        <button id="cetak" class="btn btn-info" disabled>Cetak</button>

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
                                            <th>Nama Mahasiswa</th>
                                            <?php if(has_permission('admin') || has_permission('koor-kmm')): ?>
                                            <th>Angkatan</th>
                                            <th>Nama Dosen Pembimbing</th>
                                            <th>Nama Mitra</th>
                                            <th>Total Nilai Dosen</th>
                                            <th>Total Nilai Mitra</th>
                                            <th>Nilai Akhir</th>
                                            <th>Action</th>
                                            <?php elseif(has_permission('mitra')): ?>
                                            <th>Nama Dosen Pembimbing</th>
                                            <th>Total Nilai Mitra</th>
                                            <th>Action</th>
                                            <?php elseif(has_permission('dosen')): ?>
                                            <th>Angkatan</th>
                                            <th>Nama Mitra</th>
                                            <th>Total Nilai Dosen</th>
                                            <th>Total Nilai Mitra</th>
                                            <th>Nilai Akhir</th>
                                            <th>Action</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(has_permission('admin') || has_permission('koor-kmm')) : ?>
                                        <?php
                                            $no = 1;
                                            foreach ($kmm3 as $kmm) :
                                                if($kmm->status_laporan == 'disetujui' && $kmm->tgl_seminar != null) {
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $kmm->nm_mhs ?></td>
                                            <td><?= $kmm->th_masuk ?></td>
                                            <td><?= $kmm->nm_staf ?></td>
                                            <td><?= $kmm->nama_instansi ?></td>
                                            <td>
                                                <?php
                                                    if($kmm->nilai_total_dosen == null){
                                                        echo '<a class="btn btn-sm btn-outline-primary" href="'. base_url('kmm/penilaian/kmm/dosen/'. $kmm->id_kmm) .'">Nilai</a>';
                                                    } else {
                                                        echo $kmm->nilai_total_dosen;
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if($kmm->nilai_total_mitra == null){
                                                        echo '<a class="btn btn-sm btn-outline-primary" style="display:'. (($kmm->nilai_total_mitra > 0) ? 'none' : '') .'" href="'. base_url('kmm/penilaian/kmm/mitra/'. $kmm->id_kmm) .'">Nilai</a>';
                                                    } else {
                                                        echo $kmm->nilai_total_mitra;
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if($kmm->nilai_akhir == null){
                                                        echo '<span class="badge badge-primary">Nilai Belum Ada</span>';
                                                    } else {
                                                        echo $kmm->nilai_akhir;
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php if($kmm->nilai_akhir != null): ?>
                                                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted sr-only">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        style="display:<?= (($kmm->nilai_total_dosen == null) ? 'none' : '') ?>"
                                                        href="<?= base_url('kmm/penilaian/cetak-penilaian-prodi/' . $kmm->id_kmm) ?>">Penilaian
                                                        Prodi</a>
                                                    <a class="dropdown-item"
                                                        style="display:<?= (($kmm->nilai_total_mitra == null) ? 'none' : '') ?>"
                                                        href="<?= base_url('kmm/penilaian/cetak-penilaian-mitra/' . $kmm->id_kmm) ?>">Penilaian
                                                        Mitra</a>
                                                </div>
                                                <?php else: ?>
                                                -
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php } endforeach; ?>
                                        <?php
                                            elseif(has_permission('dosen')):
                                            $no = 1;
                                            foreach ($kmm as $k) :
                                                if($k->status_laporan == 'disetujui' && $k->tgl_seminar != null) {
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $k->nm_mhs ?></td>
                                            <td><?= $k->th_masuk ?></td>
                                            <td><?= $k->nama_instansi ?></td>
                                            <td>
                                                <?php
                                                foreach($total as $p) {
                                                    if($k->id_kmm == $p->id_kmm){
                                                        if($p->nilai_total_dosen == null){
                                                            echo '<span class="badge badge-primary">Nilai Belum Ada</span>';
                                                        } else {
                                                            echo $p->nilai_total_dosen;
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                foreach($total as $p) {
                                                    if($k->id_kmm == $p->id_kmm){
                                                        if($p->nilai_total_mitra == null){
                                                            echo '<span class="badge badge-primary">Nilai Belum Ada</span>';
                                                        } else {
                                                            echo $p->nilai_total_mitra;
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                foreach($total as $p) {
                                                    if($k->id_kmm == $p->id_kmm){
                                                        if($p->nilai_akhir == null){
                                                            echo '<span class="badge badge-primary">Nilai Belum Ada</span>';
                                                        } else {
                                                            echo $p->nilai_akhir;
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    foreach($total as $p) {
                                                        if($k->id_kmm == $p->id_kmm){
                                                            if($p->nilai_total_mitra == null){
                                                                echo '<span class="badge badge-primary">Nilai Mitra Belum Ada</span>';
                                                            } elseif($p->nilai_total_dosen == null){
                                                                echo '<a class="btn btn-sm btn-outline-primary" href="'. base_url('kmm/penilaian/kmm/dosen/'. $k->id_kmm) .'">Nilai</a>';
                                                            } else {
                                                                echo '<span class="badge badge-success">Penilaian Berhasil</span>';
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php } endforeach; ?>
                                        <?php elseif(has_permission('mitra')) : ?>
                                        <?php
                                            $no = 1;
                                            foreach ($kmm2 as $km) :
                                                if($km->status_lolos == 'lolos') {
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $km->nm_mhs ?></td>
                                            <td><?= $km->nm_staf ?></td>
                                            <td>
                                                <?php
                                                foreach($total as $p) {
                                                    if($km->id_kmm == $p->id_kmm){
                                                        if($p->nilai_total_mitra == null){
                                                            echo '<span class="badge badge-primary">Nilai Belum Ada</span>';
                                                        } else {
                                                            echo $p->nilai_total_mitra;
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    foreach($total as $p) {
                                                        if($km->id_kmm == $p->id_kmm){
                                                            if($p->nilai_total_mitra == null){
                                                                echo '<a class="btn btn-sm btn-outline-primary" href="'. base_url('kmm/penilaian/kmm/mitra/'. $km->id_kmm) .'">Nilai</a>';
                                                            } else {
                                                                echo '<span class="badge badge-success">Penilaian Berhasil</span>';
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php } endforeach; ?>
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
        var timezoneOffset = -420;
        var th_masuk = $('#th_masuk').val();

        // Tambahkan parameter pada URL berdasarkan nilai-nilai form
        if (th_masuk != '') {
            <?php if(has_permission('admin') || has_permission('koor-kmm')): ?>
            var url = "<?php echo base_url('kmm/penilaian/getFilterDataNilai'); ?>" + "/" +
                th_masuk;
            <?php elseif(has_permission('dosen')): ?>
            var url = "<?php echo base_url('kmm/penilaian/getFilterDataNilaiByIdDosen'); ?>" + "/" +
                th_masuk;
            <?php endif; ?>
        }

        // Muat data dengan menggunakan AJAX
        $.ajax({
            url: url,
            method: "GET",
            dataType: 'json',
            success: function(data) {
                $('button#cetak').prop('disabled', false)
                var dataAwal = data;
                // Tampilkan data ke dalam tabel
                $('#dataTable-1').DataTable().clear().destroy();
                // tambahkan baris kode berikut untuk menambahkan data ke dalam tabel
                $.each(data, function(i, item) {
                    var url_cetak_p =
                        '<?= base_url('kmm/penilaian/cetak-penilaian-prodi') ?>' +
                        '/' + item.id_kmm;
                    var url_cetak_m =
                        '<?= base_url('kmm/penilaian/cetak-penilaian-mitra') ?>' +
                        '/' + item.id_kmm;
                    var url_nilai_mitra =
                        '<?= base_url('kmm/penilaian/kmm/mitra') ?>' +
                        '/' + item.id_kmm;
                    var url_nilai_prodi =
                        '<?= base_url('kmm/penilaian/kmm/dosen') ?>' +
                        '/' + item.id_kmm;

                    $('#dataTable-1 tbody')
                    <?php if(has_permission('admin') || has_permission('koor-kmm')): ?>
                        .append('<tr><td>' + ((i++) + 1) + '</td><td>' + item
                            .nm_mhs + '</td><td>' + item.th_masuk + '</td><td>' +
                            item.nm_staf + '</td><td>' +
                            item.nama_instansi + '</td><td>' + ((item
                                    .nilai_total_dosen == null) ?
                                ('<a class="btn btn-sm btn-outline-primary" href="' +
                                    url_nilai_prodi + '">Nilai</a>') : (item
                                    .nilai_total_dosen)) + '</td><td>' + ((item
                                    .nilai_total_mitra == null) ?
                                '<a class="btn btn-sm btn-outline-primary" style="display:' +
                                ((item.nilai_total_mitra > 0) ? 'none' : '') +
                                '" href="' + url_nilai_mitra + '">Nilai</a>' : item
                                .nilai_total_mitra) + '</td><td>' + item
                            .nilai_akhir +
                            '</td><td>' + ((item.nilai_akhir != null) ?
                                '<button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" style="display:' +
                                ((item.nilai_total_dosen == null) ? 'none' : '') +
                                '" href="' + url_cetak_p +
                                '">Penilaian Prodi</a><a class="dropdown-item" style="display:' +
                                ((item.nilai_total_mitra == null) ? 'none' : '') +
                                '" href="' + url_cetak_m +
                                '">Penilaian Mitra</a></div>' : '-') +
                            '</td></tr>');
                    <?php elseif(has_permission('dosen')): ?>
                        .append('<tr><td>' + ((i++) + 1) + '</td><td>' + item
                            .nm_mhs + '</td><td>' + item.th_masuk + '</td><td>' +
                            item
                            .nama_instansi + '</td><td>' + item.nilai_total_dosen +
                            '</td><td>' + item.nilai_total_mitra + '</td><td>' +
                            item.nilai_akhir +
                            '</td><td><span class="badge badge-success">Penilaian Berhasil</span></td></tr>'
                        );
                    <?php endif; ?>
                });
                $('#dataTable-1').DataTable({
                    columnDefs: [{
                        <?php if(has_permission('admin') || has_permission('koor-kmm')): ?>
                        targets: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                        <?php else: ?>
                        targets: [0, 1, 2, 3, 4, 5],
                        <?php endif; ?>
                        orderable: true,
                    }],
                });
            },
        });
    });

    $('#cetak').on('click', function(event) {
        event.preventDefault();
        var th_masuk = $('#th_masuk').val();

        if (th_masuk != '') {
            var url = "<?= base_url('kmm/penilaian/cetak/');?>" + "/" +
                th_masuk;
            window.open(url);
        }
    });
});
</script>

<?= $this->include('kmm/kmm_partial/dashboard/footer'); ?>