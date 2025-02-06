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
                <h2 class="page-title">Form Tambah Agenda</h2>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-10">
                            <div class="card-body">
                                <form method="POST" action="<?= base_url("tracer/agenda/simpan") ?>">
                                    <div class="form-group mb-9">
                                        <label for="address-wpalaceholder">Nama</label>
                                        <input type="text" id="address-wpalaceholder" name="nama_agenda" class="form-control" placeholder="Masukkan Nama" />
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('nama_agenda')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('nama_agenda'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-9">
                                        <label for="example-textarea">Deskripsi</label>
                                        <textarea class="form-control" id="example-textarea" name="deskripsi_agenda" placeholder="Masukan Deskripsi"></textarea>
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('deskripsi_agenda')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('deskripsi_agenda'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="form-group mb-9">
                                        <label for="address-wpalaceholder">Waktu Kegiatan</label>
                                        <div class="md-form md-outline input-with-post-icon datepicker">
                                            <input placeholder="Masukan Tanggal" name="waktu_kegiatan" type="date" id="example" class="form-control">
                                        </div>
                                            <!-- Error Validation -->
                                            <?php if ($validation->getError('waktu_kegiatan')) { ?>
                                            <div class='alert alert-danger mt-2'>
                                                <?= $error = $validation->getError('waktu_kegiatan'); ?>
                                            </div>
                                            <?php } ?>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary" type="submit">
                                            Tambah
                                        </button>
                                        <a href="<?= base_url('tracer/agenda'); ?>" class="btn btn-warning text-light">Kembali</a>
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