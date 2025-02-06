<?= $this->include('master_partial/dashboard/header'); ?>
<?= $this->include('mbkm/mbkm_partial/dashboard/top_menu'); ?>
<?php if(has_permission('admin')) : ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>
<?php elseif(has_permission('dosen')|| has_permission('koor-mbkm')) : ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/side_menu') ?>
<?php elseif(has_permission('mitra')) : ?>
<?= $this->include('mitra/mitra_partial/dashboard/side_menu'); ?>
<?php endif; ?>

<main role="main" class="main-content">
    <div class="row my-3">
        <div class="col-12">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="page-title">Penilaian UTS Mahasiswa MBKM</h2>
                </div>
                <?php if(has_permission('admin')) : ?>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right text-sm">
                        <li class="breadcrumb-item"><a
                                href="<?= base_url('admin/dashboard') ?>"><small>Dashboard</small></a>
                        </li>
                        <li class="breadcrumb-item active"><small>Penilaian UTS</small></li>
                    </ol>
                </div>
                <?php elseif(has_permission('dosen')) : ?>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right text-sm">
                        <li class="breadcrumb-item"><a
                                href="<?= base_url('admin/dashboard') ?>"><small>Dashboard</small></a>
                        </li>
                        <li class="breadcrumb-item active"><small>Penilaian UTS</small></li>
                    </ol>
                </div>
                <?php endif; ?>
            </div>
            <?php if(has_permission('admin') || has_permission('dosen')|| has_permission('koor-mbkm')) : ?>
            <div class="col-md-12">

                <div class="card shadow mb-4">

                    <div class="card-header">

                        <strong class="card-title">Pencarian Data Mahasiswa</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class=" form-group mb-3">
                                    <label>Angkatan <span class="text-danger"></span></label>
                                    <select class="form-control select2 required" name="th_masuk" id="th_masuk">
                                        <option value="">Pilih Angkatan</option>
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
                                <button id="resetFilter" class="btn btn-danger">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="card-body">
                <canvas id="grafikpenilaianuts" width="400" height="300"></canvas>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
                <script>
                var data = <?php echo json_encode($data2); ?>;
                var ctx = document.getElementById('grafikpenilaianuts').getContext('2d');
                var grafikpenilaianuts = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: data.datasets.map(function(dataset) {
                            return {
                                label: dataset.label,
                                data: dataset.data,
                                backgroundColor: [
                                    'rgba(8, 99, 210, 0.8)',
                                    'rgba(188, 188, 188, 0.67)',
                                    'rgba(60, 184, 210, 0.67)',
                                    'rgba(167, 170, 170, 0.13)',

                                ]
                            };
                        })
                    },
                    options: {
                        responsive: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    userCallback: function(label, index, labels) {
                                        // when the floored value is the same as the value we have a whole number
                                        if (Math.floor(label) === label) {
                                            return label;
                                        }
                                    }
                                }
                            }]
                        },
                        plugins: {
                            datalabels: {
                                color: 'black',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                });
                </script>

            </div> <!-- /.card-body -->
            <!-- Small table -->
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <!-- table -->
                        <a href="<?=base_url('mbkm/penilaian');?>" class="btn btn-secondary mb-3">Kembali</a>
                        <a href="<?=base_url('mbkm/penilaian/grafik-uts');?>" class="btn btn-info mb-3">Grafik</a>
                        <table class="table datatables" id="dataTable-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <?php if(has_permission('admin')|| has_permission('koor-mbkm')) : ?>
                                    <th>Nama Mahasiswa</th>
                                    <th>Nama Mitra</th>
                                    <th>Nama Dosen Pembimbing</th>
                                    <th>Nilai Dosen</th>
                                    <th>Nilai Mitra</th>
                                    <th>Nilai UTS</th>
                                    <?php elseif(has_permission('dosen') ) : ?>
                                    <th>Nama Mahasiswa</th>
                                    <th>Nama Mitra</th>
                                    <th>Nilai Dosen</th>
                                    <th>Nilai Mitra</th>
                                    <th>Nilai UTS</th>
                                    <?php elseif(has_permission('mitra')) : ?>
                                    <th>Nama Mahasiswa</th>
                                    <th>Nama Dosen Pembimbing</th>
                                    <th>Nilai Mitra</th>
                                    <?php endif; ?>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(has_permission('admin')|| has_permission('koor-mbkm')) : ?>
                                <?php
                                $no = 1;
                                foreach ($mbkm as $a) :
                                if($a->status_mahasiswa == 'diambil') {
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $a->nm_mhs ?></td>
                                    <td><?= $a->nama_instansi ?></td>
                                    <td><?= $a->nm_staf ?></td>
                                    <td>
                                        <?php
                                        foreach($totalUts as $p) {
                                        if($a->id_mbkm_fix == $p->id_mbkm_fix) {
                                        if($p->nilai_dosen_uts == 0 ){
                                        echo '<a class="btn btn-sm btn-outline-primary" href="'. base_url('mbkm/penilaian/mbkm/dosen/'. $a->id_mbkm_fix) .'">Nilai</a>';
                                         } else {
                                             echo $p->nilai_dosen_uts;
                                                }
                                            }
                                        }  ?>
                                    </td>
                                    <td>
                                        <?php
                                        foreach($totalUts as $p) {
                                        if($a->id_mbkm_fix == $p->id_mbkm_fix) {
                                        if($p->nilai_mitra_uts == null){
                                        echo '<a class="btn btn-sm btn-outline-primary" href="'. base_url('mbkm/penilaian/mbkm/mitra/'. $a->id_mbkm_fix) .'">Nilai</a>';
                                         } else {
                                             echo $p->nilai_mitra_uts;
                                                }
                                            }
                                        }  ?>
                                    </td>
                                    <td>
                                        <?php foreach($totalUts as $p) {
                                        echo ($a->id_mbkm_fix == $p->id_mbkm_fix) ? $p->nilai_final_uts : ''; } ?>
                                    </td>
                                    <td>
                                        <?php if($a->nilai_final_uts != null): ?>
                                        <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item"
                                                style="display:<?= (($a->nilai_dosen_uts == null) ? 'none' : '') ?>"
                                                href="<?= base_url('mbkm/penilaian/pdf-uts-dsn/' . $a->id_mbkm_fix) ?>">Penilaian
                                                Dosen</a>
                                            <a class="dropdown-item"
                                                style="display:<?= (($a->nilai_mitra_uts == null) ? 'none' : '') ?>"
                                                href="<?= base_url('mbkm/penilaian/cetak-penilaian-mitra/' . $a->id_mbkm_fix) ?>">Penilaian
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
                                foreach ($mbkm3 as $m) :
                                if($m->status_mahasiswa == 'diambil') {
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $m->nm_mhs ?></td>
                                    <td><?= $m->nama_instansi ?></td>
                                    <td>
                                        <?php
                                        foreach($totalUts as $p) {
                                        if($m->id_mbkm_fix == $p->id_mbkm_fix){
                                            if($p->nilai_dosen_uts == 0){
                                                echo '<span class="badge badge-danger">Belum dinilai</span>';                                            
                                            } else {
                                                echo $p->nilai_dosen_uts;
                                                }
                                                    }
                                            }?>
                                    </td>
                                    <td>
                                        <?php
                                        foreach($totalUts as $p) {
                                        if($m->id_mbkm_fix == $p->id_mbkm_fix){
                                            if($p->nilai_mitra_uts == 0){
                                                echo '<span class="badge badge-danger">Belum dinilai</span>';                                            
                                            } else {
                                                echo $p->nilai_mitra_uts;
                                                }
                                                    }
                                            }?>
                                    </td>
                                    <td>
                                        <?php
                                        foreach($totalUts as $p) {
                                        if($m->id_mbkm_fix == $p->id_mbkm_fix){
                                            if($p->nilai_final_uts == 0){
                                                echo '<span class="badge badge-danger">Belum ada</span>';                                            
                                            } else {
                                                echo $p->nilai_final_uts;
                                                }
                                                    }
                                            }?>
                                    </td>
                                    <td>
                                        <?php
                                        foreach($totalUts as $p) {
                                        if($m->id_mbkm_fix == $p->id_mbkm_fix){
                                            if($p->nilai_dosen_uts == 0){
                                                echo '<a class="btn btn-sm btn-outline-primary" href="'. base_url('mbkm/penilaian/mbkm/dosen/' . $m->id_mbkm_fix) .'">Nilai</a>';
                                            } else {
                                                echo '<span class="badge badge-success">Sudah dinilai</span>';
                                                }
                                                    }
                                            }?>
                                    </td>
                                    </td>
                                </tr>
                                </tr>
                                <?php } endforeach; ?>
                                <?php elseif(has_permission('mitra')) : ?>
                                <?php
                                $no = 1;
                                foreach ($mbkm2 as $k) :
                                if($k->status_mahasiswa == 'diambil') {
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $k->nm_mhs ?></td>
                                    <td><?= $k->nm_staf ?></td>
                                    <td>
                                        <?php
                                        foreach($totalUts as $p) {
                                        if($k->id_mbkm_fix == $p->id_mbkm_fix){
                                            if($p->nilai_mitra_uts == 0){
                                                echo '<span class="badge badge-danger">Belum dinilai</span>';                                            
                                            } else {
                                                echo $p->nilai_mitra_uts;
                                                }
                                                    }
                                            }?>
                                    </td>
                                    <td>
                                        <?php
                                        foreach($totalUts as $p) {
                                        if($k->id_mbkm_fix == $p->id_mbkm_fix){
                                            if($p->nilai_mitra_uts == 0){
                                                echo '<a class="btn btn-sm btn-outline-primary" href="'. base_url('mbkm/penilaian/mbkm/mitra/' . $k->id_mbkm_fix) .'">Nilai</a>';
                                            } else {
                                                echo '<span class="badge badge-success">Sudah dinilai</span>';
                                                }
                                                    }
                                            }?>
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
        var th_masuk = $('#th_masuk').val();

        // Tambahkan parameter pada URL berdasarkan nilai-nilai form
        if (th_masuk != '') {
            <?php if(has_permission('admin')|| has_permission('koor-mbkm')): ?>
            var url = "<?php echo base_url('mbkm/penilaian/filter-adm'); ?>" + "/" +
                th_masuk;
            <?php elseif(has_permission('dosen')): ?>
            var url = "<?php echo base_url('mbkm/penilaian/filter-dsn'); ?>" + "/" +
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
                    var url_uts_dsn =
                        '<?= base_url('mbkm/penilaian/mbkm/dosen/'); ?>' +
                        '/' + item.id_mbkm_fix;
                    var url_cetak_dsn =
                        '<?= base_url('mbkm/penilaian/pdf-uts-dsn/') ?>' +
                        '/' + item.id_kmm;
                    var url_cetak_mtr =
                        '<?= base_url('mbkm/penilaian/pdf-uts-mtr/') ?>' +
                        '/' + item.id_kmm;
                    $('#dataTable-1 tbody')
                    <?php if(has_permission('admin')|| has_permission('koor-mbkm')): ?>
                        .append('<tr><td>' + ((i++) + 1) + '</td><td>' + item
                            .nm_mhs + '</td><td>' + item.nm_staf + '</td><td>' +
                            item.nama_instansi + '</td><td>' +
                            item.nilai_dosen_uts + '</td><td>' +
                            item
                            .nilai_mitra_uts + '</td><td>' + item.nilai_final_uts +
                            '</td><td>' +
                            ((item.nilai_akhir != null) ?
                                '<button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" style="display:' +
                                ((item.nilai_total_dosen == null) ? 'none' : '') +
                                '" href="' + url_cetak_dsn +
                                '">Penilaian Prodi</a><a class="dropdown-item" style="display:' +
                                ((item.nilai_total_mitra == null) ? 'none' : '') +
                                '" href="' + url_cetak_mtr +
                                '">Penilaian Mitra</a></div>' : '-') +
                            '</td></tr>');
                    <?php elseif(has_permission('dosen')): ?>
                        .append('<tr><td>' + ((i++) + 1) + '</td><td>' + item
                            .nm_mhs + '</td><td>' +
                            item.nama_instansi + '</td><td>' +
                            item.nilai_dosen_uts + '</td><td>' +
                            item.nilai_mitra_uts + '</td><td>' +
                            item.nilai_final_uts + '</td><td>' +
                            ((item.nilai_dosen_uts > 0) ?
                                '<span class="badge badge-success">Sudah dinilai</span>' :
                                '<a class="btn btn-outline-primary" type="button" href="' +
                                url_uts_dsn +
                                '">Nilai</a>') +
                            '</td></tr>'
                        );
                    <?php endif; ?>
                });
                $('#dataTable-1').DataTable({
                    columnDefs: [{
                        <?php if(has_permission('admin')|| has_permission('koor-mbkm')): ?>
                        targets: [0, 1, 2, 3],
                        <?php elseif(has_permission('dosen')): ?>
                        targets: [0, 1, 2, 3],
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
                url: '<?php echo base_url('mbkm/penilaian');?>',
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
                                .nm_mhs + '</td><td>' + item.nm_staf +
                                '</td><td>' +
                                item.nama_instansi + '</td><td>' + item
                                .nilai_dosen_uts + '</td><td>' + item
                                .nilai_mitra_uas + '</td><td>' +
                                item.nilai_final_uts + '</td></tr>');
                        <?php elseif(has_permission('dosen')): ?>
                            .append('<tr><td>' + ((i++) + 1) + '</td><td>' +
                                item
                                .nm_mhs + '</td><td>' + item
                                .nama_instansi + '</td><td>' + item
                                .nilai_dosen_uts +
                                '</td><td>' + item.nilai_mitra_uas +
                                '</td><td>' +
                                item.nilai_final_uts +
                                '</td><td><span class="badge badge-success">Penilaian Berhasil</span></td></tr>'
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
    $('#cetak').on('click', function(event) {
        event.preventDefault();
        var th_masuk = $('#th_masuk').val();

        if (th_masuk != '') {
            var url = "<?= base_url('mbkm/penilaian/cetak/');?>" + "/" +
                th_masuk;
            window.open(url);
        }
    });
});
</script>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer'); ?>