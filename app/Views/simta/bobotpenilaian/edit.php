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
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="mt-2 page-title">Halaman Edit Bobot Penilaian Tugas Akhir</h2>
                    </div>
                <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">SIMTA</a></li>
                            <li class="breadcrumb-item active">Data Bobot Penilaian Tugas Akhir</li>
                        </ol>
                    </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">SIMTA</a></li>
                            <li class="breadcrumb-item active">Data Bobot Penilaian Tugas Akhir</li>
                        </ol>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col">
                        <div class="card shadow mb-4">
                        <div class="card-header">
                            <div class="card-body">
                                <!-- table -->
                                <form method="POST" action="<?= base_url('simta/bobotpenilaian/update/' . $bobotpenilaian->id_bobot); ?>"
                                    enctype="multipart/form-data">
                                    <?= csrf_field(); ?>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Bobot Penilaian Ujian <span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="bobot_ujianproposal"
                                            class="form-control" placeholder="Contoh : 10%"
                                            value="<?= $bobotpenilaian->bobot_ujianproposal ?>" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('bobot_ujianproposal')) { ?>
                                        <div class='alert alert-danger mt-2'>
                                            <?= $error = $validation->getError('bobot_ujianproposal'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Bobot Penilaian Seminar Hasil<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="bobot_seminarhasil"
                                            class="form-control" placeholder="Contoh : 10%"
                                            value="<?= $bobotpenilaian->bobot_seminarhasil ?>" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('bobot_seminarhasil')) { ?>
                                        <div class='alert alert-danger mt-2'>
                                            <?= $error = $validation->getError('bobot_seminarhasil'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Bobot Penilaian Ujian Tugas Akhir<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="bobot_ujianta"
                                            class="form-control" placeholder="Contoh : 10%"
                                            value="<?= $bobotpenilaian->bobot_ujianta ?>" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('bobot_ujianta')) { ?>
                                        <div class='alert alert-danger mt-2'>
                                            <?= $error = $validation->getError('bobot_ujianta'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <button class="btn btn-primary" type="submit">
                                        Simpan
                                    </button>
                                    <a href="<?=base_url('simta/bobotpenilaian');?>" class="btn btn-warning">Kembali</a>
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