<?= $this->include('master_partial/dashboard/header'); ?>
<?= $this->include('kmm/kmm_partial/dashboard/top_menu'); ?>
<?php if(has_permission('admin')) : ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>
<?php else : ?>
<?= $this->include('kmm/kmm_partial/dashboard/side_menu'); ?>
<?php endif; ?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-8">
                        <h2 class="mt-2 page-title">Halaman Tambah Indikator Penilaian KMM</h2>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <?php if(has_permission('admin')): ?>
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                            <?php else: ?>
                            <li class="breadcrumb-item"><a href="<?= base_url('kmm') ?>">Dashboard</a></li>
                            <?php endif; ?>
                            <li class="breadcrumb-item active">KMM</a></li>
                            <li class="breadcrumb-item active">Indikator Penilaian KMM</li>
                        </ol>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form method="POST" action="<?= base_url('kmm/pertanyaan-penilaian/tambah/store'); ?>"
                                    enctype="multipart/form-data">
                                    <?= csrf_field(); ?>
                                    <div class="form-group mb-3">
                                        <label>Indikator Penilaian <span class="text-danger">*</span></label>
                                        <input type="text" name="pertanyaan"
                                            class="form-control <?= ($validation->hasError('pertanyaan')) ? 'is-invalid' : ''; ?>"
                                            value="<?= set_value('pertanyaan') ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('pertanyaan'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="example-select">Penilai <span class="text-danger">*</span></label>
                                        <select name="jenis_pertanyaan"
                                            class="form-control select2 <?= ($validation->hasError('jenis_pertanyaan')) ? 'is-invalid' : ''; ?>">
                                            <option>Pilih Penilai</option>
                                            <option value="dosen" <?= set_select('jenis_pertanyaan', 'dosen') ?>>Dosen
                                                (Prodi)</option>
                                            <option value="mitra" <?= set_select('jenis_pertanyaan', 'mitra') ?>>Mitra
                                            </option>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('jenis_pertanyaan'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Nilai Maksimum <span class="text-danger">*</span></label>
                                        <input type="number" name="nilai_maks"
                                            class="form-control <?= ($validation->hasError('nilai_maks')) ? 'is-invalid' : ''; ?>"
                                            value="<?= set_value('nilai_maks') ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nilai_maks'); ?>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <a href="<?= base_url('kmm/pertanyaan-penilaian'); ?>"
                                        class="btn btn-warning">Kembali</a>
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
<?= $this->include('master_partial/dashboard/footer'); ?>