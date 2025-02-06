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
                <h2 class="page-title">Form Tambah Sub Bidang</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form method="POST" action="<?= base_url("sipema/sub-bidang/simpan") ?>">
                                    <div class="form-group mb-3">
                                        <label for="simple-select2">Nama Bidang</label>
                                        <select class="form-control select2" name="id_bidang" id="simple-select1">
                                            <option value="">Pilih Bidang</option>
                                            <?php foreach($bidang as $b): ?>
                                            <option value="<?= $b->id_bidang ?>"><?= $b->nama_bidang ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                         <!-- Error Validation -->
                                         <?php if ($validation->getError('id_bidang')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('id_bidang'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address-wpalaceholder">Nama Sub Bidang</label>
                                        <input type="text" id="address-wpalaceholder" name="nama_sub_bidang"
                                            class="form-control" placeholder="Masukkan Nama Sub Bidang" />
                                         <!-- Error Validation -->
                                         <?php if ($validation->getError('nama_sub_bidang')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('nama_sub_bidang'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="simple-select2">Nama Dosen Kesesuaian Sub Bidang</label>
                                        <select class="form-control select2-multi" name="id_staf[]" id="simple-select2" multiple required>
                                            <option value="">Pilih Dosen Kesesuaian Sub Bidang</option>
                                            <?php foreach($staf as $s): ?>
                                            <option value="<?= $s->id_staf ?>"><?= $s->nama ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <button id="tambahButton" class="btn btn-primary" type="submit">
                                        Tambah
                                    </button>
                                    <a href="<?= base_url('sipema/sub-bidang'); ?>" class="btn btn-warning">Kembali</a>
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