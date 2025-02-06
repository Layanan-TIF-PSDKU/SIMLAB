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
                <h2 class="page-title">Form Kegiatan Monitoring</h2>
                <div class="row my-4">
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title"></strong>
                            </div>
                            <div class="card-body">
                                <form method="POST"
                                    action="<?= base_url('mbkm/monitoring/simpan/' . $mbkm->id_mbkm_fix); ?>"
                                    enctype="multipart/form-data">
                                    <?= csrf_field(); ?>
                                    <input class="form-control" type="hidden" class="form-control" name="id_mbkm_fix"
                                        value="<?= $mbkm->id_mbkm_fix ?>">
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Tanggal</label>
                                        <input type="date" id="address-wpalaceholder" name="tanggal"
                                            class="form-control" placeholder="" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('tanggal')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('tanggal');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Deskripsi Kegiatan</label>
                                        <textarea type="text-area" id="address-wpalaceholder" name="deskripsi"
                                            class="form-control" placeholder=""></textarea>
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('deskripsi')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('deskripsi');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <button class="btn btn-primary" type="submit">
                                        Tambah
                                    </button>
                                    <a href="<?=base_url('mbkm/monitoring');?>" class="btn btn-warning">Kembali</a>
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