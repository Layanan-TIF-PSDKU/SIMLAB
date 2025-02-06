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
                        <h2 class="page-title">Pertanyaan UAS</h2>
                        <p class="card-text">

                        </p>
                    </div>

                    <?php if(has_permission('admin')) : ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a
                                    href="<?= base_url('admin/dashboard') ?>"><small>Dashboard</small></a>
                            </li>
                            <li class="breadcrumb-item active"><small>Pertanyaan UAS</small></li>
                        </ol>
                    </div>
                    <?php elseif(has_permission('dosen')) : ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right text-sm">
                            <li class="breadcrumb-item"><a
                                    href="<?= base_url('admin/dashboard') ?>"><small>Dashboard</small></a>
                            </li>
                            <li class="breadcrumb-item active"><small>Pertanyaan UAS</small></li>
                        </ol>
                    </div>
                    <?php endif; ?>
                </div>


                <div class="col-md-13 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- table -->
                            <a href="<?=base_url('mbkm/pertanyaan');?>" class="btn btn-secondary mb-3">Kembali</a>
                            <a href="<?=base_url('mbkm/pertanyaan/tambah_uas');?>"
                                class="btn btn-primary mb-3">Tambah</a>

                            <div class="table-responsive">
                                <table class="table datatables" id="dataTable-1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Pertanyaan UAS</th>
                                            <th>Mata Kuliah</th>
                                            <th>Penilai</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;?>
                                        <?php foreach ($pertanyaanUas as $a): ?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td>
                                                <?=$a->pertanyaan?>
                                            </td>
                                            <td>
                                                <?php if ($a->nama_mata_kuliah =='' ): ?>
                                                <p></p>Softskill
                                                <?=$a->nama_mata_kuliah?>
                                                <?php else: ?>
                                                <?=$a->nama_mata_kuliah?>

                                                <?php endif; ?>
                                            </td>
                                            <td><?=$a->jenis_penilai?></td>
                                            <td>
                                                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted sr-only">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        href="<?=base_url("mbkm/pertanyaan/edit_uas/$a->id_pertanyaan_uas");?>">Edit</a>

                                                    <form method="POST"
                                                        action="<?=base_url("mbkm/pertanyaan/hapus_uas/$a->id_pertanyaan_uas");?>">
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="submit" class="dropdown-item remove-item-btn"
                                                            data-toggle="tooltip" title='Delete'><i
                                                                class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                            Delete</button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach?>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
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