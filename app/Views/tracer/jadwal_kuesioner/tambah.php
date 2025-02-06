<?= $this->include('master_partial/dashboard/header'); ?>
<?= $this->include('master_partial/dashboard/top_menu'); ?>
<?= $this->include('master_partial/dashboard/side_menu'); ?>
    <style>
        :root {
        --warna: <?php echo $cms->warna_bg ?>;
        }
    </style>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Form Tambah Jadwal Kuesioner</h2>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-10">
                            <div class="card-body">
                                <form method="POST" action="<?= base_url("tracer/jadwal_kuesioner/simpan") ?>">
                                    <div class="form-group mb-9">
                                    <label for="simple-select2">Jenis Kuesioner</label>
                                        <select class="form-control select2" name="jenis_survey" id="simple-select1">
                                            <option value="">Pilih Jenis Kuesioner</option>
                                            <?php foreach($jenis_kuesioner as $jk): ?>
                                            <option value="<?= $jk->id_jenis_kuesioner ?>"><?= $jk->nama ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                         <!-- Error Validation -->
                                         <?php if ($validation->getError('jenis_survey')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('jenis_survey'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-9">
                                    <label for="simple-select2">Tahun Lulus</label>
                                        <select class="form-control select2" name="tahun_lulus" id="simple-select1">
                                            <option value="">Pilih Tahun</option>
                                            <?php foreach($tahun as $t): ?>
                                            <option value="<?= $t->id_tahun_lulus ?>"><?= $t->tahun ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                         <!-- Error Validation -->
                                         <?php if ($validation->getError('tahun_lulus')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('tahun_lulus'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group mb-9">
                                        <label for="address-wpalaceholder">Batas Pengisian</label>
                                        <div class="md-form md-outline input-with-post-icon datepicker">
                                            <input placeholder="Masukan Tanggal" name="batas_pengisian" type="date" id="example" class="form-control">
                                        </div>
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('batas_pengisian')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('batas_pengisian'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary" type="submit">
                                            Tambah
                                        </button>
                                        <a href="<?= base_url('tracer/jadwal_kuesioner'); ?>" class="btn btn-warning text-light">Kembali</a>
                                    </div>
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
<?php echo $this->include('sipema/sipema_partial/dashboard/footer');?>
