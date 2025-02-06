<?php echo $this->include('sipema/sipema_partial/dashboard/header');?>
<?php echo $this->include('sipema/sipema_partial/dashboard/top_menu');?>
<?php if(has_permission('admin')) : ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else : ?>
<?php echo $this->include('sipema/sipema_partial/dashboard/side_menu') ?>
<?php endif; ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Form Tambah Nilai Mata Kuliah Mahasiswa</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form method="POST" action="<?= base_url('sipema/pemetaan_mata_kuliah/tambah_detail_pemetaan_mata_kuliah/'. $detail_pemetaan_mata_kuliah->id_sub_bidang) ?>">
                                    <div class="form-group mb-3">
                                        <label>Nama Mahasiswa</label>
                                        <select class="form-control select2" name="id_mhs" id="id_mhs">
                                            <option value="">Pilih Nama Mahasiswa</option>
                                            <?php foreach($mahasiswa as $mhs): ?>
                                            <option value="<?= $mhs->id_mhs ?>"><?= $mhs->nama ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                         <!-- Error Validation -->
                                         <?php if ($validation->getError('id_mhs')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('id_mhs'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Nama Mata Kuliah</label>
                                        <select class="form-control select2" name="id_mata_kuliah" id="id_mata_kuliah">
                                            <option value="">Pilih Mata Kuliah</option>
                                        </select>
                                         <!-- Error Validation -->
                                         <?php if ($validation->getError('id_mata_kuliah')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('id_mata_kuliah'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nilai UTS</label>
                                        <input type="number" id="address-wpalaceholder" name="nilai_uts" class="form-control" placeholder="Masukkan Nilai UTS" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('nilai_uts')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('nilai_uts'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nilai UAS</label>
                                        <input type="number" id="address-wpalaceholder" name="nilai_uas" class="form-control" placeholder="Masukkan Nilai UAS" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('nilai_uas')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('nilai_uas'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <button id="tambahButton" class="btn btn-primary" type="submit">
                                        Tambah
                                    </button>
                                    <a href="<?= base_url('sipema/pemetaan_mata_kuliah'); ?>" class="btn btn-warning">Kembali</a>
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
    <script>
        document.getElementById('tambahButton').addEventListener('click', function() {
            document.getElementById('loadingOverlay').classList.add('active');
        });
    </script>
</main>
<?php echo $this->include('sipema/sipema_partial/dashboard/footer');?>