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
                        <h2 class="mt-2 page-title">Halaman Pengelolaan Tugas Akhir Terdahulu</h2>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Pengelolaan Tugas Akhir Terdahulu</li>
                            </ol>
                        </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Pengelolaan Tugas Akhir Terdahulu</li>
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
                                    <a href="<?= base_url('simta/taterdahulu/tambah'); ?>" class="btn btn-primary mb-3">Tambah</a>
                                <?php endif; ?>
                                <table class="table datatables" id="dataTable-1">
                                    <div class="table-responsive">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama mahasiswa</th>
                                                <th>Angkatan</th>
                                                <th>Judul Tugas Akhir</th>
                                                <th>Abstrak</th>
                                                <th>Dokumen Tugas Akhir</th>
                                                <?php if(has_permission('admin') || has_permission('koor-simta')) : ?>
                                                <th>Action</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;?>
                                            <?php foreach ($taterdahulu as $tt): ?>
                                            <tr>
                                                <td><?=$no++?></td>
                                                <td><?=$tt->nm_mhs?></td>
                                                <td><?=$tt->th_masuk?></td>
                                                <td><?=$tt->judul_ta?></td>
                                                <td><?=$tt->abstrak?></td>
                                                <td>
                                                    <div class="row ">
                                                        <a class="mx-1 my-1 btn btn-sm btn-outline-primary"
                                                            href="<?=base_url('simta/taterdahulu/download_dokumen_ta/' . $tt->id_taterdahulu)?>">
                                                            <span
                                                                class="fe fe-download-cloud fe-16 align-middle"></span>
                                                        </a>
                                                    </div>
                                                </td>
                                                <?php if(has_permission('admin') || has_permission('koor-simta')) : ?>
                                                    <td>
                                                        <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="<?=base_url("simta/taterdahulu/edit/$tt->id_taterdahulu");?>">Edit</a>
                                                            <form method="POST" action="<?=base_url("simta/taterdahulu/hapus/$tt->id_taterdahulu");?>">
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