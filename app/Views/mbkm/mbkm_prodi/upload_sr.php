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
                <h2 class="page-title">Upload Berkas MBKM Prodi</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form method="POST"
                                    action="<?=base_url('mbkm/mbkmProdi/proses-upload-sr/' . $mbkmProdi->id_mprodi);?>"
                                    enctype="multipart/form-data">
                                    <?=csrf_field();?>

                                    <div class="form-group mb-3">
                                        <label for="customFile">Surat Rekomendasi</label>
                                        <input type="file"
                                            class="form-control <?=($validation->hasError('surat_rekom')) ? 'is-invalid' : '';?>"
                                            name="surat_rekom" required>
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('surat_rekom');?>
                                        </div>
                                        <div class="text-danger">
                                            * File berupa pdf (Max. 5Mb)
                                        </div>
                                    </div>

                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <a href="<?=base_url('mbkm/mbkmProdi');?>" class="btn btn-warning">Kembali</a>
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