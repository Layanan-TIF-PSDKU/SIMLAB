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
                <h2 class="page-title">Form Tambah Rekomendasi Mahasiswa</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form method="POST" action="<?= base_url("sipema/rekomendasi/simpan") ?>">
                                    <div class="form-group mb-3">
                                        <label for="simple-select-3">Nama Sub Bidang</label>
                                        <select class="form-control select2" name="id_sub_bidang" id="simple-select-1">
                                            <option value="">Pilih Sub Bidang</option>
                                            <?php foreach($sub_bidang as $sb): ?>
                                            <option value="<?= $sb->id_sub_bidang ?>"><?= $sb->nama_sub_bidang ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                         <!-- Error Validation -->
                                         <?php if ($validation->getError('id_sub_bidang')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('id_sub_bidang'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="simple-select-2">Nama Mahasiswa</label>
                                        <select class="form-control select2" name="id_mhs" id="simple-select-2">
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
                                        <label for="simple-select-3">Dosen Pemberi Rekomendasi</label>
                                        <input type="hidden" class="form-control" name="id_staf" id="id_staf">
                                        <input type="text" class="form-control" id="nama_dosen" readonly>
                                    </div>
                                    <button id="tambahButton" class="btn btn-primary" type="submit">
                                        Tambah
                                    </button>
                                    <a href="<?= base_url('sipema/rekomendasi'); ?>" class="btn btn-warning">Kembali</a>
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