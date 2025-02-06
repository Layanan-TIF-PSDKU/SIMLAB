<?= $this->include('kmm/kmm_partial/dashboard/header'); ?>
<?= $this->include('kmm/kmm_partial/dashboard/top_menu'); ?>
<?= $this->include('kmm/kmm_partial/dashboard/side_menu'); ?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-8">
                        <?php if(has_permission('dosen')): ?>
                        <h2 class="mt-2 page-title">Halaman Pengelolaan Pengajuan Proposal KMM</h2>
                        <?php elseif(has_permission('mahasiswa')): ?>
                        <h2 class="mt-2 page-title">Halaman Pengajuan Proposal KMM</h2>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('kmm') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">KMM</a></li>
                            <?php if(has_permission('dosen')): ?>
                            <li class="breadcrumb-item active">Proposal KMM</li>
                            <?php elseif(has_permission('mahasiswa')): ?>
                            <li class="breadcrumb-item active">Pengajuan Proposal KMM</li>
                            <?php endif; ?>
                        </ol>
                    </div>
                </div>
                <div class="row my-3">
                    <?php if(has_permission('admin') || has_permission('dosen')): ?>
                    <div class="col-md-12">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title">Pencarian Data Mahasiswa</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class=" form-group mb-3">
                                            <label>Tahun Angkatan</label>
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
                                if(has_permission('mahasiswa')): 
                                    if($proposal == null){
                                        echo '<a href="'. base_url('kmm/proposal/pengajuan') .'"class="btn btn-primary mb-3">Tambah</a>';
                                    } else {
                                        if($status == 'tidak disetujui'){
                                            if($kmm == null){
                                                echo '<a href="' . base_url('kmm/proposal/pengajuan') .'" class="btn btn-primary mb-3">Tambah</a>';
                                            }
                                        } elseif($status == 'disetujui') {
                                            if($statuskmm == 'tidak lolos'){
                                                echo '<a href="'. base_url('kmm/proposal/pengajuan') .'"class="btn btn-primary mb-3">Tambah</a>';
                                            }
                                        }
                                    }
                                    ?>
                                <?php endif; ?>

                                <!-- table -->
                                <table class="table datatables" id="dataTable-1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <?php if(has_permission('dosen')) : ?>
                                            <th>Nama Mahasiswa</th>
                                            <th>Angkatan</th>
                                            <?php else: ?>
                                            <th>Dosen Pembimbing</th>
                                            <?php endif; ?>
                                            <th>Instansi</th>
                                            <th>Proposal KMM</th>
                                            <th>Status Verifikasi</th>
                                            <th>Catatan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if(has_permission('mahasiswa')) :
                                            $no = 1;
                                            foreach ($proposal as $p) {
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $p->nm_staf ?></td>
                                            <td><?= $p->nama_instansi ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-outline-primary"
                                                    href="<?= base_url('kmm/proposal/download/' . $p->id_proposal) ?>">Download</a>
                                            </td>
                                            <td>
                                                <?php if($p->status_proposal == 'pending'){ ?>
                                                <span class="badge badge-primary"><?= $p->status_proposal ?></span>
                                                <?php } else if ($p->status_proposal == 'disetujui') { ?>
                                                <span class="badge badge-success"><?= $p->status_proposal ?></span>
                                                <?php } else if ($p->status_proposal == 'revisi') { ?>
                                                <span class="badge badge-warning"><?= $p->status_proposal ?></span>
                                                <?php } else { ?>
                                                <span class="badge badge-danger"><?= $p->status_proposal ?></span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ($p->catatan == null) {
                                                        echo '<span class="badge badge-primary">Belum Ada Catatan</span>';
                                                    } else {
                                                        if ($p->status_proposal == 'disetujui') {
                                                            echo '<span class="badge badge-success">'.$p->catatan.'</span>';
                                                        } else {
                                                            echo $p->catatan;
                                                        }
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php if($p->status_proposal == 'revisi'): ?>
                                                <a class="btn btn-sm btn-outline-warning" data-toggle="modal"
                                                    href="#uploadProposal<?= $p->id_proposal ?>">Edit</a>
                                                <?php else: ?>
                                                <form method="POST"
                                                    action="<?= base_url('kmm/proposal/hapus/' . $p->id_proposal); ?>">
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger remove-item-btn"
                                                        data-toggle="tooltip" title='Delete'><i
                                                            class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                        Delete</button>
                                                </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="uploadProposal<?= $p->id_proposal ?>" tabindex="-1"
                                            role="dialog" aria-labelledby="varyModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="varyModalLabel">Upload Proposal KMM
                                                            <span class="text-danger">*</span>
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="<?= base_url('kmm/proposal/update/' . $p->id_proposal) ?>"
                                                            enctype="multipart/form-data">
                                                            <div class="form-group">
                                                                <input type="file" name="proposal_awal"
                                                                    class="form-control" required>
                                                                <div class="text-danger">
                                                                    * File berupa pdf (Max. 5Mb)
                                                                </div>
                                                            </div>
                                                            <button type="submit"
                                                                class="btn mb-2 btn-primary">Simpan</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php } else: 
                                            $no = 1;
                                            foreach ($proposal2 as $prop) {
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $prop->nm_mhs ?></td>
                                            <td><?= $prop->th_masuk ?></td>
                                            <td><?= $prop->nama_instansi ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-outline-primary"
                                                    href="<?= base_url('kmm/proposal/download/' . $prop->id_proposal) ?>">Download</a>
                                            </td>
                                            <td>
                                                <?php if($prop->status_proposal == 'pending'){ ?>
                                                <span class="badge badge-primary"><?= $prop->status_proposal ?></span>
                                                <?php } else if ($prop->status_proposal == 'disetujui') { ?>
                                                <span class="badge badge-success"><?= $prop->status_proposal ?></span>
                                                <?php } else if ($prop->status_proposal == 'revisi') { ?>
                                                <span class="badge badge-warning"><?= $prop->status_proposal ?></span>
                                                <?php } else { ?>
                                                <span class="badge badge-danger"><?= $prop->status_proposal ?></span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php 
                                                if ($prop->catatan == null) {
                                                    echo '<span class="badge badge-primary">Belum Ada Catatan</span>';
                                                } else {
                                                    if ($prop->status_proposal == 'disetujui') {
                                                        echo '<span class="badge badge-success">'.$prop->catatan.'</span>';
                                                    } else {
                                                        echo $prop->catatan;
                                                    }
                                                }
                                            ?>
                                            <td>
                                                <?php if($prop->status_proposal == 'disetujui' || $prop->status_proposal =='tidak disetujui'){ ?>
                                                <form method="POST"
                                                    action="<?= base_url('kmm/proposal/hapus/' . $prop->id_proposal); ?>">
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger remove-item-btn"
                                                        data-toggle="tooltip" title='Delete'><i
                                                            class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                        Delete</button>
                                                </form>
                                                <?php } else { ?>
                                                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted sr-only">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        href="<?= base_url('kmm/proposal/verifikasi-setuju/' . $prop->id_proposal) ?>">
                                                        <span class="fe fe-check fe-16 align-middle"></span> Disetujui
                                                    </a>
                                                    <a class="dropdown-item" data-toggle="modal"
                                                        href=<?= "#verifProp" . $prop->id_proposal ?>>
                                                        <span class="fe fe-refresh-cw fe-16 align-middle"></span> Revisi
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="<?= base_url('kmm/proposal/verifikasi-gagal/' . $prop->id_proposal) ?>">
                                                        <span class="fe fe-x fe-16 align-middle"></span> Tidak Disetujui
                                                    </a>
                                                </div>
                                                <?php } ?>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id=<?= "verifProp" . $prop->id_proposal ?> tabindex="-1"
                                            role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="verticalModalTitle">Catatan <span
                                                                class="text-danger">*</span></h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form
                                                            action="<?= base_url('kmm/proposal/verifikasi-revisi/' . $prop->id_proposal) ?>"
                                                            method="post">
                                                            <input type="hidden" name="id_proposal"
                                                                value="<?= $prop->id_proposal ?>">
                                                            <div class="form-group">
                                                                <textarea name="catatan" class="form-control" rows="4"
                                                                    required></textarea>
                                                            </div>
                                                            <button type="submit"
                                                                class="btn btn-primary">Simpan</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } endif;?>
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
            <?php if(has_permission('dosen')): ?>
            var url = "<?php echo base_url('kmm/proposal/getFilterProposalByIdDosen'); ?>" + "/" +
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
                    var url_download = "<?= base_url('kmm/proposal/download/') ?>" +
                        "/" + item.id_proposal;
                    var url_delete = "<?= base_url('kmm/proposal/hapus'); ?>" +
                        "/" + item.id_proposal;
                    var url_setuju =
                        "<?= base_url('kmm/proposal/verifikasi-setuju'); ?>" + "/" +
                        item.id_proposal;
                    var url_revisi = "#verifProp" + item.id_proposal;
                    var url_tidak_setuju =
                        "<?= base_url('kmm/proposal/verifikasi-gagal'); ?>" + "/" +
                        item.id_proposal;

                    $('#dataTable-1 tbody')
                    <?php if(has_permission('dosen')): ?>
                        .append('<tr><td>' + ((i++) + 1) + '</td><td>' + item
                            .nm_mhs + '</td><td>' + item.th_masuk + '</td><td>' +
                            item
                            .nama_instansi + '</td><td>' +
                            '<a class="btn btn-sm btn-outline-primary" href="' +
                            url_download + '">Download</a>' +
                            '</td><td>' + ((item.status_proposal == 'pending') ?
                                '<span class="badge badge-primary">' + item
                                .status_proposal + '</span>' : ((item
                                        .status_proposal == 'disetujui') ?
                                    '<span class="badge badge-success">' + item
                                    .status_proposal + '</span>' : (item
                                        .status_proposal == 'revisi' ?
                                        '<span class="badge badge-warning">' + item
                                        .status_proposal + '</span>' :
                                        '<span class="badge badge-danger">' + item
                                        .status_proposal + '</span>'))) +
                            '</td><td>' + ((item.catatan == null) ?
                                '<span class="badge badge-primary">Belum Ada Catatan</span>' :
                                (((item.status_proposal == 'disetujui') ?
                                    '<span class="badge badge-success">' + item
                                    .catatan + '</span>' : item.catatan))) +
                            '</td><td>' + ((item.status_proposal ==
                                    'disetujui' || item.status_proposal ==
                                    'tidak disetujui') ?
                                '<form method="POST" action="' +
                                url_delete +
                                '"><input name="_method" type="hidden" value="DELETE"><button type="submit" class="btn btn-sm btn-outline-danger remove-item-btn" data-toggle="tooltip" title="Delete"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete</button></form>' :
                                '<button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="' +
                                url_setuju +
                                '"><span class="fe fe-check fe-16 align-middle"></span> Disetujui</a><a class="dropdown-item" data-toggle="modal" href="' +
                                url_revisi +
                                '"><span class="fe fe-refresh-cw fe-16 align-middle"></span> Revisi</a><a class="dropdown-item" href="' +
                                url_tidak_setuju +
                                '"><span class="fe fe-x fe-16 align-middle"></span> Tidak Disetujui</a></div>'
                            ) + '</td></tr>'
                        );
                    <?php endif; ?>
                });
                $('#dataTable-1').DataTable({
                    columnDefs: [{
                        targets: [0, 1, 2, 3, 4, 5, 6, 7],
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
                url: '<?php echo base_url('kmm/proposal');?>',
                method: "GET",
                dataType: 'json',
                success: function(data) {
                    // Tampilkan data ke dalam tabel
                    $('#dataTable-1').DataTable().clear().destroy();
                    // tambahkan baris kode berikut untuk menambahkan data ke dalam tabel
                    $.each(data, function(i, item) {
                        $('#dataTable-1 tbody')
                        <?php if(has_permission('dosen')): ?>
                            .append('<tr><td>' + ((i++) + 1) + '</td><td>' +
                                item
                                .nm_mhs + '</td><td>' + item.th_masuk +
                                '</td><td>' +
                                item
                                .nama_instansi + '</td><td>' +
                                '<a class="btn btn-sm btn-outline-primary" href="' +
                                url_download + '">Download</a>' +
                                '</td><td>' + ((item.status_proposal ==
                                        'pending') ?
                                    '<span class="badge badge-primary">' +
                                    item
                                    .status_proposal + '</span>' : ((item
                                            .status_proposal == 'disetujui'
                                            ) ?
                                        '<span class="badge badge-success">' +
                                        item
                                        .status_proposal + '</span>' : (item
                                            .status_proposal == 'revisi' ?
                                            '<span class="badge badge-warning">' +
                                            item
                                            .status_proposal + '</span>' :
                                            '<span class="badge badge-danger">' +
                                            item
                                            .status_proposal + '</span>'))
                                    ) +
                                '</td><td>' + ((item.catatan == null) ?
                                    '<span class="badge badge-primary">Belum Ada Catatan</span>' :
                                    (((item.status_proposal ==
                                        'disetujui') ?
                                        '<span class="badge badge-success">' +
                                        item
                                        .catatan + '</span>' : item
                                        .catatan))) +
                                '</td><td>' + ((item.status_proposal ==
                                        'disetujui' || item
                                        .status_proposal ==
                                        'tidak disetujui') ?
                                    '<form method="POST" action="' +
                                    url_delete +
                                    '"><input name="_method" type="hidden" value="DELETE"><button type="submit" class="btn btn-sm btn-outline-danger remove-item-btn" data-toggle="tooltip" title="Delete"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete</button></form>' :
                                    '<button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text-muted sr-only">Action</span></button><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="' +
                                    url_setuju +
                                    '"><span class="fe fe-check fe-16 align-middle"></span> Disetujui</a><a class="dropdown-item" data-toggle="modal" href="' +
                                    url_revisi +
                                    '"><span class="fe fe-refresh-cw fe-16 align-middle"></span> Revisi</a><a class="dropdown-item" href="' +
                                    url_tidak_setuju +
                                    '"><span class="fe fe-x fe-16 align-middle"></span> Tidak Disetujui</a></div>'
                                ) + '</td></tr>'
                            );
                        <?php endif; ?>
                    });
                    $('#dataTable-1').DataTable({
                        columnDefs: [{
                            targets: [0, 1, 2, 3, 4, 5, 6, 7],
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