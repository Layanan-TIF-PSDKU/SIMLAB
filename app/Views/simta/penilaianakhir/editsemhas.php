<?php echo $this->include('simta/simta_partial/dashboard/header'); ?>
<?php echo $this->include('simta/simta_partial/dashboard/top_menu'); ?>
<?php if (has_permission('admin')): ?>
    <?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else: ?>
    <?php echo $this->include('simta/simta_partial/dashboard/side_menu') ?>
<?php endif; ?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="mt-2 page-title">Halaman Tambah Data Penilaian Akhir Tugas Akhir</h2>
                    </div>
                    <?php if (has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</li>
                                <li class="breadcrumb-item active">Tambah Penilaian Akhir</li>
                            </ol>
                        </div>
                    <?php elseif (has_permission('mahasiswa')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</li>
                                <li class="breadcrumb-item active">Tambah Penilaian Akhir</li>
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
                                <form method="POST" action="<?= base_url('simta/penilaianakhir/updatesemhas/' . $ujianproposal->id_ujianproposal); ?>"
                                    enctype="multipart/form-data">
                                    <?= csrf_field(); ?>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nilai Seminar Hasil</label>
                                        <input type="number" step="0.01" id="address-wpalaceholder" name="nilai_seminarhasil"
                                            class="form-control" placeholder="Contoh : 10%" 
                                            />
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('nilai_seminarhasil')) { ?>
                                        <div class='alert alert-danger mt-2'>
                                            <?= $error = $validation->getError('nilai_seminarhasil'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <?php if (has_permission('admin')) : ?>
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                    <?php endif; ?>
                                    <a href="<?= base_url('simta/penilaianakhir'); ?>" class="btn btn-warning">Kembali</a>
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
