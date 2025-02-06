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
                        <h2 class="mt-2 page-title">Halaman Pendaftaran Berkas Tugas Akhir</h2>
                    </div>
                <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">SIMTA</a></li>
                            <li class="breadcrumb-item active">Pendaftaran Berkas Tugas Akhir</li>
                        </ol>
                    </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">SIMTA</a></li>
                            <li class="breadcrumb-item active">Pendaftaran Berkas Tugas Akhir</li>
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
                                    action="<?=base_url("simta/berkas/simpan")?>"> <?=csrf_field();?>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nama Berkas<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="nama_berkas" class="form-control" placeholder="" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('nama_berkas')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('nama_berkas');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group" id="kategori">
                                        <label for="kategori">Nama Kategori</label>
                                        <div class="kategori">
                                            <select name="kategori" class="form-control">
                                                <option value="">Pilih Nama Kategori</option>
                                                <option value="Laporan">Laporan</option>
                                                <option value="Ujian Proposal">Ujian Proposal</option>
                                                <option value="Seminar Hasil">Seminar Hasil</option>
                                                <option value="Ujian Tugas Akhir">Ujian Tugas Akhir</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Keterangan<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="keterangan" class="form-control" placeholder="" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('keterangan')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('keterangan');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="customFile">File Berkas<span class="text-danger">*</span></label>
                                        <input type="file" class="form-control <?= ($validation->hasError('file_berkas')) ? 'is-invalid' : ''; ?>" name="file_berkas">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('file_berkas'); ?>
                                        </div>
                                        <div class="text-danger">
                                            * File berupa pdf (Max. 5Mb)
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">
                                        Tambah
                                    </button>
                                    <a href="<?=base_url('simta/berkas');?>" class="btn btn-warning">Kembali</a>
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