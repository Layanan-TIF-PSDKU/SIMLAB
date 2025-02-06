<?php echo $this->include('mbkm/mbkm_partial/dashboard/header');?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/top_menu');?>
<?php if(has_permission('admin')) : ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else : ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/side_menu') ?>
<?php endif; ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Form Tambah Pemberkasan</h2>
                <div class="row my-4">
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title"></strong>
                            </div>
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data"
                                    action="<?=base_url("mbkm/berkas/simpan")?>"> <?=csrf_field();?>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nama Berkas</label>
                                        <input type="text" id="address-wpalaceholder" name="nama_berkas"
                                            class="form-control" placeholder="" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('nama_berkas')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('nama_berkas');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="simple-select1">Jenis Berkas</label>
                                        <select class="form-control select2" name="jenis" id="simple-select1" required>
                                            <option>Pilih Jenis Berkas</option>
                                            <option value="pendaftaran" <?= set_select('jenis', 'pendaftaran') ?>>
                                                Pendftaran
                                            </option>
                                            <option value="informasi" <?= set_select('jenis', 'informasi') ?>>Informasi
                                            </option>
                                        </select>

                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('jenis')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('jenis');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="customFile">Upload Berkas (PDF)</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile"
                                                name="file_berkas" required>
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">
                                        Tambah
                                    </button>
                                    <a href="<?=base_url('mbkm/berkas');?>" class="btn btn-warning">Kembali</a>
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
<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer'); ?>