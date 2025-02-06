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
                <h2 class="page-title">Form Edit Pertanyaan UAS MBKM</h2>
                <div class="row my-4">
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title"></strong>
                            </div>
                            <div class="card-body">
                                <form method="POST"
                                    action="<?=base_url('mbkm/pertanyaan/update_uas/' . $pertanyaanUas->id_pertanyaan_uas)?>">
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Pertanyaan</label>
                                        <textarea type="text" id="address-wpalaceholder" name="pertanyaan"
                                            class="form-control" placeholder=""
                                            value="<?= $pertanyaanUas->pertanyaan ?>"><?= $pertanyaanUas->pertanyaan ?> </textarea>
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('pertanyaan')) { ?>
                                        <div class='alert alert-danger mt-2'>
                                            <?= $error = $validation->getError('pertanyaan'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="simple-select2">Mata Kuliah</label>
                                        <select class="form-control select2" name="nama_mata_kuliah"
                                            id="simple-select2">
                                            <?php foreach($matkul as $m): ?>
                                            <option value="<?= $m->nama_mata_kuliah ?>"
                                                <?= $pertanyaanUas->nama_mata_kuliah == $m->nama_mata_kuliah ? 'selected' : null ?>>
                                                <?= $m->nama_mata_kuliah ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <!-- Error Validation -->
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="example-select1">Jenis Penilai</label>
                                        <select name="jenis_penilai"
                                            class="form-control select2 <?= ($validation->hasError('jenis_penilai')) ? 'is-invalid' : ''; ?>"
                                            id="simple-select1">
                                            <option>Pilih Jenis Penilai</option>
                                            <option value="dosen"
                                                <?= $pertanyaanUas->jenis_penilai == 'dosen' ? 'selected' : ''; ?>>Dosen
                                            </option>
                                            <option value="mitra"
                                                <?= $pertanyaanUas->jenis_penilai == 'mitra' ? 'selected' : ''; ?>>Mitra
                                            </option>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('jenis_penilai'); ?>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary" type="submit">
                                        Edit
                                    </button>
                                    <a href="<?=base_url('mbkm/pertanyaan/uas');?>" class="btn btn-warning">Kembali</a>
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