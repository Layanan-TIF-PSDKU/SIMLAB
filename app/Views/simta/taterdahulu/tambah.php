<?php echo $this->include('simta/simta_partial/dashboard/header');?>
<?php echo $this->include('simta/simta_partial/dashboard/top_menu');?>
<?php if(has_permission('admin')) : ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else : ?>
<?php echo $this->include('simta/simta_partial/dashboard/side_menu') ?>
<?php endif; ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="mt-2 page-title">Halaman Tambah Tugas Akhir Terdahulu</h2>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">SIMTA</a></li>
                            <li class="breadcrumb-item active">Tambah Tugas Akhir Terdahulu</li>
                        </ol>
                    </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">SIMTA</a></li>
                            <li class="breadcrumb-item active">Tambah Tugas Akhir Terdahulu</li>
                        </ol>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="row my-4">
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title"></strong>
                            </div>
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data"
                                    action="<?=base_url("simta/taterdahulu/simpan")?>"> 
                                    <?=csrf_field();?>

                                    <div class="form-group mb-3">
                                        <label for="simple-select2">Nama Mahasiswa<span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="id_mhs" id="simple-select2">
                                            <option value="">Daftar Mahasiswa</option>
                                            <?php foreach ($mahasiswa as $m): ?>
                                            <option value="<?=$m->id_mhs?>"><?=$m->nama?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('id_mhs')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('id_mhs');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Judul Tugas Akhir<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="judul_ta"
                                            class="form-control" placeholder="Copy Paste Proposal Tugas Akhir" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('judul_ta')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('judul_ta');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Abstrak<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="abstrak"
                                            class="form-control" placeholder="Copy Paste Proposal Tugas Akhir" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('abstrak')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('abstrak');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="customFile">Dokumen Tugas Akhir<span class="text-danger">*</span></label>
                                        <input type="file"
                                            class="form-control <?= ($validation->hasError('dokumen_ta')) ? 'is-invalid' : ''; ?>"
                                            name="dokumen_ta">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('dokumen_ta'); ?>
                                        </div>
                                        <div class="text-danger">
                                            * File berupa pdf (Max. 5Mb)
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Tambah</button>
                                    <a href="<?=base_url('simta/taterdahulu');?>" class="btn btn-warning">Kembali</a>
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