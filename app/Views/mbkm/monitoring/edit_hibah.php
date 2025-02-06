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
                <h2 class="page-title">Form Monitoring Dosen</h2>
                <p>Form validasi berupa feedback/respon tanggapan terhadap kegiatan monitoring mahasiswa</p>
                <div class="row my-4">
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title"></strong>
                            </div>
                            <div class="card-body">
                                <form method="POST"
                                    action="<?=base_url('mbkm/monitoring/simpan-dosen-hibah/' .  $monitoring->id_monitoring)?>">

                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Feedback Dosen</label>
                                        <textarea type="text" id="address-wpalaceholder" name="feedback[]"
                                            class="form-control <?= ($validation->hasError('feedback')) ? 'is-invalid' : ''; ?>"></textarea>
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('feedback')) { ?>
                                        <div class='alert alert-danger mt-2'>
                                            <?= $error = $validation->getError('feedback'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>

                                    <button class="btn btn-primary" type="submit">
                                        Submit
                                    </button>
                                    <a href="<?=base_url('mbkm/monitoring/mbkm-hibah');?>"
                                        class="btn btn-warning">Kembali</a>
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