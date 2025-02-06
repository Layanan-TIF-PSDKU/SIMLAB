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
                        <h2 class="page-title">Halaman Pendaftaran MBKM Prodi</h2>
                        <p class="card-text">
                            MBKM Prodi dengan mitra yang telah berkerja sama dengan prodi
                        </p>
                    </div>

                    <?php if(has_permission('admin')) : ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a
                                    href="<?= base_url('admin/dashboard') ?>"><small>Dashboard</small></a>
                            </li>
                            <li class="breadcrumb-item active"><small>Pendaftaran MBKM Prodi</small></li>
                        </ol>
                    </div>
                    <?php elseif(has_permission('dosen') || has_permission('mahasiswa')) : ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a href="<?= base_url('mbkm') ?>"><small>Dashboard</small></a>
                            </li>
                            <li class="breadcrumb-item active"><small>Pendaftaran MBKM Prodi</small></li>
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
                                                <?php foreach($mhs2 as $akt): ?>
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

                                <a href="<?=base_url('mbkm/mbkmProdi/tambah');?>"
                                    class="btn btn-primary mb-3">Tambah</a>
                                <div class="table-responsive">

                                    <table class="table datatables" id="dataTable-1">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-mbkm') ) : ?>
                                                <th>Nama Mahasiswa</th>
                                                <?php endif; ?>
                                                <?php if(has_permission('admin') || has_permission('mahasiswa') || has_permission('koor-mbkm')) : ?>
                                                <th>Nama Dosen </th>
                                                <?php endif; ?>
                                                <th>Nama Instansi</th>
                                                <th>Persetujuan Dosen</th>
                                                <th>Status Mahasiswa</th>
                                                <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-mbkm'))  : ?>
                                                <th>Verifikasi Dosen</th>
                                                <?php endif; ?>
                                                <?php if(has_permission('admin') || has_permission('koor-mbkm'))  : ?>
                                                <th>Berkas</th>
                                                <?php endif; ?>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (has_permission('admin') || has_permission('koor-mbkm')):
                                            $no = 1;
                                            foreach ($mbkmProdi as $a) :
                                        ?>
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

                                                <td><?=$a->nama_instansi?></td>

                                                <td>
                                                    <?php if ($a->status_dosen == 'pending') {?>
                                                    <span class="badge badge-warning"><?=$a->status_dosen?></span>
                                                    <?php } else if ($a->status_dosen == 'disetujui') {?>
                                                    <span class="badge badge-success"><?=$a->status_dosen?></span>
                                                    <?php } else {?>
                                                    <span class="badge badge-danger"><?=$a->status_dosen?></span>
                                                    <?php }?>
                                                </td>
                                                <td>
                                                    <?php if ($a->status_mahasiswa == 'pending') {?>
                                                    <span class="badge badge-warning"><?=$a->status_mahasiswa?></span>

                                                    <?php } else if ($a->status_mahasiswa == 'diambil') {?>
                                                    <span class="badge badge-success"><?=$a->status_mahasiswa?></span>

                                                    <?php } else if ($a->status_mahasiswa == 'tidak diambil') {?>
                                                    <span class="badge badge-secondary"><?=$a->status_mahasiswa?></span>

                                                    <?php } else if ($a->status_mahasiswa == 'tidak lolos') {?>
                                                    <span class="badge badge-danger"><?=$a->status_mahasiswa?></span>

                                                    <?php } else {?>
                                                    <span class="badge badge-primary"><?=$a->status_mahasiswa?></span>
                                                    <?php }?>
                                                </td>

                                                <td>
                                                    <?php if ($a->status_dosen == 'pending'): ?>
                                                    <a class="mx-1 my-1 btn btn-sm btn-outline-success"
                                                        href="<?=base_url('mbkm/mbkmProdi/dosen/verifikasi-setujui/' . $a->id_mprodi)?>">
                                                        <span class="fe fe-check fe-16 align-middle"></span>
                                                    </a>
                                                    <a class="mx-1 my-1 btn btn-sm btn-outline-danger"
                                                        href="<?=base_url('mbkm/mbkmProdi/dosen/verifikasi-tidak-disetujui/' . $a->id_mprodi)?>">
                                                        <span class="fe fe-x fe-16 align-middle"></span>
                                                    </a>
                                                    <?php else: ?>
                                                    <span class="badge badge-success">Sudah diverifikasi</span>
                                                    <?php endif; ?>
                                                </td>

                                                <td>
                                                    <?php if ($a->surat_rekom == ''): ?>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                            href="<?=base_url('mbkm/mbkmProdi/upload-sr/' . $a->id_mprodi)?>">Upload
                                                            SR</a>

                                                    </div>
                                                    <?php else: ?>
                                                    <span class="badge badge-success">Sudah Upload</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <?php if ($a->status_mahasiswa == 'diambil' || $a->status_mahasiswa == 'tidak diambil'): ?>
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("mbkm/mbkmProdi/edit/$a->id_mprodi");?>">Edit
                                                            Pendaftaran</a>
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("mbkm/mbkmProdi/detail/$a->id_mprodi");?>">Detail
                                                        </a>
                                                        <form method="POST"
                                                            action="<?=base_url("mbkm/msib/hapus/$a->id_mprodi");?>">
                                                            <input name="_method" type="hidden" value="DELETE">
                                                            <button type="submit" class="dropdown-item remove-item-btn"
                                                                data-toggle="tooltip" title='Delete'><i
                                                                    class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                Delete</button>
                                                        </form>
                                                        <?php else: ?>
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("mbkm/mbkmProdi/edit-status-mhs/$a->id_mprodi");?>">Edit
                                                            Status Mahasiswa</a>
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("mbkm/mbkmProdi/edit/$a->id_mprodi");?>">Edit
                                                            Pendaftaran</a>
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("mbkm/mbkmProdi/detail/$a->id_mprodi");?>">Detail
                                                        </a>
                                                        <form method="POST"
                                                            action="<?=base_url("mbkm/mbkmProdi/hapus/$a->id_mprodi");?>">
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
                                            <?php elseif (has_permission('dosen')) :
                                            $no = 1;
                                            foreach ($mbkmProdi3 as $k) { ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td>
                                                    <?php foreach($mahasiswa as $mhs) {
                                                    echo ($k->id_mhs == $mhs->id_mhs) ? $mhs->nama : ''; } ?>
                                                </td>
                                                <td><?=$k->nama_instansi?></td>
                                                <td>
                                                    <?php if ($k->status_dosen == 'pending') {?>
                                                    <span class="badge badge-warning"><?=$k->status_dosen?></span>
                                                    <?php } else if ($k->status_dosen == 'disetujui') {?>
                                                    <span class="badge badge-success"><?=$k->status_dosen?></span>
                                                    <?php } else {?>
                                                    <span class="badge badge-danger"><?=$k->status_dosen?></span>
                                                    <?php }?>
                                                </td>
                                                <td>
                                                    <?php if ($k->status_mahasiswa == 'pending') {?>
                                                    <span class="badge badge-warning"><?=$k->status_mahasiswa?></span>

                                                    <?php } else if ($k->status_mahasiswa == 'diambil') {?>
                                                    <span class="badge badge-success"><?=$k->status_mahasiswa?></span>

                                                    <?php } else if ($k->status_mahasiswa == 'tidak diambil') {?>
                                                    <span class="badge badge-secondary"><?=$k->status_mahasiswa?></span>

                                                    <?php } else if ($k->status_mahasiswa == 'tidak lolos') {?>
                                                    <span class="badge badge-danger"><?=$k->status_mahasiswa?></span>

                                                    <?php } else {?>
                                                    <span class="badge badge-primary"><?=$k->status_mahasiswa?></span>
                                                    <?php }?>
                                                </td>
                                                <td>
                                                    <?php if ($k->status_dosen == 'pending'): ?>
                                                    <a class="mx-1 my-1 btn btn-sm btn-outline-success"
                                                        href="<?=base_url('mbkm/mbkmProdi/dosen/verifikasi-setujui/' . $k->id_mprodi)?>">
                                                        <span class="fe fe-check fe-16 align-middle"></span>
                                                    </a>
                                                    <a class="mx-1 my-1 btn btn-sm btn-outline-danger"
                                                        href="<?=base_url('mbkm/mbkmProdi/dosen/verifikasi-tidak-disetujui/' . $k->id_mprodi)?>">
                                                        <span class="fe fe-x fe-16 align-middle"></span>
                                                    </a>
                                                    <?php else: ?>
                                                    <span class="badge badge-success">Sudah diverifikasi</span>
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
                                                            href="<?=base_url("mbkm/mbkmProdi/detail/$k->id_mprodi");?>">Detail
                                                        </a>

                                                    </div>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                            <?php elseif (has_permission('mahasiswa')):
                                            $no = 1;
                                            foreach ($mbkmProdi2 as $a) :
                                            ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td>
                                                    <?php foreach($staf as $s) {
                                                    echo ($a->id_staf == $s->id_staf) ? $s->nama : ''; } ?>
                                                </td>
                                                <td><?= $a->nama_instansi ?></td>

                                                <td>
                                                    <?php if ($a->status_dosen == 'pending') {?>
                                                    <span class="badge badge-warning"><?=$a->status_dosen?></span>
                                                    <?php } else if ($a->status_dosen == 'disetujui') {?>
                                                    <span class="badge badge-success"><?=$a->status_dosen?></span>
                                                    <?php } else {?>
                                                    <span class="badge badge-danger"><?=$a->status_dosen?></span>
                                                    <?php }?>
                                                </td>
                                                <td>
                                                    <?php if ($a->status_mahasiswa == 'pending') {?>
                                                    <span class="badge badge-warning"><?=$a->status_mahasiswa?></span>

                                                    <?php } else if ($a->status_mahasiswa == 'diambil') {?>
                                                    <span class="badge badge-success"><?=$a->status_mahasiswa?></span>

                                                    <?php } else if ($a->status_mahasiswa == 'tidak diambil') {?>
                                                    <span class="badge badge-secondary"><?=$a->status_mahasiswa?></span>

                                                    <?php } else if ($a->status_mahasiswa == 'tidak lolos') {?>
                                                    <span class="badge badge-danger"><?=$a->status_mahasiswa?></span>

                                                    <?php } else {?>
                                                    <span class="badge badge-primary"><?=$a->status_mahasiswa?></span>
                                                    <?php }?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <?php if ($a->status_mahasiswa == 'diambil' || $a->status_mahasiswa == 'tidak diambil'): ?>
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("mbkm/mbkmProdi/detail/$a->id_mprodi");?>">Detail
                                                        </a>
                                                        <?php else: ?>
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("mbkm/mbkmProdi/detail/$a->id_mprodi");?>">Detail
                                                        </a>
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("mbkm/mbkmProdi/edit-status-mhs/$a->id_mprodi");?>">Edit
                                                            Status Mahasiswa</a>
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("mbkm/mbkmProdi/edit/$a->id_mprodi");?>">Edit
                                                            Pendaftaran</a>
                                                        <form method="POST"
                                                            action="<?=base_url("mbkm/mbkmProdi/hapus/$a->id_mprodi");?>">
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
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
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
            var url = "<?php echo base_url('mbkm/mbkmProdi/filter-prodi'); ?>" +
                "/" +
                th_masuk;
            <?php elseif(has_permission('dosen')): ?>
            var url = "<?php echo base_url('mbkm/mbkmProdi/filter-prodi-dsn'); ?>" + "/" +
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
                    var url_detail = '<?= base_url('mbkm/mbkmProdi/detail'); ?>' +
                        '/' + item.id_mprodi;
                    var url_delete = '<?= base_url('mbkm/mbkmProdi/hapus'); ?>' +
                        '/' + item.id_mprodi;
                    var url_edit = '<?= base_url('mbkm/mbkmProdi/edit'); ?>' + '/' +
                        item.id_mprodi;
                    var url_disetujui =
                        "<?= base_url('mbkm/mbkmProdi/dosen/verifikasi-disetujui'); ?>" +
                        "/" + item.id_mprodi;
                    var url_tidak_disetujui =
                        "<?= base_url('mbkm/mbkmProdi/dosen/verifikasi-tidak-disetujui'); ?>" +
                        "/" + item.id_mprodi;
                    var url_sr =
                        "<?= base_url('mbkm/mbkmProdi/upload-sr'); ?>" +
                        "/" + item.id_mprodi;
                    var url_sptjm =
                        "<?= base_url('mbkm/mbkmProdi/upload-sptjm'); ?>" +
                        "/" + item.id_mprodi;
                    var url_editStatusMahasiswa =
                        "<?= base_url('mbkm/mbkmProdi/edit-status-mhs'); ?>" +
                        "/" + item.id_mprodi;

                    $('#dataTable-1 tbody')
                    <?php if(has_permission('admin')|| has_permission('koor-mbkm')): ?>
                        .append('<tr><td>' + (i++ + 1) +
                            '</td><td>' +
                            item.nm_mhs + '</td><td>' + item.nm_staf +
                            '</td><td>' + item.nama_instansi +
                            '</td><td>' +
                            ((item.status_dosen === 'pending') ?
                                '<span class="badge badge-warning">pending</span>' :
                                ((item.status_dosen === 'disetujui') ?
                                    '<span class="badge badge-success">Disetujui</span>' :
                                    '<span class="badge badge-danger">Tidak disetujui</span>'
                                )
                            ) + '</td><td>' +
                            ((item.status_mahasiswa === 'pending') ?
                                '<span class="badge badge-warning">pending</span>' :
                                ((item.status_mahasiswa === 'diambil') ?
                                    '<span class="badge badge-success">diambil</span>' :
                                    ((item.status_mahasiswa === 'tidak diambil') ?
                                        '<span class="badge badge-secondary">tidak diambil</span>' :
                                        ((item.status_mahasiswa === 'lolos') ?
                                            '<span class="badge badge-primary">lolos</span>' :
                                            ((item.status_mahasiswa ===
                                                    'tidak lolos') ?
                                                '<span class="badge badge-primary">tidak lolos</span>' :
                                                '<span class="badge badge-primary">tidak lolos</span>'
                                            )
                                        )
                                    )
                                )

                            ) +
                            '</td><td>' +
                            ((item.status_dosen != 'pending') ?
                                '<span class="badge badge-success">Sudah Diverifikasi</span>' :
                                '<a class="my-1 mx-1 btn btn-sm btn-outline-success" data-toggle="modal" href="' +
                                url_disetujui +
                                '"><span class="fe fe-check fe-16 align-middle"></a><a class="my-1 mx-1 btn btn-sm btn-outline-danger" href="' +
                                url_tidak_disetujui +
                                '"><span class="fe fe-x fe-16 align-middle"></span></a>'
                            ) + '</td><td>' +

                            '<button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="' +
                            url_sr +
                            '">Upload SR</a></form>' +
                            '</td><td>' +

                            ((item.status_mahasiswa === 'diambil') ?
                                '<button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="' +
                                url_detail +
                                '">Detail</a><a class="dropdown-item" href="' +
                                url_edit +
                                '">Edit</a><form method="POST" action="' +
                                url_delete +
                                '"><input name="_method" type="hidden" value="DELETE"><button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title="Delete"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete</button></form>' :
                                ((item.status_mahasiswa === 'tidak diambil') ?
                                    '<button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="' +
                                    url_detail +
                                    '">Detail</a><a class="dropdown-item" href="' +
                                    url_edit +
                                    '">Edit</a><form method="POST" action="' +
                                    url_delete +
                                    '"><input name="_method" type="hidden" value="DELETE"><button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title="Delete"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete</button></form>' :
                                    '<button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="' +
                                    url_detail +
                                    '">Detail</a><a class="dropdown-item" href="' +
                                    url_editStatusMahasiswa +
                                    '">Edit Status Mahasiswa</a><a class="dropdown-item" href="' +
                                    url_edit +
                                    '">Edit</a><form method="POST" action="' +
                                    url_delete +
                                    '"><input name="_method" type="hidden" value="DELETE"><button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title="Delete"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete</button></form>'
                                )
                            ) + '</td></tr>');

                    <?php elseif(has_permission('dosen')): ?>
                        .append('<tr><td>' + (i++ + 1) +
                            '</td><td>' +
                            item.nm_mhs + '</td><td>' + item.nama_instansi +
                            '</td><td>' +
                            ((item.status_dosen === 'pending') ?
                                '<span class="badge badge-warning">pending</span>' :
                                ((item.status_dosen === 'disetujui') ?
                                    '<span class="badge badge-success">Disetujui</span>' :
                                    '<span class="badge badge-danger">Tidak disetujui</span>'
                                )
                            ) + '</td><td>' +
                            ((item.status_mahasiswa === 'pending') ?
                                '<span class="badge badge-warning">pending</span>' :
                                ((item.status_mahasiswa === 'diambil') ?
                                    '<span class="badge badge-success">diambil</span>' :
                                    ((item.status_mahasiswa === 'tidak diambil') ?
                                        '<span class="badge badge-secondary">tidak diambil</span>' :
                                        ((item.status_mahasiswa === 'lolos') ?
                                            '<span class="badge badge-primary">lolos</span>' :
                                            ((item.status_mahasiswa ===
                                                    'tidak lolos') ?
                                                '<span class="badge badge-primary">tidak lolos</span>' :
                                                '<span class="badge badge-primary">tidak lolos</span>'
                                            )
                                        )
                                    )
                                )

                            ) +
                            '</td><td>' +
                            ((item.status_dosen != 'pending') ?
                                '<span class="badge badge-success">Sudah Diverifikasi</span>' :
                                '<a class="my-1 mx-1 btn btn-sm btn-outline-success" data-toggle="modal" href="' +
                                url_disetujui +
                                '"><span class="fe fe-check fe-16 align-middle"></a><a class="my-1 mx-1 btn btn-sm btn-outline-danger" href="' +
                                url_tidak_disetujui +
                                '"><span class="fe fe-x fe-16 align-middle"></span></a>'
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
                            '/' + item.id_mprodi;
                        var url_delete =
                            '<?= base_url('mbkm/msib/hapus'); ?>' +
                            '/' + item.id_mprodi;
                        var url_edit =
                            '<?= base_url('mbkm/msib/edit'); ?>' +
                            '/' +
                            item.id_mprodi;
                        var url_unduh_prop =
                            '<?= base_url('mbkm/msib/download-proposal/'); ?>' +
                            '/' + item.id_mprodi;
                        var url_unduh_lap =
                            '<?= base_url('mbkm/msib/download-proposal/'); ?>' +
                            '/' + item.id_mprodi;
                        var url_disetujui =
                            "<?= base_url('mbkm/msib/dosen/verifikasi-disetujui'); ?>" +
                            "/" + item.id_mprodi;
                        var url_tidak_disetujui =
                            "<?= base_url('mbkm/msib/dosen/verifikasi-tidak-disetujui'); ?>" +
                            "/" + item.id_mprodi;

                        $('#dataTable-1 tbody')
                        <?php if(has_permission('admin') || has_permission('koor-mbkm')): ?>
                            .append('<tr><td>' + ((i++) + 1) +
                                '</td><td>' +
                                item.nm_mhs + '</td><td>' + item
                                .nm_staf +
                                '</td><td>' + item.nama_instansi +
                                '</td><td>' + ((item.proposal != '') ?
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
                                '</td><td>' + item.status_lolos +
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
    });
});
</script>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer'); ?>