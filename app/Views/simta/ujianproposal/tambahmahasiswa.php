<?php echo $this->include('simta/simta_partial/dashboard/header');?>
<?php echo $this->include('simta/simta_partial/dashboard/top_menu');?>
<?php if(has_permission('admin')) : ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else : ?>
<?php echo $this->include('simta/simta_partial/dashboard/side_menu') ?>
<?php endif; ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Form Tambah Data Ujian Proposal</h2>
                <div class="row my-4">
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title"></strong>
                            </div>
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data"
                                    action="<?=base_url("simta/ujianproposal/simpanmahasiswa")?>"> 
                                    <?=csrf_field();?>

                                    <div class="form-group mb-3">
                                        <label for="simple-select2">Nama Mahasiswa</label>
                                        <select name="id_mhs"
                                            class="form-control select2 <?= ($validation->hasError('id_mhs')) ? 'is-invalid' : ''; ?>">
                                            <option>Pilih Nama Mahasiswa</option>
                                            <?php foreach ($mahasiswa as $mhs) : ?>
                                            <option value="<?= $mhs->id_mhs ?>"><?= $mhs->nama ?>
                                            </option>
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
                                        <label for="example-select">Nama Dosen Penguji</label>
                                        <select name="id_staf"
                                            class="form-control select2 <?= ($validation->hasError('id_staf')) ? 'is-invalid' : ''; ?>">
                                            <option>Pilih Dosen Pembimbing</option>
                                            <?php foreach ($staf as $s) : ?>
                                            <option value="<?= $s->id_staf ?>"><?= $s->nama ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('id_staf'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Judul Tugas Akhir</label>
                                        <input type="text" id="address-wpalaceholder" name="nama_judul"
                                            class="form-control" placeholder="Copy Paste Proposal Tugas Akhir" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('nama_judul')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('nama_judul');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Deskripsi Sistem</label>
                                        <input type="text" id="address-wpalaceholder" name="deskripsi_sistem"
                                            class="form-control" placeholder="Copy Paste Proposal Tugas Akhir" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('deskripsi_sistem')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('deskripsi_sistem');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Tanggal Ujian</label>
                                        <input type="datetime" id="address-wpalaceholder" name="tanggal"
                                            class="form-control" placeholder="" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('tanggal')) {?>
                                        <div class='alert alert-danger mt-2'>
                                            <?=$error = $validation->getError('tanggal');?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="customFile">Proposal</label>
                                        <input type="file"
                                            class="form-control <?= ($validation->hasError('proposalawal')) ? 'is-invalid' : ''; ?>"
                                            name="proposalawal">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('proposalawal'); ?>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">
                                        Tambah
                                    </button>
                                    <a href="<?=base_url('simta/ujianproposal');?>" class="btn btn-warning">Kembali</a>
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
<?php echo $this->include('simta/simta_partial/dashboard/footer'); ?>