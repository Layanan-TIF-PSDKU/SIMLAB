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
                <h2 class="mb-2 page-title">Halaman Pendaftaran MBKM Hibah</h2>
                <p class="card-text">
                    Halaman Pendaftaran MBKM Prodi
                </p>
                <div class="row my-3">
                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->

                                <a href="<?=base_url('mbkm/hibah/tambah');?>" class="btn btn-primary mb-3">Tambah</a>
                                <div class="table-responsive">
                                    <table class="table datatables" id="dataTable-1">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <?php if(has_permission('admin')) : ?>
                                                <th>Nama Mahasiswa</th>
                                                <?php endif; ?>
                                                <th>Nama Dosen</th>
                                                <th>Judul</th>
                                                <th>Proposal</th>
                                                <th>Bukti lolos</th>
                                                <th>Lap Akhir</th>
                                                <th>Persetujuan Dosen</th>
                                                <th>Status Mahasiswa</th>
                                                <?php if(has_permission('admin')) : ?>
                                                <th>Action Dosen</th>
                                                <?php endif; ?>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;?>
                                            <?php foreach ($hibah as $a): ?>
                                            <tr>
                                                <td><?=$no++?></td>
                                                <?php if(has_permission('admin')) : ?>
                                                <td><?=$a->nm_mhs?></td>
                                                <?php endif; ?>
                                                <td><?=$a->nm_staf?></td>
                                                <td><?=$a->judul?></td>
                                                <td>
                                                    <?php if ($a->proposal == ''): ?>
                                                    <span class="badge badge-danger">Belum upload</span>
                                                    <?php else: ?>
                                                    <span class="badge badge-secondary"></span>
                                                    <span class="mx-1 my-1 btn btn-sm btn-outline-primary"
                                                        href="<?=base_url('mbkm/hibah/download-proposal/' . $a->id_hibah)?>">
                                                        <a class="fe fe-download-cloud fe-16 align-middle">
                                                        </a>
                                                    </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($a->bukti == ''): ?>
                                                    <span class="badge badge-danger">Belum upload</span>
                                                    <?php else: ?>
                                                    <span class="badge badge-secondary"></span>
                                                    <span class="mx-1 my-1 btn btn-sm btn-outline-primary"
                                                        href="<?=base_url('mbkm/hibah/download-bukti/' . $a->id_hibah)?>">
                                                        <a class="fe fe-download-cloud fe-16 align-middle">
                                                        </a>
                                                    </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($a->lap_akhir == ''): ?>
                                                    <span class="badge badge-danger">Belum upload</span>
                                                    <?php else: ?>
                                                    <span class="badge badge-secondary"></span>
                                                    <span class="mx-1 my-1 btn btn-sm btn-outline-primary"
                                                        href="<?=base_url('mbkm/hibah/download-lap-akhir/' . $a->id_hibah)?>">
                                                        <a class="fe fe-download-cloud fe-16 align-middle">
                                                        </a>
                                                    </span>
                                                    <?php endif; ?>
                                                </td>

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
                                                    <a class="mx-1 my-1 btn btn-sm btn-outline-success"
                                                        href="<?=base_url('mbkm/hibah/dosen/verifikasi-setujui/' . $a->id_hibah)?>">
                                                        <span class="fe fe-check fe-16 align-middle"></span>
                                                    </a>
                                                    <a class="mx-1 my-1 btn btn-sm btn-outline-danger"
                                                        href="<?=base_url('mbkm/hibah/dosen/verifikasi-tidak-disetujui/' . $a->id_hibah)?>">
                                                        <span class="fe fe-x fe-16 align-middle"></span>
                                                    </a>

                                                </td>


                                                <td>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("mbkm/hibah/edit-status-mhs/$a->id_hibah");?>">Edit
                                                            Status Mahasiswa</a>
                                                        <a class="dropdown-item"
                                                            href="<?=base_url("mbkm/hibah/edit/$a->id_hibah");?>">Edit
                                                            Pendaftaran</a>
                                                        <?php if(has_permission('admin')) : ?> <form method="POST"
                                                            action="<?=base_url("mbkm/hibah/hapus/$a->id_hibah");?>">
                                                            <input name="_method" type="hidden" value="DELETE">
                                                            <button type="submit" class="dropdown-item remove-item-btn"
                                                                data-toggle="tooltip" title='Delete'><i
                                                                    class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <?php endif; ?>
                                            </tr>
                                            <?php endforeach ?>
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