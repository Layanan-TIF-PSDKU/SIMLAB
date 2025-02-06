<?php echo $this->include('master_partial/dashboard/header');?>
<?php echo $this->include('kmm/kmm_partial/dashboard/top_menu');?>
<?php if(has_permission('admin')): ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>
<?php else: ?>
<?= $this->include('kmm/kmm_partial/dashboard/side_menu'); ?>
<?php endif; ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-8">
                        <h2 class="mt-2 page-title">Halaman Edit Dokumen Pendukung KMM</h2>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">KMM</a></li>
                            <li class="breadcrumb-item active">Dokumen Pendukung KMM</li>
                        </ol>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data"
                                    action="<?=base_url("kmm/berkas/update/" . $berkas->id_berkas)?>">
                                    <?=csrf_field();?>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Dokumen Pendukung <span
                                                class="text-danger">*</span></label>
                                        <input type="file" name="berkas"
                                            class="form-control <?= ($validation->hasError('berkas')) ? 'is-invalid' : ''; ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('berkas'); ?>
                                        </div>
                                        <div class="text-danger">
                                            <span>*</span> File berupa pdf (Max. 5Mb)
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Keterangan Berkas <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control <?= ($validation->hasError('ket_berkas')) ? 'is-invalid' : ''; ?>"
                                            name="ket_berkas" value="<?= $berkas->ket_berkas ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('ket_berkas'); ?>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <a href="<?=base_url('kmm/berkas');?>" class="btn btn-warning">Kembali</a>
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
<?php echo $this->include('master_partial/dashboard/footer'); ?>