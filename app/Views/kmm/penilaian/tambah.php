<?= $this->include('master_partial/dashboard/header'); ?>
<?= $this->include('kmm/kmm_partial/dashboard/top_menu'); ?>
<?php if(has_permission('admin')) : ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>
<?php elseif(has_permission('mitra')) : ?>
<?= $this->include('mitra/mitra_partial/dashboard/side_menu'); ?>
<?php else : ?>
<?= $this->include('kmm/kmm_partial/dashboard/side_menu'); ?>
<?php endif; ?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-8">
                        <h2 class="mt-2 page-title">Halaman Penilaian Kegiatan Magang Mahasiswa</h2>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <?php if(has_permission('admin')): ?>
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                            <?php elseif(has_permission('mitra')): ?>
                            <li class="breadcrumb-item"><a href="<?= base_url('mitra/dashboard') ?>">Dashboard</a></li>
                            <?php else: ?>
                            <li class="breadcrumb-item"><a href="<?= base_url('kmm') ?>">Dashboard</a></li>
                            <?php endif; ?>
                            <li class="breadcrumb-item active">KMM</a></li>
                            <li class="breadcrumb-item active">Penilaian KMM</li>
                        </ol>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form method="POST" action="<?= base_url('kmm/penilaian/mitra/' . $kmm->id_kmm); ?>"
                                    enctype="multipart/form-data">
                                    <?= csrf_field(); ?>
                                    <input class="form-control" type="hidden" class="form-control" name="id_kmm"
                                        value="<?= $kmm->id_kmm ?>">

                                    <div class="form-group">
                                        <?php foreach ($pertanyaan_mtr as $mtr) { ?>
                                        <input type="hidden" name="id_pertanyaan[]" value="<?= $mtr->id_pertanyaan ?>">
                                        <label class="mt-2"><?= ($mtr->id_pertanyaan) ? $mtr->pertanyaan : '' ?></label>
                                        <input type="number" name="nilai[]" min="0" max="<?= $mtr->nilai_maks ?>"
                                            class="form-control <?= ($validation->hasError('nilai')) ? 'is-invalid' : ''; ?>"
                                            required>
                                        <div class="invalid-feedback mb-3">
                                            <?= $validation->getError('nilai'); ?>
                                        </div>
                                        <div class="text-danger">* Skala Nilai 0 - 100</div>
                                        <?php } ?>
                                    </div>

                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <a href="<?= base_url('kmm/penilaian'); ?>" class="btn btn-warning">Kembali</a>
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