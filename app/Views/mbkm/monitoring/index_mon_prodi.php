<?php echo $this->include('mbkm/mbkm_partial/dashboard/header'); ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/top_menu'); ?>
<?php if (has_permission('admin')): ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else: ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/side_menu') ?>
<?php endif;?>
<main role="main" class="main-content">

    <div class="row my-3">
        <!-- Small table -->
        <div class="col-md-12">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="page-title">Monitoring Kegiatan MBKM Prodi</h2>
                    <p class="card-text">
                        Data Mahasiswa Aktif Kegiatan MBKM Prodi
                    </p>
                </div>
                <?php if(has_permission('admin')) : ?>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right text-sm">
                        <li class="breadcrumb-item"><a
                                href="<?= base_url('admin/dashboard') ?>"><small>Dashboard</small></a>
                        </li>
                        <li class="breadcrumb-item active"><small>Monitoring MBKM Prodi</small></li>
                    </ol>
                </div>
                <?php elseif(has_permission('dosen')) : ?>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right text-sm">
                        <li class="breadcrumb-item"><a href="<?= base_url('mbkm') ?>"><small>Dashboard</small></a>
                        </li>
                        <li class="breadcrumb-item active"><small>Monitoring MBKM Prodi</small></li>
                    </ol>
                </div>
                <?php endif; ?>
            </div>
            <?php if (has_permission('admin') || has_permission('dosen') || has_permission('koor-mbkm')): ?>
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
                                    <?php foreach ($mhs2 as $akt): ?>
                                    <option value="<?=$akt->th_masuk?>"><?=$akt->th_masuk?></option>
                                    <?php endforeach;?>
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
            <?php endif;?>
            <div class="card shadow">
                <div class="card-body">

                    <!-- table -->
                    <a href="<?=base_url('mbkm/monitoring');?>" class="btn btn-secondary bt-sm mb-3">Kembali</a>
                    <div class="table-responsive">
                        <table class="table datatables" id="dataTable-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Mahasiswa</th>
                                    <?php if (has_permission('admin') || has_permission('koor-mbkm')): ?>
                                    <th>Dosen Pembimbing</th>
                                    <?php endif;?>
                                    <th>Nama Instansi</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(has_permission('admin') || has_permission('koor-mbkm')):
                                $no = 1;
                                foreach ($MonAdmProdi as $a) : 
                                // dd($MonAdmMsib); ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $a->nm_mhs ?></td>
                                    <td><?= $a->nm_staf ?></td>
                                    <td><?= $a->nama_instansi ?></td>

                                    <td> <a class="btn btn-outline-primary" type="button"
                                            href="<?= base_url('mbkm/monitoring/detail-mbkm-prodi/' . $a->id_mbkm_fix) ?>">Monitoring</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php 
                                elseif(has_permission('dosen')):
                                $no = 1;
                                foreach ($MonDsnProdi as $a) :  ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $a->nm_mhs ?></td>
                                    <td><?= $a->nama_instansi ?></td>

                                    <td> <a class="btn btn-outline-primary" type="button"
                                            href="<?= base_url('mbkm/monitoring/detail-mbkm-prodi/' . $a->id_mbkm_fix) ?>">Monitoring</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    </tbody>

    </div>
    <!-- simple table -->
    </div>
    <!-- end section -->
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
            <?php if (has_permission('admin') || has_permission('koor-mbkm')): ?>
            var url = "<?php echo base_url('mbkm/monitoring/filter-adm-prodi'); ?>" +
                "/" +
                th_masuk;
            <?php elseif (has_permission('dosen')): ?>
            var url = "<?php echo base_url('mbkm/monitoring/filter-dsn-prodi'); ?>" + "/" +
                th_masuk;
            <?php endif;?>
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
                    var url_detail =
                        '<?=base_url('mbkm/monitoring/detail-msib');?>' +
                        '/' + item.id_mbkm_fix;
                    $('#dataTable-1 tbody')
                    <?php if (has_permission('admin') || has_permission('koor-mbkm')): ?>
                        .append('<tr><td>' + (i++ + 1) +
                            '</td><td>' + item.nm_mhs + '</td><td>' + item.nm_staf +
                            '</td><td>' + item.nm_mitra +
                            '</td><td>' +
                            '<a class="btn btn-outline-primary" type="button" href="' +
                            url_detail +
                            '">Monitoring</a>' +
                            '</td></tr>');
                    <?php elseif (has_permission('dosen')): ?>
                        .append('<tr><td>' + (i++ + 1) +
                            '</td><td>' + item.nm_mhs +
                            '</td><td>' + item.nm_mitra +
                            '</td><td>' +
                            '<a class="btn btn-outline-primary" type="button" href="' +
                            url_detail +
                            '">Monitoring</a>' +
                            '</td></tr>');
                    <?php endif;?>
                });

                $('#dataTable-1').DataTable({
                    columnDefs: [{
                        <?php if(has_permission('admin') || has_permission('koor-mbkm')): ?>
                        targets: [0, 1, 2, 3, 4],
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
                url: '<?php echo base_url('mbkm/monitoring/mbkm-prodi'); ?>',
                method: "GET",
                dataType: 'json',
                success: function(data) {
                    // Tampilkan data ke dalam tabel
                    $('#dataTable-1').DataTable().clear().destroy();
                    // tambahkan baris kode berikut untuk menambahkan data ke dalam tabel
                    $.each(data, function(i, item) {
                        '<?=base_url('mbkm/monitoring/detail-mbkm-prodi');?>' +
                        '/' + item.id_mbkm_fix;
                        $('#dataTable-1 tbody')
                        <?php if (has_permission('admin') || has_permission('koor-mbkm')): ?>
                            .append('<tr><td>' + (i++ + 1) +
                                '</td><td>' + item.nm_mhs + '</td><td>' +
                                item.nm_staf +
                                '</td><td>' + item.nm_mitra +
                                '</td><td>' +
                                '<a class="btn btn-outline-primary" type="button" href="' +
                                url_detail +
                                '">Monitoring</a>' +
                                '</td></tr>');
                        <?php elseif (has_permission('dosen')): ?>
                            .append('<tr><td>' + (i++ + 1) +
                                '</td><td>' + item.nm_mhs +
                                '</td><td>' + item.nm_mitra +
                                '</td><td>' +
                                '<a class="btn btn-outline-primary" type="button" href="' +
                                url_detail +
                                '">Monitoring</a>' +
                                '</td></tr>');
                        <?php endif;?>
                    });
                    $('#dataTable-1').DataTable({
                        columnDefs: [{
                            targets: [0, 1, 2, 3, 4],
                            orderable: true,
                        }],
                    });
                },
            });
        });
    });
});
</script>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer'); ?>