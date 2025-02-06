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
                        <h2 class="mt-2 page-title">Halaman Tambah Data Penilaian Ujian Tugas Akhir</h2>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Tambah Penilaian Ujian TA</li>
                            </ol>
                        </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Tambah Penilaian Ujian TA</li>
                            </ol>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <!-- table -->
                                <form method="POST" action="<?= base_url('simta/ujianta/updatestatus/' . $pengujiujianta->id_penguji_ujianta); ?>"
                                    enctype="multipart/form-data">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" id="id_ujianta" name="id_ujianta"
                                        value="<?= $pengujiujianta->id_ujianta ?>" />
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nilai<span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="nilai_ujianta"
                                            class="form-control" placeholder="Masukkan Nilai Ujian ta" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('nilai_ujianta')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('nilai_ujianta');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="simple-select2">Hasil<span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="status_ut"
                                            id="simple-select2">
                                            <option value="">Pilih Hasil</option>
                                            <option value="LULUS"
                                                <?= $pengujiujianta->status_ut == 'LULUS' ? 'selected' : ''?>>
                                                LULUS</option>
                                            <option value="LULUS DENGAN REVISI"
                                                <?= $pengujiujianta->status_ut == 'LULUS DENGAN REVISI' ? 'selected' : ''?>>
                                                LULUS DENGAN REVISI</option>
                                            <option value="GAGAL"
                                                <?= $pengujiujianta->status_ut == 'GAGAL' ? 'selected' : ''?>>
                                                GAGAL</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Catatan<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="catatan"
                                            class="form-control" placeholder="Masukkan Catatan" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('catatan')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('catatan');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <a href="<?=base_url('simta/ujianta');?>" class="btn btn-warning">Kembali</a>
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