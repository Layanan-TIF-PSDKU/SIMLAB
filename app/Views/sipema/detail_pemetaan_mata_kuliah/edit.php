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
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="page-title">Form Edit Detail Mata Kuliah Relevan</h2>
                    </div>
                    <?php if(has_permission('admin')) : ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Sipema</a></li>
                                <li class="breadcrumb-item active">Edit Pemetaan Mata Kuliah</li>
                            </ol>
                        </div>
                    <?php else : ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url('sipema') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Edit Pemetaan Mata Kuliah</li>
                            </ol>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form method="POST" action="<?= base_url('sipema/pemetaan_mata_kuliah/update_detail_pemetaan_mata_kuliah/'. $detail_pemetaan_mata_kuliah->id_sub_bidang . '/' . $detail_pemetaan_mata_kuliah->id_mata_kuliah); ?>">
                                    <div class="form-group mb-3">
                                        <label for="simple-select-3">Nama Sub Bidang</label>
                                        <input type="text" id="address-wpalaceholder" class="form-control" value="<?= $detail_pemetaan_mata_kuliah->nama_sub_bidang ?>" readonly/>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="simple-select-1">Nama Mata Kuliah</label>
                                        <select class="form-control select2" name="id_mata_kuliah" id="simple-select1">
                                            <option value="">Pilih Mata Kuliah</option>
                                            <?php foreach($mata_kuliah as $mk): ?>
                                                <option value="<?= $mk->id_mata_kuliah ?>"<?= $detail_pemetaan_mata_kuliah->id_mata_kuliah == $mk->id_mata_kuliah ? 'selected' : null ?>><?= $mk->nama_mata_kuliah ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                         <!-- Error Validation -->
                                         <?php if ($validation->getError('id_mata_kuliah')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('id_mata_kuliah'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="simple-select-2">Jenis Bobot</label>
                                        <select class="form-control select2" name="id_bobot" id="simple-select2">
                                            <option value="">Pilih Jenis Bobot</option>
                                            <?php foreach($bobot as $b): ?>
                                                <option value="<?= $b->id_bobot ?>"<?= $detail_pemetaan_mata_kuliah->id_bobot == $b->id_bobot ? 'selected' : null ?>><?= $b->jenis_bobot ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                         <!-- Error Validation -->
                                         <?php if ($validation->getError('id_bobot')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('id_bobot'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <button id="editButton" class="btn btn-primary" type="submit">
                                        Edit
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
        document.getElementById('editButton').addEventListener('click', function() {
            document.getElementById('loadingOverlay').classList.add('active');
        });
    </script>
</main>
<?php echo $this->include('sipema/sipema_partial/dashboard/footer');?>