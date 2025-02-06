<?= $this->include('kmm/kmm_partial/dashboard/header'); ?>
<?= $this->include('kmm/kmm_partial/dashboard/top_menu'); ?>
<?= $this->include('kmm/kmm_partial/dashboard/side_menu'); ?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-8">
                        <h2 class="mt-2 page-title">Halaman Pengajuan Proposal KMM</h2>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('kmm') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">KMM</a></li>
                            <li class="breadcrumb-item active">Pengajuan Proposal KMM</li>
                        </ol>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <!-- <div class="card-header">
                                <strong class="card-title">Pengajuan Proposal KMM</strong>
                            </div> -->
                            <div class="card-body">
                                <form method="POST" action="<?= base_url('kmm/proposal/pengajuan/store'); ?>"
                                    enctype="multipart/form-data">
                                    <?= csrf_field(); ?>
                                    <input class="form-control" type="hidden" class="form-control" name="id_mhs"
                                        value="<?= $mahasiswa[0]->id_mhs ?>">
                                    <div class="form-group mb-3">
                                        <label for="example-select">Nama Dosen Pembimbing <span
                                                class="text-danger">*</span></label>
                                        <select name="id_staf"
                                            class="form-control select2 <?= ($validation->hasError('id_staf')) ? 'is-invalid' : ''; ?>">
                                            <option>Pilih Dosen Pembimbing</option>
                                            <?php foreach ($staf as $s) : ?>
                                            <option value="<?= $s->id_staf ?>"
                                                <?= set_select('id_staf', $s->id_staf) ?>><?= $s->nama ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('id_staf'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="example-select">Nama Instansi <span
                                                class="text-danger">*</span></label>
                                        <select name="id_mitra"
                                            class="form-control select2 <?= ($validation->hasError('id_mitra')) ? 'is-invalid' : ''; ?>">
                                            <option>Pilih Instansi</option>
                                            <?php foreach ($mitra as $mtr) : ?>
                                            <option value="<?= $mtr->id_mitra ?>"
                                                <?= set_select('id_mitra', $mtr->id_mitra) ?>><?= $mtr->nama_instansi ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('id_mitra'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="customFile">Proposal KMM Yang Diajukan <span
                                                class="text-danger">*</span></label>
                                        <input type="file"
                                            class="form-control <?= ($validation->hasError('proposal_awal')) ? 'is-invalid' : ''; ?>"
                                            name="proposal_awal">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('proposal_awal'); ?>
                                        </div>
                                        <div class="text-danger">* File berupa pdf (Max. 5Mb)</div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <a href="<?= base_url('kmm/proposal'); ?>" class="btn btn-warning">Kembali</a>
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

<?= $this->include('kmm/kmm_partial/dashboard/footer'); ?>