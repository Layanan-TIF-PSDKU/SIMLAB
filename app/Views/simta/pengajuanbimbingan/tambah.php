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
                        <h2 class="mt-2 page-title">Halaman Pendaftaran Pengajuan Bimbingan Tugas Akhir</h2>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Pendaftaran Pengajuan Bimbingan Tugas Akhir</li>
                            </ol>
                        </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Pendaftaran Pengajuan Bimbingan Tugas Akhir</li>
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
                                action="<?=base_url('simta/pengajuanbimbingan/store/' . $pengajuanjudul->id_pengajuanjudul)?>"> 
                                <?=csrf_field();?>
                                    <!--  -->
                                    <div class="form-group" id="id_mhs">
                                        <div class="id_mhs-row">
                                            <input type="hidden" id="id_mhs" name="id_mhs" class="form-control" placeholder="Masukkan Ujian Proposal" value="<?= $pengajuanjudul->id_mhs ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group" id="id_staf">
                                        <div class="id_staf-row">
                                            <input type="hidden" id="id_staf" name="id_staf" class="form-control" placeholder="Masukkan Ujian Proposal" value="<?= $pengajuanjudul->id_staf ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Tanggal Bimbingan<span class="text-danger">*</span></label>
                                        <input type="date" id="address-wpalaceholder" name="jadwal_bimbingan"
                                            class="form-control" placeholder="" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('jadwal_bimbingan')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('jadwal_bimbingan');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Tambah</button>
                                    <a href="<?=base_url('simta/pengajuanbimbingan');?>" class="btn btn-warning">Kembali</a>
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