<?php echo $this->include('master_partial/dashboard/header'); ?>
<?php echo $this->include('master_partial/dashboard/top_menu'); ?>
<?php echo $this->include('master_partial/dashboard/side_menu'); ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Form Edit Data Mata Kuliah</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form method="POST" action="<?=base_url("mata-kuliah/update/" . $matakuliah->id_mata_kuliah)?>">
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Kode Mata Kuliah</label>
                                        <input type="text" id="address-wpalaceholder" name="kode_mata_kuliah" class="form-control <?php if ($validation->getError('kode_mata_kuliah')): ?>is-invalid <?php endif?>" placeholder="Masukkan Kode Mata Kuliah" value="<?=$matakuliah->kode_mata_kuliah?>"/>
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('kode_mata_kuliah')) {?>
                                            <div class='invalid-feedback'>
                                                <?=$error = $validation->getError('kode_mata_kuliah');?>
                                            </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nama Mata Kuliah</label>
                                        <input type="text" id="address-wpalaceholder" name="nama_mata_kuliah" class="form-control <?php if ($validation->getError('nama_mata_kuliah')): ?>is-invalid <?php endif?>" placeholder="Masukkan Nama Mata Kuliah" value="<?=$matakuliah->nama_mata_kuliah?>"/>
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('nama_mata_kuliah')) {?>
                                            <div class='invalid-feedback'>
                                                <?=$error = $validation->getError('nama_mata_kuliah');?>
                                            </div>
                                        <?php }?>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="simple-select-2">Semester</label>
                                        <select class="form-control select2 <?php if ($validation->getError('semester')): ?>is-invalid <?php endif?>" name="semester" id="simple-select-2">
                                            <option value="">Pilih Semester</option>
                                            <option value="1" <?=$matakuliah->semester == '1' ? 'selected' : ''?>>1</option>
											<option value="2" <?=$matakuliah->semester == '2' ? 'selected' : ''?>>2</option>
											<option value="3" <?=$matakuliah->semester == '3' ? 'selected' : ''?>>3</option>
											<option value="4" <?=$matakuliah->semester == '4' ? 'selected' : ''?>>4</option>
											<option value="5" <?=$matakuliah->semester == '5' ? 'selected' : ''?>>5</option>
											<option value="6" <?=$matakuliah->semester == '6' ? 'selected' : ''?>>6</option>
                                        </select>
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('semester')) {?>
                                            <div class='invalid-feedback'>
                                                <?=$error = $validation->getError('semester');?>
                                            </div>
                                            <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">SKS</label>
                                        <input type="number" min="1" max="8" id="address-wpalaceholder" name="sks" class="form-control <?php if ($validation->getError('sks')): ?>is-invalid <?php endif?>" value="<?=$matakuliah->sks?>" placeholder="Masukkan Jumlah SKS" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('sks')): ?>
                                                <div class="invalid-feedback">
                                                    <?=$validation->getError('sks')?>
                                                </div>
                                                <?php endif;?>
                                    </div>
                                    <div class="form-group mb-3">
                                    <label for="simple-select-2">Jenis Mata Kuliah</label>
                                        <select class="form-control select2 <?php if ($validation->getError('jenis')): ?>is-invalid <?php endif?>" name="jenis" id="simple-select-2">
                                            <option value="">Pilih Jenis Mata Kuliah</option>
                                            <option value="Teori" <?=$matakuliah->jenis == 'Teori' ? 'selected' : ''?>>Teori</option>
											<option value="Praktik" <?=$matakuliah->jenis == 'Praktik' ? 'selected' : ''?>>Praktik</option>
                                        </select>
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('jenis')): ?>
                                                <div class="invalid-feedback">
                                                    <?=$validation->getError('jenis')?>
                                                </div>
                                                <?php endif;?>
                                    </div>
                                    <button class="btn btn-primary" type="submit">
                                        Edit
                                    </button>
                                    <a href="<?=base_url('mata-kuliah');?>" class="btn btn-warning">Kembali</a>
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