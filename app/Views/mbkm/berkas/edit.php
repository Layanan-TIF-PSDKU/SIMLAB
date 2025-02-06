<?php echo $this->include('mbkm/mbkm_partial/dashboard/header'); ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/top_menu'); ?>
<?php if (has_permission('admin')): ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else: ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/side_menu') ?>
<?php endif;?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Edit Data Berkas</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form method="POST"
                                    action="<?= base_url('mbkm/berkas/update/' . $berkas->id_berkas); ?>"
                                    enctype="multipart/form-data">
                                    <?= csrf_field(); ?>

                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nama Berkas</label>
                                        <input type="text" id="address-wpalaceholder" name="nama_berkas"
                                            class="form-control" placeholder="Masukkan Nama Bidang"
                                            value="<?= $berkas->nama_berkas ?>" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('nama_berkas')) { ?>
                                        <div class='alert alert-danger mt-2'>
                                            <?= $error = $validation->getError('nama_berkas'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="example-select1">Jenis Berkas</label>
                                        <select name="jenis"
                                            class="form-control select2 <?= ($validation->hasError('jenis')) ? 'is-invalid' : ''; ?>"
                                            id="simple-select1">
                                            <option>Pilih Jenis Penilai</option>
                                            <option value="pendaftaran"
                                                <?= $berkas->jenis == 'pendaftaran' ? 'selected' : ''; ?>>
                                                Pendaftaran
                                            </option>
                                            <option value="informasi"
                                                <?= $berkas->jenis == 'informasi' ? 'selected' : ''; ?>>
                                                Informasi
                                            </option>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('jenis'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="customFile">Upload Berkas</label>
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input  <?= ($validation->hasError('file_berkas')) ? 'is-invalid' : ''; ?>"
                                                id="customFile" name="file_berkas">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <a href="<?= base_url('mbkm/berkas'); ?>" class="btn btn-warning">Kembali</a>
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