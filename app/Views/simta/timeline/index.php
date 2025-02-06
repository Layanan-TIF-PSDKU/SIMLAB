<?php echo $this->include('simta/simta_partial/dashboard/header'); ?>
<?php echo $this->include('simta/simta_partial/dashboard/top_menu'); ?>
<?php if (has_permission('admin')): ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else: ?>
<?php echo $this->include('simta/simta_partial/dashboard/side_menu') ?>
<?php endif;?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="mt-2 page-title">Halaman Pengelolaan Timeline</h2>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Pengelolaan Timeline</li>
                            </ol>
                        </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Pengelolaan Timeline</li>
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
                                <?php if(has_permission('admin') || has_permission('koor-simta')) : ?>
                                    <a href="<?= base_url('simta/timeline/tambah'); ?>" class="btn btn-primary mb-3">Tambah</a>
                                <?php endif; ?>
                                <table class="table datatables" id="dataTable-1">
                                    <div class="table-responsive">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Kegiatan</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Tanggal Selesai</th>
                                                <?php if(has_permission('admin') || has_permission('koor-simta')) : ?>
                                                <th>Action</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;?>
                                            <?php foreach ($timeline as $t): ?>
                                            <tr>
                                                <td><?=$no++?></td>
                                                <td><?=$t->nama_kegiatan?></td>
                                                <td><?=date('d M Y', round($t->tanggal_mulai/1000))?></td>
                                                <td><?=date('d M Y', round($t->tanggal_selesai/1000))?></td>
                                                <?php if(has_permission('admin') || has_permission('koor-simta')) : ?>
                                                    <td>
                                                        <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="<?=base_url("simta/timeline/edit/$t->id_timeline");?>">Edit</a>
                                                            <form method="POST" action="<?=base_url("simta/timeline/hapus/$t->id_timeline");?>">
                                                            <input name="_method" type="hidden" value="DELETE">
                                                            <button type="submit" class="dropdown-item remove-item-btn" data-toggle="tooltip" title='Delete'>
                                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                            <?php endforeach?>
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
<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer'); ?>