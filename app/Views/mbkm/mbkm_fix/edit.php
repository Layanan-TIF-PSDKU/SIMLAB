<?php echo $this->include('mbkm/mbkm_partial/dashboard/header'); ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/top_menu'); ?>
<?php if (has_permission('admin')): ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else: ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/side_menu') ?>
<?php endif;?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Edit Data MBKM Berjalan</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form method="POST"
                                    action="<?= base_url('mbkm/mbkmFix/update/' . $mbkmFix->id_mbkm_fix); ?>"
                                    enctype="multipart/form-data">
                                    <?= csrf_field(); ?>
                                    <?php if(has_permission('admin')) : ?>
                                    <div class="form-group mb-3">
                                        <label for="simple-select1">Nama Mahasiswa</label>
                                        <select name="id_mhs"
                                            class="form-control select2 <?= ($validation->hasError('id_mhs')) ? 'is-invalid' : ''; ?>">
                                            <option>Pilih Mahasiswa</option>
                                            <?php foreach ($mahasiswa as $m) : ?>
                                            <option value="<?= $m->id_mhs ?>"
                                                <?= ($mbkmFix->id_mhs) == $m->id_mhs ? 'selected' : '' ?>>
                                                <?= $m->nama ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <?php else: ?>
                                    <input class="form-control" type="hidden" class="form-control" name="id_mhs"
                                        value="<?= $mhs[0]->id_mhs ?>">
                                    <?php endif; ?>
                                    <div class="form-group mb-3">
                                        <label for="example-select">Nama Dosen Pembimbing</label>
                                        <select name="id_staf"
                                            class="form-control select2 <?= ($validation->hasError('id_staf')) ? 'is-invalid' : ''; ?>">
                                            <option>Pilih Dosen Pembimbing</option>
                                            <?php foreach ($staf as $s) : ?>
                                            <option value="<?= $s->id_staf ?>"
                                                <?= ($mbkmFix->id_staf) == $s->id_staf ? 'selected' : '' ?>>
                                                <?= $s->nama ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('id_staf'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="example-select">Nama Instansi</label>
                                        <select name="id_mitra"
                                            class="form-control select2 <?= ($validation->hasError('id_mitra')) ? 'is-invalid' : ''; ?>">
                                            <option>Pilih Instansi</option>
                                            <?php foreach ($mitra as $s) : ?>
                                            <option value="<?= $s->id_mitra ?>"
                                                <?= ($mbkmFix->id_mitra) == $s->id_mitra ? 'selected' : '' ?>>
                                                <?= $s->nama_instansi ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('id_mitra'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="customFile">LoA/Bukti</label>
                                        <input type="file"
                                            class="form-control <?= ($validation->hasError('bukti')) ? 'is-invalid' : ''; ?>"
                                            name="bukti">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('bukti'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="customFile">Laporan Akhir</label>
                                        <input type="file"
                                            class="form-control <?= ($validation->hasError('lap_akhir')) ? 'is-invalid' : ''; ?>"
                                            name="lap_akhir">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('lap_akhir'); ?>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <a href="<?= base_url('mbkm/mbkmFix'); ?>" class="btn btn-warning">Kembali</a>
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

<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer'); ?>