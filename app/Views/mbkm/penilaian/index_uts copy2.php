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
                <h2 class="mb-2 page-title">Halaman <?=$title?></h2>
                <p class="card-text">

                </p>
                <div class="col-md-13 mb-4">
                    <div class="card shadow">
                        <div class="card-body">

                            <div class="tab-content mb-1" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab">
                                    <div class="card-body">
                                        <!-- table -->

                                        <a href="<?=base_url('mbkm/penilaian/');?>"
                                            class="btn btn-primary mb-3">Kembali</a>

                                        <div class="table-responsive">
                                            <table class="table datatables" id="dataTable-1">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Mahasiswa</th>
                                                        <?php if(has_permission('admin') || has_permission('dosen')) : ?>
                                                        <th>Nama Mitra</th>
                                                        <?php endif; ?>
                                                        <th>Nama Dosen Pembimbing</th>
                                                        <?php if(has_permission('admin') || has_permission('dosen')) : ?>
                                                        <th>Nilai Dosen</th>
                                                        <?php endif; ?>
                                                        <th>Nilai Mitra</th>
                                                        <?php if(has_permission('admin') || has_permission('dosen')) : ?>
                                                        <th>Nilai UTS</th>
                                                        <?php endif; ?>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                            if(has_permission('dosen')):
                                            $no = 1;
                                            foreach ($mbkm3 as $a) :
                                                if($a->status_mahasiswa == 'diambil') {?> <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td><?= $a->nm_mhs ?></td>
                                                        <td><?= $a->nama_instansi ?></td>
                                                        <td><?= $a->nm_staf ?></td>
                                                        <td>
                                                            <?php foreach($totalUts as $p) {
                                                    echo ($a->id_mbkm_fix == $p->id_mbkm_fix) ? $p->nilai_dosen_uts : ''; } ?>
                                                        </td>
                                                        <td>
                                                            <?php foreach($totalUts as $p) {
                                                    echo ($a->id_mbkm_fix == $p->id_mbkm_fix) ? $p->nilai_mitra_uts : ''; } ?>
                                                        </td>
                                                        <td>
                                                            <?php foreach($totalUts as $p) {
                                                    echo ($a->id_mbkm_fix == $p->id_mbkm_fix) ? $p->nilai_final_uts : ''; } ?>
                                                        </td>
                                                        <td>
                                                            <a
                                                                href="<?= base_url('mbkm/penilaian/mbkm/dosen/' . $a->id_mbkm_fix) ?>">Nilai</a>
                                                        </td>
                                                    </tr>
                                                    <?php } endforeach; ?>

                                                    <?php elseif(has_permission('mitra')) : ?>
                                                    <?php 
                                            $no = 1;
                                            foreach ($mbkm2 as $m) :
                                                if($m->status_mahasiswa == 'diambil') {
                                                    
                                        ?><tr>
                                                        <td><?= $no++ ?></td>
                                                        <td><?= $m->nm_mhs ?></td>
                                                        <td><?= $m->nm_staf ?></td>
                                                        <td>
                                                            <?php foreach($totalUts as $p) {
                                                    echo ($m->id_mbkm_fix == $p->id_mbkm_fix) ? $p->nilai_mitra_uts : ''; } ?>
                                                        </td>
                                                        <td>
                                                            <a
                                                                href="<?= base_url('mbkm/penilaian/mbkm/mitra/' . $m->id_mbkm_fix) ?>">Nilai</a>
                                                        </td>
                                                    </tr>
                                                    <?php } endforeach; ?>
                                                    <?php endif; ?>

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