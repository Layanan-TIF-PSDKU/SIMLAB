<?= $this->include('master_partial/dashboard/header'); ?>
<?= $this->include('kmm/kmm_partial/dashboard/top_menu'); ?>
<?php if(has_permission('admin')) : ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>
<?php elseif(has_permission('mitra')) : ?>
<?= $this->include('mitra/mitra_partial/dashboard/side_menu'); ?>
<?php else: ?>
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
                            <li class="breadcrumb-item"><a href="<?= base_url('kmm') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">KMM</a></li>
                            <li class="breadcrumb-item active">Penilaian KMM</li>
                        </ol>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form method="POST" action="<?= base_url('kmm/penilaian/dosen/' . $kmm->id_kmm); ?>"
                                    enctype="multipart/form-data">
                                    <?= csrf_field(); ?>
                                    <input class="form-control" type="hidden" class="form-control" name="id_kmm"
                                        value="<?= $kmm->id_kmm ?>">

                                    <div class="form-group mb-3">
                                        <?php foreach ($pertanyaan_dsn as $dsn) { ?>
                                        <input type="hidden" name="id_pertanyaan[]" value="<?= $dsn->id_pertanyaan ?>">
                                        <label class="my-1"><?= ($dsn->id_pertanyaan) ? $dsn->pertanyaan : '' ?></label>
                                        <input type="number" name="nilai[]" min="0" max="<?= $dsn->nilai_maks ?>"
                                            class="form-control <?= ($validation->hasError('nilai')) ? 'is-invalid' : ''; ?>"
                                            required>
                                        <div class="invalid-feedback mb-3">
                                            <?= $validation->getError('nilai'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <!-- <div class="text-danger my-2">Skala Total Nilai 0 - 100</div> -->

                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <a href="<?= base_url('kmm/penilaian'); ?>" class="btn btn-warning">Kembali</a>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-center"><strong>Ketentuan Penilaian</strong></h5>
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr class="text-center">
                                            <th><strong>Indikator Penilaian</strong></th>
                                            <th><strong>Nilai Maksimum</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($pertanyaan_dsn as $p) {
                                        ?>
                                        <tr>
                                            <td><?= $p->pertanyaan ?></td>
                                            <td class="text-center"><?= $p->nilai_maks ?></td>
                                        </tr>
                                        <?php } ?>
                                        <?php
                                            foreach ($nilai_maks_pertanyaan as $n) {
                                                ?>
                                        <tr class="text-center">
                                            <td><strong>Jumlah</strong></td>
                                            <td><?= $n->nilai_maks ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
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