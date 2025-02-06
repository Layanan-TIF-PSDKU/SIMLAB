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
                        <h2 class="mt-2 page-title">Halaman Tambah Data Hasil Pengajuan Bimbingan Tugas Akhir</h2>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Hasil Pengajuan Bimbingan</li>
                            </ol>
                        </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Hasil Pengajuan Bimbingan</li>
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
                                    <?php $validation = \Config\Services::validation();?>
                                    <form method="POST" enctype="multipart/form-data"  
                                    action="<?=base_url("simta/pengajuanbimbingan/update/" . $pengajuanbimbingan->id_bimbingan)?>">
                                    <?=csrf_field(); ?>
                                    <div class="form-group mb-3">
                                        <label for="hasil_bimbingan">Hasil Bimbingan<span class="text-danger">*</span></label>
                                        <input type="text" id="hasil_bimbingan" name="hasil_bimbingan" class="form-control <?=($validation->hasError('hasil_bimbingan')) ? 'is-invalid' : ''?>" value="<?=$pengajuanbimbingan->hasil_bimbingan?>" />
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('hasil_bimbingan');?>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">
                                        Edit
                                    </button>
                                    <a href="<?=base_url('simta/pengajuanbimbingan');?>" class="btn btn-warning">Kembali</a>
                                </form>
                            </div>
                        </div>
                    </div> <!-- simple table -->
                </div> <!-- end section -->
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
</main>

<?php echo $this->include('simta/simta_partial/dashboard/footer'); ?>