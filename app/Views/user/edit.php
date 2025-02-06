<?php echo $this->include('simta/simta_partial/dashboard/header'); ?>
<?php echo $this->include('simta/simta_partial/dashboard/top_menu'); ?>
<?php if (has_permission('admin')): ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else: ?>
<?php echo $this->include('simta/simta_partial/dashboard/side_menu') ?>
<?php endif;?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">Halaman <?=$title?></h2>
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col">
                        <div class="card shadow mb-4">
                        <div class="card-header">
                                
                            </div>
                            <div class="card-body">
                                <!-- table -->
                                <form method="POST" action="<?= base_url('users/update/' . $user->id); ?>"
                                    enctype="multipart/form-data">
                                    <?= csrf_field(); ?>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Email</label>
                                        <input type="text" id="address-wpalaceholder" name="email"
                                            class="form-control" placeholder="Masukkan Email"
                                            value="<?= $user->email ?>" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('email')) { ?>
                                        <div class='alert alert-danger mt-2'>
                                            <?= $error = $validation->getError('email'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Username</label>
                                        <input type="text" id="address-wpalaceholder" name="username"
                                            class="form-control" placeholder="Masukkan Username"
                                            value="<?= $user->username ?>" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('username')) { ?>
                                        <div class='alert alert-danger mt-2'>
                                            <?= $error = $validation->getError('username'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <button class="btn btn-primary" type="submit">
                                        Simpan
                                    </button>
                                    <a href="<?=base_url('users');?>" class="btn btn-warning">Kembali</a>
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
<?php echo $this->include('simta/simta_partial/dashboard/footer'); ?>