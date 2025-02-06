<?php echo $this->include('mbkm/mbkm_partial/dashboard/header');?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/top_menu');?>
<?php if(has_permission('admin')) : ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else : ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/side_menu') ?>
<?php endif; ?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Detail Pendaftaran MBKM Hibah</h2>
                <div class="row my-4">
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title">Data Pendaftar</strong>
                            </div>
                            <div class="card-body">
                                <form>

                                    <div class="form-group row">
                                        <label type="text" class="col-sm-3 col-form-label">Nama Mahasiswa</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control" id=""
                                                value="<?=$hibah->nm_mhs?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label type="text" class="col-sm-3 col-form-label">Dosen Pembimbing</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control" id=""
                                                value="<?=$hibah->nm_staf?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label type="text" class="col-sm-3 col-form-label">Dosen Pembimbing</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control" id=""
                                                value="<?=$hibah->nama_instansi?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label type="text" class="col-sm-3 col-form-label">Verifikasi Dosen</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control" id=""
                                                value="<?=$hibah->status_dosen?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label type="text" class="col-sm-3 col-form-label">Status Mahasiswa</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control" id=""
                                                value="<?=$hibah->status_mahasiswa?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label type="text" class="col-sm-3 col-form-label">Proposal</label>
                                        <?php if ($hibah->proposal == ''): ?>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control" id="" value="Belum Upload">
                                        </div>
                                        <?php else: ?>
                                        <div class="col-sm-9">
                                            <a class=""
                                                href="<?=base_url('mbkm/hibah/download-proposal/' . $hibah->id_hibah)?>">
                                                <span class="btn btn-outline-primary">Download</span>
                                            </a>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group row">
                                        <label type="text" class="col-sm-3 col-form-label">Surat Rekomendasi</label>
                                        <?php if ($hibah->surat_rekom == 'proses'): ?>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control" id="" value="proses">

                                        </div>
                                        <?php else: ?>
                                        <div class="col-sm-9">
                                            <a class=""
                                                href="<?=base_url('mbkm/hibah/download-sr/' . $hibah->id_hibah)?>">
                                                <span class="btn btn-outline-primary">Download</span>
                                            </a>
                                        </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group mb-2">
                                        <a href="<?=base_url('mbkm/hibah');?>" class="btn btn-secondary">Kembali</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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