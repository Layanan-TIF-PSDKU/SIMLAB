<?= $this->include('kmm/kmm_partial/dashboard/header'); ?>
<?= $this->include('kmm/kmm_partial/dashboard/top_menu'); ?>
<?php if(has_permission('admin')) : ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>
<?php else : ?>
<?= $this->include('kmm/kmm_partial/dashboard/side_menu'); ?>
<?php endif; ?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="mt-2 page-title">Halaman Pendaftaran KMM</h2>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <?php if(has_permission('admin')): ?>
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                            <?php else: ?>
                            <li class="breadcrumb-item"><a href="<?= base_url('kmm') ?>">Dashboard</a></li>
                            <?php endif; ?>
                            <li class="breadcrumb-item active">KMM</a></li>
                            <li class="breadcrumb-item active">Pendaftaran KMM</li>
                        </ol>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form method="POST" action="<?= base_url('kmm/kmm/tambah/store'); ?>"
                                    enctype="multipart/form-data">
                                    <?= csrf_field(); ?>
                                    <?php if(has_permission('admin') || has_permission('koor-kmm')) : ?>
                                    <div class="form-group mb-3">
                                        <label for="simple-select1">Nama Mahasiswa <span
                                                class="text-danger">*</span></label>
                                        <select
                                            class="form-control select2 <?= ($validation->hasError('id_mhs')) ? 'is-invalid' : ''; ?>"
                                            name="id_mhs">
                                            <option value="">Pilih Mahasiswa</option>
                                            <?php foreach ($mahasiswa as $mhs) : ?>
                                            <option value="<?= $mhs->id_mhs ?>"
                                                <?= set_select('id_mhs', $mhs->id_mhs) ?>><?= $mhs->nama ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('id_mhs'); ?>
                                        </div>
                                        <div class="text-danger">
                                            * Nama mahasiswa ada apabila proposal KMM telah disetujui
                                        </div>
                                    </div>
                                    <?php else: ?>
                                    <input class="form-control" type="hidden" class="form-control" name="id_mhs"
                                        value="<?= $mhs[0]->id_mhs ?>">
                                    <?php endif; ?>
                                    <div class="form-group mb-3">
                                        <label for="example-select">Nama Dosen Pembimbing <span
                                                class="text-danger">*</span></label>
                                        <select name="id_staf"
                                            class="form-control select2 <?= ($validation->hasError('id_staf')) ? 'is-invalid' : ''; ?>">
                                            <option>Pilih Dosen Pembimbing</option>
                                            <?php foreach ($staf as $s) : ?>
                                            <option value="<?= $s->id_staf ?>"
                                                <?= set_select('id_staf', $s->id_staf) ?>><?= $s->nama ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('id_staf'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="example-select">Nama Instansi <span
                                                class="text-danger">*</span></label>
                                        <select name="id_mitra" id="simple-select2"
                                            class="form-control select2 <?= ($validation->hasError('id_mitra')) ? 'is-invalid' : ''; ?>">
                                            <option>Pilih Instansi</option>
                                            <?php foreach ($mitra as $mtr) : ?>
                                            <option value="<?= $mtr->id_mitra ?>"
                                                <?= set_select('id_mitra', $mtr->id_mitra) ?>>
                                                <?= $mtr->nama_instansi ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('id_mitra'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Tanggal Mulai KMM <span class="text-danger">*</span></label>
                                        <input type="date"
                                            class="form-control <?= ($validation->hasError('tgl_mulai')) ? 'is-invalid' : ''; ?>"
                                            name="tgl_mulai">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('tgl_mulai'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Tanggal Selesai KMM <span class="text-danger">*</span></label>
                                        <input type="date"
                                            class="form-control <?= ($validation->hasError('tgl_selesai')) ? 'is-invalid' : ''; ?>"
                                            name="tgl_selesai">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('tgl_selesai'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="customFile">Proposal KMM Yang Disetujui(Telah Ditandatangani) <span
                                                class="text-danger">*</span></label>
                                        <input type="file"
                                            class="form-control <?= ($validation->hasError('proposal')) ? 'is-invalid' : ''; ?>"
                                            name="proposal">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('proposal'); ?>
                                        </div>
                                        <div class="text-danger">
                                            * File berupa pdf (Max. 5Mb)
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="customFile">Surat Pengantar KMM <span
                                                class="text-danger">*</span></label>
                                        <input type="file"
                                            class="form-control <?= ($validation->hasError('surat_pengantar')) ? 'is-invalid' : ''; ?>"
                                            name="surat_pengantar">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('surat_pengantar'); ?>
                                        </div>
                                        <span><a href="https://layanan.vokasi.uns.ac.id/" target="_blank">Link
                                                Pengajuan</a></span>
                                        <div class="text-danger">
                                            * File berupa pdf (Max. 5Mb)
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <a href="<?= base_url('kmm/kmm'); ?>" class="btn btn-warning">Kembali</a>
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