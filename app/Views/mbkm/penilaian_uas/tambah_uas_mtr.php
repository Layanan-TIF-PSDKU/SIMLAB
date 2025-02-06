<?= $this->include('master_partial/dashboard/header'); ?>
<?= $this->include('mbkm/mbkm_partial/dashboard/top_menu'); ?>
<?php if(has_permission('admin')) : ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>
<?php elseif(has_permission('dosen')) : ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/side_menu') ?>
<?php elseif(has_permission('mitra')) : ?>
<?= $this->include('mitra/mitra_partial/dashboard/side_menu'); ?>
<?php endif; ?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Penilaian UAS MBKM</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form method="POST"
                                    action="<?= base_url('mbkm/penilaian/uas/simpan/mitra/uas/' . $mbkm->id_mbkm_fix); ?>"
                                    enctype="multipart/form-data">
                                    <?= csrf_field(); ?>

                                    <input class="form-control" type="hidden" class="form-control" name="id_mbkm_fix"
                                        value="<?= $mbkm->id_mbkm_fix ?>">
                                    <div class="form-group">
                                        <?php foreach ($pertanyaan_mtr_uas as $p) { ?>
                                        <input type="hidden" name="id_pertanyaan_uas[]"
                                            value="<?= $p->id_pertanyaan_uas ?>">
                                        <?php if ($p->nama_mata_kuliah =='' ): ?>

                                        <label class="mt-2"><?= ($p->id_pertanyaan_uas) ? $p->pertanyaan : '' ?>
                                            ( Softskill )</label>
                                        <?php else: ?>

                                        <label class="mt-2"><?= ($p->id_pertanyaan_uas) ? $p->pertanyaan : '' ?>
                                            ( <?= $p->nama_mata_kuliah ?> )</label>

                                        <?php endif; ?>
                                        <input type="number" name="nilai[]"
                                            class="form-control <?= ($validation->hasError('nilai')) ? 'is-invalid' : ''; ?>">
                                        <div class="invalid-feedback mb-3">
                                            <?= $validation->getError('nilai'); ?>
                                        </div>
                                        <div class="text-danger">* Skala Nilai 0 - 100</div>
                                        <?php } ?>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <a href="<?= base_url('mbkm/penilaian/uas'); ?>" class="btn btn-warning">Kembali</a>
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