<?php echo $this->include('simta/simta_partial/dashboard/header');?>
<?php echo $this->include('simta/simta_partial/dashboard/top_menu');?>
<?php if(has_permission('admin')) : ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else : ?>
<?php echo $this->include('simta/simta_partial/dashboard/side_menu') ?>
<?php endif; ?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-6">
                        <?php
                            if(has_permission('admin') || has_permission('dosen')) {
                                echo '<h2 class="mt-2 page-title">Halaman Pengelolaan Pengajuan Bimbingan Tugas Akhir</h2>';
                            } else {
                                echo '<h2 class="mt-2 page-title">Halaman Pendaftaran Pengajuan Bimbingan Tugas Akhir</h2>';
                            }
                        ?>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">SIMTA</a></li>
                            <li class="breadcrumb-item active">Pengelolaan Pengajuan Bimbingan Tugas Akhir</li>
                        </ol>
                    </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">SIMTA</a></li>
                            <li class="breadcrumb-item active">Pengajuan Bimbingan Tugas Akhir</li>
                        </ol>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="row my-3">
                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <table class="table datatables" id="dataTable-1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')) : ?>
                                                <th>Nama Mahasiswa</th>
                                            <?php endif; ?>
                                            <?php if(has_permission('admin') || has_permission('mahasiswa') || has_permission('koor-simta')) : ?>
                                                <th>Nama Dosen Pembimbng</th>
                                            <?php endif; ?>
                                            <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                                                <th>NIM</th>
                                            <?php endif; ?>
                                            <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                                                <th>Kelas</th>
                                            <?php endif; ?>
                                            <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                                                <th>Angkatan</th>
                                            <?php endif; ?>
                                            <th>Status Pengajuan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if (has_permission('admin') || has_permission('koor-simta')):
                                            $no = 1;
                                            foreach ($pengajuanbimbingan as $pg1) :
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td>
                                                <?php foreach($mahasiswa as $mhs) {
                                                    echo ($pg1->id_mhs == $mhs->id_mhs) ? $mhs->nama : ''; } ?>
                                            </td>
                                            <td>
                                                <?php foreach($staf as $s) {
                                                    echo ($pg1->id_staf == $s->id_staf) ? $s->nama : ''; } ?>
                                            </td>
                                            <td>
                                                <?php foreach($mahasiswa as $mhs) {
                                                    echo ($pg1->id_mhs == $mhs->id_mhs) ? $mhs->nim : ''; } ?>
                                            </td>
                                            <td>
                                                <?php foreach($mahasiswa as $mhs) {
                                                    echo ($pg1->id_mhs == $mhs->id_mhs) ? $mhs->kelas : ''; } ?>
                                            </td>
                                            <td>
                                                <?php foreach($mahasiswa as $mhs) {
                                                    echo ($pg1->id_mhs == $mhs->id_mhs) ? $mhs->th_masuk : ''; } ?>
                                            </td>
                                            <td>
                                                <?php if ($pg1->status_ajuan == 'pending'): ?>
                                                    <span class="badge badge-warning">PENDING</span>
                                                    <?php else: ?>
                                                    <?php if ($pg1->status_ajuan == 'diterima') {?>
                                                    <span class="badge badge-success"><?=$pg1->status_ajuan?></span>
                                                    <?php } else {?>
                                                    <?php } if ($pg1->status_ajuan == 'ditolak') {?>
                                                    <span class="badge badge-danger"><?=$pg1->status_ajuan?></span>
                                                    <?php }?>
                                                    <?php endif; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm dropdown-toggle more-horizontal"
                                                type="button" data-toggle="dropdown" aria-haspopsh="true"
                                                aria-expanded="false">
                                                <span class="text-muted sr-only">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                    href="<?=base_url("simta/pengajuanbimbingan/detail/$pg1->id_bimbingan");?>">Detail</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; elseif (has_permission('mahasiswa')):
                                        $no = 1;
                                        foreach ($pengajuanbimbingan2 as $pg2) :
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td>
                                                <?php foreach($staf as $s) {
                                                    echo ($pg2->id_staf == $s->id_staf) ? $s->nama : ''; 
                                                } ?>
                                            </td>
                                            <td>
                                                <?php if ($pg2->status_ajuan == 'pending'): ?>
                                                    <span class="badge badge-warning">PENDING</span>
                                                <?php else: ?>
                                                <?php if ($pg2->status_ajuan == 'diterima') {?>
                                                    <span class="badge badge-success"><?=$pg2->status_ajuan?></span>
                                                <?php } else {?>
                                                <?php } if ($pg2->status_ajuan == 'ditolak') {?>
                                                    <span class="badge badge-danger"><?=$pg2->status_ajuan?></span>
                                                <?php }?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm dropdown-toggle more-horizontal"
                                                type="button" data-toggle="dropdown" aria-haspopsh="true"
                                                aria-expanded="false">
                                                <span class="text-muted sr-only">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" 
                                                    href="<?=base_url("simta/pengajuanbimbingan/edit/$pg2->id_bimbingan");?>">
                                                    Hasil</a>
                                                    <a class="dropdown-item"
                                                    href="<?=base_url("simta/pengajuanbimbingan/detail/$pg2->id_bimbingan");?>">Detail</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; elseif (has_permission('dosen')):
                                        $no = 1;
                                        foreach ($pengajuanbimbingan3 as $pg3) :
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td>
                                                <?php foreach($mahasiswa as $mhs) {
                                                    echo ($pg3->id_mhs == $mhs->id_mhs) ? $mhs->nama : ''; 
                                                } ?>
                                            </td>
                                            <td>
                                                <?php foreach($mahasiswa as $mhs) {
                                                    echo ($pg3->id_mhs == $mhs->id_mhs) ? $mhs->nim : ''; 
                                                } ?>
                                            </td>
                                            <td>
                                                <?php foreach($mahasiswa as $mhs) {
                                                    echo ($pg3->id_mhs == $mhs->id_mhs) ? $mhs->kelas : ''; 
                                                } ?>
                                            </td>
                                            <td>
                                                <?php foreach($mahasiswa as $mhs) {
                                                    echo ($pg3->id_mhs == $mhs->id_mhs) ? $mhs->th_masuk : ''; 
                                                } ?>
                                            </td>
                                            <td>
                                                <?php if ($pg3->status_ajuan == 'pending'): ?>
                                                    <span class="badge badge-warning">PENDING</span>
                                                <?php else: ?>
                                                <?php if ($pg3->status_ajuan == 'diterima') {?>
                                                    <span class="badge badge-success"><?=$pg3->status_ajuan?></span>
                                                <?php } else {?>
                                                <?php } if ($pg3->status_ajuan == 'ditolak') {?>
                                                    <span class="badge badge-danger"><?=$pg3->status_ajuan?></span>
                                                <?php }?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" 
                                                aria-haspopsh="true" aria-expanded="false">
                                                <span class="text-muted sr-only">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                    href="<?=base_url("simta/pengajuanbimbingan/detail/$pg3->id_bimbingan");?>">Detail</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; else :
                                        $no = 1;
                                        foreach ($pengajuanbimbingan4 as $k) {
                                        ?>
                                        <tr>

                                        </tr>
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
            <?php if(has_permission('admin')): ?>
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
                    var url_tidak_lolos =
                        "<?= base_url('kmm/kmm/verifikasi/tidak-lolos'); ?>" + "/" +
                        item.id_kmm;

                    $('#dataTable-1 tbody')
                    <?php if(has_permission('admin')): ?>
                        .append('<tr><td>' + ((i++) + 1) + '</td><td>' + item
                            .nm_mhs +
                            '</td><td>' + item
                            .nm_staf + '</td><td>' + item.nama_instansi +
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
                                '"><span class="fe fe-check fe-16 align-middle"></a><a class="my-1 mx-1 btn btn-sm btn-outline-danger" href="' +
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
                            .nm_mhs + '</td><td>' + item.nama_instansi +
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
                        <?php if(has_permission('admin')): ?>
                        targets: [0, 1, 2, 3, 4, 5, 6],
                        <?php elseif(has_permission('dosen')): ?>
                        targets: [0, 1, 2, 3, 4],
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
                        var url_tidak_lolos =
                            "<?= base_url('kmm/kmm/verifikasi/tidak-lolos'); ?>" +
                            "/" +
                            item.id_kmm;

                        $('#dataTable-1 tbody')
                        <?php if(has_permission('admin')): ?>
                            .append('<tr><td>' + ((i++) + 1) + '</td><td>' +
                                item
                                .nm_mhs +
                                '</td><td>' + item
                                .nm_staf + '</td><td>' + item
                                .nama_instansi +
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
                                '</td><td>' + ((item
                                        .status_lolos != 'pending') ?
                                    '<span class="badge badge-success">Sudah Diverifikasi</span>' :
                                    '<a class="my-1 mx-1 btn btn-sm btn-outline-success" data-toggle="modal" href="' +
                                    url_lolos +
                                    '"><span class="fe fe-check fe-16 align-middle"></a><a class="my-1 mx-1 btn btn-sm btn-outline-danger" href="' +
                                    url_tidak_lolos +
                                    '"><span class="fe fe-x fe-16 align-middle"></span></a>'
                                ) + '</td><td>' +
                                '<button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="' +
                                url_detail +
                                '">Detail</a><a class="dropdown-item" href="' +
                                url_edit +
                                '">Edit</a><form method="POST" action="' +
                                url_delete +
                                '"><input name="_method" type="hidden" value="DELETE"><button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title="Delete"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete</button></form>' +
                                '</td></tr>');
                        <?php elseif(has_permission('dosen')): ?>
                            .append('<tr><td>' + ((i++) + 1) + '</td><td>' +
                                item
                                .nm_mhs + '</td><td>' + item.nama_instansi +
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
                                '</td></tr>');
                        <?php endif; ?>
                    });
                    $('#dataTable-1').DataTable({
                        columnDefs: [{
                            <?php if(has_permission('admin')): ?>
                            targets: [0, 1, 2, 3, 4, 5, 6],
                            <?php elseif(has_permission('dosen')): ?>
                            targets: [0, 1, 2, 3],
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
<?php echo $this->include('simta/simta_partial/dashboard/footer'); ?>