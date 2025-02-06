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
                <h2 class="mb-2 page-title">Kegiatan MBKM Berjalan</h2>
                <p class="card-text">
                    Kegiatan MBKM yang sedang dilaksanakan. Pastikan untuk update mitra atau instansi terkait!
                </p>
                <div class="row my-3">
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
                                                <?php if(has_permission('admin') || has_permission('dosen')) : ?>
                                                <th>Nama Mahasiswa</th>
                                                <?php endif; ?>
                                                <?php if(has_permission('admin') || has_permission('mahasiswa')) : ?>
                                                <th>Dosen Pembimbing</th>
                                                <?php endif; ?>
                                                <th>Nama Instansi</th>
                                                <th>LoA/Bukti Lolos</th>
                                                <th>Laporan Akhir</th>
                                                <?php if(has_permission('admin') || has_permission('dosen')) : ?>
                                                <th>Action</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (has_permission('admin')):
                                            $no = 1;
                                            foreach ($mbkmFix as $a) :
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

                                                <td>
                                                    <?php if ($a->id_mitra == ''): ?>
                                                    <span type="button" class="btn mb-2 btn-link">Update
                                                        mitra</span>
                                                    <?php else: ?>
                                                    <?php foreach($mitra as $mtr) {
                                                    echo ($a->id_mitra == $mtr->id_mitra) ? $mtr->nama_instansi : '';} ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($a->bukti == ''): ?>
                                                    <a href="#" class="btn btn-sm btn-outline-primary"
                                                        data-toggle="modal" data-target="#import"><i
                                                            class="fe fe-file fe-16"></i>&nbspUpload</a>
                                                    <?php else: ?>
                                                    <a class="mx-1 my-1 btn btn-sm btn-outline-primary"
                                                        href="<?=base_url("mbkm/mbkmProdi/download-LoA/$a->id_mbkm_fix");?>">
                                                        <span class="fe fe-download-cloud fe-16 align-middle"></span>
                                                    </a>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($a->lap_akhir == ''): ?>
                                                    <span class="badge badge-danger">Belum upload</span>
                                                    <?php else: ?>
                                                    <a class="mx-1 my-1 btn btn-sm btn-outline-primary"
                                                        href="<?=base_url("mbkm/mbkmProdi/download-LoA/$a->id_mbkm_fix");?>">
                                                        <span class="fe fe-download-cloud fe-16 align-middle"></span>
                                                    </a>

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
                                                            href="<?=base_url("mbkm/mbkmFix/edit/$a->id_mbkm_fix");?>">Edit
                                                            Pendaftaran</a>
                                                        <?php if(has_permission('admin')) : ?> <form method="POST"
                                                            action="<?=base_url("mbkm/mbkmFix/hapus/$a->id_mbkm_fix");?>">
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
                                            <?php endforeach; ?>
                                            <?php elseif (has_permission('dosen')) :
                                            $no = 1;
                                            foreach ($mbkmFix5 as $k) { ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $k->nm_mhs; ?></td>
                                                <td>
                                                    <?php if ($k->id_mitra == ''): ?>
                                                    <span type="button" class="btn mb-2 btn-link">Update
                                                        mitra</span>
                                                    <?php else: ?>
                                                    <?php foreach($mitra as $mtr) {
                                                    echo ($k->id_mitra == $mtr->id_mitra) ? $mtr->nama_instansi : '';} ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($k->bukti == ''): ?>
                                                    <a href="#" class="btn btn-sm btn-outline-primary"
                                                        data-toggle="modal" data-target="#import"><i
                                                            class="fe fe-file fe-16"></i>&nbspUpload</a>
                                                    <?php else: ?>
                                                    <a class="mx-1 my-1 btn btn-sm btn-outline-primary"
                                                        href="<?=base_url("mbkm/mbkmProdi/download-LoA/$k->id_mbkm_fix");?>">
                                                        <span class="fe fe-download-cloud fe-16 align-middle"></span>
                                                    </a>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($k->lap_akhir == ''): ?>
                                                    <span class="badge badge-danger">Belum upload</span>
                                                    <?php else: ?>
                                                    <a class="mx-1 my-1 btn btn-sm btn-outline-primary"
                                                        href="<?=base_url("mbkm/mbkmProdi/download-LoA/$k->id_mbkm_fix");?>">
                                                        <span class="fe fe-download-cloud fe-16 align-middle"></span>
                                                    </a>

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
                                                            href="<?=base_url("mbkm/mbkmFix/edit/$k->id_mbkm_fix");?>">Edit
                                                            Pendaftaran</a>
                                                        <?php if(has_permission('admin')) : ?> <form method="POST"
                                                            action="<?=base_url("mbkm/mbkmFix/hapus/$k->id_mbkm_fix");?>">
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
                                            <?php } ?>

                                            <?php elseif (has_permission('mahasiswa')):
                                            $no = 1;
                                            foreach ($mbkmFix as $a) : ?>
                                            <tr>
                                                <?php
                                                if($a->id_mitra == '') {
                                                foreach ($mbkmFix2 as $k){ ?>
                                                <td><?= $no++; ?></td>
                                                <td><?= $k->nm_staf ?></td>
                                                <td>
                                                    <?php if ($k->id_mitra == ''): ?>
                                                    <a href="#" class="btn btn-sm btn-outline-primary"
                                                        data-toggle="modal" data-target="#update-mitra1"><i
                                                            class="fe fe-file fe-16"></i>&nbspUpdate Mitra</a>
                                                    <?php else: ?>
                                                    <?php foreach($mitra as $mtr) {
                                                    echo ($k->id_mitra == $mtr->id_mitra) ? $mtr->nama_instansi : '';} ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($k->bukti == ''): ?>
                                                    <a href="#" class="btn btn-sm btn-outline-primary"
                                                        data-toggle="modal"
                                                        data-target="#import <?= $k->id_mbkm_fix?>"><i
                                                            class="fe fe-file fe-16"></i>&nbspUpload</a>
                                                    <?php else: ?>
                                                    <a class="mx-1 my-1 btn btn-sm btn-outline-primary"
                                                        href="<?=base_url("mbkm/mbkmProdi/download-LoA/$k->id_mbkm_fix");?>">
                                                        <span class="fe fe-download-cloud fe-16 align-middle"></span>
                                                    </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($k->lap_akhir == ''): ?>
                                                    <span class="badge badge-danger">Belum upload</span>
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
                                                                <h5 class="modal-title" id="verticalModalTitle">Import
                                                                    Data</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <?= $k->id_mbkm_fix ?>
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
                                                                            <option value="">Daftar Instansi</option>
                                                                            <?php foreach ($mitra as $m): ?>
                                                                            <option value="<?=$m->id_mitra?>">
                                                                                <?=$m->nama_instansi?></option>
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
                                                <?php } 
                                                } else {
                                                foreach ($mbkmFix4 as $k2){ ?>
                                                <td><?= $no++; ?></td>
                                                <td><?= $k2->nm_staf ?></td>
                                                <td><?= $k2->nama_instansi ?></td>
                                                <td>
                                                    <?php if ($k2->bukti == ''): ?>
                                                    <a href="#" class="btn btn-sm btn-outline-primary"
                                                        data-toggle="modal" data-target="#import "><i
                                                            class="fe fe-file fe-16"></i>&nbspUpload</a>
                                                    <?php else: ?>
                                                    <a class="mx-1 my-1 btn btn-sm btn-outline-primary"
                                                        href="<?=base_url("mbkm/mbkmProdi/download-LoA/$k2->id_mbkm_fix");?>">
                                                        <span class="fe fe-download-cloud fe-16 align-middle"></span>
                                                    </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($k2->lap_akhir == ''): ?>
                                                    <span class="badge badge-danger">Belum upload</span>
                                                    <?php else: ?>
                                                    <a class="mx-1 my-1 btn btn-sm btn-outline-primary"
                                                        href="<?=base_url("mbkm/mbkmProdi/download-LoA/$k2->id_mbkm_fix");?>">
                                                        <span class="fe fe-download-cloud fe-16 align-middle"></span>
                                                    </a>

                                                    <?php endif; ?>
                                                </td>

                                                <?php }
                                                        }?>
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
<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer'); ?>