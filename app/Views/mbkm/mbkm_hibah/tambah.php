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
                <h2 class="page-title">Form Pendaftaran MBKM Hibah</h2>
                <div class="row my-4">
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title"></strong>
                            </div>
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data"
                                    action="<?=base_url("mbkm/hibah/simpan")?>"> <?=csrf_field();?>

                                    <?php if (has_permission('admin')|| has_permission('dosen')): ?>
                                    <div class="form-group mb-3">
                                        <label for="simple-select1">Nama Mahasiswa</label>
                                        <select class="form-control select2" name="id_mhs" id="simple-select1">
                                            <option value="">Daftar Mahasiswa</option>
                                            <?php foreach ($mahasiswa as $m): ?>
                                            <option value="<?=$m->id_mhs?>"><?=$m->nama?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('id_mhs')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('id_mhs');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <?php else: ?>
                                    <input class="form-control" type="hidden" class="form-control" name="id_mhs"
                                        value="<?= $mhs[0]->id_mhs ?>">
                                    <?php endif; ?>

                                    <div class="form-group mb-3">
                                        <label for="simple-select2">Nama Dosen</label>
                                        <select class="form-control select2" name="id_staf" id="simple-select2">
                                            <option value="">Pilih Dosen</option>
                                            <?php foreach ($staf as $s): ?>
                                            <option value="<?=$s->id_staf?>"><?=$s->nama?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('id_staf')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('id_staf');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nama Instansi/Mitra</label>
                                        <input type="text" id="address-wpalaceholder" name="nama_instansi"
                                            placeholder="cth: Gojek" class="form-control" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('nama_instansi')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('nama_instansi');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Judul Proposal</label>
                                        <input type="text" id="address-wpalaceholder" name="judul"
                                            placeholder="cth: development POS berbasis website " class="form-control" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('judul')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('judul');?>
                                        </div>
                                        <?php }?>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="customFile">Proposal</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" name="proposal"
                                                required>
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                        <div class="text-danger">
                                            * File berupa pdf (Max. 5Mb)
                                        </div>
                                    </div>

                                    <button class="btn btn-primary" type="submit">
                                        Tambah
                                    </button>
                                    <a href="<?=base_url('mbkm/hibah');?>" class="btn btn-warning">Kembali</a>
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