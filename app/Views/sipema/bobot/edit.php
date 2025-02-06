<?php echo $this->include('sipema/sipema_partial/dashboard/header');?>
<?php echo $this->include('sipema/sipema_partial/dashboard/top_menu');?>
<?php if(has_permission('admin')) : ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else : ?>
<?php echo $this->include('sipema/sipema_partial/dashboard/side_menu') ?>
<?php endif; ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Form Edit Bobot</h2>
                    </div>
                    <?php if(has_permission('admin')) : ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Sipema</a></li>
                                <li class="breadcrumb-item active">Edit Bobot</li>
                            </ol>
                        </div>
                    <?php else : ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url('sipema') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Edit Bobot</li>
                            </ol>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                            <form method="POST" action="<?= base_url('sipema/bobot/update/' . $bobot->id_bobot) ?>">
                                    <div class="form-group mb-3">
                                    <label for="simple-select-3">Jenis Bobot</label>
                                        <input type="text" id="address-wpalaceholder" name="jenis_bobot" class="form-control" value="<?= $bobot->jenis_bobot ?>"/>
                                         <!-- Error Validation -->
                                         <?php if ($validation->getError('jenis_bobot')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('jenis_bobot'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="simple-select-3">Nilai Bobot (%)</label>
                                        <input type="number" id="address-wpalaceholder" name="nilai_bobot" class="form-control" value="<?= $bobot->nilai_bobot * 100 ?>" />
                                         <!-- Error Validation -->
                                         <?php if ($validation->getError('nilai_bobot')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('nilai_bobot'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <button id="editButton" class="btn btn-primary" type="submit">
                                        Edit
                                    </button>
                                    <a href="<?= base_url('sipema/bobot'); ?>" class="btn btn-warning">Kembali</a>
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
    <script>
        document.getElementById('editButton').addEventListener('click', function() {
            document.getElementById('loadingOverlay').classList.add('active');
        });
    </script>
</main>
<?php echo $this->include('sipema/sipema_partial/dashboard/footer');?>