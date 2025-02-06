<?php echo $this->include('simta/simta_partial/dashboard/header');?>
<?php echo $this->include('simta/simta_partial/dashboard/top_menu');?>
<?php if(has_permission('admin')) : ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else : ?>
<?php echo $this->include('simta/simta_partial/dashboard/side_menu') ?>
<?php endif; ?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="mt-2 page-title">Halaman Pendaftaran Ujian Tugas Akhir</h2>
                    </div>
                    <?php if(has_permission('admin') || has_permission('dosen') || has_permission('koor-simta')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Pendaftaran Ujian Tugas Akhir</li>
                            </ol>
                        </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SIMTA</a></li>
                                <li class="breadcrumb-item active">Pendaftaran Ujian Tugas Akhir</li>
                            </ol>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row my-4">
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title"></strong>
                            </div>
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data"
                                    action="<?=base_url('simta/ujianta/store/' . $ujianproposal->id_ujianproposal)?>"> 
                                    <?=csrf_field();?>
                                    <input type="hidden" id="id_ujianproposal" name="id_ujianproposal"
                                        value="<?= $ujianproposal->id_ujianproposal ?>" />
                                        <div class="form-group" id="id_ujianproposal">
                                        <div class="id_ujianproposal">
                                            <input type="hidden" id="id_ujianproposal" name="id_ujianproposal" class="form-control" placeholder="Masukkan Ujian Proposal" value="<?= $ujianproposal->id_ujianproposal ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group" id="id_mhs">
                                        <div class="id_mhs-row">
                                            <input type="hidden" id="id_mhs" name="id_mhs" class="form-control" placeholder="Masukkan Ujian Proposal" value="<?= $ujianproposal->id_mhs ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group" id="id_staf">
                                        <div class="id_staf-row">
                                            <input type="hidden" id="id_staf" name="id_staf" class="form-control" placeholder="Masukkan Ujian Proposal" value="<?= $ujianproposal->id_staf ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group" id="nama_judul">
                                        <div class="nama_judul-row">
                                            <input type="hidden" id="nama_judul" name="nama_judul" class="form-control" placeholder="Masukkan Ujian Proposal" value="<?= $ujianproposal->nama_judul ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group" id="abstrak">
                                        <div class="abstrak-row">
                                            <input type="hidden" id="abstrak" name="abstrak" class="form-control" placeholder="Masukkan Ujian Proposal" value="<?= $ujianproposal->abstrak ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="tanggal">Tanggal Ujian<span class="text-danger">*</span></label>
                                        <input type="date" id="tanggal" name="tanggal"
                                            class="form-control <?=($validation->hasError('tanggal')) ? 'is-invalid' : ''?>"
                                            value="" />
                                        <!-- Error Validation -->
                                        <div class="invalid-feedback">
                                            <?=$validation->getError('tanggal');?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="customFile">Berita Acara KMM<span class="text-danger">*</span></label>
                                        <input type="file"
                                            class="form-control <?= ($validation->hasError('berita_acarakmm')) ? 'is-invalid' : ''; ?>"
                                            name="berita_acarakmm">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('berita_acarakmm'); ?>
                                        </div>
                                        <div class="text-danger">
                                            * File berupa pdf (Max. 5Mb)
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="customFile">KRS<span class="text-danger">*</span></label>
                                        <input type="file"
                                            class="form-control <?= ($validation->hasError('krs')) ? 'is-invalid' : ''; ?>"
                                            name="krs">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('krs'); ?>
                                        </div>
                                        <div class="text-danger">
                                            * File berupa pdf (Max. 5Mb)
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="customFile">Transkrip Nilai<span class="text-danger">*</span></label>
                                        <input type="file"
                                            class="form-control <?= ($validation->hasError('transkrip_nilai')) ? 'is-invalid' : ''; ?>"
                                            name="transkrip_nilai">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('transkrip_nilai'); ?>
                                        </div>
                                        <div class="text-danger">
                                            * File berupa pdf (Max. 5Mb)
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="customFile">Rekomendasi Dosen Pembimbing<span class="text-danger">*</span></label>
                                        <input type="file"
                                            class="form-control <?= ($validation->hasError('rekomendasi_dospem')) ? 'is-invalid' : ''; ?>"
                                            name="rekomendasi_dospem">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('rekomendasi_dospem'); ?>
                                        </div>
                                        <div class="text-danger">
                                            * File berupa pdf (Max. 5Mb)
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="customFile">Proposal Tugas Akhir<span class="text-danger">*</span></label>
                                        <input type="file"
                                            class="form-control <?= ($validation->hasError('proposalakhir')) ? 'is-invalid' : ''; ?>"
                                            name="proposalakhir">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('proposalakhir'); ?>
                                        </div>
                                        <div class="text-danger">
                                            * File berupa pdf (Max. 5Mb)
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Tambah</button>
                                    <a href="<?=base_url('simta/ujianta');?>" class="btn btn-warning">Kembali</a>
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
<?php echo $this->include('simta/simta_partial/dashboard/footer'); ?>