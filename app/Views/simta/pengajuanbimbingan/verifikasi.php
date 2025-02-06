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
                        <h2 class="mt-2 page-title">Halaman Tambah Data Verifikasi Pengajuan Bimbingan Tugas Akhir</h2>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Verifikasi Pengajuan Bimbingan Tugas Akhir</li>
                            </ol>
                        </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Verifikasi Pengajuan Bimbingan Tugas Akhir</li>
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
                                <?php $validation = \Config\Services::validation();?>
                                <form method="POST" enctype="multipart/form-data" 
                                action="<?=base_url("simta/pengajuanbimbingan/updateverifikasi/" . $pengajuanbimbingan->id_bimbingan)?>">
                                <?=csrf_field(); ?>
                                    <div class="form-group mb-3">
                                        <label for="tanggal">Tanggal Bimbingan<span class="text-danger">*</span></label>
                                        <input type="date" id="jadwal_bimbingan" name="jadwal_bimbingan"
                                            class="form-control <?=($validation->hasError('jadwal_bimbingan')) ? 'is-invalid' : ''?>"
                                            value="<?=date('Y-m-d',round($pengajuanbimbingan->jadwal_bimbingan/1000))?>" />
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('jadwal_bimbingan');?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Ruang Bimbingan<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="ruang_bimbingan"
                                            class="form-control" placeholder="" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('ruang_bimbingan')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('ruang_bimbingan');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="jam_mulai">Jam Mulai<span class="text-danger">*</span></label>
                                        <input type="time" id="jam_mulai" name="jam_mulai"
                                            class="form-control <?=($validation->hasError('jam_mulai')) ? 'is-invalid' : ''?>"
                                            value="<?=date('H:i', round($pengajuanbimbingan->jam_mulai/1000))?>" />
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('jam_mulai');?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="simple-select2">Status<span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="status_ajuan"
                                            id="simple-select2">
                                            <option value="">Pilih Status</option>
                                            <option value="diterima"
                                                <?= $pengajuanbimbingan->status_ajuan == 'diterima' ? 'selected' : ''?>>
                                                diterima</option>
                                            <option value="pending"
                                                <?= $pengajuanbimbingan->status_ajuan == 'pending' ? 'selected' : ''?>>
                                                pending</option>
                                            <option value="ditolak"
                                                <?= $pengajuanbimbingan->status_ajuan == 'ditolak' ? 'selected' : ''?>>
                                                ditolak</option>
                                        </select>
                                        <!-- Error Validation -->
                                    </div>
                                    <button class="btn btn-primary" type="submit">Edit</button>
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