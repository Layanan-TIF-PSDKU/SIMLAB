<?php echo $this->include('master_partial/dashboard/header');?>
<?php echo $this->include('kmm/kmm_partial/dashboard/top_menu');?>
<?php if(has_permission('admin')): ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>
<?php else: ?>
<?= $this->include('kmm/kmm_partial/dashboard/side_menu'); ?>
<?php endif; ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-8">
                        <h2 class="mt-2 page-title">Halaman Edit Bobot Penilaian KMM</h2>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <?php if(has_permission('admin')): ?>
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                            <?php else: ?>
                            <li class="breadcrumb-item"><a href="<?= base_url('kmm') ?>">Dashboard</a></li>
                            <?php endif; ?>
                            <li class="breadcrumb-item active">KMM</a></li>
                            <li class="breadcrumb-item active">Bobot Penilaian KMM</li>
                        </ol>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data"
                                    action="<?=base_url("kmm/bobot/update/" . $bobot->id_bobot)?>">
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
                                    <a href="<?=base_url('kmm/bobot');?>" class="btn btn-warning">Kembali</a>
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
<?php echo $this->include('master_partial/dashboard/footer'); ?>