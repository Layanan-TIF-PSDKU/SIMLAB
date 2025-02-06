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
                        <h2 class="mt-2 page-title">Halaman Edit Berkas Tugas Akhir</h2>
                    </div>
                <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">SIMTA</a></li>
                            <li class="breadcrumb-item active">Edit Berkas Tugas Akhir</li>
                        </ol>
                    </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">SIMTA</a></li>
                            <li class="breadcrumb-item active">Edit Berkas Tugas Akhir</li>
                        </ol>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="row my-4">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form method="POST"
                                    action="<?= base_url('simta/berkas/update/' . $berkas->id_berkas); ?>"
                                    enctype="multipart/form-data">
                                    <?= csrf_field(); ?>

                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nama Berkas<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="nama_berkas"
                                            class="form-control" placeholder="Masukkan Nama Berkas"
                                            value="<?= $berkas->nama_berkas ?>" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('nama_berkas')) { ?>
                                        <div class='alert alert-danger mt-2'>
                                            <?= $error = $validation->getError('nama_berkas'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="simple-select2">Kategori<span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="kategori"
                                            id="simple-select2">
                                            <option value="">Pilih Kategori</option>
                                            <option value="Laporan"
                                                <?= $berkas->kategori == 'Laporan' ? 'selected' : ''?>>
                                                Laporan</option>
                                            <option value="Ujian Proposal"
                                                <?= $berkas->kategori == 'Ujian Proposal' ? 'selected' : ''?>>
                                                Ujian Proposal</option>
                                            <option value="Seminar Hasil"
                                                <?= $berkas->kategori == 'Seminar Hasil' ? 'selected' : ''?>>
                                                Seminar Hasil</option>
                                            <option value="Ujian Tugas Akhir"
                                                <?= $berkas->kategori == 'Ujian Tugas Akhir' ? 'selected' : ''?>>
                                                Ujian Tugas Akhir</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Keterangan<span class="text-danger">*</span></label>
                                        <input type="text" id="address-wpalaceholder" name="keterangan"
                                            class="form-control" placeholder="Masukkan Keterangan"
                                            value="<?= $berkas->keterangan ?>" />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('keterangan')) { ?>
                                        <div class='alert alert-danger mt-2'>
                                            <?= $error = $validation->getError('keterangan'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="customFile">Upload Berkas<span class="text-danger">*</span></label>
                                        <input type="file"
                                            class="form-control <?= ($validation->hasError('file_berkas')) ? 'is-invalid' : ''; ?>"
                                            name="file_berkas">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('file_berkas'); ?>
                                        </div>
                                        <div class="text-danger">
                                            * File berupa pdf (Max. 5Mb)
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <a href="<?= base_url('simta/berkas'); ?>" class="btn btn-warning">Kembali</a>
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