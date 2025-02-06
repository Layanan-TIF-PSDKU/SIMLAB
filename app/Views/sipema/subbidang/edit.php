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
                        <h2 class="page-title">Form Edit Sub Bidang</h2>
                    </div>
                    <?php if(has_permission('admin')) : ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Sipema</a></li>
                                <li class="breadcrumb-item active">Edit Sub Bidang</li>
                            </ol>
                        </div>
                    <?php else : ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url('sipema') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Edit Sub Bidang</li>
                            </ol>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form class="needs-validation" novalidate method="POST" action="<?= base_url('sipema/sub-bidang/update/' . $subbidang->id_sub_bidang) ?>">
                                    <div class="form-group mb-3">
                                        <label for="simple-select1">Nama Bidang</label>
                                        <select class="form-control select2" name="id_bidang" id="simple-select1">
                                            <?php foreach($bidang as $b): ?>    
                                            <option value="<?= $b->id_bidang ?>"<?= $subbidang->id_bidang == $b->id_bidang ? 'selected' : null ?>><?= $b->nama_bidang ?></option>
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
                                        <input type="text" id="address-wpalaceholder" name="nama_sub_bidang" class="form-control" placeholder="Masukkan Nama Bidang" value="<?= $subbidang->nama_sub_bidang ?>"/>
                                       <!-- Error Validation -->
                                       <?php if ($validation->getError('nama_sub_bidang')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('nama_sub_bidang'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="simple-select2">Nama Dosen Kesesuaian Sub Bidang</label>
                                        <select class="form-control select2" name="id_staf[]" id="simple-select2" multiple required>
                                            <?php foreach($staf as $s): ?>    
                                                <option value="<?= $s->id_staf ?>"<?= in_array($s->id_staf, $id_staf) ? 'selected' : null ?>><?= $s->nama ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <button id="editButton" class="btn btn-primary" type="submit">
                                        Edit
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
        document.getElementById('editButton').addEventListener('click', function() {
            document.getElementById('loadingOverlay').classList.add('active');
        });
    </script>
</main>
<?php echo $this->include('sipema/sipema_partial/dashboard/footer');?>