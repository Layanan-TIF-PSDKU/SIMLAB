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
                <h2 class="page-title">Edit Bobot Penilaian MBKM</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data"
                                    action="<?=base_url("mbkm/bobot/update/" . $bobot->id_bobot)?>">
                                    <?=csrf_field();?>
                                    <div class="form-group mb-3">
                                        <label>Bobot Dosen (Prodi) <span class="text-danger">*</span></label>
                                        <input type="number"
                                            class="form-control <?= ($validation->hasError('bobot_dosen')) ? 'is-invalid' : ''; ?>"
                                            name="bobot_dosen" value="<?= $bobot->bobot_dosen ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('bobot_dosen'); ?>
                                        </div>
                                        <div class="text-danger">
                                            <span>*</span> Skala bobot 0-100
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Bobot Mitra <span class="text-danger">*</span></label>
                                        <input type="number"
                                            class="form-control <?= ($validation->hasError('bobot_mitra')) ? 'is-invalid' : ''; ?>"
                                            name="bobot_mitra" value="<?= $bobot->bobot_mitra ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('bobot_mitra'); ?>
                                        </div>
                                        <div class="text-danger">
                                            <span>*</span> Skala bobot 0-100
                                        </div>
                                    </div>

                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <a href="<?=base_url('mbkm/bobot');?>" class="btn btn-warning">Kembali</a>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- end section -->
            </div>
            <!-- /.col-12 col-lg-10 col-xl-10 -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container-fluid -->
</main>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer'); ?>