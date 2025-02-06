<?php echo $this->include('mbkm/mbkm_partial/dashboard/header'); ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/top_menu'); ?>
<?php if (has_permission('admin')): ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else: ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/side_menu') ?>
<?php endif;?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Kegiatan MBKM Aktif</h2>
                        <p class="card-text">
                            Kegiatan MBKM yang sedang dilaksanakan. Pastikan untuk update mitra atau instansi terkait!
                        </p>
                    </div>

                    <?php if(has_permission('admin')) : ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a
                                    href="<?= base_url('admin/dashboard') ?>"><small>Dashboard</small></a>
                            </li>
                            <li class="breadcrumb-item active"><small>MBKM Aktif</small></li>
                        </ol>
                    </div>
                    <?php elseif(has_permission('dosen') || has_permission('mahasiswa')) : ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a href="<?= base_url('mbkm') ?>"><small>Dashboard</small></a>
                            </li>
                            <li class="breadcrumb-item active"><small>MBKM Aktif</small></li>
                        </ol>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="row my-3">
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
                    <?php endif; ?>
                    <!-- table -->
                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <div class="table-responsive">
                                    <table class="table datatables" id="dataTable-1">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <?php if(has_permission('admin') || has_permission('koor-mbkm') ) : ?>
                                                <th>Nama Mahasiswa</th>
                                                <th>Dosen Pembimbing</th>
                                                <th>Nama Instansi</th>
                                                <th>Action</th>
                                                <?php elseif (has_permission('dosen') ) : ?>
                                                <th>Nama Mahasiswa</th>
                                                <th>Nama Instansi</th>
                                                <th>Action</th>
                                                <?php elseif (has_permission('mahasiswa') ) : ?>
                                                <th>Dosen Pembimbing</th>
                                                <th>Nama Instansi</th>
                                                <th>Bukti/LoA</th>
                                                <th>Laporan Akhir</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(has_permission('admin') || has_permission('koor-mbkm')) : $no = 1; foreach($mbkmFix as $a): ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td>
                                                    <?php foreach($mahasiswa as $mhs) {
                                                    echo ($a->id_mhs == $mhs->id_mhs) ? $mhs->nama : ''; } ?>
                                                </td>
                                                <td>
                                                    <?php foreach($staf as $s) {
                                                    echo ($a->id_staf == $s->id_staf) ? $s->nama : ''; } ?>
                                                </td>
                                                <td>
                                                    <?php if ($a->id_mitra == ''): ?>
                                                    <span class="badge badge-danger">Belum update</span>
                                                    <?php else: ?>
                                                    <?php foreach($mitra as $mtr) {
                                                    echo ($a->id_mitra == $mtr->id_mitra) ? $mtr->nama_instansi : '';} ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("mbkm/mbkmFix/detail/$a->id_mbkm_fix");?>">Detail</a>
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("mbkm/mbkmFix/edit/$a->id_mbkm_fix");?>">Edit
                                                            Pendaftaran</a>
                                                        <?php if(has_permission('admin')) : ?>
                                                        <form method="POST"
                                                            action="<?=base_url("mbkm/mbkmFix/hapus/$a->id_mbkm_fix");?>">
                                                            <input name="_method" type="hidden" value="DELETE">
                                                            <button type="submit" class="dropdown-item remove-item-btn"
                                                                data-toggle="tooltip" title='Delete'><i
                                                                    class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                Delete</button>
                                                        </form>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <?php elseif(has_permission('dosen')) : $no = 1; foreach ($mbkmFix5 as $k): ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $k->nm_mhs; ?></td>
                                                <td>
                                                    <?php if ($k->id_mitra == ''): ?>
                                                    <span type="button" class="badge badge-danger">Belum Update</span>
                                                    <?php else: ?>
                                                    <?php foreach($mitra as $mtr) {
                                                    echo ($k->id_mitra == $mtr->id_mitra) ? $mtr->nama_instansi : '';} ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("mbkm/mbkmFix/detail/$k->id_mbkm_fix");?>">Detail</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <?php elseif(has_permission('mahasiswa')):  $no = 1; foreach ($mbkmFix2 as $k):?>
                                            <tr>
                                                <?php if($k->id_mitra == ''):?>
                                                <td><?= $no++; ?></td>
                                                <td><?= $k->nm_staf ?></td>
                                                <td>
                                                    <?php if ($k->id_mitra == ''): ?>
                                                    <a href="#" class="btn btn-sm btn-outline-primary"
                                                        data-toggle="modal" data-target="#update-mitra1"><i
                                                            class="fe fe-file fe-16"></i>&nbspUpdate
                                                        Mitra</a>
                                                    <?php else: ?>
                                                    <?php foreach($mitra as $mtr) {
                                                    echo ($k->id_mitra == $mtr->id_mitra) ? $mtr->nama_instansi : '';} ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($k->id_mitra == ''): ?>
                                                    <span class="badge badge-danger">belum update mitra</span>
                                                    <?php else: ?>
                                                    <a class="mx-1 my-1 btn btn-sm btn-outline-primary"
                                                        href="<?=base_url("mbkm/mbkmProdi/download-LoA/$k->id_mbkm_fix");?>">
                                                        <span class="fe fe-download-cloud fe-16 align-middle"></span>
                                                    </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($k->lap_akhir == ''): ?>
                                                    <span class="badge badge-danger">belum update mitra</span>
                                                    <?php else: ?>
                                                    <a class="mx-1 my-1 btn btn-sm btn-outline-primary"
                                                        href="<?=base_url("mbkm/mbkmProdi/download-LoA/$k->id_mbkm_fix");?>">
                                                        <span class="fe fe-download-cloud fe-16 align-middle"></span>
                                                    </a>
                                                    <?php endif; ?>
                                                </td>
                                                <!-- Modal -->
                                                <div class="modal fade" id="update-mitra1" tabindex="-1" role="dialog"
                                                    aria-labelledby="verticalModalTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="verticalModalTitle">
                                                                    Update Mitra/Instansi</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST"
                                                                    action="<?=base_url('mbkm/mbkmFix/update-mitra/'. $k->id_mbkm_fix);?>"
                                                                    enctype=" multipart/form-data">
                                                                    <input class="form-control" type="hidden"
                                                                        class="form-control" name="id_mbkm_fix"
                                                                        value="<?= $k->id_mbkm_fix ?>">
                                                                    <div class="form-group mb-3">
                                                                        <label for="simple-select2">Nama
                                                                            Instansi</label>
                                                                        <select class="form-control select2"
                                                                            name="id_mitra" id="simple-select2">
                                                                            <option value="">Daftar
                                                                                Instansi</option>
                                                                            <?php foreach ($mitra as $m): ?>
                                                                            <option value="<?=$m->id_mitra?>">
                                                                                <?=$m->nama_instansi?>
                                                                            </option>
                                                                            <?php endforeach;?>
                                                                        </select>
                                                                        <!-- Error Validation -->
                                                                        <?php if ($validation->getError('id_mitra')) {?>
                                                                        <div class='alert alert-danger mt-2'>
                                                                            <?=$error = $validation->getError('id_mitra');?>
                                                                        </div>
                                                                        <?php }?>
                                                                    </div>
                                                                    <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
                                                                    <div class="modal-footer">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Save
                                                                            changes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </tr>
                                            <?php else:  ?> <?php foreach ($mbkmFix4 as $k2): ?> <td>
                                                <?= $no++; ?>
                                            </td>
                                            <td><?= $k2->nm_staf ?></td>
                                            <td><?= $k2->nama_instansi ?></td>
                                            <td>
                                                <?php if ($k2->bukti == ''): ?>
                                                <a href="#" class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                                    data-target="#upload2"><i class="fe fe-file fe-16"></i>&nbspUpload
                                                    Bukti</a>
                                                <?php else: ?>
                                                <a class="mx-1 my-1 btn btn-sm btn-outline-primary"
                                                    href="<?=base_url('mbkm/mbkmFix/download-bukti/' . $k2->id_mbkm_fix)?>">
                                                    <span class="fe fe-download-cloud fe-16 align-middle"></span>
                                                </a>
                                                <?php endif; ?>
                                            </td>
                                            <?php if ($k2->bukti == ''): ?>
                                            <td>
                                                <span class="badge badge-danger">belum upload bukti</span>
                                            </td>
                                            <?php else: ?>
                                            <td>
                                                <?php if ($k2->lap_akhir == ''): ?>
                                                <a href="#" class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                                    data-target="#upload1"><i class="fe fe-file fe-16"></i>&nbspUpload
                                                    Laporan Akhir</a>
                                                <?php else: ?>
                                                <a class="mx-1 my-1 btn btn-sm btn-outline-primary"
                                                    href="<?=base_url('mbkm/mbkmFix/download-lap-akhir/' . $k2->id_mbkm_fix)?>">
                                                    <span class="fe fe-download-cloud fe-16 align-middle"></span>
                                                </a>
                                                <?php endif; ?>
                                            </td>
                                            <?php endif; ?>

                                            <!-- Modal -->
                                            <div class="modal fade" id="upload1" tabindex="-1" role="dialog"
                                                aria-labelledby="verticalModalTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="verticalModalTitle">Upload
                                                                Laporan Akhir</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST"
                                                                action="<?=base_url('mbkm/mbkmFix/upload-lap-akhir/'. $k2->id_mbkm_fix);?>"
                                                                enctype="multipart/form-data">
                                                                <input class="form-control" type="hidden"
                                                                    class="form-control" name="id_mbkm_fix"
                                                                    value="<?= $k2->id_mbkm_fix ?>">
                                                                <div class="form-group">
                                                                    <input type="file" name="lap_akhir"
                                                                        class="form-control">
                                                                    <div class="text-danger text-italic">
                                                                        <span class="text-danger">*</span>
                                                                        File berupa
                                                                        pdf
                                                                        (Max. 5Mb)
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
                                                        <div class="modal-footer">
                                                            <button type="submit"
                                                                class="btn btn-primary">Simpan</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="upload2" tabindex="-1" role="dialog"
                                                aria-labelledby="verticalModalTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="verticalModalTitle">Upload
                                                                Bukti/LoA</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST"
                                                                action="<?=base_url('mbkm/mbkmFix/upload-bukti/'. $k2->id_mbkm_fix);?>"
                                                                enctype="multipart/form-data">
                                                                <input class="form-control" type="hidden"
                                                                    class="form-control" name="id_mbkm_fix"
                                                                    value="<?= $k2->id_mbkm_fix ?>">
                                                                <label for="">Upload Bukti</label>
                                                                <div class="form-group">
                                                                    <input type="file" name="bukti"
                                                                        class="form-control">
                                                                    <div class="text-danger text-italic">
                                                                        <span class="text-danger">*</span>
                                                                        File berupa
                                                                        pdf
                                                                        (Max. 5Mb)
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
                                                        <div class="modal-footer">
                                                            <button type="submit"
                                                                class="btn btn-primary">Simpan</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php else:  ?>
                                            <?php endif; ?>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- simple table -->

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
            var url = "<?php echo base_url('mbkm/mbkmFix/filter-adm'); ?>" +
                "/" +
                th_masuk;
            <?php elseif(has_permission('dosen')): ?>
            var url = "<?php echo base_url('mbkm/mbkmFix/filter-dsn'); ?>" + "/" +
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
                    var url_detail = '<?= base_url('mbkm/mbkmFix/detail'); ?>' +
                        '/' + item.id_mbkm_fix;
                    var url_delete = '<?= base_url('mbkm/mbkmFix/hapus'); ?>' +
                        '/' + item.id_mbkm_fix;
                    var url_edit = '<?= base_url('mbkm/mbkmFix/edit'); ?>' + '/' +
                        item.id_mbkm_fix;
                    var url_bukti =
                        '<?= base_url('mbkm/mbkmFix/download-bukti'); ?>' + '/' +
                        item.id_mbkm_fix;
                    var url_lap =
                        '<?= base_url('mbkm/mbkmFix/download-lap-akhir'); ?>' +
                        '/' +
                        item.id_mbkm_fix;


                    $('#dataTable-1 tbody')
                    <?php if(has_permission('admin')|| has_permission('koor-mbkm')): ?>
                        .append('<tr><td>' + (i++ + 1) +
                            '</td><td>' +
                            item.nm_mhs + '</td><td>' + item.nm_staf +
                            '</td><td>' + ((item.id_mitra === '') ?
                                '<span class="badge badge-warning">Belum Update</span>' :
                                item.nm_mitra
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
                        .append('<tr><td>' + (i++ + 1) +
                            '</td><td>' +
                            item.nm_mhs + '</td><td>' +
                            ((item.nm_mitra === '') ?
                                '<span class="badge badge-warning">Belum Update</span>' :
                                item.nm_mitra
                            ) + '</td><td>' +
                            '<button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="' +
                            url_detail +
                            '">Detail</a></form>' +
                            '</td></tr>');
                    <?php endif; ?>
                });
                $('#dataTable-1').DataTable({
                    columnDefs: [{
                        targets: [0, 1, 2, 3, 4, 5, 6],
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
                url: '<?php echo base_url('mbkm/msib');?>',
                method: "GET",
                dataType: 'json',
                success: function(data) {
                    // Tampilkan data ke dalam tabel
                    $('#dataTable-1').DataTable().clear().destroy();
                    // tambahkan baris kode berikut untuk menambahkan data ke dalam tabel
                    $.each(data, function(i, item) {
                        var url_detail =
                            '<?= base_url('mbkm/msib/detail'); ?>' +
                            '/' + item.id_msib;
                        var url_delete =
                            '<?= base_url('mbkm/msib/hapus'); ?>' +
                            '/' + item.id_msib;
                        var url_edit =
                            '<?= base_url('mbkm/msib/edit'); ?>' +
                            '/' +
                            item.id_msib;
                        var url_unduh_prop =
                            '<?= base_url('mbkm/msib/download-proposal/'); ?>' +
                            '/' + item.id_msib;
                        var url_unduh_lap =
                            '<?= base_url('mbkm/msib/download-proposal/'); ?>' +
                            '/' + item.id_msib;
                        var url_disetujui =
                            "<?= base_url('mbkm/msib/dosen/verifikasi-disetujui'); ?>" +
                            "/" + item.id_msib;
                        var url_tidak_disetujui =
                            "<?= base_url('mbkm/msib/dosen/verifikasi-tidak-disetujui'); ?>" +
                            "/" + item.id_msib;

                        $('#dataTable-1 tbody')
                        <?php if(has_permission('admin')|| has_permission('koor-mbkm')): ?>
                            .append('<tr><td>' + ((i++) + 1) +
                                '</td><td>' +
                                item.nm_mhs + '</td><td>' + item
                                .nm_staf +
                                '</td><td>' + item
                                .nama_instansi +
                                '</td><td>' + ((item.proposal !=
                                        '') ?
                                    '<a class="my-1 mx-1 btn btn-sm btn-outline-success" data-toggle="modal" href="' +
                                    url_unduh_prop +
                                    '"><span class="fe fe-check fe-16 align-middle"></a>' :
                                    '<span class="badge badge-danger">Belum Upload</span>'
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
                            .append('<tr><td>' + ((i++) + 1) +
                                '</td><td>' +
                                item
                                .nm_mhs + '</td><td>' + item
                                .nama_instansi +
                                '</td><td>' + item
                                .status_lolos +
                                '</td></tr>');
                        <?php endif; ?>
                    });
                    $('#dataTable-1').DataTable({
                        columnDefs: [{
                            targets: [0, 1, 2, 3, 4, 5,
                                6
                            ],
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
            var url = "<?= base_url('mbkm/mbkmFix/cetak-excel/');?>" + "/" +
                th_masuk;
            window.open(url);
        }
    });
    $('#cetakPdf').on('click', function(event) {
        event.preventDefault();
        var th_masuk = $('#th_masuk').val();

        if (th_masuk != '') {
            var url = "<?= base_url('mbkm/mbkmFix/cetak-pdf/');?>" + "/" +
                th_masuk;
            window.open(url);
        }
    });
});
</script>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer'); ?>