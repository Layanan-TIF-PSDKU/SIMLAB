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
                        <h2 class="mt-2 page-title">Halaman Pendaftaran Pengajuan Judul Tugas Akhir</h2>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Pendaftaran Pengajuan Judul</li>
                            </ol>
                        </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Pendaftaran Pengajuan Judul</li>
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
                            <?php if(has_permission('admin') || has_permission('mahasiswa')) : ?>
                                <form method="POST" action="<?=base_url("simta/pengajuanjudul/store")?>">
                                    <?=csrf_field();?>
                                    <div class="form-group mb-3">
                                        <label for="simple-select2">Nama Mahasiswa<span class="text-danger">*</span></label>
                                        <select name="id_mhs"
                                            class="form-control select2 <?= ($validation->hasError('id_mhs')) ? 'is-invalid' : ''; ?>">
                                            <option>Pilih Nama Mahasiswa</option>
                                            <?php foreach ($mahasiswa as $mhs) : ?>
                                            <option value="<?= $mhs->id_mhs ?>"><?= $mhs->nama ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('id_mhs')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('id_mhs');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nama Judul 1<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="nama_judul1"
                                            class="form-control" placeholder="Silahkan Masukkan Nama Judul 1" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('nama_judul1')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('nama_judul1');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Deskripsi Sistem 1<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="deskripsi_sistem1"
                                            class="form-control" placeholder="Silahkan Masukkan Deskripsi Sistem 1" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('deskripsi_sistem1')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('deskripsi_sistem1');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nama Judul 2<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="nama_judul2"
                                            class="form-control" placeholder="Silahkan Masukkan Nama Judul 2" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('nama_judul2')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('nama_judul2');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Deskripsi Sistem 2<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="deskripsi_sistem2"
                                            class="form-control" placeholder="Silahkan Masukkan Deskripsi Sistem 2" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('deskripsi_sistem2')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('deskripsi_sistem2');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nama Judul 3<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="nama_judul3"
                                            class="form-control" placeholder="Silahkan Masukkan Nama Judul 3" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('nama_judul3')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('nama_judul3');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Deskripsi Sistem 3<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="deskripsi_sistem3"
                                            class="form-control" placeholder="Silahkan Masukkan Deskripsi Sistem 3" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('deskripsi_sistem3')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('deskripsi_sistem3');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Tambah</button>
                                    <a href="<?=base_url('simta/pengajuanjudul');?>" class="btn btn-warning">Kembali</a>
                                </form>
                            <?php endif; ?>
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
<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer'); ?>