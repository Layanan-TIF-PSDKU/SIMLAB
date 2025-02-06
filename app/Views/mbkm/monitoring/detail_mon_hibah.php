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
                    <h2 class="page-title">Detail Monitoring Mahasiswa MBKM Hibah</h2>

                </div>

                <?php if(has_permission('admin')) : ?>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right text-sm">
                        <li class="breadcrumb-item"><a
                                href="<?= base_url('admin/dashboard') ?>"><small>Dashboard</small></a>
                        </li>
                        <li class="breadcrumb-item active"><a
                                href="<?= base_url('mbkm/monitoring/mbkm-hibah') ?>"><small>Monitoring
                                    MBKM Hibah</small></a></li>
                        <li class="breadcrumb-item active"><small>Detail Monitoring</small></li>
                    </ol>
                </div>
                <?php elseif(has_permission('dosen')) : ?>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right text-sm">
                        <li class="breadcrumb-item"><a href="<?= base_url('mbkm') ?>"><small>Dashboard</small></a>
                        </li>
                        <li class="breadcrumb-item active"><a
                                href="<?= base_url('mbkm/monitoring/mbkm-hibah') ?>"><small>Monitoring
                                    MBKM Hibah</small></a></li>
                        <li class="breadcrumb-item active"><small>Detail Monitoring</small></li>
                    </ol>
                </div>
                <?php endif; ?>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <!-- table -->
                    <a href="<?=base_url('mbkm/monitoring/mbkm-hibah');?>"
                        class="btn btn-secondary bt-sm mb-3">Kembali</a>
                    <div class="table-responsive">
                        <table class="table datatables" id="dataTable-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Deskripsi</th>
                                    <th>Feedback</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(has_permission('admin')):
                                $no = 1;
                                foreach ($MonDetailHibahAdm as $a) : 
                                // dd($MonDetailMsibAdm); ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $a->tanggal ?></td>
                                    <td><?= $a->deskripsi ?></td>
                                    <td>
                                        <?= $a->feedback ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item"
                                                href="<?=base_url('mbkm/monitoring/tambah-dosen-hibah/' . $a->id_monitoring);?>">Feedback
                                            </a>
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
                                </tr>
                                <?php endforeach; ?>
                                <?php 
                                elseif(has_permission('dosen')):
                                $no = 1;
                                foreach ($MonDetailHibahDsn as $a) :  ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $a->tanggal ?></td>
                                    <td><?= $a->deskripsi ?></td>
                                    <td>
                                        <?php if ($a->feedback == ''): ?>
                                        <a class="btn btn-sm btn-outline-primary"
                                            href="<?=base_url('mbkm/monitoring/tambah-dosen-hibah/' . $a->id_monitoring)?>">
                                            <span>Beri Feedback</span>
                                            <?php else: ?>
                                            <?= $a->feedback ?>
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
<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer'); ?>