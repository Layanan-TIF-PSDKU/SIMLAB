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
                <h2 class="page-title">Form Edit Monitoring</h2>
                <div class="row my-4">
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title"></strong>
                            </div>
                            <div class="card-body">
                                <form method="POST"
                                    action="<?=base_url('mbkm/monitoring/simpan-dosen/' .  $mbkm->id_mbkm_fix)?>">
                                    <div class="form-group mb-3">
                                        <label for="simple-select1">Nama Mahasiswa</label>
                                        <select class="form-control select2" name="id_mhs" id="simple-select1">
                                            <?php foreach($mahasiswa as $m): ?>
                                            <option value="<?= $m->id_mhs ?>"
                                                <?= $monitoring->id_mhs == $m->id_mhs ? 'selected' : null ?>>
                                                <?= $m->nama ?></option>
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
                                        <label for="simple-select2">Nama Dosen</label>
                                        <select class="form-control select2" name="id_staf" id="simple-select2">
                                            <?php foreach($staf as $m): ?>
                                            <option value="<?= $m->id_staf ?>"
                                                <?= $monitoring->id_staf == $m->id_staf ? 'selected' : null ?>>
                                                <?= $m->nama ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('id_staf')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('id_staf');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Tanggal</label>
                                        <input type="date" id="address-wpalaceholder" name="tanggal"
                                            class="form-control" placeholder="" value="<?= $monitoring->tanggal ?>" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('tanggal')) { ?>
                                        <div class='alert alert-danger mt-2'>
                                            <?= $error = $validation->getError('tanggal'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Deskripsi Kegiatan</label>
                                        <textarea type="text" id="address-wpalaceholder" name="deskripsi"
                                            class="form-control" placeholder=""
                                            value=""><?= $monitoring->deskripsi ?> </textarea>
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('deskripsi')) { ?>
                                        <div class='alert alert-danger mt-2'>
                                            <?= $error = $validation->getError('deskripsi'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Feedback Dosen</label>
                                        <textarea type="text" id="address-wpalaceholder" name="feedback"
                                            class="form-control" placeholder=""
                                            value="<?= $monitoring->feedback ?>"><?= $monitoring->feedback ?> </textarea>
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('feedback')) { ?>
                                        <div class='alert alert-danger mt-2'>
                                            <?= $error = $validation->getError('feedback'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>

                                    <button class="btn btn-primary" type="submit">
                                        Edit
                                    </button>
                                    <a href="<?=base_url('mbkm/monitoring');?>" class="btn btn-warning">Kembali</a>
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