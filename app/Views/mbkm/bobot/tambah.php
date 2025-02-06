<?php echo $this->include('mbkm/mbkm_partial/dashboard/header');?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/top_menu');?>
<?php if(has_permission('admin')) : ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else : ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/side_menu') ?>
<?php endif; ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Form Tambah Bobot Penilaian</h2>
                <div class="row my-4">
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title"></strong>
                            </div>
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data"
                                    action="<?=base_url("mbkm/bobot/simpan")?>"> <?=csrf_field();?>

                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Bobot Dosen</label>
                                        <input type="text" id="address-wpalaceholder" name="bobot_dosen"
                                            class="form-control" placeholder=""></input>
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('bobot_dosen')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('bobot_dosen');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Bobot Mitra</label>
                                        <input type="text" id="address-wpalaceholder" name="bobot_mitra"
                                            class="form-control" placeholder=""></input>
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('bobot_mitra')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('bobot_mitra');?>
                                        </div>
                                        <?php }?>
                                    </div>

                                    <button class="btn btn-primary" type="submit">
                                        Tambah
                                    </button>
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