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
                <h2 class="page-title">Form Tambah Bobot</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form method="POST" action="<?= base_url("sipema/bobot/simpan") ?>">
                                    <div class="form-group mb-3">
                                    <label for="simple-select-3">Jenis Bobot</label>
                                        <input type="text" id="address-wpalaceholder" name="jenis_bobot" class="form-control" placeholder="Masukkan Jenis Bobot" />
                                         <!-- Error Validation -->
                                         <?php if ($validation->getError('jenis_bobot')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('jenis_bobot'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="simple-select-3">Nilai Bobot (%)<span class="text-danger">*</span></label>
                                        <input type="number" id="address-wpalaceholder" name="nilai_bobot" class="form-control" placeholder="Masukkan Nilai Bobot" />
                                         <!-- Error Validation -->
                                         <?php if ($validation->getError('nilai_bobot')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('nilai_bobot'); ?>
                                            </div>
                                        <?php } ?>
                                        <div class="text-danger">
                                            <span>*</span> Skala bobot 0-100
                                        </div>
                                    </div>
                                    <button id="tambahButton" class="btn btn-primary" type="submit">
                                        Tambah
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
        document.getElementById('tambahButton').addEventListener('click', function() {
            document.getElementById('loadingOverlay').classList.add('active');
        });
    </script>
</main>
<?php echo $this->include('sipema/sipema_partial/dashboard/footer');?>