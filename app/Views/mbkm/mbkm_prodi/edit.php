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
                <h2 class="page-title">Edit Pendaftaran MBKM Prodi</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form method="POST"
                                    action="<?=base_url('mbkm/mbkmProdi/update/' . $mbkmProdi->id_mprodi);?>"
                                    enctype="multipart/form-data">
                                    <?=csrf_field();?>
                                    <?php if (has_permission('admin') || has_permission('koor-mbkm')): ?>
                                    <div class="form-group mb-3">
                                        <label for="simple-select1">Nama Mahasiswa</label>
                                        <select name="id_mhs"
                                            class="form-control select2 <?=($validation->hasError('id_mhs')) ? 'is-invalid' : '';?>">
                                            <option>Pilih Mahasiswa</option>
                                            <?php foreach ($mahasiswa as $m): ?>
                                            <option value="<?=$m->id_mhs?>"
                                                <?=($mbkmProdi->id_mhs) == $m->id_mhs ? 'selected' : ''?>><?=$m->nama?>
                                            </option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <?php else: ?>
                                    <input class="form-control" type="hidden" class="form-control" name="id_mhs"
                                        value="<?=$mhs[0]->id_mhs?>">
                                    <?php endif;?>
                                    <div class="form-group mb-3">
                                        <label for="example-select">Nama Dosen Pembimbing</label>
                                        <select name="id_staf"
                                            class="form-control select2 <?=($validation->hasError('id_staf')) ? 'is-invalid' : '';?>">
                                            <option>Pilih Dosen Pembimbing</option>
                                            <?php foreach ($staf as $s): ?>
                                            <option value="<?=$s->id_staf?>"
                                                <?=($mbkmProdi->id_staf) == $s->id_staf ? 'selected' : ''?>>
                                                <?=$s->nama?>
                                            </option>
                                            <?php endforeach;?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('id_staf');?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nama Instansi</label>
                                        <input type="text" id="address-wpalaceholder" name="nama_instansi"
                                            class="form-control" placeholder="Masukkan Nama Bidang"
                                            value="<?=$mbkmProdi->nama_instansi?>" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('nama_instansi')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('nama_instansi');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <?php if (has_permission('admin')|| has_permission('koor-mbkm')): ?>
                                    <div class="form-group mb-3">
                                        <label for="customFile">Upload Surat Rekomendasi</label>
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input  <?= ($validation->hasError('surat_rekom')) ? 'is-invalid' : ''; ?>"
                                                id="customFile" name="surat_rekom">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <a href="<?=base_url('mbkm/mbkmProdi');?>" class="btn btn-warning">Kembali</a>

                                    <?php elseif (has_permission('mahasiswa')): ?>
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <a href="<?=base_url('mbkm/mbkmProdi');?>" class="btn btn-warning">Kembali</a>
                                    <input type="file" type="hidden" name="surat_rekom"
                                        class="custom-file-input  <?= ($validation->hasError('surat_rekom')) ? 'is-invalid' : ''; ?>">
                                    <?php endif;?>


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