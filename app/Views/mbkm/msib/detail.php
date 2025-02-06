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
                <h2 class="page-title">Detail Pendaftaran MBKM MSIB</h2>
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
                                                value="<?=$msib2->nm_mhs?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label type="text" class="col-sm-3 col-form-label">Dosen Pembimbing</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control" id=""
                                                value="<?=$msib2->nm_staf?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label type="text" class="col-sm-3 col-form-label">Nama Instansi</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control" id=""
                                                value="<?=$msib2->nama_instansi?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label type="text" class="col-sm-3 col-form-label">Link MSIB</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control" id=""
                                                value="<?=$msib2->link_msib?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label type="text" class="col-sm-3 col-form-label">Verifikasi Dosen</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control" id=""
                                                value="<?=$msib2->status_dosen?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label type="text" class="col-sm-3 col-form-label">Status Mahasiswa</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control" id=""
                                                value="<?=$msib2->status_mahasiswa?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label type="text" class="col-sm-3 col-form-label">Surat Rekomendasi</label>
                                        <?php if ($msib2->surat_rekom == ''): ?>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control" id="" value="Proses">
                                        </div>
                                        <?php else: ?>
                                        <div class="col-sm-9">
                                            <a class=""
                                                href="<?=base_url('mbkm/msib/download-sr/' . $msib2->id_msib)?>">
                                                <span class="btn btn-outline-primary">Download</span>
                                            </a>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group row">
                                        <label type="text" class="col-sm-3 col-form-label">SPTJM</label>
                                        <?php if ($msib2->sptjm == ''): ?>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control" id="" value="Proses">
                                        </div>
                                        <?php else: ?>
                                        <div class="col-sm-9">
                                            <a class=""
                                                href="<?=base_url('mbkm/msib/download-sptjm/' . $msib2->id_msib)?>">
                                                <span class="btn btn-outline-primary">Download</span>
                                            </a>
                                        </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group mb-2">
                                        <a href="<?=base_url('mbkm/msib');?>" class="btn btn-secondary">Kembali</a>
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