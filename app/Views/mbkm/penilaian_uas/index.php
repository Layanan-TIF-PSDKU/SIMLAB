<?= $this->include('master_partial/dashboard/header'); ?>
<?= $this->include('mbkm/mbkm_partial/dashboard/top_menu'); ?>
<?php if(has_permission('admin')) : ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>
<?php elseif(has_permission('dosen') || has_permission('koor-mbkm')) : ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/side_menu') ?>
<?php elseif(has_permission('mitra')) : ?>
<?= $this->include('mitra/mitra_partial/dashboard/side_menu'); ?>
<?php endif; ?>

<main role="main" class="main-content">
    <div class="row my-3">
        <div class="col-12">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="page-title">Penilaian UAS Mahasiswa MBKM</h2>
                    <p class="card-text">

                    </p>
                </div>
                <?php if(has_permission('admin')) : ?>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right text-sm">
                        <li class="breadcrumb-item"><a
                                href="<?= base_url('admin/dashboard') ?>"><small>Dashboard</small></a>
                        </li>
                        <li class="breadcrumb-item active"><small>Penilaian UAS</small></li>
                    </ol>
                </div>
                <?php elseif(has_permission('dosen')) : ?>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right text-sm">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>"><small>Dashboard</small></a>
                        </li>
                        <li class="breadcrumb-item active"><small>Penilaian UAS</small></li>
                    </ol>
                </div>
                <?php endif; ?>
            </div>
            <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-mbkm')) : ?>
            <div class="container-fluid">
                <div class="row my-3">
                    <div class="col-12">
                        <div class="row">
                            <!-- Recent Activity -->
                            <div class="col-md-12 col-lg-5">
                                <div class="card shadow" style="height: 260px; ">
                                    <div class="card-header">
                                        <strong class="card-title pb-4">Pencarian Data Nilai Mahasiswa</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="pb-3">
                                            <div class="row">
                                                <div class="col-md-6 col-lg-10">
                                                    <div class=" form-group mb-2">
                                                        <label>Angkatan <span class="text-danger"></span></label>
                                                        <select class="form-control select2 required" name="th_masuk"
                                                            id="th_masuk">
                                                            <option value="">Pilih Angkatan</option>
                                                            <?php foreach($mhs as $akt): ?>
                                                            <option value="<?= $akt->th_masuk ?>">
                                                                <?= $akt->th_masuk ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <div class="text-danger">* Pilih angkatan sebelum export data
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-lg-8">
                                                    <button id="prosesFilter" class="btn btn-primary">Proses</button>
                                                    <button id="cetak" class="btn btn-info" disabled>Cetak</button>
                                                    <button id="resetFilter" class="btn btn-danger">Reset</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div> <!-- / .card-body -->
                                </div> <!-- / .card -->
                            </div> <!-- / .col-md-6 -->
                            <!-- Striped rows -->
                            <div class="col-md-12 col-lg-7">
                                <div class="card shadow" style="width: 589px; height: 260px;">
                                    <div class="card-header">
                                        <strong class="card-title">Grafik UAS</strong>
                                    </div>
                                    <div class="card-body mx-1">
                                        <canvas id="grafikpenilaianuas" width="589" height="200"></canvas>
                                        <script
                                            src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js">
                                        </script>
                                        <script>
                                        var data = <?php echo json_encode($data2); ?>;
                                        var ctx = document.getElementById('grafikpenilaianuas').getContext('2d');
                                        var grafikpenilaianuas = new Chart(ctx, {
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
                                                            'rgba(51, 186, 126, 0.43)',
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
                                                            userCallback: function(label, index,
                                                                labels) {
                                                                if (Math.floor(label) ===
                                                                    label) {
                                                                    return label;
                                                                }
                                                            }
                                                        },
                                                        scaleLabel: {
                                                            display: true,
                                                            labelString: 'Jumlah Mahasiswa' // Ganti dengan label yang diinginkan untuk sumbu Y
                                                        }
                                                    }],
                                                    xAxes: [{
                                                        scaleLabel: {
                                                            display: true,
                                                            labelString: 'Nilai UAS' // Ganti dengan label yang diinginkan untuk sumbu X
                                                        }
                                                    }]
                                                },
                                                plugins: {
                                                    datalabels: {
                                                        color: 'black',
                                                        font: {
                                                            weight: 'bold',
                                                            size: 5,
                                                        }
                                                    }
                                                },
                                                legend: {
                                                    display: false,
                                                },
                                                tooltips: {
                                                    callbacks: {
                                                        label: function(tooltipItem) {
                                                            return tooltipItem.yLabel;
                                                        }
                                                    }
                                                }
                                            }

                                        });
                                        </script>

                                    </div> <!-- /.card-body -->
                                </div>
                            </div> <!-- Striped rows -->
                        </div> <!-- .row-->
                    </div> <!-- .row-->
                </div> <!-- .row-->
            </div> <!-- .row-->
            <?php endif; ?>
            <!-- Small table -->

            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <!-- table -->
                        <a href="<?=base_url('mbkm/penilaian');?>" class="btn btn-secondary bt-sm mb-3">Kembali</a>
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
                                    <th>Nilai UAS</th>
                                    <th>Action</th>
                                    <?php elseif(has_permission('dosen') ) : ?>
                                    <th>Nama Mahasiswa</th>
                                    <th>Nama Mitra</th>
                                    <th>Nilai Dosen</th>
                                    <th>Nilai Mitra</th>
                                    <th>Nilai UAS</th>
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
                                        <?php foreach($totalUas as $p) {
                                                    echo ($a->id_mbkm_fix == $p->id_mbkm_fix) ? $p->nilai_dosen_uas : ''; } ?>
                                    </td>
                                    <td>
                                        <?php foreach($totalUas as $p) {
                                                    echo ($a->id_mbkm_fix == $p->id_mbkm_fix) ? $p->nilai_mitra_uas : ''; } ?>
                                    </td>
                                    <td>
                                        <?php foreach($totalUas as $p) {
                                                    echo ($a->id_mbkm_fix == $p->id_mbkm_fix) ? $p->nilai_final_uas : ''; } ?>
                                    </td>

                                    <td>
                                        <?php
                                        foreach($totalUas as $p) {
                                        if($a->id_mbkm_fix == $p->id_mbkm_fix) {
                                        if($p->nilai_dosen_uas == null){
                                        echo '<a class="btn btn-sm btn-outline-primary" href="'. base_url('mbkm/penilaian/uas/mbkm/dosen/uas/'. $a->id_mbkm_fix) .'">Nilai</a>';
                                         } else {
                                             echo '<span class="badge badge-success">Sudah dinilai</span>';
                                                }
                                            }
                                        }  ?>
                                    </td>
                                    <td>
                                        <?php if($a->nilai_final_uas != null): ?>
                                        <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item"
                                                style="display:<?= (($a->nilai_dosen_uas == null) ? 'none' : '') ?>"
                                                href="<?= base_url('mbkm/penilaian/uas/pdf-uas-dsn/' . $a->id_mbkm_fix) ?>">Penilaian
                                                Dosen</a>
                                            <a class="dropdown-item"
                                                style="display:<?= (($a->nilai_mitra_uas == null) ? 'none' : '') ?>"
                                                href="<?= base_url('mbkm/penilaian/uas/pdf-uas-mtr/' . $a->id_mbkm_fix) ?>">Penilaian
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
                                                foreach ($dosen as $m) :
                                                if($m->status_mahasiswa == 'diambil') {
                                        ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $m->nm_mhs ?></td>
                                    <td><?= $m->nama_instansi ?></td>
                                    <td>
                                        <?php if($m->nilai_dosen_uas == 0):?>
                                        <span class="badge badge-danger">belum dinilai</span>
                                        <?php else: ?>
                                        <?= $m->nilai_dosen_uas?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($m->nilai_mitra_uas == 0):?>
                                        <span class="badge badge-danger">belum dinilai</span>
                                        <?php else: ?>
                                        <?= $m->nilai_mitra_uas?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($m->nilai_final_uas < 60):?>
                                        <span class="badge badge-danger">belum ada</span>
                                        <?php else: ?>
                                        <?= $m->nilai_final_uas?>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if($m->nilai_dosen_uts == 0 && $m->nilai_mitra_uts == 0):?>
                                        <span class="badge badge-warning">penilaian UAS belum dimulai</span>
                                        <?php elseif($m->nilai_mitra_uts > 0 && $m->nilai_dosen_uts == 0 ): ?>
                                        <span class="badge badge-warning">penilaian UAS belum dimulai</span>
                                        <?php elseif($m->nilai_mitra_uts == 0 && $m->nilai_dosen_uts > 0 ): ?>
                                        <span class="badge badge-warning">penilaian UAS belum dimulai</span>
                                        <?php elseif($m->nilai_dosen_uas > 0  ): ?>
                                        <span class="badge badge-success">sudah dinilai</span>
                                        <?php elseif($m->nilai_mitra_uts > 0 && $m->nilai_dosen_uts > 0 ): ?>
                                        <a class="btn btn-sm btn-outline-primary"
                                            href="<?=base_url('mbkm/penilaian/uas/mbkm/dosen/uas/'. $m->id_mbkm_fix)?>">Nilai</a>
                                        <?php endif; ?>
                                    </td>
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
                                        <?php if($k->nilai_mitra_uas == 0):?>
                                        <span class="badge badge-danger">belum dinilai</span>

                                        <?php else: ?>
                                        <?= $k->nilai_mitra_uas ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($k->nilai_dosen_uts == 0 && $k->nilai_mitra_uts == 0):?>
                                        <span class="badge badge-warning">penilaian UAS belum dimulai</span>
                                        <?php elseif($k->nilai_dosen_uts > 0 && $k->nilai_mitra_uts == 0  ): ?>
                                        <span class="badge badge-warning">penilaian UAS belum dimulai</span>
                                        <?php elseif($k->nilai_mitra_uts == 0 && $k->nilai_dosen_uts > 0  ): ?>
                                        <span class="badge badge-warning">penilaian UAS belum dimulai</span>
                                        <?php elseif($k->nilai_mitra_uas > 0  ): ?>
                                        <span class="badge badge-success">sudah dinilai</span>
                                        <?php elseif($k->nilai_mitra_uts > 0 && $k->nilai_dosen_uts > 0  ): ?>
                                        <a class="btn btn-sm btn-outline-primary"
                                            href="<?=base_url('mbkm/penilaian/uas/mbkm/mitra/uas/'. $k->id_mbkm_fix)?>">Nilai</a>
                                        <?php endif; ?>
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
            var url = "<?php echo base_url('mbkm/penilaian/uas/filter-adm-uas'); ?>" + "/" +
                th_masuk;
            <?php elseif(has_permission('dosen')): ?>
            var url = "<?php echo base_url('mbkm/penilaian/uas/filter-dsn-uas'); ?>" + "/" +
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
                    var url_uas_dsn =
                        '<?= base_url('mbkm/penilaian/uas/mbkm/dosen/uas/'); ?>' +
                        '/' + item.id_mbkm_fix;
                    $('#dataTable-1 tbody')
                    <?php if(has_permission('admin')|| has_permission('koor-mbkm')): ?>
                        .append('<tr><td>' + ((i++) + 1) + '</td><td>' + item
                            .nm_mhs + '</td><td>' + item.nm_staf + '</td><td>' +
                            item.nama_instansi + '</td><td>' +
                            item.nilai_dosen_uas + '</td><td>' +
                            item.nilai_mitra_uas + '</td><td>' +
                            item.nilai_final_uas + '</td><td>' +
                            item.nilai_konversi +
                            '</td></tr>');
                    <?php elseif(has_permission('dosen')): ?>
                        .append('<tr><td>' + ((i++) + 1) + '</td><td>' + item
                            .nm_mhs + '</td><td>' +
                            item.nama_instansi + '</td><td>' +
                            item.nilai_dosen_uas + '</td><td>' +
                            item.nilai_mitra_uas + '</td><td>' +
                            item.nilai_final_uas + '</td><td>' +
                            item.nilai_konversi + '</td><td>' +
                            (
                                (item.nilai_dosen_uts === 0 && item
                                    .nilai_mitra_uts === 0) ?
                                '<span class="badge badge-warning">penilaian UAS belum dimulai</span>' :
                                (item.nilai_dosen_uts > 0 && item
                                    .nilai_mitra_uts === 0) ?
                                '<span class="badge badge-warning">penilaian UAS belum dimulai</span>' :
                                (item.nilai_dosen_uts === 0 && item
                                    .nilai_mitra_uts > 0) ?
                                '<span class="badge badge-warning">penilaian UAS belum dimulai</span>' :
                                (item.nilai_dosen_uas > 0) ?
                                '<span class="badge badge-success">sudah dinilai</span>' :
                                (item.nilai_dosen_uts > 0 && item.nilai_mitra_uts >
                                    0) ?
                                '<a class="btn btn-outline-primary" type="button" href="' +
                                url_uas_dsn +
                                '">Nilai</a>' :
                                '<a class="btn btn-outline-primary" type="button" href="' +
                                url_uas_dsn +
                                '">Nilai</a>'
                            ) +
                            '</td></tr>');
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
                url: '<?php echo base_url('mbkm/penilaian/uas');?>',
                method: "GET",
                dataType: 'json',
                success: function(data) {
                    // Tampilkan data ke dalam tabel
                    $('#dataTable-1').DataTable().clear().destroy();
                    // tambahkan baris kode berikut untuk menambahkan data ke dalam tabel
                    $.each(data, function(i, item) {
                        $('#dataTable-1 tbody')
                        <?php if(has_permission('admin')|| has_permission('koor-mbkm')): ?>
                            .append('<tr><td>' + ((i++) + 1) + '</td><td>' +
                                item
                                .nm_mhs + '</td><td>' + item.nm_staf +
                                '</td><td>' +
                                item.nama_instansi + '</td><td>' +
                                item.nilai_dosen_uas + '</td><td>' +
                                item.nilai_mitra_uas + '</td><td>' +
                                item.nilai_final_uas + '</td></tr>');
                        <?php elseif(has_permission('dosen')): ?>
                            .append('<tr><td>' + ((i++) + 1) + '</td><td>' +
                                item
                                .nm_mhs + '</td><td>' +
                                item.nama_instansi + '</td><td>' +
                                item.nilai_dosen_uas +
                                '</td><td>' + item.nilai_mitra_uas +
                                '</td><td>' +
                                item.nilai_final_uas +
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
            var url = "<?= base_url('mbkm/penilaian/uas/cetak/');?>" + "/" +
                th_masuk;
            window.open(url);
        }
    });
});
</script>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer'); ?>