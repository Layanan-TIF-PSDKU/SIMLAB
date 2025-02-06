<?php echo $this->include('simta/simta_partial/dashboard/header'); ?>
<?php echo $this->include('simta/simta_partial/dashboard/top_menu'); ?>
<?php if (has_permission('admin')): ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else: ?>
<?php echo $this->include('simta/simta_partial/dashboard/side_menu') ?>
<?php endif;?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="mt-2 page-title">Halaman Edit Tugas Akhir Terdahulu</h2>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Edit Tugas Akhir Terdahulu</li>
                            </ol>
                        </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Edit Tugas Akhir Terdahulu</li>
                            </ol>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <!-- table -->
                                <form method="POST" enctype="multipart/form-data"
                                    action="<?=base_url("simta/taterdahulu/update/" . $taterdahulu->id_taterdahulu)?>">
                                    <?=csrf_field(); ?>
                                    <div class="form-group mb-3">
                                        <label for="simple-select1">Nama Mahasiswa<span class="text-danger">*</span></label>
                                        <select name="id_mhs"
                                            class="form-control select2 <?= ($validation->hasError('id_mhs')) ? 'is-invalid' : ''; ?>">
                                            <option>Pilih Mahasiswa</option>
                                            <?php foreach ($mahasiswa as $m) : ?>
                                            <option value="<?= $m->id_mhs ?>"
                                                <?= ($taterdahulu->id_mhs) == $m->id_mhs ? 'selected' : '' ?>>
                                                <?= $m->nama ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('id_mhs'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="judul_ta">Judul Tugas Akhir<span class="text-danger">*</span></label>
                                        <input type="text" id="judul_ta" name="judul_ta"
                                            class="form-control <?=($validation->hasError('judul_ta')) ? 'is-invalid' : ''?>"
                                            value="<?=$taterdahulu->judul_ta?>"
                                            placeholder="Masukkan Judul Tugas Akhir" />
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('judul_ta');?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="abstrak">Abstrak<span class="text-danger">*</span></label>
                                        <input type="text" id="abstrak" name="abstrak"
                                            class="form-control <?=($validation->hasError('abstrak')) ? 'is-invalid' : ''?>"
                                            value="<?= $taterdahulu->abstrak ?>"
                                            placeholder="Masukkan Judul Tugas Akhir" />
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('abstrak');?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="customFile">Dokumen Tugas Akhir<span class="text-danger">*</span></label>
                                        <input type="file"
                                            class="form-control <?= ($validation->hasError('dokumen_ta')) ? 'is-invalid' : ''; ?>"
                                            name="dokumen_ta">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('dokumen_ta'); ?>
                                        </div>
                                        <div class="text-danger">
                                            * File berupa pdf (Max. 5Mb)
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Edit</button>
                                    <a href="<?=base_url('simta/taterdahulu');?>" class="btn btn-warning">Kembali</a>
                                </form>
                            </div>
                        </div>
                    </div> <!-- simple table -->
                </div> <!-- end section -->
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
</main>

<?php echo $this->include('simta/simta_partial/dashboard/footer'); ?>