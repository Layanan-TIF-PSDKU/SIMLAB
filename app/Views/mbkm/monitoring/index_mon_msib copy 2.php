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
                        <?php if (has_permission('admin')): ?>

                        <?php foreach ($MonAdmMsib as $m) : ?>
                        <!-- .row -->
                        <div class="row">
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
                                                <p class="small text-muted mb-0"><?= $m->nama_instansi ?></p>

                                            </div>
                                        </div>
                                        <div class="row align-items-center justify-content-center ">
                                            <?php if ($m->bukti == ''): ?>
                                            <div class="col-auto">
                                                <span class="badge badge-danger">Belum upload LoA</span>
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
                                                <span class="badge badge-danger">Belum upload LapAkhir</span>
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

                                                    <small><span class="bg-success mr-1"></span> Monitoring Mahasiswa<i
                                                            class="fe fe-chevron-right ml-4"></i></small>
                                            </div>

                                            </a>
                                        </div>
                                    </div> <!-- /.card-footer -->
                                </div>
                            </div>
                        </div>
                        <?php endforeach ?>
                        <?php elseif(has_permission('dosen')):
                        foreach ($MonDsnMsib as $a) :  ?>

                        <?php endforeach; ?>
                        <?php endif;?>

                    </div>
                </div>
            </div>
        </div>
    </div>


</main>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer'); ?>