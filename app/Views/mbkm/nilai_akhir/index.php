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
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2 ">
                    <div class="col-sm-6">
                        <h2 class="page-title">Nilai Akhir Mahasiswa MBKM</h2>
                        <p class="card-text">
                            Rekap data dari nilai UTS, UAS, dan Nilai Akhir Mahasiswa MBKM

                        </p>
                    </div>
                    <?php if(has_permission('admin')||has_permission('koor-mbkm')) : ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a
                                    href="<?= base_url('admin/dashboard') ?>"><small>Dashboard</small></a>
                            </li>
                            <li class="breadcrumb-item active"><small>Nilai Akhir</small></li>
                        </ol>
                    </div>
                    <?php elseif(has_permission('dosen')) : ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a
                                    href="<?= base_url('dashboard') ?>"><small>Dashboard</small></a>
                            </li>
                            <li class="breadcrumb-item active"><small>Penilaian UAS</small></li>
                        </ol>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="row my-4">
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-mbkm')) : ?>
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
                                            <div class="text-danger">* Pilih angkatan sebelum export data
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button id="prosesFilter" class="btn btn-primary">Proses</button>
                                        <button id="cetak" class="btn btn-info" disabled>Excel</button>
                                        <button id="cetakPdf" class="btn btn-info" disabled>PDF</button>
                                        <button id="resetFilter" class="btn btn-danger">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <!-- Small table -->

                <div class="card shadow ">
                    <div class="card-body">
                        <!-- table -->
                        <a href="<?=base_url('mbkm/penilaian');?>" class="btn btn-secondary bt-sm mb-3">Kembali</a>
                        <table class="table datatables" id="dataTable-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <?php if(has_permission('admin')|| has_permission('koor-mbkm')) : ?>
                                    <th>Nama Mahasiswa</th>
                                    <th>Dosen Pembimbing</th>
                                    <th>Mitra</th>
                                    <th>Nilai UTS</th>
                                    <th>Nilai UAS</th>
                                    <th>Nilai Akhir</th>
                                    <?php elseif(has_permission('dosen') ) : ?>
                                    <th>Nama Mahasiswa</th>
                                    <th>Mitra</th>
                                    <th>Nilai UTS</th>
                                    <th>Nilai UAS</th>
                                    <th>Nilai Akhir</th>
                                    <?php endif; ?>
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
                                    <td><?= $a->nm_staf ?></td>
                                    <td><?= $a->nama_instansi ?></td>
                                    <td><?= $a->nilai_final_uts ?></td>
                                    <td><?= $a->nilai_final_uas ?></td>
                                    <td><?= $a->nilai_konversi ?></td>

                                </tr>
                                <?php } endforeach; ?>
                                <?php
                                            elseif(has_permission('dosen')):
                                                $no = 1;
                                                foreach ($mbkmDsn as $m) :
                                                if($m->status_mahasiswa == 'diambil') {
                                        ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $m->nm_mhs ?></td>
                                    <td><?= $m->nama_instansi ?></td>
                                    <td><?= $m->nilai_final_uts ?></td>
                                    <td><?= $m->nilai_final_uas ?></td>
                                    <td><?= $m->nilai_konversi ?></td>

                                </tr>
                                <?php } endforeach; ?>
                                <?php elseif(has_permission('mitra')) : ?>

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
    </div>
    <!-- .col-12 -->

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
            var url = "<?php echo base_url('mbkm/penilaian/akhir/filter-adm'); ?>" + "/" +
                th_masuk;
            <?php elseif(has_permission('dosen')): ?>
            var url = "<?php echo base_url('mbkm/penilaian/akhir/filter-dsn'); ?>" + "/" +
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
                $('button#cetakPdf').prop('disabled', false)
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
                            item.nilai_final_uts + '</td><td>' +
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
            var url = "<?= base_url('mbkm/penilaian/akhir/cetak/');?>" + "/" +
                th_masuk;
            window.open(url);
        }
    });
    $('#cetakPdf').on('click', function(event) {
        event.preventDefault();
        var th_masuk = $('#th_masuk').val();

        if (th_masuk != '') {
            var url = "<?= base_url('mbkm/penilaian/akhir/pdf/');?>" + "/" +
                th_masuk;
            window.open(url);
        }
    });
});
</script>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer'); ?>