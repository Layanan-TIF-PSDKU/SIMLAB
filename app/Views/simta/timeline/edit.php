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
                        <h2 class="mt-2 page-title">Halaman Tambah Timeline</h2>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">SIMTA</a></li>
                            <li class="breadcrumb-item active">Tambah Timeline</li>
                        </ol>
                    </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">SIMTA</a></li>
                            <li class="breadcrumb-item active">Tambah Timeline</li>
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
                            <?php $validation = \Config\Services::validation();?>
                                    <form method="POST" enctype="multipart/form-data"  
                                    action="<?=base_url("simta/timeline/update/" . $timeline->id_timeline)?>">
                                    <?=csrf_field(); ?>
                                    <div class="form-group mb-3">
                                        <label for="nama_kegiatan">Nama Kegiatan<span class="text-danger">*</span></label>
                                        <input type="text" id="nama_kegiatan" name="nama_kegiatan" class="form-control <?=($validation->hasError('nama_kegiatan')) ? 'is-invalid' : ''?>" value="<?=$timeline->nama_kegiatan?>" />
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('nama_kegiatan');?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="tanggal_mulai">Tanggal Mulai<span class="text-danger">*</span></label>
                                        <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                                            class="form-control <?=($validation->hasError('tanggal_mulai')) ? 'is-invalid' : ''?>"
                                            value="<?=date('Y-m-d', round($timeline->tanggal_mulai/1000))?>" />
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('tanggal_mulai');?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="tanggal_selesai">Tanggal Selesai<span class="text-danger">*</span></label>
                                        <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                                            class="form-control <?=($validation->hasError('tanggal_selesai')) ? 'is-invalid' : ''?>"
                                            value="<?=date('Y-m-d', round($timeline->tanggal_selesai/1000))?>" />
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('tanggal_selesai');?>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <a href="<?=base_url('simta/timeline');?>" class="btn btn-warning">Kembali</a>
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