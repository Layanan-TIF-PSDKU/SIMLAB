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
                <h2 class="page-title">Form Tambah Alumni Berprestasi</h2>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-10">
                            <div class="card-body">
                                <form method="POST" action="<?= base_url("tracer/alumni_berprestasi/simpan") ?>" enctype="multipart/form-data">
                                    <div class="form-group mb-9">
                                        <label for="address-wpalaceholder">Nama</label>
                                        <input type="text" id="address-wpalaceholder" name="nama_mahasiswa" class="form-control" placeholder="Masukkan Nama Mahasiswa" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('nama_mahasiswa')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('nama_mahasiswa'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-9">
                                        <label for="address-wpalaceholder">Prodi</label>
                                        <input type="text" id="address-wpalaceholder" name="program_study" class="form-control" placeholder="Masukkan Program Study" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('program_study')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('program_study'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-9">
                                        <label for="address-wpalaceholder">Nama</label>
                                        <input type="text" id="address-wpalaceholder" name="prestasi" class="form-control" placeholder="Masukkan Prestasi" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('prestasi')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('prestasi'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-9">
                                        <label for="customFile">Foto</label>
                                        <input type="file" class="form-control" name="foto">
                                        <!-- Error Validation -->
                                        <?php if ($validation->getError('foto')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('foto'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary" type="submit">
                                            Tambah
                                        </button>
                                        <a href="<?= base_url('tracer/alumni_berprestasi'); ?>" class="btn btn-warning text-light">Kembali</a>
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