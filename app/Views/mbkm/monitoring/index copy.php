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
            <h2 class="mb-2 page-title">Monitoring Kegiatan MBKM</h2>
            <p class="card-text">
                Monitoring mahasiswa selama kegiatan MBKM
            </p>
            <div class="card shadow">
                <div class="card-body">

                    <?php if(has_permission('mahasiswa')): ?>
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
                                    <th>Feedback</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(has_permission('admin')):
                                $no = 1;
                                foreach ($monitoring as $a) :  ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <?php foreach($mbkmFix as $p) {
                                        echo ($a->id_mbkm_fix == $p->id_mbkm_fix) ? $p->nm_mhs : ''; } ?>
                                    </td>
                                    <td>
                                        <?php foreach($mbkmFix as $p) {
                                        echo ($a->id_mbkm_fix == $p->id_mbkm_fix) ? $p->nm_staf : ''; } ?>
                                    </td>
                                    <td><?= $a->tanggal ?></td>
                                    <td><?= $a->deskripsi ?></td>
                                    <td><?= $a->feedback ?></td>

                                    <td>
                                        <?php 
                                        foreach ($monitoring as $p) :  
                                        if($p->feedback == ''){
                                        ?>
                                        <a href="<?= base_url('mbkm/monitoring/tambah-dosen/' . $p->id_monitoring) ?>">Beri
                                            Feedback</a>
                                        <?php } else{
                                        echo 'sudah';
                                        } endforeach; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php 
                                elseif(has_permission('dosen')):
                                $no = 1;
                                foreach ($mbkmFix6 as $a) :  ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $a->nm_mhs ?></td>
                                    <td><?= $a->tanggal ?></td>
                                    <td><?= $a->deskripsi ?></td>
                                    <td><?= $a->feedback ?></td>
                                    <td> <a href="<?= base_url('mbkm/monitoring/tambah-dosen/' . $a->id_monitoring) ?>">Beri
                                            Feedback</a></td>


                                </tr>
                                <?php endforeach; ?>
                                <?php elseif(has_permission('mahasiswa')) : ?>
                                <?php
                                                $no = 1;
                                            foreach ($monitoring as $a):
                                                ?>
                                <tr>
                                    <td><?=$no++?></td>
                                    <td><?=$a->tanggal?></td>
                                    <td><?=$a->deskripsi?></td>
                                    <td><?=$a->feedback?></td>
                                    <td>
                                        <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item"
                                                href="<?=base_url("mbkm/msib/edit-status-mhs/$a->id_monitoring");?>">Edit
                                                Status Mahasiswa</a>
                                            <a class="dropdown-item"
                                                href="<?=base_url("mbkm/msib/edit/$a->id_monitoring");?>">Edit
                                                Pendaftaran</a>
                                            <?php if(has_permission('admin')) : ?> <form method="POST"
                                                action="<?=base_url("mbkm/msib/hapus/$a->id_monitoring");?>">
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit" class="dropdown-item remove-item-btn"
                                                    data-toggle="tooltip" title='Delete'><i
                                                        class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                    Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                    <?php endif; ?>
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