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
                <h2 class="page-title">Form Tambah Pertanyaan UTS</h2>
                <div class="row my-4">
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title"></strong>
                            </div>
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data"
                                    action="<?=base_url("mbkm/pertanyaan/simpan")?>"> <?=csrf_field();?>

                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Pertanyaan</label>
                                        <textarea type="text-area" id="address-wpalaceholder" name="pertanyaan"
                                            class="form-control" placeholder=""></textarea>
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('pertanyaan')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('pertanyaan');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="simple-select2">Mata Kuliah </label>
                                        <select class="form-control select2" name="nama_mata_kuliah"
                                            id="simple-select2">
                                            <option value="">Pilih Mata Kuliah</option>
                                            <?php foreach ($matkul as $s): ?>
                                            <option value="<?=$s->nama_mata_kuliah?>"><?=$s->nama_mata_kuliah?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <div class="text-danger">
                                            * Optional
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="simple-select1">Penilai</label>
                                        <select class="form-control select2" name="jenis_penilai" id="simple-select1"
                                            required>
                                            <option>Pilih Penilai</option>
                                            <option value="dosen" <?= set_select('jenis_penilai', 'dosen') ?>>Dosen
                                            </option>
                                            <option value="mitra" <?= set_select('jenis_penilai', 'mitra') ?>>Mitra
                                            </option>
                                        </select>

                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('jenis_penilai')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('jenis_penilai');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <button class="btn btn-primary" type="submit">
                                        Tambah
                                    </button>
                                    <a href="<?=base_url('mbkm/pertanyaan/uts');?>" class="btn btn-warning">Kembali</a>
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