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
                <div class="row align-items-center mb-2">
                    <div class="col mb-4 mt-2">
                        <h2 class="mb-2 page-title">Mahasiswa MBKM MSIB</h2>
                        <!-- Small table -->
                        <div class="card shadow mb-3">
                            <div class="card-header">
                                <strong class="card-title">Filter Data</strong>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="th_masuk"><strong>Tahun Angkatan</strong></label>
                                            <input class="form-control" id="th_masuk" type="date" name="th_masuk">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="id_ruang"><strong>Kelas</strong></label>
                                            <select class="form-control select2" name="id_ruang" id="id_ruang">
                                                <option value="">Pilih Kelas</option>
                                                <option value="D">D</option>
                                                <option value="E">E</option>
                                                </option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3 my-4">

                                            <button id="filter" class="btn btn-primary">Filter</button>
                                            <button id="reset" class="btn btn-danger">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- .row -->
                        <div class="row" id="FilterMonMsib">
                            <?php if (has_permission('admin')): ?>
                            <?php foreach ($MonAdmMsib as $m) : ?>
                            <div class="col-md-4">
                                <div class="card shadow mb-3">
                                    <div class="card-body ">
                                        <div class="avatar avatar-lg mt-6 text-center">
                                            <a href="#!" class="avatar avatar-lg">
                                                <img src="https://firebasestorage.googleapis.com/v0/b/myfin-ktp.appspot.com/o/Avatar%2Fuser.png?alt=media&token=22e6fddc-0378-4045-9d39-9fb6d1db9832"
                                                    alt="..." class="avatar-img rounded-circle">
                                            </a>
                                        </div>
                                        <div class="card-text text-center my-3">
                                            <div class="card-text my-3">
                                                <strong class="card-title my-0"><?= $m->nm_mhs ?></strong>
                                                <p class="nama-dosen mb-0"><strong class="small mb-0">Dosen
                                                        :
                                                    </strong><a><?= $m->nm_staf ?></a> </p>

                                                <p class="small text-muted mb-0">
                                                    <?= $m->nama_instansi ?>
                                                </p>

                                            </div>
                                        </div>
                                        <div class="row align-items-center justify-content-center ">
                                            <?php if ($m->bukti == ''): ?>
                                            <div class="col-auto">
                                                <span class="badge badge-danger">Belum
                                                    upload LoA</span>
                                            </div>
                                            <?php else: ?>

                                            <div class="col-auto">
                                                <a href="<?=base_url("" . $m->id_mbkm_fix )?>" type="button bt-sm"
                                                    class="btn mb-2 btn-outline-primary"><span>
                                                        LoA</span></a>
                                            </div>
                                            <?php endif; ?>
                                            <?php if ($m->lap_akhir == ''): ?>
                                            <div class="col-auto">
                                                <span class="badge badge-danger">Belum
                                                    upload
                                                    LapAkhir</span>
                                            </div>
                                            <?php else: ?>
                                            <div class="col-auto">
                                                <a type="button " class="btn mb-2 btn-outline-primary bt-sm"
                                                    href="<?=base_url("" . $m->id_mbkm_fix )?>"><small>
                                                        <span>Lap Akhir</span></a>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div> <!-- ./card-text -->
                                    <div class="card-footer ">
                                        <div class="row align-items-center justify-content-center ">
                                            <div class="col-auto">
                                                <a
                                                    href="<?= base_url('mbkm/monitoring/detail-msib/' . $m->id_mbkm_fix) ?>">

                                                    <small><span class="bg-success mr-1"></span>
                                                        Monitoring
                                                        Mahasiswa<i class="fe fe-chevron-right ml-4"></i></small>
                                            </div>

                                            </a>
                                        </div>
                                    </div> <!-- /.card-footer -->
                                </div>
                            </div>
                            <?php endforeach ?>


                            <?php elseif(has_permission('dosen')):
                            foreach ($MonDsnMsib as $a) :  ?>
                            <div class="col-md-4">
                                <div class="card shadow mb-3">
                                    <div class="card-body ">
                                        <div class="avatar avatar-lg mt-6 text-center">
                                            <a href="#!" class="avatar avatar-lg">
                                                <img src="https://firebasestorage.googleapis.com/v0/b/myfin-ktp.appspot.com/o/Avatar%2Fuser.png?alt=media&token=22e6fddc-0378-4045-9d39-9fb6d1db9832"
                                                    alt="..." class="avatar-img rounded-circle">
                                            </a>
                                        </div>
                                        <div class="card-text text-center my-3">
                                            <div class="card-text my-3">
                                                <strong class="card-title my-0"><?= $a->nm_mhs ?></strong>
                                                <p class="small text-muted mb-0">
                                                    <?= $a->nama_instansi ?>
                                                </p>

                                            </div>
                                        </div>
                                        <div class="row align-items-center justify-content-center ">
                                            <?php if ($a->bukti == ''): ?>
                                            <div class="col-auto">
                                                <span class="badge badge-danger">Belum
                                                    upload LoA</span>
                                            </div>
                                            <?php else: ?>

                                            <div class="col-auto">
                                                <a href="<?=base_url("" . $a->id_mbkm_fix )?>" type="button bt-sm"
                                                    class="btn mb-2 btn-outline-primary"><span>
                                                        LoA</span></a>
                                            </div>
                                            <?php endif; ?>
                                            <?php if ($a->lap_akhir == ''): ?>
                                            <div class="col-auto">
                                                <span class="badge badge-danger">Belum
                                                    upload
                                                    LapAkhir</span>
                                            </div>
                                            <?php else: ?>
                                            <div class="col-auto">
                                                <a type="button " class="btn mb-2 btn-outline-primary bt-sm"
                                                    href="<?=base_url("" . $a->id_mbkm_fix )?>"><small>
                                                        <span>Lap Akhir</span></a>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div> <!-- ./card-text -->
                                    <div class="card-footer ">
                                        <div class="row align-items-center justify-content-center ">
                                            <div class="col-auto">
                                                <a
                                                    href="<?= base_url('mbkm/monitoring/detail-msib/' . $a->id_mbkm_fix) ?>">

                                                    <small><span class="bg-success mr-1"></span>
                                                        Monitoring
                                                        Mahasiswa<i class="fe fe-chevron-right ml-4"></i></small>
                                            </div>

                                            </a>
                                        </div>
                                    </div> <!-- /.card-footer -->
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif;?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#filter').on('click', function(event) {
            event.preventDefault();
            var th_masuk = $('#th_masuk').val();
            var kelas = $('#kelas').val();
            // var id_ruang = $('#id_ruang').val();
            if (th_masuk == '' || kelas == '') {
                Swal.fire('Error', 'Isi Semua Kolom Untuk Melakukan Filter Data Alat Masuk', 'error');
            }
            // Make Ajax request
            $.ajax({
                url: "<?=base_url('simlab/laporan/filter-alat-masuk');?>",
                type: 'get',
                dataType: 'json',
                data: {
                    th_masuk: th_masuk,
                    kelas: kelas,
                    // id_ruang: id_ruang,
                },
                success: function(data) {
                    // console.log(data)
                    var data_awal = data;
                    $('#FilterMonMsib').DataTable().clear().destroy();
                    $.each(data, function(i, item) {
                        $('#FilterMonMsib tbody').append(
                            '<tr><td style="visibility: hidden;">' + item
                            .th_masuk + '</td><td class="d-none">' + item
                            .kelas + '</td><td>' + item.nama_mata_kuliah +
                            '</td><td>' + item.nama_kategori + '</td><td>' +
                            item.nilai_uas + '</td></tr>');
                    });
                    $('#FilterMonMsib').DataTable({
                        columnDefs: [{
                            targets: [0, 1, 2, 3], // kolom sub bidang
                            orderable: false,
                        }],
                    });
                },
                endRender: null,
                dataSrc: 0
            });
        });
    });
    $(document).ready(function() {
        $('#reset').on('click', function(event) {
            event.preventDefault();
            $("#th_masuk").val(''); // empty value
            $("#kelas").val('');
            $("#id_ruang").val('').trigger('change');
            // Make Ajax request
            $.ajax({
                url: "<?=base_url('simlab/laporan/filter-alat-masuk');?>",
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    $('#FilterMonMsib').DataTable().clear().destroy();
                    $.each(data, function(i, item) {
                        $('#FilterMonMsib tbody').append(
                            '<tr><td style="visibility: hidden;">' + item
                            .id_alat + '</td><td class="d-none">' + item
                            .nama_alat + '</td><td>' + item.nama_mata_kuliah +
                            '</td><td>' + item.nama_kategori + '</td><td>' +
                            item.nilai_uas + '</td></tr>');
                    });
                    $('#FilterMonMsib').DataTable({
                        columnDefs: [{
                            targets: [0, 1, 2, 3, 4, 5, 6, 7, 8,
                                9
                            ], // kolom sub bidang
                            orderable: false,
                        }],
                    });
                },
                endRender: null,
                dataSrc: 0
            });
        });
    });
    </script>

</main>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer'); ?>