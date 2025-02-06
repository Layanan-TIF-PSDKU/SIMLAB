<?php echo $this->include('mbkm/mbkm_partial/dashboard/header'); ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/top_menu'); ?>
<?php if (has_permission('admin')): ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else: ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/side_menu') ?>
<?php endif;?>
<main role="main" class="main-content">

    <div class="row my-3 mx-2">
        <!-- Small table -->
        <div class="col-md-12">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="page-title">Monitoring Mahasiswa MBKM</h2>
                    <p class="card-text">
                        Monitoring Kegiatan Mahasiswa selama MBKM berlangsung
                    </p>
                </div>

                <?php if(has_permission('admin')) : ?>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right text-sm">
                        <li class="breadcrumb-item"><a
                                href="<?= base_url('admin/dashboard') ?>"><small>Dashboard</small></a>
                        </li>
                        <li class="breadcrumb-item active"><small>Monitoring</small></li>
                    </ol>
                </div>
                <?php elseif(has_permission('dosen') || has_permission('mahasiswa')) : ?>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right text-sm">
                        <li class="breadcrumb-item"><a href="<?= base_url('mbkm') ?>"><small>Dashboard</small></a>
                        </li>
                        <li class="breadcrumb-item active"><small>Monitoring</small></li>
                    </ol>
                </div>
                <?php endif; ?>
            </div>
            <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-mbkm')): ?>
            <!-- .row -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow mb-5">
                        <div class="card-body text-center">
                            <div class="avatar avatar-lg mt-4">
                                <a href="">
                                    <i class="fe fe-users" style="font-size: 4em;"></i>
                                </a>
                            </div>
                            <div class="card-text my-2">
                                <strong class="card-title my-0">MBKM MSIB</strong>
                                <p></p>
                            </div>
                        </div> <!-- ./card-text -->
                        <div class="card-footer">
                            <div class="row align-items-center justify-content-center ">
                                <div class="col-auto">
                                    <a href="<?= base_url('mbkm/monitoring/msib') ?>">
                                        <small><span class="bg-success mr-1"></span> Telusuri Selengkapnya <i
                                                class="fe fe-chevron-right ml-4"></i></small>
                                </div>
                                </a>
                            </div>
                        </div> <!-- /.card-footer -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow mb-4">
                        <div class="card-body text-center">
                            <div class="avatar avatar-lg mt-4">
                                <a href="">
                                    <i class="fe fe-users" style="font-size: 4em;"></i>
                                </a>
                            </div>
                            <div class="card-text my-2">
                                <strong class="card-title my-0">MBKM Prodi</strong>
                                <p></p>
                            </div>
                        </div> <!-- ./card-text -->
                        <div class="card-footer">
                            <div class="row align-items-center justify-content-center">
                                <div class="col-auto">
                                    <a href="<?= base_url('mbkm/monitoring/mbkm-prodi') ?>">
                                        <small><span class="bg-success mr-1"></span> Telusuri Selengkapnya <i
                                                class="fe fe-chevron-right ml-4"></i></small>
                                </div>
                                </a>
                            </div>
                        </div> <!-- /.card-footer -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow mb-4">
                        <div class="card-body text-center">
                            <div class="avatar avatar-lg mt-4">
                                <a href="">
                                    <i class="fe fe-users" style="font-size: 4em;"></i>
                                </a>
                            </div>
                            <div class="card-text my-2">
                                <strong class="card-title my-0">MBKM Hibah</strong>
                                <p></p>
                            </div>
                        </div> <!-- ./card-text -->
                        <div class="card-footer">
                            <div class="row align-items-center justify-content-center">
                                <div class="col-auto">
                                    <a href="<?= base_url('mbkm/monitoring/mbkm-hibah') ?>">
                                        <small><span class="bg-success mr-1"></span> Telusuri Selengkapnya <i
                                                class="fe fe-chevron-right ml-4"></i></small>
                                </div>
                                </a>
                            </div>
                        </div> <!-- /.card-footer -->
                    </div>
                </div>
            </div> <!-- .col -->

        </div>
    </div>

    <?php elseif(has_permission('mahasiswa')): ?>
    <div class="row my-3">

        <!-- Small table -->
        <div class="col-md-12">

            <?php if(has_permission('mahasiswa')): ?>
            <div class="card shadow">
                <div class="card-body">
                    <?php
                    $no = 1;
                    foreach ($mbkmFix3 as $k) :
                    if($k->status_mahasiswa == 'diambil') {
                    ?>
                    <div class="data mahasiswa">
                        <a href="<?=base_url('mbkm/monitoring/tambah/' . $k->id_mbkm_fix);?>"
                            class="btn btn-primary mb-3">Tambah</a>
                    </div>
                    <?php } endforeach; ?>
                    <?php endif; ?>
                    <!-- table -->
                    <div class="table-responsive">
                        <table class="table datatables" id="dataTable-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <?php if (has_permission('admin') || has_permission('dosen')): ?>
                                    <th>Nama Mahasiswa</th>
                                    <?php endif;?>
                                    <?php if (has_permission('admin')): ?>
                                    <th>Dosen Pembimbing</th>
                                    <?php endif;?>
                                    <th>Tanggal</th>
                                    <th>Deskripsi</th>
                                    <th>Feedback/Tanggapan Dosen</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(has_permission('mahasiswa')) : ?>
                                <?php
                                $no = 1;
                                foreach ($MonByMhs as $a):
                                ?>
                                <tr>
                                    <td><?=$no++?></td>
                                    <td><?=$a->tanggal?></td>
                                    <td><?=$a->deskripsi?></td>
                                    <td>
                                        <?php if ($a->feedback == ''): ?>
                                        <span class="badge badge-warning">belum ada</span>
                                        <?php else: ?>
                                        <?=$a->feedback?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <form method="POST"
                                                action="<?=base_url("mbkm/monitoring/hapus/$a->id_monitoring");?>">
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit" class="dropdown-item remove-item-btn"
                                                    data-toggle="tooltip" title='Delete'><i
                                                        class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                    Delete</button>
                                            </form>
                                        </div>
                                    </td>
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
    </div>



    </tbody>

    </div>
    <!-- simple table -->
    </div>

    <!-- end section -->
    </div>
    <!-- .col-12 -->
    <!-- .row -->
    <?php endif; ?>

    </div>
    <!-- .container-fluid -->
</main>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer'); ?>